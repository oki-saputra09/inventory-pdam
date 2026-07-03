<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $user->loadMissing('role');

        $status = strtolower(trim($user->status ?? ''));

        if ($status !== 'aktif') {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->withErrors([
                    'login' => 'Akun ini sedang nonaktif. Silakan hubungi admin.',
                ]);
        }

        $roleName = optional($user->role)->name;

        if (!$roleName && isset($user->getAttributes()['role'])) {
            $roleName = $user->getAttributes()['role'];
        }

        $roleName = strtolower(trim($roleName ?? ''));

        if ($roleName === 'staff') {
            $roleName = 'staf';
        }

        $allowedRoles = [];

        foreach ($roles as $role) {
            foreach (explode(',', $role) as $item) {
                $item = strtolower(trim($item));

                if ($item === 'staff') {
                    $item = 'staf';
                }

                if ($item !== '') {
                    $allowedRoles[] = $item;
                }
            }
        }

        if (!in_array($roleName, $allowedRoles, true)) {
            abort(403, 'Anda tidak punya akses ke halaman ini.');
        }

        return $next($request);
    }
}