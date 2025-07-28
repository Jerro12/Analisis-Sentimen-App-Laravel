<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Laravel\Socialite\Two\GoogleProvider;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route untuk delete foto profil (opsional)
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
});

// Route Login Google
Route::middleware('guest')->group(function () {
    Route::get('/auth/google', function () {
        return Socialite::driver('google')->redirect();
    })->name('google.login');

    Route::get('/auth/google/callback', function () {

        /** @var GoogleProvider $googleProvider */
        $googleProvider = Socialite::driver('google');
        $googleUser = $googleProvider->stateless()->user();

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => bcrypt(Str::random(24)),
                'profile_photo_url' => $googleUser->getAvatar(), // Simpan avatar dari Google
                'role' => 'user' // default user
            ]
        );

        Auth::login($user);
        return redirect('/dashboard');
    });
});

require __DIR__ . '/auth.php';