<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Concerns\RespondsWithDataTables;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
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

        return view('customer.orders.index');
    }

    public function show(Order $order): View
    {
        $this->authorizeOrder($order);

        $order->load('merchantProfile.user', 'items', 'invoice');

        return view('customer.orders.show', compact('order'));
    }

    private function data(Request $request): JsonResponse
    {
        $baseQuery = auth()->user()->orders()->with('merchantProfile', 'invoice')->latest();

        return $this->dataTablesResponse(
            $baseQuery,
            $request,
            fn (Order $order) => [
                'order_number' => $order->order_number,
                'merchant_name' => $order->merchantProfile->company_name,
                'delivery_date' => $order->delivery_date->format('d M Y'),
                'total' => 'Rp '.number_format((float) $order->total, 0, ',', '.'),
                'status_badge' => view('components.status-badge', ['status' => $order->status])->render(),
                'action' => view('customer.orders.partials.actions', ['order' => $order])->render(),
            ],
            function ($query) use ($request) {
                $query->search($request->query('keyword'))->ofStatus($request->query('status'));
            },
        );
    }

    private function authorizeOrder(Order $order): void
    {
        if ($order->customer_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }
    }
}
