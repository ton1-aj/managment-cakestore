<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kue extends Model
{
    protected $table = 'kue';
    protected $primaryKey = 'id_kue';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_kategori_kue',
        'nama_kue',
        'komposisi_kue',
        'harga_kue',
        'stok_kue',
        'foto_kue'
    ];


    /**
     * Relasi ke KategoriKue
     * Kue belongsTo KategoriKue
     */
    public function kategoriKue()
    {
        return $this->belongsTo(
            KategoriKue::class,
            'id_kategori_kue',
            'id_kategori_kue'
        );
    }
}
