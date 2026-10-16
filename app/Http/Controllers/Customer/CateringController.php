<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\MerchantProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CateringController extends Controller
{
    public function index(Request $request): View
    {
        $caterings = MerchantProfile::query()
            ->withUser()
            ->search($request->query('q'))
            ->foodType($request->query('food_type'))
            ->location($request->query('location'))
            ->paginate(9)
            ->withQueryString();

        $foodTypes = MerchantProfile::query()->foodTypes()->pluck('food_type');

        return view('customer.caterings.index', compact('caterings', 'foodTypes'));
    }

    public function show(MerchantProfile $merchant): View
    {
        $merchant->load('user', 'menus');

        return view('customer.caterings.show', compact('merchant'));
    }
}
