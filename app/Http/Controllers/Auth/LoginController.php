<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Email atau password salah.',
                ]);
        }

        $request->session()->regenerate();

        return redirect()
            ->intended(route($this->dashboardRouteFor($request->user())))
            ->with('toast', [
                'type' => 'success',
                'message' => 'Login berhasil.',
            ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('toast', [
                'type' => 'info',
                'message' => 'Anda telah logout.',
            ]);
    }

    private function dashboardRouteFor(User $user): string
    {
        return match (true) {
            $user->isAdmin() => 'admin.dashboard',
            $user->isMerchant() => 'merchant.dashboard',
            default => 'customer.dashboard',
        };
    }
}
