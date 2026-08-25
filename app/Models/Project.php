<?php

namespace App\Models;

use App\Enums\ProjectImageKind;
use App\Models\Concerns\FormatsApproximatePrice;
use App\Models\Concerns\Publishable;
use Database\Factories\ProjectFactory;
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
 * @property int|null $service_id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property list<string>|null $work_items
 * @property string|null $price_from
 * @property string|null $currency
 * @property string $cta_label
 * @property int $sort_order
 * @property bool $is_published
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Business $business
 * @property-read Service|null $service
 * @property-read Collection<int, ProjectImage> $images
 */
#[Fillable([
    'business_id',
    'service_id',
    'name',
    'slug',
    'description',
    'work_items',
    'price_from',
    'currency',
    'cta_label',
    'sort_order',
    'is_published',
])]
class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use FormatsApproximatePrice, HasFactory, Publishable;

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'cta_label' => 'I Want The Same',
        'sort_order' => 0,
        'is_published' => false,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'work_items' => 'array',
            'price_from' => 'decimal:2',
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
     * @return BelongsTo<Service, $this>
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * @return HasMany<ProjectImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function coverImage(): ?ProjectImage
    {
        $images = $this->images;

        return $images->firstWhere('kind', ProjectImageKind::After)
            ?? $images->first();
    }
}
