<?php
namespace App\Http\Requests\CarModel;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarModelRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'car_brand_id' => 'required|exists:car_brands,id',
            'name'         => 'required|string|max:255',
            'is_active'    => 'nullable|boolean',
        ];
    }
}