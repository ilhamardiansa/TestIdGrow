<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mutasis', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('jenis_mutasi', ['masuk', 'keluar']); // masuk = tambah stok, keluar = kurangi
            $table->integer('jumlah');
            $table->string('keterangan')->nullable();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('produk_lokasi_id')->constrained('produk_lokasi')->cascadeOnDelete();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mutasis');
    }
};
