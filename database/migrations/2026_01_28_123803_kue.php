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
        Schema::create('kue', function (Blueprint $table) {
            $table->id('id_kue');
            $table->unsignedBigInteger('id_kategori_kue');
            $table->string('nama_kue', 255);
            $table->text('komposisi_kue');
            $table->integer('harga_kue');
            $table->integer('stok_kue');
            $table->string('foto_kue', 255);
            $table->timestamps();

            $table->foreign('id_kategori_kue')->references('id_kategori_kue')->on('kategori_kue')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
