<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnalogTapeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:50', 'unique:analog_tapes,code'],
            'name' => ['required', 'string', 'max:255'],
            'media_format' => ['required', 'string', 'max:100'],
            'recording_year' => ['nullable', 'integer', 'min:1900', 'max:2026'],
            'physical_condition' => ['required', 'string', 'max:100'],
            'magnetic_degradation' => ['required', 'string', 'max:100'],
            'housing_status' => ['required', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
            'actions' => ['required', 'array', 'min:1'],
            'actions.*.action_name' => ['required', 'string', 'max:255'],
            'actions.*.priority' => ['required', 'string', 'in:Rendah,Sedang,Tinggi'],
            'actions.*.status' => ['required', 'string', 'in:Direncanakan,Berjalan,Selesai'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.unique' => 'Kode koleksi pita sudah terdaftar.',
            'actions.required' => 'Minimal harus ada satu rencana tindakan restorasi.',
            'actions.*.action_name.required' => 'Nama tindakan restorasi tidak boleh kosong.',
        ];
    }
}
