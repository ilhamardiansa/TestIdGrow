<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            $credentials = $request->only('email', 'password');

            try {
                if (!$token = JWTAuth::attempt($credentials)) {
                    return responseSuccess('Email atau password salah', [], 401);
                }
            } catch (JWTException $e) {
                return responseSuccess('Gagal membuat token', [], 500);
            }

            $user = Auth::user();

            return responseSuccess('Login berhasil', [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60, // default 1 jam
                'user' => $user,
            ]);
        } catch (\Exception $e) {
            return responseError('Terjadi kesalahan saat login: ' . $e->getMessage(), 500);
        }
    }
}
