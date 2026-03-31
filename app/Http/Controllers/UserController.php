<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use App\Models\Peminjaman;
use App\Models\UlasanBuku;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'peminjam')->get();
        return view('admin.user.index', compact('users'));
    }

    public function catalog()
    {
        $buku = Buku::with(['kategoribuku', 'ulasanbuku'])->get();
        $kategori = KategoriBuku::all();
        return view('user.catalog.index', compact('buku', 'kategori'));
    }

    public function show($id)
    {
        $buku = Buku::with(['ulasanbuku.user'])->findOrFail($id);

        // Cek apakah user ini punya peminjaman selesai untuk buku ini
        $peminjamanSelesai = Peminjaman::where('user_id', Auth::id())
            ->where('buku_id', $id)
            ->where('status_peminjaman', 'selesai')
            ->exists();

        // Ambil ulasan user yang sudah login (jika ada)
        $ulasanUser = UlasanBuku::where('user_id', Auth::id())
            ->where('buku_id', $id)
            ->first();

        return view('user.catalog.show', compact('buku', 'peminjamanSelesai', 'ulasanUser'));
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}
