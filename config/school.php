<?php

return [
    'name' => env('SCHOOL_NAME', 'Elunora School'),
    'tagline' => env('SCHOOL_TAGLINE', 'School of Art'),

    'address' => env('SCHOOL_ADDRESS', 'Jl. Magnolia No. 17, The Aurora Residence, Kota Lavendra'),
    'phone' => env('SCHOOL_PHONE', '(021) 7788-9900'),
    'email' => env('SCHOOL_EMAIL', 'info@elunoraschool.sch.id'),
    'website' => env('SCHOOL_WEBSITE', config('app.url')), // fallback to APP_URL if available

    // Optional data (fill via .env as needed)
    'headmaster' => env('SCHOOL_HEADMASTER', null),
    'hours' => [
        // Example: 'Senin-Jumat 08.00-16.00'
        env('SCHOOL_HOURS_1', ''),
        env('SCHOOL_HOURS_2', ''),
    ],
    'programs' => array_filter([
        env('SCHOOL_PROGRAM_1', ''),
        env('SCHOOL_PROGRAM_2', ''),
        env('SCHOOL_PROGRAM_3', ''),
    ]),
    'vision' => env('SCHOOL_VISION', ''),
    'mission' => array_filter([
        env('SCHOOL_MISSION_1', ''),
        env('SCHOOL_MISSION_2', ''),
        env('SCHOOL_MISSION_3', ''),
    ]),
];
