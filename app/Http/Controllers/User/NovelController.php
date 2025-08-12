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

        $search = trim($request->search);
        $showAll = $request->query('show') === 'all';

        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('author', 'like', '%' . $search . '%');
        }

        $novels = $showAll
            ? $query->latest()->get()
            : $query->latest()->take(20)->get();

        return view('search', compact('novels', 'search', 'showAll'));
    }
    public function show(Request $request, $id)
    {
        $novel = Novel::findOrFail($id);
        $recommendations = null;

        if (Auth::check()) {
            $recommendations = $this->getRecommendations($novel);
        }

        $from = $request->query('from'); // tangkap query ?from=bookmark

        return view('novel-show', compact('novel', 'recommendations', 'from'));
    }


    private function getRecommendations(Novel $novel)
    {
        $user = Auth::user();

        // Ambil komentar user untuk novel ini saja, dengan sentimen yang sudah dianalisis
        $lastComment = $user->comments()
            ->where('novel_id', $novel->id)
            ->whereNotNull('sentiment')
            ->latest()
            ->first();

        // Kalau user belum pernah berkomentar di novel ini, jangan tampilkan rekomendasi
        if (!$lastComment) {
            return null;
        }

        // Ambil novel-novel lain dengan genre sama
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
