<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Novel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $novel = Novel::findOrFail($id);

        // Kirim komentar ke FastAPI untuk analisis sentimen
        $response = Http::post('http://127.0.0.1:8800/predict', [
            'text' => $request->comment,
        ]);

        $data = $response->successful() ? $response->json() : [];

        $sentiment = $data['sentiment'] ?? 'unknown';
        $score     = $data['score'] ?? null;

        // Log respons FastAPI
        Log::info('FastAPI response:', $data);

        // Simpan komentar ke database
        Comment::create([
            'user_id'   => Auth::id(),
            'novel_id'  => $novel->id,
            'content'   => $request->comment,
            'sentiment' => $sentiment,
            'score'     => $score,
            'status'    => 'active',
        ]);

        return redirect()->route('novel.show', $novel->id)->with('success', 'Komentar berhasil dikirim.');
    }
}
