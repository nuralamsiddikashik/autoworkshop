<?php

namespace App\Http\Requests\CarBrand;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarBrandRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name'      => 'required|string|max:255|unique:car_brands,name',
            'is_active' => 'nullable|boolean',
        ];
    }
}