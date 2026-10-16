<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\StoreMerchantProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $profile = auth()->user()->merchantProfile;

        return view('merchant.profile', compact('profile'));
    }

    public function update(StoreMerchantProfileRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->merchantProfile()->updateOrCreate(
            ['user_id' => $user->id],
            $request->validated()
        );

        return back()->with('toast', [
            'type' => 'success',
            'message' => 'Profil perusahaan berhasil disimpan.',
        ]);
    }
}
