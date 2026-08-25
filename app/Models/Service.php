<?php

namespace App\Models;

use App\Models\Concerns\FormatsApproximatePrice;
use App\Models\Concerns\Publishable;
use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $business_id
 * @property int|null $service_category_id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string|null $price_from
 * @property string|null $price_to
 * @property string|null $currency
 * @property string|null $duration_estimate
 * @property string $cta_label
 * @property int $sort_order
 * @property bool $is_published
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Business $business
 * @property-read ServiceCategory|null $serviceCategory
 * @property-read Collection<int, Project> $projects
 */
#[Fillable([
    'business_id',
    'service_category_id',
    'name',
    'slug',
    'description',
    'price_from',
    'price_to',
    'currency',
    'duration_estimate',
    'cta_label',
    'sort_order',
    'is_published',
])]
class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use FormatsApproximatePrice, HasFactory, Publishable;

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'cta_label' => 'Request service',
        'sort_order' => 0,
        'is_published' => false,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price_from' => 'decimal:2',
            'price_to' => 'decimal:2',
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        $query = parent::resolveRouteBindingQuery($query, $value, $field);

        return $query->where('is_published', true);
    }

    /**
     * @return BelongsTo<Business, $this>
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    /**
     * @return BelongsTo<ServiceCategory, $this>
     */
    public function serviceCategory(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    /**
     * @return HasMany<Project, $this>
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class)->orderBy('sort_order')->orderBy('id');
    }
}
