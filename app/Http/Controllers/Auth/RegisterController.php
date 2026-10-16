<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route($this->dashboardRouteFor($user))
            ->with('toast', [
                'type' => 'success',
                'message' => 'Registrasi berhasil. Selamat datang!',
            ]);
    }

    private function dashboardRouteFor(User $user): string
    {
        return $user->isMerchant() ? 'merchant.dashboard' : 'customer.dashboard';
    }
}
