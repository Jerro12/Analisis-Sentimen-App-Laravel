<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Novel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    // Tampilkan daftar novel yang sudah dibookmark user
    public function index()
    {
        /** @var \App\Models\User $user */
        $bookmarks = Auth::user()->bookmarks()->get();
        return view('bookmark', compact('bookmarks'));
    }

    // Simpan atau hapus bookmark (toggle)
    public function toggle(Request $request)
    {
        $user = auth()->user();
        $novelId = $request->input('novel_id');

        // Cek apakah novel ada
        $novel = Novel::findOrFail($novelId);

        // Toggle bookmark pakai belongsToMany
        $user->bookmarks()->toggle($novel->id);

        return back()->with('success', 'Bookmark diperbarui.');
    }

    // Hapus secara eksplisit berdasarkan ID bookmark (opsional)
    public function destroy(Bookmark $bookmark)
    {
        if ($bookmark->user_id === Auth::id()) {
            $bookmark->delete();
            return back()->with('success', 'Bookmark dihapus.');
        }

        return back()->with('error', 'Tidak diizinkan.');
    }
}
