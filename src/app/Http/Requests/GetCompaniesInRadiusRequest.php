<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetCompaniesInRadiusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'radius' => 'required|numeric',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
