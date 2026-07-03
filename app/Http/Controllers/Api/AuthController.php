<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:100'],
        ]);

        $user = User::with('role')
            ->where('email', $validated['login'])
            ->orWhere('username', $validated['login'])
            ->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'login' => ['Email/username atau password salah.'],
            ]);
        }

        if (strtolower($user->status ?? '') !== 'aktif') {
            return response()->json([
                'message' => 'Akun tidak aktif. Silakan hubungi admin.',
            ], 403);
        }

        $roleName = optional($user->role)->name;

        if (!$roleName && isset($user->getAttributes()['role'])) {
            $roleName = $user->getAttributes()['role'];
        }

        $roleName = strtolower(trim($roleName ?? ''));

        if ($roleName === 'staff') {
            $roleName = 'staf';
        }

        $token = $user->createToken($validated['device_name'] ?? 'api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login API berhasil.',
            'token_type' => 'Bearer',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'role_id' => $user->role_id,
                'role' => $roleName,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'no_hp' => $user->no_hp,
                'status' => $user->status,
                'foto' => $user->foto ? asset('storage/' . $user->foto) : null,
            ],
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user()->loadMissing('role');

        $roleName = optional($user->role)->name;

        if (!$roleName && isset($user->getAttributes()['role'])) {
            $roleName = $user->getAttributes()['role'];
        }

        $roleName = strtolower(trim($roleName ?? ''));

        if ($roleName === 'staff') {
            $roleName = 'staf';
        }

        return response()->json([
            'message' => 'Data user login.',
            'user' => [
                'id' => $user->id,
                'role_id' => $user->role_id,
                'role' => $roleName,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'no_hp' => $user->no_hp,
                'status' => $user->status,
                'foto' => $user->foto ? asset('storage/' . $user->foto) : null,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        if ($request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json([
            'message' => 'Logout API berhasil.',
        ]);
    }
}