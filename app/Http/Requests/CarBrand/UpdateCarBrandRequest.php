<?php
namespace App\Http\Requests\CarBrand;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarBrandRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name'      => 'required|string|max:255|unique:car_brands,name,' . $this->id,
            'is_active' => 'nullable|boolean',
        ];
    }
}