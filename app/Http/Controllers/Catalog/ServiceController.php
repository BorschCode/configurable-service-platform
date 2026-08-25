<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Project;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Support\CatalogPayload;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(Business $business): Response
    {
        $categories = $business->serviceCategories()
            ->with('services')
            ->get()
            ->map(function (ServiceCategory $category) use ($business): ?array {
                $category->setRelation(
                    'services',
                    $category->services->where('is_published', true)->values(),
                );

                if ($category->services->isEmpty()) {
                    return null;
                }

                return CatalogPayload::category($category, $business->currency);
            })
            ->filter()
            ->values();

        $uncategorized = $business->services()
            ->published()
            ->whereNull('service_category_id')
            ->with('serviceCategory')
            ->get()
            ->map(fn (Service $service): array => CatalogPayload::service($service, $business->currency))
            ->values();

        return Inertia::render('catalog/services/index', [
            'business' => CatalogPayload::business($business),
            'categories' => $categories,
            'uncategorized' => $uncategorized,
        ]);
    }

    public function show(Business $business, Service $service): Response
    {
        $service->load('serviceCategory');

        $projects = $service->projects()
            ->published()
            ->with('images')
            ->get()
            ->map(fn (Project $project): array => CatalogPayload::projectSummary($project, $business->currency))
            ->values();

        return Inertia::render('catalog/services/show', [
            'business' => CatalogPayload::business($business),
            'service' => CatalogPayload::service($service, $business->currency),
            'projects' => $projects,
        ]);
    }
}
