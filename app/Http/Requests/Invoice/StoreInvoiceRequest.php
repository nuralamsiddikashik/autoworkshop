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

            // 🔥 ADD THESE (MOST IMPORTANT)
            'vat'                   => 'nullable|numeric',
            'grand_total'           => 'nullable|numeric',
            'bill_amount'           => 'nullable|numeric',

            'parts'                 => 'nullable|array',
            'parts.*.name'          => 'nullable|string',
            'parts.*.qty'           => 'nullable|numeric',
            'parts.*.buy_price'     => 'nullable|numeric',
            'parts.*.unit'          => 'nullable|string',
            'parts.*.unit_price'    => 'nullable|numeric',
            'parts.*.sell_price'    => 'nullable|numeric',

            'works'                 => 'nullable|array',
            'works.*.name'          => 'nullable|string',
            'works.*.qty'           => 'nullable|numeric',
            'works.*.buy_price'     => 'nullable|numeric',
            'works.*.unit'          => 'nullable|string',
            'works.*.unit_price'    => 'nullable|numeric',
            'works.*.sell_price'    => 'nullable|numeric',

            'services'              => 'nullable|array',
            'services.*.name'       => 'nullable|string',
            'services.*.qty'        => 'nullable|numeric',
            'services.*.buy_price'  => 'nullable|numeric',
            'services.*.unit'       => 'nullable|string',
            'services.*.unit_price' => 'nullable|numeric',
            'services.*.sell_price' => 'nullable|numeric',
        ];
    }
}
