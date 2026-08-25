<?php

namespace App\Models;

use Database\Factories\TelegramBotFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $business_id
 * @property string $username
 * @property int|null $telegram_id
 * @property string|null $mini_app_short_name
 * @property string|null $token
 * @property string|null $webhook_secret
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Business $business
 */
#[Fillable([
    'business_id',
    'username',
    'telegram_id',
    'mini_app_short_name',
    'token',
    'webhook_secret',
])]
#[Hidden(['token', 'webhook_secret'])]
class TelegramBot extends Model
{
    /** @use HasFactory<TelegramBotFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'telegram_id' => 'integer',
            'token' => 'encrypted',
            'webhook_secret' => 'encrypted',
        ];
    }

    /**
     * @return BelongsTo<Business, $this>
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }
}
