<?php
// app/Http/Controllers/User/NovelController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Novel;
use Illuminate\Support\Facades\Auth;



class NovelController extends Controller
{
    public function index(Request $request)
    {
        $query = Novel::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('author', 'like', '%' . $request->search . '%');
        }

        $novels = $query->latest()->paginate(12)->withQueryString();

        return view('search', compact('novels'));
    }
    public function show(Request $request, $id)
    {
        $novel = Novel::findOrFail($id);
        $recommendations = null;

        if (auth()->check()) {
            $recommendations = $this->getRecommendations($novel);
        }

        $from = $request->query('from'); // tangkap query ?from=bookmark

        return view('novel-show', compact('novel', 'recommendations', 'from'));
    }


    private function getRecommendations(Novel $novel)
    {
        $user = Auth::user();

        // Ambil komentar terbaru user dengan sentimen yang sudah dianalisis
        $lastComment = $user->comments()
            ->whereNotNull('sentiment')
            ->latest()
            ->first();

        // Kalau tidak ada komentar, kembalikan null
        if (!$lastComment) {
            return null;
        }

        // Ambil novel-novel dengan genre sama, kecuali novel yang sedang dibuka
        $recommendations = Novel::where('genre', $novel->genre)
            ->where('id', '!=', $novel->id)
            ->latest()
            ->take(5)
            ->get();

        return [
            'comment' => $lastComment,
            'novels' => $recommendations,
        ];
    }

    public function genre($slug)
    {
        $genre = Str::of($slug)->replace('-', ' ')->value(); // Misalnya: science-fiction → science fiction

        $novels = Novel::where('genre', 'LIKE', '%' . $genre . '%')->get();

        return view('genre-show', compact('novels', 'genre')); // 👈 GANTI di sini
    }
}
