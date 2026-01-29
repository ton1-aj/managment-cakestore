<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kue;
use App\Models\KategoriKue;
use App\Models\DataPegawai; // ← tambahkan ini

class AdminController extends Controller
{
    public function index()
    {
        return view('admin_dashboard', [
            'kue' => Kue::all(),
            'kategori_kue' => KategoriKue::all(),
            'data_pegawai' => DataPegawai::all(), // ← sekarang Laravel tahu class ini
        ]);
    }
}
