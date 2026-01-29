<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_pegawai', function (Blueprint $table) {
            $table->id('id_data_pegawai');
            $table->string('nama_pegawai', 255);
            $table->text('alamat_pegawai');
            $table->string('posisi_pegawai', 255);
            $table->time('jam_masuk');
            $table->time('jam_pulang');
            $table->integer('gaji_pegawai');
            $table->string('foto_pegawai', 255);
            $table->timestamps();
        });
        //
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
