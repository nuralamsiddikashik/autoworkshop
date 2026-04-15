<?php

return [
    'units'                   => array_values(
        array_filter(
            array_map(
                'trim',
                explode( ',', (string) env( 'INVOICE_UNITS', '' ) )
            )
        )
    ),
    'hidden_list_password'    => env(
        'INVOICE_HIDDEN_LIST_PASSWORD',
        'nur@123'
    ),
    'hidden_list_session_key' => 'hidden_invoice_access_granted',
];
