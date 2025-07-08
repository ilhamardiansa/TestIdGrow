<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasis';

    protected $fillable = [
        'kode_lokasi',
        'nama_lokasi',
    ];
    
    public function produks()
    {
        return $this->belongsToMany(Product::class, 'produk_lokasi', 'produk_id', 'lokasi_id')
                    ->withPivot('stok')
                    ->withTimestamps();
    }
}
