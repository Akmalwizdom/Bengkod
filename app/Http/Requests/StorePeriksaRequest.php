<?php

namespace App\Http\Requests;

use App\Services\ObatService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StorePeriksaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_daftar_poli' => ['required', 'exists:daftar_poli,id'],
            'obat_json'      => ['required', 'json'],
            'catatan'        => ['nullable', 'string'],
            'biaya_periksa'  => ['required', 'integer', 'min:0'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $obatIds = json_decode($this->obat_json, true) ?? [];
            $errors = app(ObatService::class)->validasiStokResep($obatIds);

            foreach ($errors as $error) {
                $validator->errors()->add('obat_json', $error);
            }
        });
    }
}
