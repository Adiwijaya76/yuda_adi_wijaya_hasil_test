<?php

namespace App\Http\Controllers\Merchant;

use App\Exceptions\MerchantProfileRequiredException;
use App\Exceptions\OrderStatusTransitionException;
use App\Http\Controllers\Concerns\RespondsWithDataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\UpdateOrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    use RespondsWithDataTables;

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->data($request);
        }

        return view('merchant.orders.index');
    }

    public function show(Order $order): View
    {
        $this->authorizeOrder($order);

        $order->load('customer', 'items', 'invoice', 'merchantProfile');

        return view('merchant.orders.show', compact('order'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order): RedirectResponse
    {
        $this->authorizeOrder($order);

        try {
            $order->transitionTo($request->validated('status'));
        } catch (OrderStatusTransitionException $e) {
            return back()->with('toast', [
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        }

        return back()->with('toast', [
            'type' => 'success',
            'message' => "Status pesanan diperbarui menjadi \"{$order->status}\".",
        ]);
    }

    private function data(Request $request): JsonResponse
    {
        $profile = $this->merchantProfile();

        $baseQuery = $profile->orders()->with('customer', 'invoice')->latest();

        return $this->dataTablesResponse(
            $baseQuery,
            $request,
            fn (Order $order) => [
                'order_number' => $order->order_number,
                'customer_name' => $order->customer->name,
                'delivery_date' => $order->delivery_date->format('d M Y'),
                'total' => 'Rp '.number_format((float) $order->total, 0, ',', '.'),
                'status_badge' => view('components.status-badge', ['status' => $order->status])->render(),
                'action' => view('merchant.orders.partials.actions', ['order' => $order])->render(),
            ],
            function ($query) use ($request) {
                $query->search($request->query('keyword'))->ofStatus($request->query('status'));
            },
        );
    }

    private function merchantProfile()
    {
        $profile = auth()->user()->merchantProfile;

        if (! $profile) {
            throw new MerchantProfileRequiredException;
        }

        return $profile;
    }

    private function authorizeOrder(Order $order): void
    {
        $profile = auth()->user()->merchantProfile;

        if (! $profile || $order->merchant_profile_id !== $profile->id) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }
    }
}
