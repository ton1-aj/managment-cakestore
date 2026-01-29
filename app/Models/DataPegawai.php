<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPegawai extends Model
{
    use HasFactory;

    protected $table = 'data_pegawai';
    protected $primaryKey = 'id_data_pegawai';

    protected $fillable = [
        'nama_pegawai',
        'alamat_pegawai',
        'posisi_pegawai',
        'jam_masuk',
        'jam_pulang',
        'gaji_pegawai',
        'foto_pegawai'
    ];
}
