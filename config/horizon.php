<?php

use Illuminate\Support\Str;

return [

    'domain' => env('HORIZON_DOMAIN'),
    'path'   => env('HORIZON_PATH', 'horizon'),
    'use'    => 'default',
    'prefix' => env('HORIZON_PREFIX', Str::slug(env('APP_NAME', 'mixpost'), '_').'_horizon:'),
    'middleware' => ['web'],

    'waits'  => ['redis:default' => 60],
    'trim'   => [
        'recent'        => 60,
        'pending'       => 60,
        'completed'     => 60,
        'recent_failed' => 10080,
        'failed'        => 10080,
        'monitored'     => 10080,
    ],
    'metrics' => ['trim_snapshots' => ['job' => 24, 'queue' => 24]],
    'fast_termination' => false,
    'memory_limit'     => 128,

    /* NO importa lo que pongas aquí; Horizon 5.32 no hereda si falta algún campo */
    'defaults' => [],

    'environments' => [

        /* ---------- PRODUCCIÓN ---------- */
        'production' => [

            // Worker genérico (cola “default”)
            'supervisor-1' => [
                'connection'       => 'mixpost-redis',
                'queue'            => ['default'],
                'balance'          => false,
                'processes'        => 3,
                'tries'            => 3,
                'timeout'          => 60,
                'balanceMaxShift'  => 1,
                'balanceCooldown'  => 3,
            ],

            'supervisor-redis' => [
                'connection'       => 'redis',
                'queue'            => ['default'],
                'balance'          => false,
                'processes'        => 3,
                'tries'            => 3,
                'timeout'          => 60,
                'balanceMaxShift'  => 1,
                'balanceCooldown'  => 3,
            ],

            // Worker pesado para publicaciones programadas
            'mixpost-heavy' => [
                'connection' => 'mixpost-redis',
                'queue'      => ['publish-post'],
                'balance'    => false,
                'processes'  => 4,
                'tries'      => 1,
                'timeout'    => 3600,
            ],
        ],

        /* ---------- LOCAL / STAGING ---------- */
        'local' => [

            'supervisor-1' => [
                'connection' => 'redis',
                'queue'      => ['default'],
                'balance'    => false,
                'processes'  => 1,
                'tries'      => 1,
                'timeout'    => 60,
            ],
        ],
    ],
];
