<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Update basic fields
        $user->fill($request->only(['name', 'email']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Handle foto profil upload
        if ($request->hasFile('photo')) {
            // Delete old photo (jika ada dan bukan dari OAuth)
            $user->deleteOldProfilePhoto();

            // Upload foto baru
            $photo = $request->file('photo');

            // Generate nama file yang unik
            $filename = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();

            // Simpan ke storage/app/public/profile_photos
            $path = $photo->storeAs('profile_photos', $filename, 'public');

            if ($path) {
                // Simpan path ke database
                $user->profile_photo_url = 'storage/' . $path;

                logger('Profile photo updated successfully: ' . $user->profile_photo_url);
            } else {
                logger('Failed to upload profile photo');
                return Redirect::route('profile.edit')->with('error', 'Gagal mengupload foto profil.');
            }
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete profile photo before deleting user
        $user->deleteOldProfilePhoto();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}