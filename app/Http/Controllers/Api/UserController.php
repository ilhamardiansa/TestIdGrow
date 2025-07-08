<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();
            return responseSuccess('Daftar user', $users);
        } catch (\Exception $e) {
            return responseError('Gagal mengambil data user', 500, [$e->getMessage()]);
        }
    }

    public function store(UserRequest $request)
    {
        try {

            $validated = $request->validated();

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role' => $validated['role'] ?? 'user',
            ]);

            return responseSuccess('User berhasil ditambahkan', $user, 201);
        } catch (\Exception $e) {
            return responseError('Gagal menambahkan user', 500, [$e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return responseSuccess('Detail user', $user);
        } catch (\Exception $e) {
            return responseError('User tidak ditemukan', 404, [$e->getMessage()]);
        }
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validated();

            $user->update([
                'name' => $validated['name ']?? $user->name,
                'email' => $validated['email'] ?? $user->email,
                'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
                'role' => $validated['role'] ?? $user->role,
            ]);

            return responseSuccess('User berhasil diperbarui', $user);
        } catch (\Exception $e) {
            return responseError('Gagal memperbarui user', 500, [$e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return responseSuccess('User berhasil dihapus');
        } catch (\Exception $e) {
            return responseError('Gagal menghapus user', 500, [$e->getMessage()]);
        }
    }

    public function mutasiHistory($id)
    {
        try {
            $user = User::with([
                'mutasis.produk',
                'mutasis.produkLokasi.lokasi'
            ])->findOrFail($id);

            $mutasiHistory = $user->mutasis->map(function ($mutasi) {
                return [
                    'id'           => $mutasi->id,
                    'tanggal'      => $mutasi->tanggal,
                    'jenis_mutasi' => $mutasi->jenis_mutasi,
                    'jumlah'       => $mutasi->jumlah,
                    'keterangan'   => $mutasi->keterangan,
                    'produk'       => $mutasi->produk?->nama_produk,
                    'lokasi'       => $mutasi->produkLokasi?->lokasi?->nama_lokasi,
                    'created_at'   => $mutasi->created_at,
                    'updated_at'   => $mutasi->updated_at,
                ];
            });

            return responseSuccess('Riwayat mutasi user berhasil diambil', $mutasiHistory);
        } catch (\Exception $e) {
            return responseError('Gagal mengambil riwayat mutasi user', 500, [$e->getMessage()]);
        }
    }
}
