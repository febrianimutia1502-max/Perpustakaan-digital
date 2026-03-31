<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        \App\Models\User::create([
            'username' => 'admin',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'email' => 'admin@gmail.com',
            'nama_lengkap' => 'Administrator',
            'alamat' => 'Jl. Admin No. 1',
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'username' => 'petugas',
            'password' => \Illuminate\Support\Facades\Hash::make('petugas123'),
            'email' => 'petugas@gmail.com',
            'nama_lengkap' => 'Petugas Satu',
            'alamat' => 'Jl. Petugas No. 1',
            'role' => 'petugas',
        ]);

        \App\Models\User::create([
             'username' => 'user1',
             'password' => \Illuminate\Support\Facades\Hash::make('user123'),
             'email' => 'user1@gmail.com',
             'nama_lengkap' => 'User Satu',
             'alamat' => 'Jl. User No. 1',
             'role' => 'peminjam',
         ]);

         // Kategori Buku
         $kat1 = \App\Models\KategoriBuku::create(['nama_kategori' => 'Fiksi']);
         $kat2 = \App\Models\KategoriBuku::create(['nama_kategori' => 'Non-Fiksi']);
         $kat3 = \App\Models\KategoriBuku::create(['nama_kategori' => 'Sejarah']);
         $kat4 = \App\Models\KategoriBuku::create(['nama_kategori' => 'Pendidikan']);

         // Buku
         $buku1 = \App\Models\Buku::create([
             'judul' => 'Laskar Pelangi',
             'penulis' => 'Andrea Hirata',
             'penerbit' => 'Bentang Pustaka',
             'tahun_terbit' => 2005,
         ]);
         $buku2 = \App\Models\Buku::create([
             'judul' => 'Bumi Manusia',
             'penulis' => 'Pramoedya Ananta Toer',
             'penerbit' => 'Hasta Mitra',
             'tahun_terbit' => 1980,
         ]);
         $buku3 = \App\Models\Buku::create([
             'judul' => 'Filosofi Teras',
             'penulis' => 'Henry Manampiring',
             'penerbit' => 'Kompas',
             'tahun_terbit' => 2018,
         ]);

         // Relasi Buku-Kategori
         \App\Models\KategoriBukuRelasi::create(['buku_id' => $buku1->id, 'kategori_id' => $kat1->id]);
         \App\Models\KategoriBukuRelasi::create(['buku_id' => $buku1->id, 'kategori_id' => $kat4->id]);
         \App\Models\KategoriBukuRelasi::create(['buku_id' => $buku2->id, 'kategori_id' => $kat1->id]);
         \App\Models\KategoriBukuRelasi::create(['buku_id' => $buku2->id, 'kategori_id' => $kat3->id]);
         \App\Models\KategoriBukuRelasi::create(['buku_id' => $buku3->id, 'kategori_id' => $kat2->id]);
     }
}
