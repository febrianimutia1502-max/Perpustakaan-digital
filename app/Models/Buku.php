<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $fillable = ['judul', 'penulis', 'penerbit', 'tahun_terbit', 'cover', 'stok', 'deskripsi'];

    public function kategoribuku()
    {
        return $this->belongsToMany(KategoriBuku::class, 'kategoribuku_relasi', 'buku_id', 'kategori_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function ulasanbuku()
    {
        return $this->hasMany(UlasanBuku::class);
    }

    public function koleksipribadi()
    {
        return $this->hasMany(KoleksiPribadi::class);
    }
}
