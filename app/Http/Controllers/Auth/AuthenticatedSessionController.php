<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        $user->loadMissing('role');

        $status = strtolower(trim($user->status ?? ''));

        if ($status !== 'aktif') {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'login' => 'Akun ini sedang nonaktif. Silakan hubungi admin.',
            ]);
        }

        $roleName = optional($user->role)->name;
        $roleName = strtolower(trim($roleName ?? ''));

        if ($roleName === 'staff') {
            $roleName = 'staf';
        }

        if ($roleName === 'admin') {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        if ($roleName === 'staf') {
            return redirect()->intended(route('staff.dashboard', absolute: false));
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        throw ValidationException::withMessages([
            'login' => 'Role akun tidak dikenali.',
        ]);
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}