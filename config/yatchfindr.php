<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'BOAT_TYPES' => [
            'Personal Watercraft' => 'Personal Watercraft',
            'Power' => 'Power Boat',
            'Sail' => 'Sail Boat'
        ],
        'ENGINE_TYPES' => [
            'Electric' => 'Electric',
            'Inboard' => 'Inboard',
            'Outboard' => 'Outboard',
            'Other' => 'Other',
        ],
        'FUEL_TYPES' => [
            'Diesel' => 'Diesel',
            'Electric' => 'Electric',
            'Gasoline' => 'Gasoline',
            'LPG' => 'LPG',
            'Other' => 'Other',

        ],

        'CURRENCY_CODES' => [
            'United States' => [ 'currency_code' => 'USD', 'flag_code' => 'us'],
            'Canada' => [ 'currency_code' => 'CAD', 'flag_code' => 'ca'],
            'Australia' =>  [ 'currency_code' => 'AUD', 'flag_code' => 'au'],
            'United Kingdom'    =>  [ 'currency_code' => 'GBP', 'flag_code' => 'gb'],
            'Europe' => ['currency_code' => 'EUR', 'flag_code' => 'eu'],
            'Japan' => [ 'currency_code' => 'JPY', 'flag_code' => 'jp']
        ],

        'YEAR_START' => 1977,
        'DEFAULT_PLAN_ID' => 2,
        'ALPHABETS' => ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'],
        'ELECTRICAL_SYSTEM' => ['12 VDC','110 VDC','220 VDC'],
        'MILES' => ['EXACT', 10, 25, 50, 100, 200, 500, 1000, 'ANY Distance']
    ],



];
