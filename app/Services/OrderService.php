<?php

namespace App\Services;

use App\Exceptions\MenuUnavailableException;
use App\Models\Menu;
use App\Models\MerchantProfile;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderService
{
    public function __construct(private readonly InvoiceService $invoiceService) {}

    /**
     * Membuat order + order items + invoice secara atomik.
     *
     * @param  array<int, array{menu_id:int, quantity:int}>  $items
     * @param  array{merchant_profile_id:int, delivery_date:string, delivery_address:string}  $data
     *
     * @throws Throwable
     */
    public function checkout(User $customer, array $items, array $data): Order
    {
        return DB::transaction(function () use ($customer, $items, $data) {
            $merchantProfile = MerchantProfile::findOrFail($data['merchant_profile_id']);

            $prepared = $this->prepareItems($items, $merchantProfile->id);

            $order = Order::create([
                'order_number' => $this->generateOrderNumber(),
                'customer_id' => $customer->id,
                'merchant_profile_id' => $merchantProfile->id,
                'delivery_date' => $data['delivery_date'],
                'delivery_address' => $data['delivery_address'],
                'total' => $prepared['total'],
                'status' => Order::STATUS_PENDING,
            ]);

            foreach ($prepared['items'] as $item) {
                $order->items()->create([
                    'menu_id' => $item['menu']->id,
                    'menu_name' => $item['menu']->name,
                    'unit_price' => $item['menu']->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            $this->invoiceService->createForOrder($order);

            return $order;
        });
    }

    /**
     * Validasi menu & hitung harga di server.
     *
     * @return array{items: array, total: float}
     */
    private function prepareItems(array $items, int $merchantProfileId): array
    {
        $prepared = [];
        $total = 0;

        foreach ($items as $item) {
            $menu = Menu::query()
                ->forMerchant($merchantProfileId)
                ->find($item['menu_id']);

            if (! $menu) {
                throw new MenuUnavailableException("Menu #{$item['menu_id']}");
            }

            if (! $menu->is_available) {
                throw new MenuUnavailableException($menu->name);
            }

            $subtotal = round((float) $menu->price * (int) $item['quantity'], 2);

            $prepared[] = [
                'menu' => $menu,
                'quantity' => (int) $item['quantity'],
                'subtotal' => $subtotal,
            ];

            $total += $subtotal;
        }

        return [
            'items' => $prepared,
            'total' => round($total, 2),
        ];
    }

    private function generateOrderNumber(): string
    {
        do {
            $number = 'ORD-'.now()->format('Ymd').'-'.strtoupper(bin2hex(random_bytes(4)));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
}
