<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Novel;
use Illuminate\Http\Request;

class NovelController extends Controller
{
    public function index(Request $request)
    {
        $query = Novel::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('author', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        $novels = $query->latest()->paginate(10)->withQueryString();

        return view('admin.novels.index', compact('novels'));
    }

    public function create()
    {
        return view('admin.novels.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'author'    => 'required|string|max:255',
            'genre'     => 'required|string|max:100',
            'year'      => 'required|digits:4|integer',
            'pages'     => 'required|integer',
            'synopsis'  => 'nullable|string',
            'photo'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('novel_covers', 'public');
        }

        Novel::create($data);

        return redirect()->route('admin.novels.index')->with('success', 'Novel berhasil ditambahkan!');
    }

    public function edit(Novel $novel)
    {
        return view('admin.novels.edit', compact('novel'));
    }

    public function update(Request $request, Novel $novel)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'author'    => 'required|string|max:255',
            'genre'     => 'required|string|max:100',
            'year'      => 'required|digits:4|integer',
            'pages'     => 'required|integer',
            'synopsis'  => 'nullable|string',
            'photo'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('novel_covers', 'public');
        }

        $novel->update($data);

        return redirect()->route('admin.novels.index')->with('success', 'Novel berhasil diperbarui!');
    }

    public function destroy(Novel $novel)
    {
        $novel->delete();
        return redirect()->route('admin.novels.index')->with('success', 'Novel berhasil dihapus!');
    }
}
