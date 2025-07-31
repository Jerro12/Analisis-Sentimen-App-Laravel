<?php
// app/Http/Controllers/SentimentController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SentimentController extends Controller
{
    public function analyze(Request $request)
    {
        $text = $request->input('text');

        // Kirim request ke FastAPI
        $response = Http::post('http://127.0.0.1:8800/predict', [
            'text' => $text,
        ]);

        // Ambil hasil prediksi
        $result = $response->json();

        // Kembalikan response ke frontend atau simpan ke DB
        return response()->json([
            'text' => $text,
            'sentiment' => $result['label'],
            'score' => $result['score']
        ]);
    }
}
