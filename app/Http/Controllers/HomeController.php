<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Novel;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil lebih banyak novel untuk carousel (minimal 12 untuk 2 slide)
        $latestNovels = Novel::latest()->take(12)->get();

        // Ambil genre unik dari novel
        $genres = Novel::select('genre')
            ->distinct()
            ->whereNotNull('genre')
            ->orderBy('genre')
            ->pluck('genre');

        // Ambil rekomendasi jika user login
        $recommendations = null;
        if (Auth::check()) {
            $recommendations = $this->getRecommendations();
        }

        return view('home', compact('latestNovels', 'genres', 'recommendations'));
    }

    private function getRecommendations()
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

        // Ambil novel berdasarkan sentimen komentar
        $recommendations = $this->getNovelsBySentiment($lastComment->sentiment);

        return [
            'comment' => $lastComment,
            'novels' => $recommendations,
        ];
    }

    private function getNovelsBySentiment($sentiment)
    {
        // Logika rekomendasi berdasarkan sentimen
        switch (strtolower($sentiment)) {
            case 'positive':
                // Untuk sentimen positif, rekomendasikan novel populer atau rating tinggi
                return Novel::latest()->take(6)->get();

            case 'negative':
                // Untuk sentimen negatif, rekomendasikan novel dengan genre berbeda atau yang lebih ringan
                return Novel::whereIn('genre', ['Comedy', 'Romance', 'Adventure'])
                    ->latest()
                    ->take(6)
                    ->get();

            case 'neutral':
                // Untuk sentimen netral, rekomendasikan novel terbaru
                return Novel::latest()->take(6)->get();

            default:
                return Novel::latest()->take(6)->get();
        }
    }
}