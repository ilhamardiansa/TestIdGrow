<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class LokasiRequest extends FormRequest
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
        $id = $this->route('lokasi');

        return [
            'kode_lokasi' => 'sometimes|required|string|max:50|unique:lokasis,kode_lokasi,' . $id,
            'nama_lokasi' => 'sometimes|required|string|max:255',
        ];
    }
}
