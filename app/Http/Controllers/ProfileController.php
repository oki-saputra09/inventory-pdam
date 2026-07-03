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
            'name' => ['required', 'string', 'max:255'],

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

        return redirect()
            ->back()
            ->with('success', 'Profil berhasil diperbarui.');
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

        $folderPath = public_path('uploads/foto-profil');

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        if ($user->foto && $user->foto !== 'uploads/foto-profil/avatar.jpg') {
            $fotoLama = public_path($user->foto);

            if (file_exists($fotoLama) && is_file($fotoLama)) {
                unlink($fotoLama);
            }
        }

        $file = $request->file('foto');

        $namaFile = 'profil_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

        $file->move($folderPath, $namaFile);

        $user->foto = 'uploads/foto-profil/' . $namaFile;
        $user->save();

        return redirect()
            ->back()
            ->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function hapusFoto(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->foto && $user->foto !== 'uploads/foto-profil/avatar.jpg') {
            $fotoLama = public_path($user->foto);

            if (file_exists($fotoLama) && is_file($fotoLama)) {
                unlink($fotoLama);
            }
        }

        $user->foto = null;
        $user->save();

        return redirect()
            ->back()
            ->with('success', 'Foto profil berhasil dihapus. Foto kembali ke avatar default.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->foto && $user->foto !== 'uploads/foto-profil/avatar.jpg') {
            $fotoLama = public_path($user->foto);

            if (file_exists($fotoLama) && is_file($fotoLama)) {
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