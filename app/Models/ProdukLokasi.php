<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukLokasi extends Model
{
    use HasFactory;

    protected $table = 'produk_lokasi';

    protected $fillable = [
        'produk_id',
        'lokasi_id',
        'stok',
    ];

    /**
     * Relasi ke Produk
     */
    public function produk()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relasi ke Lokasi
     */
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }
}
