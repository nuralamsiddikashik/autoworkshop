<?php

namespace App\Http\Requests\JobCard;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobCardRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'car_receive_id' => 'required|exists:car_receives,id',
            'problem_note'   => 'nullable|string',
            'work_note'      => 'nullable|string',
        ];
    }

    public function messages(): array {
        return [
            'car_receive_id.required' => 'Car receive is required',
            'car_receive_id.exists'   => 'Invalid car receive selected',
        ];
    }
}