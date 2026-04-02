<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'job_card_id'           => 'required|exists:job_cards,id',

            'parts'                 => 'nullable|array',
            'parts.*.name'          => 'nullable|string',
            'parts.*.qty'           => 'nullable|numeric',
            'parts.*.sell_price'    => 'nullable|numeric',

            'works'                 => 'nullable|array',
            'works.*.name'          => 'nullable|string',
            'works.*.qty'           => 'nullable|numeric',
            'works.*.sell_price'    => 'nullable|numeric',

            'services'              => 'nullable|array',
            'services.*.name'       => 'nullable|string',
            'services.*.qty'        => 'nullable|numeric',
            'services.*.sell_price' => 'nullable|numeric',
        ];
    }
}
