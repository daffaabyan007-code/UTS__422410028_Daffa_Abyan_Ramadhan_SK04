<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAnalogTapeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tapeId = $this->route('tape')->id;

        return [
            'code' => ['required', 'string', 'max:50', Rule::unique('analog_tapes', 'code')->ignore($tapeId)],
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
}
