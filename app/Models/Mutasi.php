<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Mutasi extends Model
{
    use HasFactory;
    protected $table = 'mutasis';

    protected $fillable = [
        'tanggal',
        'jenis_mutasi',
        'jumlah',
        'keterangan',
        'user_id',
        'produk_id',
        'lokasi_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produkLokasi()
    {
        return $this->belongsTo(ProdukLokasi::class, 'produk_lokasi_id');
    }

   protected static function boot()
    {
        parent::boot();

        static::creating(function ($mutasi) {
            $produkLokasi = ProdukLokasi::where('produk_id', $mutasi->produk_id)
                                        ->where('lokasi_id', $mutasi->lokasi_id)
                                        ->first();

            if (!$produkLokasi) {
                throw new ModelNotFoundException("Produk pada lokasi ini tidak ditemukan");
            }

            if ($mutasi->jenis_mutasi === 'masuk') {
                $produkLokasi->stok += $mutasi->jumlah;
            } elseif ($mutasi->jenis_mutasi === 'keluar') {
                if ($produkLokasi->stok < $mutasi->jumlah) {
                    throw new \Exception("Stok tidak cukup untuk mutasi keluar");
                }
                $produkLokasi->stok -= $mutasi->jumlah;
            }

            $produkLokasi->save();
        });

        static::updating(function ($mutasi) {
            $produkLokasi = ProdukLokasi::where('produk_id', $mutasi->produk_id)
                                        ->where('lokasi_id', $mutasi->lokasi_id)
                                        ->first();

            if (!$produkLokasi) {
                throw new ModelNotFoundException("Produk pada lokasi ini tidak ditemukan");
            }

            $original = $mutasi->getOriginal();

            $oldJenis = $original['jenis_mutasi'];
            $oldJumlah = $original['jumlah'];

            $newJenis = $mutasi->jenis_mutasi;
            $newJumlah = $mutasi->jumlah;

            if ($oldJenis === 'masuk') {
                $produkLokasi->stok -= $oldJumlah;
            } elseif ($oldJenis === 'keluar') {
                $produkLokasi->stok += $oldJumlah;
            }

            if ($newJenis === 'masuk') {
                $produkLokasi->stok += $newJumlah;
            } elseif ($newJenis === 'keluar') {
                if ($produkLokasi->stok < $newJumlah) {
                    throw new \Exception("Stok tidak cukup untuk mutasi keluar (update)");
                }
                $produkLokasi->stok -= $newJumlah;
            }

            if ($produkLokasi->stok < 0) {
                throw new \Exception("Stok menjadi negatif setelah update mutasi");
            }

            $produkLokasi->save();
        });

        static::deleting(function ($mutasi) {
            $produkLokasi = ProdukLokasi::where('produk_id', $mutasi->produk_id)
                                        ->where('lokasi_id', $mutasi->lokasi_id)
                                        ->first();

            if (!$produkLokasi) {
                throw new ModelNotFoundException("Produk pada lokasi ini tidak ditemukan");
            }

            if ($mutasi->jenis_mutasi === 'masuk') {
                if ($produkLokasi->stok < $mutasi->jumlah) {
                    throw new \Exception("Tidak bisa hapus mutasi masuk karena stok sudah digunakan");
                }
                $produkLokasi->stok -= $mutasi->jumlah;
            } elseif ($mutasi->jenis_mutasi === 'keluar') {
                $produkLokasi->stok += $mutasi->jumlah;
            }

            $produkLokasi->save();
        });
    }

    public function produk()
    {
        return $this->belongsTo(Product::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }
}
