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
        Schema::table('mutasis', function (Blueprint $table) {
            $table->dropForeign(['produk_lokasi_id']); 
            $table->dropColumn('produk_lokasi_id');
            $table->unsignedBigInteger('produk_id');
            $table->unsignedBigInteger('lokasi_id');

            $table->foreign('produk_id')->references('id')->on('produks')->onDelete('cascade');
            $table->foreign('lokasi_id')->references('id')->on('lokasis')->onDelete('cascade');
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
