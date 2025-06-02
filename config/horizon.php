<?php

use Illuminate\Support\Str;

return [

    /*--------------------------------------------------------------*/
    /*  Básicos                                                     */
    /*--------------------------------------------------------------*/

    'domain' => env('HORIZON_DOMAIN'),
    'path'   => env('HORIZON_PATH', 'horizon'),

    /*
    | Horizon guardará su “meta” en esta conexión Redis. 
    | Asegúrate de que exista en config/queue.php
    */
    'use'    => env('HORIZON_REDIS_CONNECTION', 'mixpost-redis'),

    'prefix' => env(
        'HORIZON_PREFIX',
        Str::slug(env('APP_NAME', 'mixpost'), '_').'_horizon:'
    ),

    'middleware' => ['web'],

    /*--------------------------------------------------------------*/
    /*  Umbrales de espera                                          */
    /*--------------------------------------------------------------*/

    'waits' => [
        // Dispara LongWaitDetected si un job espera > 60 s
        'mixpost-redis:default'       => 60,
        'mixpost-redis:publish-post'  => 60,
    ],

    /*--------------------------------------------------------------*/
    /*  Retención de jobs y métricas                                */
    /*--------------------------------------------------------------*/

    'trim' => [
        'recent'        => 60,        // 1 h
        'pending'       => 60,
        'completed'     => 60,
        'recent_failed' => 10080,     // 7 d
        'failed'        => 10080,
        'monitored'     => 10080,
    ],

    'metrics' => [
        'trim_snapshots' => [
            'job'   => 24,            // 24 h
            'queue' => 24,
        ],
    ],

    /*--------------------------------------------------------------*/
    /*  Otros                                                       */
    /*--------------------------------------------------------------*/

    'fast_termination' => false,
    'memory_limit'     => 128,        // MB
    'silenced'         => [],

    /*--------------------------------------------------------------*/
    /*  Config por defecto (se replica en todos los entornos)       */
    /*--------------------------------------------------------------*/

    'defaults' => [
        'supervisor-default' => [
            'connection'   => 'mixpost-redis',
            'queue'        => ['default'],
            'balance'      => 'auto',
            'minProcesses' => 1,
            'maxProcesses' => 3,
            'tries'        => 1,
            'timeout'      => 60,
            'memory'       => 256,
        ],
    ],

    /*--------------------------------------------------------------*/
    /*  Config específica por entorno                               */
    /*--------------------------------------------------------------*/

    'environments' => [

        /* ---------- Producción ---------- */
        'production' => [

            // Worker genérico
            'supervisor-default' => [
                'connection'       => 'mixpost-redis',
                'queue'            => ['default'],
                'balance'          => 'auto',
                'minProcesses'     => 1,
                'maxProcesses'     => 3,
                'balanceMaxShift'  => 1,
                'balanceCooldown'  => 3,
                'tries'            => 1,
                'timeout'          => 60,
            ],

            // Worker pesado para publicaciones programadas
            'mixpost-heavy' => [
                'connection'   => 'mixpost-redis',
                'queue'        => ['publish-post'],
                'balance'      => 'auto',
                'minProcesses' => 1,
                'maxProcesses' => 4,
                'tries'        => 1,
                'timeout'      => 3600,   // 1 h por vídeo largo
            ],
        ],

        /* ---------- Local / staging ---------- */
        'local' => [

            'supervisor-default' => [
                'connection' => 'mixpost-redis',
                'queue'      => ['default'],
                'balance'    => false,
                'processes'  => 1,
                'tries'      => 1,
                'timeout'    => 60,
            ],

            'mixpost-heavy' => [
                'connection' => 'mixpost-redis',
                'queue'      => ['publish-post'],
                'balance'    => false,
                'processes'  => 1,
                'tries'      => 1,
                'timeout'    => 3600,
            ],
        ],
    ],
];
