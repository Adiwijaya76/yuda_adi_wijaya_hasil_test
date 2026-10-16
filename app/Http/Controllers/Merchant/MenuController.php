<?php

namespace App\Http\Controllers\Merchant;

use App\Exceptions\MerchantProfileRequiredException;
use App\Http\Controllers\Concerns\RespondsWithDataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\StoreMenuRequest;
use App\Http\Requests\Merchant\UpdateMenuRequest;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MenuController extends Controller
{
    use RespondsWithDataTables;

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->data($request);
        }

        return view('merchant.menus.index');
    }

    public function create(): View
    {
        return view('merchant.menus.create');
    }

    public function store(StoreMenuRequest $request): RedirectResponse
    {
        $profile = $this->merchantProfile();

        $data = $request->safe()->except('photo');
        $data['merchant_profile_id'] = $profile->id;
        $data['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('menus', 'public');
        }

        Menu::create($data);

        return redirect()->route('merchant.menus.index')->with('toast', [
            'type' => 'success',
            'message' => 'Menu berhasil ditambahkan.',
        ]);
    }

    public function edit(Menu $menu): View
    {
        $this->authorizeMenu($menu);

        return view('merchant.menus.edit', compact('menu'));
    }

    public function update(UpdateMenuRequest $request, Menu $menu): RedirectResponse
    {
        $this->authorizeMenu($menu);

        $data = $request->safe()->except('photo');
        $data['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('photo')) {
            $this->deleteOldPhoto($menu);
            $data['photo'] = $request->file('photo')->store('menus', 'public');
        }

        $menu->update($data);

        return redirect()->route('merchant.menus.index')->with('toast', [
            'type' => 'success',
            'message' => 'Menu berhasil diperbarui.',
        ]);
    }

    public function destroy(Menu $menu): RedirectResponse
    {
        $this->authorizeMenu($menu);

        $menu->delete();

        return back()->with('toast', [
            'type' => 'success',
            'message' => 'Menu berhasil dinonaktifkan.',
        ]);
    }

    private function data(Request $request): JsonResponse
    {
        $profile = $this->merchantProfile();

        $baseQuery = $profile->menus()->latest();

        return $this->dataTablesResponse(
            $baseQuery,
            $request,
            fn (Menu $menu) => [
                'photo_html' => view('merchant.menus.partials.photo', ['menu' => $menu])->render(),
                'name' => $menu->name,
                'price' => 'Rp '.number_format((float) $menu->price, 0, ',', '.'),
                'availability' => view('components.availability-badge', ['available' => $menu->is_available])->render(),
                'action' => view('merchant.menus.partials.actions', ['menu' => $menu])->render(),
            ],
            function ($query) use ($request) {
                $query->search($request->query('keyword'));
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

    private function authorizeMenu(Menu $menu): void
    {
        $profile = auth()->user()->merchantProfile;

        if (! $profile || $menu->merchant_profile_id !== $profile->id) {
            abort(403, 'Anda tidak memiliki akses ke menu ini.');
        }
    }

    private function deleteOldPhoto(Menu $menu): void
    {
        if ($menu->photo) {
            Storage::disk('public')->delete($menu->photo);
        }
    }
}
