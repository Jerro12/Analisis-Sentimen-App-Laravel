<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use App\Models\User;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\Admin\NovelController as AdminNovelController;
use App\Http\Controllers\User\NovelController as UserNovelController;
use App\Http\Controllers\User\CommentController as UserCommentController;
use App\Http\Controllers\HomeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman awal
Route::get('/', fn() => view('auth.login'));

// =====================
// User Routes
// =====================
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard umum (user)
    // Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/genre/{slug}', [UserNovelController::class, 'genre'])->name('genre.show');

    // Search & Detail Novel
    Route::get('/search', [UserNovelController::class, 'index'])->name('search');
    Route::get('/novel/{id}', [UserNovelController::class, 'show'])->name('novel.show');

    // Komentar novel
    Route::post('/novel/{id}/comment', [UserCommentController::class, 'store'])->name('novel.comment');

    // Bookmark routes
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmark/toggle', [BookmarkController::class, 'toggle'])->name('bookmark.toggle');
    Route::delete('/bookmarks/{bookmark}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
});
// =====================
// Route untuk Authenticated User
// =====================
Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
});

// =====================
// Admin Routes (Hanya Admin Bisa Akses)
// =====================
// Dashboard admin
Route::get('/admin/dashboard', fn() => view('admin.dashboard'))
    ->middleware(['auth', 'admin']) // tambahkan 'admin' agar hanya admin bisa akses
    ->name('admin.dashboard');
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Manajemen Comment
    Route::resource('comments', \App\Http\Controllers\Admin\CommentController::class)->only(['index', 'destroy']);

    // Manajemen Novel
    Route::resource('novels', AdminNovelController::class);

    // Manajemen User
    Route::resource('users', UserController::class);
    Route::delete('/users/{user}/photo', [UserController::class, 'deletePhoto'])->name('users.delete-photo');
    Route::post('/users/bulk-action', [UserController::class, 'bulkAction'])->name('users.bulk-action');
});

// =====================
// Login dengan Google (Hanya untuk tamu/guest)
// =====================
Route::middleware('guest')->group(function () {
    Route::get('/auth/google', fn() => Socialite::driver('google')->redirect())->name('google.login');

    Route::get('/auth/google/callback', function () {
        /** @var GoogleProvider $googleProvider */
        $googleProvider = Socialite::driver('google');
        $googleUser = $googleProvider->stateless()->user();

        // Cari user berdasarkan email atau buat baru
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => bcrypt(Str::random(24)), // generate password acak
                'profile_photo_url' => $googleUser->getAvatar(),
                'role' => 'user'
            ]
        );

        Auth::login($user);
        return redirect('/home'); // redirect ke dashboard user biasa
    });
});

// Route Auth Default dari Laravel (login, register, dll)
require __DIR__ . '/auth.php';
