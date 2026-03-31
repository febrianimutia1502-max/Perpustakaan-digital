<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KoleksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    

    Route::resource('admin/buku', BukuController::class)->names([
        'index' => 'admin.buku.index',
        'store' => 'admin.buku.store',
        'update' => 'admin.buku.update',
        'destroy' => 'admin.buku.destroy',
    ]);
    
    Route::resource('admin/kategori', KategoriController::class)->names([
        'index' => 'admin.kategori.index',
        'store' => 'admin.kategori.store',
        'update' => 'admin.kategori.update',
        'destroy' => 'admin.kategori.destroy',
    ]);

    Route::resource('admin/petugas', PetugasController::class)->names([
        'index' => 'admin.petugas.index',
        'store' => 'admin.petugas.store',
        'update' => 'admin.petugas.update',
        'destroy' => 'admin.petugas.destroy',
    ]);

    Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user.index');
    Route::delete('/admin/user/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');

    Route::get('/admin/peminjaman', [PeminjamanController::class, 'manage'])->name('admin.peminjaman.index');
    Route::post('/admin/peminjaman/confirm/{id}', [PeminjamanController::class, 'confirm'])->name('admin.peminjaman.confirm');
    Route::post('/admin/peminjaman/reject/{id}', [PeminjamanController::class, 'reject'])->name('admin.peminjaman.reject');
    Route::post('/admin/peminjaman/confirm-return/{id}', [PeminjamanController::class, 'confirmReturn'])->name('admin.peminjaman.confirm-return');

    Route::get('/admin/ulasan', [UlasanController::class, 'index'])->name('admin.ulasan.index');
    Route::delete('/admin/ulasan/{id}', [UlasanController::class, 'destroy'])->name('admin.ulasan.destroy');

    Route::get('/admin/laporan/buku', [LaporanController::class, 'buku'])->name('admin.laporan.buku');
    Route::get('/admin/laporan/peminjaman', [LaporanController::class, 'peminjaman'])->name('admin.laporan.peminjaman');
    Route::get('/admin/laporan/user', [LaporanController::class, 'user'])->name('admin.laporan.user');
});

Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/petugas/dashboard', function () {
        return view('petugas.dashboard');
    })->name('petugas.dashboard');

    Route::resource('petugas/buku', BukuController::class)->names([
        'index' => 'petugas.buku.index',
        'store' => 'petugas.buku.store',
        'update' => 'petugas.buku.update',
        'destroy' => 'petugas.buku.destroy',
    ]);
    
    Route::resource('petugas/kategori', KategoriController::class)->names([
        'index' => 'petugas.kategori.index',
        'store' => 'petugas.kategori.store',
        'update' => 'petugas.kategori.update',
        'destroy' => 'petugas.kategori.destroy',
    ]);

    Route::get('/petugas/peminjaman', [PeminjamanController::class, 'manage'])->name('petugas.peminjaman.index');
    Route::post('/petugas/peminjaman/confirm/{id}', [PeminjamanController::class, 'confirm'])->name('petugas.peminjaman.confirm');
    Route::post('/petugas/peminjaman/reject/{id}', [PeminjamanController::class, 'reject'])->name('petugas.peminjaman.reject');
    Route::post('/petugas/peminjaman/confirm-return/{id}', [PeminjamanController::class, 'confirmReturn'])->name('petugas.peminjaman.confirm-return');

    Route::get('/petugas/laporan/buku', [LaporanController::class, 'buku'])->name('petugas.laporan.buku');
    Route::get('/petugas/laporan/peminjaman', [LaporanController::class, 'peminjaman'])->name('petugas.laporan.peminjaman');
});

Route::middleware(['auth', 'role:peminjam'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    Route::get('/user/catalog', [UserController::class, 'catalog'])->name('user.catalog.index');
    Route::get('/user/catalog/{id}', [UserController::class, 'show'])->name('user.catalog.show');
    Route::get('/user/peminjaman', [PeminjamanController::class, 'index'])->name('user.peminjaman.index');
    Route::post('/user/peminjaman', [PeminjamanController::class, 'store'])->name('user.peminjaman.store');
    Route::post('/user/peminjaman/return/{id}', [PeminjamanController::class, 'returnBook'])->name('user.peminjaman.return');

    // Route cetak struk - diperbaiki nama menjadi user.peminjaman.cetak
    Route::get('/user/peminjaman/cetak/{id}', [PeminjamanController::class, 'cetak'])->name('user.peminjaman.cetak');

    Route::get('/user/koleksi', [KoleksiController::class, 'index'])->name('user.koleksi.index');
    Route::post('/user/koleksi', [KoleksiController::class, 'store'])->name('user.koleksi.store');
    Route::delete('/user/koleksi/{id}', [KoleksiController::class, 'destroy'])->name('user.koleksi.destroy');

    Route::post('/user/ulasan', [UlasanController::class, 'store'])->name('user.ulasan.store');
    Route::put('/user/ulasan/{id}', [UlasanController::class, 'update'])->name('user.ulasan.update');
});