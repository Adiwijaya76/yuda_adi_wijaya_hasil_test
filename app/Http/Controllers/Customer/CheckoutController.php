<?php

namespace App\Http\Controllers\Customer;

use App\Exceptions\MenuUnavailableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CheckoutRequest;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Throwable;

class CheckoutController extends Controller
{
    public function __construct(private readonly OrderService $orderService) {}

    public function store(CheckoutRequest $request): RedirectResponse
    {
        try {
            $order = $this->orderService->checkout(
                $request->user(),
                $request->validated('items'),
                $request->safe()->only('merchant_profile_id', 'delivery_date', 'delivery_address'),
            );
        } catch (MenuUnavailableException $e) {
            return back()->with('toast', [
                'type' => 'error',
                'message' => $e->getMessage(),
            ]);
        } catch (Throwable $e) {
            report($e);

            return back()->with('toast', [
                'type' => 'error',
                'message' => 'Checkout gagal. Silakan coba lagi.',
            ]);
        }

        return redirect()->route('customer.orders.show', $order)
            ->with('toast', [
                'type' => 'success',
                'message' => 'Pesanan berhasil dibuat.',
            ]);
    }
}
