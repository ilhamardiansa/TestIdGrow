<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'produks';

    protected $fillable = [
        'nama_produk',
        'kode_produk',
        'kategori',
        'satuan',
    ];

    public function lokasis()
    {
        return $this->belongsToMany(Lokasi::class, 'produk_lokasi', 'produk_id', 'lokasi_id')
                    ->withPivot('stok')
                    ->withTimestamps();
    }

    public function mutasis()
    {
        return $this->hasMany(
            Mutasi::class,                
            'produk_id',                
            'id',    
        );
    }
}
