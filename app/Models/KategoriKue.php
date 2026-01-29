<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriKue extends Model
{
    use HasFactory;

    // Nama tabel (karena bukan plural default Laravel)
    protected $table = 'kategori_kue';

    // Primary key custom
    protected $primaryKey = 'id_kategori_kue';

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'nama_kategori_kue',
        'gambar_kategori_kue'
    ];

    // Jika suatu saat relasi ke tabel kue
    public function kue()
    {
        return $this->hasMany(Kue::class, 'id_kategori_kue', 'id_kategori_kue');
    }
}
