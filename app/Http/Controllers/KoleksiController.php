<?php

namespace App\Http\Controllers;

use App\Models\KoleksiPribadi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KoleksiController extends Controller
{
    public function index()
    {
        $koleksi = KoleksiPribadi::where('user_id', Auth::id())->with('buku')->get();
        return view('user.koleksi.index', compact('koleksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
        ]);

        $exists = KoleksiPribadi::where('user_id', Auth::id())
            ->where('buku_id', $request->buku_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Buku sudah ada di koleksi Anda.');
        }

        KoleksiPribadi::create([
            'user_id' => Auth::id(),
            'buku_id' => $request->buku_id,
        ]);

        return back()->with('success', 'Buku berhasil ditambahkan ke koleksi.');
    }

    public function destroy($id)
    {
        KoleksiPribadi::where('user_id', Auth::id())->where('id', $id)->delete();
        return back()->with('success', 'Buku dihapus dari koleksi.');
    }
}
