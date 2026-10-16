<?php

namespace App\Http\Controllers\Merchant;

use App\Exceptions\MerchantProfileRequiredException;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $profile = $this->merchantProfile();

        $stats = [
            'menu_count' => $profile->menus()->count(),
            'order_count' => $profile->orders()->count(),
            'pending_count' => $profile->orders()->ofStatus(Order::STATUS_PENDING)->count(),
            'revenue' => $profile->orders()->ofStatus(Order::STATUS_DELIVERED)->sum('total'),
        ];

        $recentOrders = $profile->orders()
            ->with('customer')
            ->recent()
            ->get();

        return view('merchant.dashboard', compact('stats', 'recentOrders'));
    }

    private function merchantProfile()
    {
        $profile = auth()->user()->merchantProfile;

        if (! $profile) {
            throw new MerchantProfileRequiredException;
        }

        return $profile;
    }
}
