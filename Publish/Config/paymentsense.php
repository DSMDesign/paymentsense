<?php

return [
    'end_point' => env('PAYMENTSENSE_PAC_ENDPOINT', ''),      // End point is unique for each merchant
    'api_key'   => env('PAYMENTSENSE_PAC_API', ''),           // Key used for basic auth (PASSWORD)
    'api_user'  => env('PAYMENTSENSE_PAC_USER', 'default'),   // The User name can be anything
    'house_id'  => env('PAYMENTSENSE_HOUSE_ID', ''),          // NOT SURE IF THIS IS NEEDED
    'in_demo'   => true                                       // make sure this is false once live
];
