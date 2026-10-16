<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MerchantProfile;
use App\Models\Order;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'user_count' => User::count(),
            'merchant_count' => MerchantProfile::count(),
            'order_count' => Order::count(),
            'revenue' => Order::ofStatus(Order::STATUS_DELIVERED)->sum('total'),
        ];

        $recentOrders = Order::query()
            ->withList()
            ->recent()
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
