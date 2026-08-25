<?php

namespace App\Support;

use App\Enums\ProjectImageKind;
use App\Models\Business;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Service;
use App\Models\ServiceCategory;

class CatalogPayload
{
    /**
     * @return array{
     *     name: string,
     *     slug: string,
     *     description: string,
     *     logo_url: string|null
     * }
     */
    public static function directoryItem(Business $business): array
    {
        return [
            'name' => $business->name,
            'slug' => $business->slug,
            'description' => $business->description,
            'logo_url' => $business->logo_url,
        ];
    }

    /**
     * @return array{
     *     name: string,
     *     slug: string,
     *     description: string,
     *     logo_url: string|null,
     *     currency: string,
     *     services_cta_label: string,
     *     portfolio_cta_label: string,
     *     contact_cta_label: string
     * }
     */
    public static function business(Business $business): array
    {
        return [
            'name' => $business->name,
            'slug' => $business->slug,
            'description' => $business->description,
            'logo_url' => $business->logo_url,
            'currency' => $business->currency,
            'services_cta_label' => $business->services_cta_label,
            'portfolio_cta_label' => $business->portfolio_cta_label,
            'contact_cta_label' => $business->contact_cta_label,
        ];
    }

    /**
     * @return array{
     *     phone: string|null,
     *     email: string|null,
     *     telegram: string|null,
     *     address: string|null
     * }
     */
    public static function contact(Business $business): array
    {
        return [
            'phone' => $business->phone !== null && $business->phone !== '' ? $business->phone : null,
            'email' => $business->email !== null && $business->email !== '' ? $business->email : null,
            'telegram' => $business->telegram !== null && $business->telegram !== '' ? $business->telegram : null,
            'address' => $business->address !== null && $business->address !== '' ? $business->address : null,
        ];
    }

    /**
     * @return array{
     *     name: string,
     *     slug: string,
     *     description: string,
     *     price_label: string|null,
     *     duration_estimate: string|null,
     *     cta_label: string,
     *     category: string|null
     * }
     */
    public static function service(Service $service, string $fallbackCurrency): array
    {
        return [
            'name' => $service->name,
            'slug' => $service->slug,
            'description' => $service->description,
            'price_label' => $service->approximatePriceLabel($fallbackCurrency),
            'duration_estimate' => $service->duration_estimate,
            'cta_label' => $service->cta_label,
            'category' => $service->serviceCategory?->name,
        ];
    }

    /**
     * @return array{name: string, slug: string, services: array<int, array<string, mixed>>}
     */
    public static function category(ServiceCategory $category, string $fallbackCurrency): array
    {
        return [
            'name' => $category->name,
            'slug' => $category->slug,
            'services' => $category->services
                ->map(fn (Service $service): array => self::service($service, $fallbackCurrency))
                ->values()
                ->all(),
        ];
    }

    /**
     * @return array{
     *     name: string,
     *     slug: string,
     *     description: string,
     *     price_label: string|null,
     *     cta_label: string,
     *     work_items: list<string>,
     *     cover_url: string|null,
     *     cover_alt: string|null
     * }
     */
    public static function projectSummary(Project $project, string $fallbackCurrency): array
    {
        $cover = $project->coverImage();

        return [
            'name' => $project->name,
            'slug' => $project->slug,
            'description' => $project->description,
            'price_label' => $project->approximatePriceLabel($fallbackCurrency),
            'cta_label' => $project->cta_label,
            'work_items' => $project->work_items ?? [],
            'cover_url' => $cover?->url,
            'cover_alt' => $cover?->alt,
        ];
    }

    /**
     * @return array{
     *     name: string,
     *     slug: string,
     *     description: string,
     *     price_label: string|null,
     *     cta_label: string,
     *     work_items: list<string>,
     *     images: array{before: array<int, array{url: string, alt: string|null}>, after: array<int, array{url: string, alt: string|null}>, gallery: array<int, array{url: string, alt: string|null}>}
     * }
     */
    public static function projectDetail(Project $project, string $fallbackCurrency): array
    {
        return [
            ...self::projectSummary($project, $fallbackCurrency),
            'images' => [
                'before' => self::imagesOfKind($project, ProjectImageKind::Before),
                'after' => self::imagesOfKind($project, ProjectImageKind::After),
                'gallery' => self::imagesOfKind($project, ProjectImageKind::Gallery),
            ],
        ];
    }

    /**
     * @return array<int, array{url: string, alt: string|null}>
     */
    private static function imagesOfKind(Project $project, ProjectImageKind $kind): array
    {
        return $project->images
            ->filter(fn (ProjectImage $image): bool => $image->kind === $kind)
            ->map(fn (ProjectImage $image): array => [
                'url' => $image->url,
                'alt' => $image->alt,
            ])
            ->values()
            ->all();
    }
}
