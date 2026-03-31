<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Buku;
use App\Models\KategoriBuku;
use App\Models\KategoriBukuRelasi;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategoribuku')->get();
        $kategori = KategoriBuku::all();
        $role = auth()->user()->role;
        return view($role . '.buku.index', compact('buku', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'kategori_id' => 'required|array',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        $buku = Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'cover' => $coverPath,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
        ]);

        $buku->kategoribuku()->attach($request->kategori_id);

        return back()->with('success', 'Buku berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'kategori_id' => 'required|array',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $coverPath = $buku->cover;
        if ($request->hasFile('cover')) {
            if ($coverPath) {
                Storage::disk('public')->delete($coverPath);
            }
            $coverPath = $request->file('cover')->store('covers', 'public');
        }

        $buku->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'cover' => $coverPath,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
        ]);

        $buku->kategoribuku()->sync($request->kategori_id);

        return back()->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Buku::findOrFail($id)->delete();
        return back()->with('success', 'Buku berhasil dihapus.');
    }
}
