<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductRequest;
use App\Models\Mutasi;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
     public function index()
    {
        try {
            $products = Product::with('lokasis')->get();
            return responseSuccess('Daftar produk berhasil diambil', $products);
        } catch (\Exception $e) {
            return responseError('Gagal mengambil data produk', 500, [$e->getMessage()]);
        }
    }

    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        try {
            $product = Product::create($validated);

            if (isset($validated['lokasis'])) {
                $pivotData = [];
                foreach ($validated['lokasis'] as $lokasi) {
                    $pivotData[$lokasi['id']] = ['stok' => $lokasi['stok']];
                }
                $product->lokasis()->attach($pivotData);
            }

            return responseSuccess('Produk berhasil dibuat', $product->load('lokasis'));
        } catch (\Exception $e) {
            return responseError('Gagal membuat produk', 500, [$e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $product = Product::with('lokasis')->findOrFail($id);
            return responseSuccess('Detail produk berhasil diambil', $product);
        } catch (\Exception $e) {
            return responseError('Gagal mengambil detail produk', 404, [$e->getMessage()]);
        }
    }

    public function update(ProductRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            $product = Product::findOrFail($id);
            $product->update($validated);

            if (isset($validated['lokasis'])) {
                $pivotData = [];
                foreach ($validated['lokasis'] as $lokasi) {
                    $pivotData[$lokasi['id']] = ['stok' => $lokasi['stok']];
                }
                $product->lokasis()->sync($pivotData);
            }

            return responseSuccess('Produk berhasil diperbarui', $product->load('lokasis'));
        } catch (\Exception $e) {
            return responseError('Gagal memperbarui produk', 500, [$e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->lokasis()->detach();
            $product->delete();

            return responseSuccess('Produk berhasil dihapus');
        } catch (\Exception $e) {
            return responseError('Gagal menghapus produk', 500, [$e->getMessage()]);
        }
    }

    public function mutasiHistory($id)
    {
        try {
            $product = Product::with(['mutasis.user', 'mutasis.produkLokasi.lokasi'])->findOrFail($id);

            $mutasiHistory = $product->mutasis->map(function ($mutasi) {
                return [
                    'id'             => $mutasi->id,
                    'tanggal'        => $mutasi->tanggal,
                    'jenis_mutasi'   => $mutasi->jenis_mutasi,
                    'jumlah'         => $mutasi->jumlah,
                    'keterangan'     => $mutasi->keterangan,
                    'user'           => $mutasi->user ? $mutasi->user->name : null,
                    'lokasi'         => $mutasi->produkLokasi?->lokasi?->nama_lokasi,
                    'created_at'     => $mutasi->created_at,
                    'updated_at'     => $mutasi->updated_at,
                ];
            });

            return responseSuccess('Riwayat mutasi produk berhasil diambil', $mutasiHistory);
        } catch (\Exception $e) {
            return responseError('Gagal mengambil riwayat mutasi produk', 500, [$e->getMessage()]);
        }
    }
}
