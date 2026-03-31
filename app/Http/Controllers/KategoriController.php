<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\KategoriBuku;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = KategoriBuku::all();
        $role = auth()->user()->role;
        return view($role . '.kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategoribuku',
        ]);

        KategoriBuku::create($request->all());

        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategoribuku,nama_kategori,' . $id,
        ]);

        $kategori = KategoriBuku::findOrFail($id);
        $kategori->update($request->all());

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        KategoriBuku::findOrFail($id)->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
