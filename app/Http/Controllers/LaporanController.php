<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

use PDF;

class LaporanController extends Controller
{
    public function buku(Request $request)
    {
        $query = Buku::query();

        if ($request->filled('nama')) {
            $query->where('judul', 'like', '%' . $request->nama . '%');
        }

        $buku = $query->get();

        if ($request->has('print')) {
            $pdf = PDF::loadView('admin.laporan.pdf.buku', compact('buku'));
            return $pdf->download('laporan-buku.pdf');
        }

        return view('admin.laporan.buku', compact('buku'));
    }

    public function peminjaman(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku']);

        if ($request->filled('nama')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->nama . '%');
            });
        }

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('tanggal_peminjaman', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $peminjaman = $query->get();

        if ($request->has('print')) {
            $pdf = PDF::loadView('admin.laporan.pdf.peminjaman', compact('peminjaman'));
            return $pdf->download('laporan-peminjaman.pdf');
        }

        return view('admin.laporan.peminjaman', compact('peminjaman'));
    }

    public function user(Request $request)
    {
        $query = User::where('role', 'peminjam');

        if ($request->filled('nama')) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama . '%');
        }

        $users = $query->get();

        if ($request->has('print')) {
            $pdf = PDF::loadView('admin.laporan.pdf.user', compact('users'));
            return $pdf->download('laporan-user.pdf');
        }

        return view('admin.laporan.user', compact('users'));
    }
}
