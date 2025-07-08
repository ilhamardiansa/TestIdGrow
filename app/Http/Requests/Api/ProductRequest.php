<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $id = $this->route('product'); 

        return [
            'nama_produk'        => 'sometimes|required|string|max:255',
            'kode_produk'        => 'sometimes|required|string|max:100|unique:produks,kode_produk,' . $id,
            'kategori'           => 'sometimes|required|string|max:100',
            'satuan'             => 'sometimes|required|string|max:50',
            'lokasis'            => 'array',
            'lokasis.*.id'       => 'required|exists:lokasis,id',
            'lokasis.*.stok'     => 'required|integer|min:0',
        ];
    }
}
