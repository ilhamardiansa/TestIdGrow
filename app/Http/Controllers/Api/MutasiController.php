<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MutasiRequest;
use App\Models\Mutasi;
use Illuminate\Http\Request;

class MutasiController extends Controller
{
     public function index()
    {
        try {
            $mutasis = Mutasi::with(['user', 'produkLokasi.produk', 'produkLokasi.lokasi'])->get();
            return responseSuccess('Daftar mutasi berhasil diambil', $mutasis);
        } catch (\Exception $e) {
            return responseError('Gagal mengambil data mutasi', 500, [$e->getMessage()]);
        }
    }

    public function store(MutasiRequest $request)
    {
        $validated = $request->validated();

        try {
            $mutasi = Mutasi::create($validated);
            return responseSuccess('Mutasi berhasil dibuat', $mutasi->load(['user', 'produkLokasi.produk', 'produkLokasi.lokasi']));
        } catch (\Exception $e) {
            return responseError('Gagal membuat mutasi', 500, [$e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $mutasi = Mutasi::with(['user', 'produkLokasi.produk', 'produkLokasi.lokasi'])->findOrFail($id);
            return responseSuccess('Detail mutasi berhasil diambil', $mutasi);
        } catch (\Exception $e) {
            return responseError('Gagal mengambil detail mutasi', 404, [$e->getMessage()]);
        }
    }

    public function update(MutasiRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            $mutasi = Mutasi::findOrFail($id);
            $mutasi->update($validated);
            return responseSuccess('Mutasi berhasil diperbarui', $mutasi->load(['user', 'produkLokasi.produk', 'produkLokasi.lokasi']));
        } catch (\Exception $e) {
            return responseError('Gagal memperbarui mutasi', 500, [$e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $mutasi = Mutasi::findOrFail($id);
            $mutasi->delete();

            return responseSuccess('Mutasi berhasil dihapus');
        } catch (\Exception $e) {
            return responseError('Gagal menghapus mutasi', 500, [$e->getMessage()]);
        }
    }
}
