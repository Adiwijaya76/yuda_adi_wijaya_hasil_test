<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $stats = [
            'order_count' => $user->orders()->count(),
            'pending_count' => $user->orders()->ofStatus(Order::STATUS_PENDING)->count(),
            'delivered_count' => $user->orders()->ofStatus(Order::STATUS_DELIVERED)->count(),
        ];

        $recentOrders = $user->orders()
            ->with('merchantProfile', 'invoice')
            ->recent()
            ->get();

        return view('customer.dashboard', compact('stats', 'recentOrders'));
    }
}
