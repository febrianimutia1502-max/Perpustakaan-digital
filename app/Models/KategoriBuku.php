<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{
    protected $table = 'kategoribuku';
    protected $fillable = ['nama_kategori'];

    public function kategoribuku_relasi()
    {
        return $this->hasMany(KategoriBukuRelasi::class, 'kategori_id');
    }
}
