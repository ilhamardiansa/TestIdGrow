<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk_lokasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lokasi_id')->constrained()->cascadeOnDelete();
            $table->integer('stok')->default(0);
            $table->timestamps();

            $table->unique(['produk_id', 'lokasi_id']); // prevent duplicate
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_lokasi');
    }
};
