<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\TelegramBot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TelegramBot>
 */
class TelegramBotFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'business_id' => Business::factory(),
            'username' => fake()->unique()->userName().'_bot',
            'telegram_id' => null,
            'mini_app_short_name' => null,
            'token' => null,
            'webhook_secret' => null,
        ];
    }
}
