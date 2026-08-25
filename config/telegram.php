<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Demo seeder bot tokens
    |--------------------------------------------------------------------------
    |
    | Optional local overrides for seeded TelegramBot rows. Never commit real
    | tokens. Production bots should be stored encrypted on telegram_bots.
    |
    */

    'seed_tokens' => [
        'custom-garage' => env('TELEGRAM_BOT_TOKEN_CUSTOM_GARAGE'),
        'apex-construction' => env('TELEGRAM_BOT_TOKEN_APEX_CONSTRUCTION'),
    ],

];
