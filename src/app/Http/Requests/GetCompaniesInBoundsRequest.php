<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetCompaniesInBoundsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'top_left' => 'required|array',
            'top_left.lat' => 'required|numeric|between:-90,90',
            'top_left.lon' => 'required|numeric|between:-180,180',
            'bottom_right' => 'required|array',
            'bottom_right.lat' => 'required|numeric|between:-90,90',
            'bottom_right.lon' => 'required|numeric|between:-180,180',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
