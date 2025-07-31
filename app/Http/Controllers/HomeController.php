<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Novel;

class HomeController extends Controller
{
    public function index()
    {
        $latestNovels = Novel::latest()->take(5)->get(); // Ambil 5 novel terbaru

        // Ambil genre unik dari novel
        $genres = Novel::select('genre')
            ->distinct()
            ->whereNotNull('genre')
            ->orderBy('genre')
            ->pluck('genre');

        return view('home', compact('latestNovels', 'genres'));
    }
}
