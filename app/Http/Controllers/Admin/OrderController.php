<?php

namespace App\Http\Controllers\Admin;

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

        return view('admin.orders.index');
    }

    private function data(Request $request): JsonResponse
    {
        $baseQuery = Order::query()->withList()->latest();

        return $this->dataTablesResponse(
            $baseQuery,
            $request,
            fn (Order $order) => [
                'order_number' => $order->order_number,
                'customer_name' => $order->customer->name,
                'merchant_name' => $order->merchantProfile->company_name,
                'total' => 'Rp '.number_format((float) $order->total, 0, ',', '.'),
                'status_badge' => view('components.status-badge', ['status' => $order->status])->render(),
                'action' => $order->invoice
                    ? view('admin.orders.partials.actions', ['order' => $order])->render()
                    : '<span class="text-muted">-</span>',
            ],
            function ($query) use ($request) {
                $query->search($request->query('keyword'))->ofStatus($request->query('status'));
            },
        );
    }
}
