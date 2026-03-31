<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Support\Facades\Auth;
class PeminjamanController extends Controller
{
    // For User
    public function index()
    {
        $peminjaman = Peminjaman::where('user_id', Auth::id())->with('buku.ulasanbuku')->get();
        return view('user.peminjaman.index', compact('peminjaman'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
        ]);
        $buku = Buku::findOrFail($request->buku_id);
        if ((int) $buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis.');
        }
        // Check if already borrowed and not returned
        $exists = Peminjaman::where('user_id', Auth::id())
            ->where('buku_id', $request->buku_id)
            ->whereIn('status_peminjaman', ['pending', 'dipinjam'])
            ->exists();
        if ($exists) {
            return back()->with('error', 'Anda sudah meminjam buku ini atau sedang dalam antrean.');
        }
        Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $request->buku_id,
            'tanggal_peminjaman' => now(),
            'status_peminjaman' => 'pending',
        ]);
        return back()->with('success', 'Permintaan peminjaman berhasil diajukan.');
    }

    // Cetak struk peminjaman
    public function cetak($id)
    {
        $pinjam = Peminjaman::with('buku', 'user')->findOrFail($id);
        return view('peminjaman.cetak', compact('pinjam'));
    }

    // For Admin/Petugas
    public function manage()
    {
        $peminjaman = Peminjaman::with(['user', 'buku.kategoribuku'])->latest()->get();
        $role = Auth::user()->role;
        return view($role . '.peminjaman.index', compact('peminjaman', 'role'));
    }
    public function confirm($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        if ($peminjaman->status_peminjaman !== 'pending') {
            return back()->with('error', 'Status peminjaman tidak valid untuk dikonfirmasi.');
        }
        $buku = Buku::findOrFail($peminjaman->buku_id);
        if ((int) $buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis. Tidak bisa konfirmasi peminjaman.');
        }
        $buku->decrement('stok');
        $peminjaman->update(['status_peminjaman' => 'dipinjam']);
        return back()->with('success', 'Peminjaman berhasil dikonfirmasi.');
    }
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        if ($peminjaman->status_peminjaman !== 'pending') {
            return back()->with('error', 'Status peminjaman tidak valid untuk ditolak.');
        }
        $peminjaman->update(['status_peminjaman' => 'ditolak']);
        return back()->with('success', 'Permintaan peminjaman berhasil ditolak.');
    }
    public function returnBook($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'status_peminjaman' => 'dikembalikan',
            'tanggal_pengembalian' => now(),
        ]);
        return back()->with('success', 'Buku telah dikembalikan, menunggu konfirmasi petugas.');
    }
    public function confirmReturn($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        if ($peminjaman->status_peminjaman !== 'dikembalikan') {
            return back()->with('error', 'Status peminjaman tidak valid untuk konfirmasi pengembalian.');
        }
        $peminjaman->update(['status_peminjaman' => 'selesai']);
        Buku::where('id', $peminjaman->buku_id)->increment('stok');
        return back()->with('success', 'Pengembalian berhasil dikonfirmasi.');
    }
}