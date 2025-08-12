<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Comment;
use App\Models\Novel;

class DashboardController extends Controller
{
    public function index()
    {
        $recentUsers = User::latest()->take(3)->get()->map(function ($user) {
            return [
                'type' => 'user',
                'message' => "Pengguna baru mendaftar: {$user->name}",
                'time' => $user->created_at,
            ];
        });

        $recentNovels = Novel::latest()->take(3)->get()->map(function ($novel) {
            return [
                'type' => 'novel',
                'message' => "Novel baru diterbitkan: {$novel->title}",
                'time' => $novel->created_at,
            ];
        });

        $recentComments = Comment::latest()->take(3)->get()->map(function ($comment) {
            return [
                'type' => 'comment',
                'message' => "Komentar baru ditambahkan oleh {$comment->user->name}",
                'time' => $comment->created_at,
            ];
        });

        $recentActivities = collect()
            ->merge($recentUsers)
            ->merge($recentNovels)
            ->merge($recentComments)
            ->sortByDesc('time')
            ->take(5);

        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalNovels' => Novel::count(),
            'totalComments' => Comment::count(),
            'recentActivities' => $recentActivities,
        ]);
    }
}