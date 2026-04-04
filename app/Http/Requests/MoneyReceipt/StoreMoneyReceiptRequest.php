<?php
namespace App\Http\Requests\MoneyReceipt;

use Illuminate\Foundation\Http\FormRequest;

class StoreMoneyReceiptRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'customer_id'           => 'required|exists:customers,id',

            'payments'              => 'required|array',
            'payments.*.invoice_id' => 'required|exists:invoices,id',
            'payments.*.pay'        => 'nullable|numeric|min:0',
            'payments.*.discount'   => 'nullable|numeric|min:0',
        ];
    }
}