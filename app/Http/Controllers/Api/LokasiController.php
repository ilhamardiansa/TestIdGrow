<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LokasiRequest;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LokasiController extends Controller
{
    public function index()
    {
        try {
            $lokasis = Lokasi::all();
            return responseSuccess('Daftar lokasi berhasil diambil', $lokasis);
        } catch (\Exception $e) {
            return responseError('Gagal mengambil data lokasi', 500, [$e->getMessage()]);
        }
    }

    public function store(LokasiRequest $request)
    {
        $validated = $request->validated();

        try {
            $lokasi = Lokasi::create($validated);
            return responseSuccess('Lokasi berhasil dibuat', $lokasi);
        } catch (\Exception $e) {
            return responseError('Gagal membuat lokasi', 500, [$e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $lokasi = Lokasi::findOrFail($id);
            return responseSuccess('Detail lokasi berhasil diambil', $lokasi);
        } catch (\Exception $e) {
            return responseError('Gagal mengambil detail lokasi', 404, [$e->getMessage()]);
        }
    }

    public function update(LokasiRequest $request, $id)
    {
        $validated = $request->validated();

        try {
            $lokasi = Lokasi::findOrFail($id);
            $lokasi->update($validated);

            return responseSuccess('Lokasi berhasil diperbarui', $lokasi);
        } catch (\Exception $e) {
            return responseError('Gagal memperbarui lokasi', 500, [$e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $lokasi = Lokasi::findOrFail($id);
            $lokasi->delete();

            return responseSuccess('Lokasi berhasil dihapus');
        } catch (\Exception $e) {
            return responseError('Gagal menghapus lokasi', 500, [$e->getMessage()]);
        }
    }
}
