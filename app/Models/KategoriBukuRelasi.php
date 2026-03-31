<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBukuRelasi extends Model
{
    protected $table = 'kategoribuku_relasi';
    protected $fillable = ['buku_id', 'kategori_id'];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function kategoribuku()
    {
        return $this->belongsTo(KategoriBuku::class, 'kategori_id');
    }
}
