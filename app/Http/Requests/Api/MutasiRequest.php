<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class MutasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tanggal'      => 'sometimes|required|date',
            'jenis_mutasi' => 'sometimes|required|in:masuk,keluar',
            'jumlah'       => 'sometimes|required|integer|min:1',
            'keterangan'   => 'nullable|string|max:255',
            'user_id'      => 'sometimes|required|exists:users,id',
            'produk_id'    => 'sometimes|required|exists:produks,id',
            'lokasi_id'    => 'sometimes|required|exists:lokasis,id',
        ];
    }
}
