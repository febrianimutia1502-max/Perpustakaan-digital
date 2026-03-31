<?php
namespace App\Http\Controllers;

use App\Models\UlasanBuku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    // Admin: tampilkan semua ulasan
    public function index()
    {
        $ulasan = UlasanBuku::with(['user', 'buku'])->latest()->get();
        return view('admin.ulasan.index', compact('ulasan'));
    }

    // User: simpan ulasan baru
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'ulasan'  => 'required|string|max:1000',
            'rating'  => 'required|integer|min:1|max:5',
        ]);

        // Cek eligibilitas: user harus pernah meminjam dan status sudah 'selesai'
        $eligible = Peminjaman::where('user_id', Auth::id())
            ->where('buku_id', $request->buku_id)
            ->where('status_peminjaman', 'selesai')
            ->exists();

        if (!$eligible) {
            return back()->with('error', 'Anda hanya bisa memberi ulasan setelah buku berhasil dikembalikan dan dikonfirmasi.');
        }

        UlasanBuku::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'buku_id' => $request->buku_id,
            ],
            [
                'ulasan' => $request->ulasan,
                'rating' => $request->rating,
            ]
        );

        return back()->with('success', 'Ulasan berhasil dikirim.');
    }

    // User: update ulasan yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'ulasan' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $ulasan = UlasanBuku::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $ulasan->update([
            'ulasan' => $request->ulasan,
            'rating' => $request->rating,
        ]);

        return back()->with('success', 'Ulasan berhasil diperbarui.');
    }

    // Admin: hapus ulasan
    public function destroy($id)
    {
        UlasanBuku::findOrFail($id)->delete();
        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}