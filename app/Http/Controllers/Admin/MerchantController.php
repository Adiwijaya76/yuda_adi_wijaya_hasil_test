<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\RespondsWithDataTables;
use App\Http\Controllers\Controller;
use App\Models\MerchantProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MerchantController extends Controller
{
    use RespondsWithDataTables;

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->data($request);
        }

        return view('admin.merchants.index');
    }

    private function data(Request $request): JsonResponse
    {
        $baseQuery = MerchantProfile::query()->withUser()->withCounts()->latest();

        return $this->dataTablesResponse(
            $baseQuery,
            $request,
            fn (MerchantProfile $merchant) => [
                'company' => view('admin.merchants.partials.company', ['merchant' => $merchant])->render(),
                'owner' => $merchant->user->name,
                'food_type' => $merchant->food_type ?? '-',
                'menus_count' => $merchant->menus_count,
                'orders_count' => $merchant->orders_count,
            ],
            function ($query) use ($request) {
                $query->search($request->query('keyword'));
            },
        );
    }
}
