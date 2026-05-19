<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreObatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_obat' => ['required', 'string', 'max:255'],
            'kemasan'   => ['required', 'string', 'max:35'],
            'harga'     => ['required', 'integer', 'min:0'],
            'stok'      => ['required', 'integer', 'min:0'],
        ];
    }
}
