<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KueController;
use App\Http\Controllers\KategoriKueController;
use App\Http\Controllers\DataPegawaiController;

Route::get('/', function () {
    return view('welcome');
});

route::get('/about', function () {
    return view('about');
});

// Routes untuk Kue
Route::get('/kue', [KueController::class, 'index'])->name('kue');
Route::post('/kue', [KueController::class, 'store'])->name('kue.store');
Route::put('/kue/{id}', [KueController::class, 'update'])->name('kue.update');
Route::delete('/kue/{id}', [KueController::class, 'destroy'])->name('kue.destroy');
Route::get('/kue/{id}/edit', [KueController::class, 'edit'])->name('kue.edit');


// Routes untuk Kategori Kue
Route::get('/kategori_kue', [KategoriKueController::class, 'index'])->name('kategori_kue');
Route::post('/kategori.kue', [KategoriKueController::class, 'store'])->name('kategori_kue.store');
Route::put('/kategori-kue/{id}', [KategoriKueController::class, 'update'])->name('kategori_kue.update');
Route::delete('/kategori-kue/{id}', [KategoriKueController::class, 'destroy'])->name('kategori_kue.destroy');



// Routes untuk Data Pegawai
Route::get('/data_pegawai', [DataPegawaiController::class, 'index'])->name('data_pegawai');
Route::post('/data_pegawai', [DataPegawaiController::class, 'store'])->name('data_pegawai.store');
Route::put('/data_pegawai/{id}', [DataPegawaiController::class, 'update'])->name('data_pegawai.update');
Route::delete('/data_pegawai/{id}', [DataPegawaiController::class, 'destroy'])->name('data_pegawai.destroy');

