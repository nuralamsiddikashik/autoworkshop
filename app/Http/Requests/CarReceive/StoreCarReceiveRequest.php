<?php

namespace App\Http\Requests\CarReceive;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarReceiveRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'customer_id'     => 'required|exists:customers,id',
            'car_brand_id'    => 'required|exists:car_brands,id',
            'car_model_id'    => 'required|exists:car_models,id',

            'vin'             => 'nullable|string|max:255',
            'registration_no' => 'nullable|string|max:255',
            'odometer'        => 'nullable|integer',

            'note'            => 'nullable|string',
        ];
    }
}
