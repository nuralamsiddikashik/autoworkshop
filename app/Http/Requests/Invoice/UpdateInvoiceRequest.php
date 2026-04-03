<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | Rules
    |--------------------------------------------------------------------------
     */
    public function rules(): array {
        return [

            'job_card_id'           => 'required|exists:job_cards,id',
            'vat'                   => 'nullable|numeric',
            'grand_total'           => 'nullable|numeric',
            'bill_amount'           => 'nullable|numeric',

            /*
            |--------------------------------------------------------------------------
            | Parts
            |--------------------------------------------------------------------------
             */
            'parts'                 => 'nullable|array',
            'parts.*.name'          => 'nullable|string|max:255',
            'parts.*.qty'           => 'required_with:parts.*.name|numeric|min:1',
            'parts.*.buy_price'     => 'nullable|numeric|min:0',
            'parts.*.unit'          => 'nullable|string|max:50',
            'parts.*.unit_price'    => 'required_with:parts.*.name|numeric|min:0',
            'parts.*.sell_price'    => 'required_with:parts.*.name|numeric|min:0',

            /*
            |--------------------------------------------------------------------------
            | Works
            |--------------------------------------------------------------------------
             */
            'works'                 => 'nullable|array',
            'works.*.name'          => 'nullable|string|max:255',
            'works.*.qty'           => 'required_with:works.*.name|numeric|min:1',
            'works.*.buy_price'     => 'nullable|numeric|min:0',
            'works.*.unit'          => 'nullable|string|max:50',
            'works.*.unit_price'    => 'required_with:works.*.name|numeric|min:0',
            'works.*.sell_price'    => 'required_with:works.*.name|numeric|min:0',

            /*
            |--------------------------------------------------------------------------
            | Services
            |--------------------------------------------------------------------------
             */
            'services'              => 'nullable|array',
            'services.*.name'       => 'nullable|string|max:255',
            'services.*.qty'        => 'required_with:services.*.name|numeric|min:1',
            'services.*.buy_price'  => 'nullable|numeric|min:0',
            'services.*.unit'       => 'nullable|string|max:50',
            'services.*.unit_price' => 'required_with:services.*.name|numeric|min:0',
            'services.*.sell_price' => 'required_with:services.*.name|numeric|min:0',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Custom Validation (🔥 MUST)
    |--------------------------------------------------------------------------
     */
    public function withValidator( $validator ) {
        $validator->after( function ( $validator ) {

            $hasParts = collect( $this->parts ?? [] )
                ->filter( fn( $item ) => !empty( $item['name'] ) )
                ->count();

            $hasWorks = collect( $this->works ?? [] )
                ->filter( fn( $item ) => !empty( $item['name'] ) )
                ->count();

            $hasServices = collect( $this->services ?? [] )
                ->filter( fn( $item ) => !empty( $item['name'] ) )
                ->count();

            if ( $hasParts === 0 && $hasWorks === 0 && $hasServices === 0 ) {
                $validator->errors()->add( 'items', 'At least one item is required' );
            }
        } );
    }

    /*
    |--------------------------------------------------------------------------
    | Messages (Optional but PRO 🔥)
    |--------------------------------------------------------------------------
     */
    public function messages(): array {
        return [
            'job_card_id.required'       => 'Job Card is required',
            'job_card_id.exists'         => 'Invalid Job Card',

            '*.qty.required_with'        => 'Quantity is required',
            '*.qty.min'                  => 'Quantity must be at least 1',

            '*.unit_price.required_with' => 'Unit price required',
            '*.sell_price.required_with' => 'Sell price required',
        ];
    }
}