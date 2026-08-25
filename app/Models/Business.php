<?php

namespace App\Models;

use App\Models\Concerns\Publishable;
use Database\Factories\BusinessFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string|null $logo_url
 * @property string $currency
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $telegram
 * @property string|null $address
 * @property string $services_cta_label
 * @property string $portfolio_cta_label
 * @property string $contact_cta_label
 * @property bool $is_published
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read TelegramBot|null $telegramBot
 * @property-read Collection<int, ServiceCategory> $serviceCategories
 * @property-read Collection<int, Service> $services
 * @property-read Collection<int, Project> $projects
 */
#[Fillable([
    'name',
    'slug',
    'description',
    'logo_url',
    'currency',
    'phone',
    'email',
    'telegram',
    'address',
    'services_cta_label',
    'portfolio_cta_label',
    'contact_cta_label',
    'is_published',
])]
class Business extends Model
{
    /** @use HasFactory<BusinessFactory> */
    use HasFactory, Publishable;

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'currency' => 'USD',
        'services_cta_label' => 'View Services',
        'portfolio_cta_label' => 'View Projects',
        'contact_cta_label' => 'Request a Quote',
        'is_published' => false,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return HasOne<TelegramBot, $this>
     */
    public function telegramBot(): HasOne
    {
        return $this->hasOne(TelegramBot::class);
    }

    /**
     * @return HasMany<ServiceCategory, $this>
     */
    public function serviceCategories(): HasMany
    {
        return $this->hasMany(ServiceCategory::class)->orderBy('sort_order')->orderBy('id');
    }

    /**
     * @return HasMany<Service, $this>
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class)->orderBy('sort_order')->orderBy('id');
    }

    /**
     * @return HasMany<Project, $this>
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class)->orderBy('sort_order')->orderBy('id');
    }
}
