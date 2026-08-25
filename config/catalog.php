<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Reserved first-path segments
    |--------------------------------------------------------------------------
    |
    | Business slugs must never collide with platform routes. Catalog catch-all
    | routes exclude these names so Fortify, Filament, and health checks win.
    |
    */

    'reserved_slugs' => [
        'login',
        'register',
        'forgot-password',
        'reset-password',
        'two-factor-challenge',
        'two-factor',
        'confirm-password',
        'verify-email',
        'dashboard',
        'settings',
        'manage',
        'storage',
        'up',
        'livewire',
        'filament',
    ],

];
