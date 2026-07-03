<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateFoto(Request $request): RedirectResponse
    {
        $request->validate([
            'foto' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],
        ]);

        $user = $request->user();

        $folderPath = public_path('uploads/foto-profil/');

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        if ($user->foto && str_starts_with($user->foto, 'uploads/foto-profil/')) {
            $fotoLama = public_path($user->foto);

            if (file_exists($fotoLama)) {
                unlink($fotoLama);
            }
        }

        $file = $request->file('foto');

        $namaFile = 'profil_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

        $file->move($folderPath, $namaFile);

        $user->foto = 'uploads/foto-profil/' . $namaFile;
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'foto-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->foto && str_starts_with($user->foto, 'uploads/foto-profil/')) {
            $fotoLama = public_path($user->foto);

            if (file_exists($fotoLama)) {
                unlink($fotoLama);
            }
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}