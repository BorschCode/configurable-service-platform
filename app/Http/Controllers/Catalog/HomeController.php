<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Project;
use App\Models\Service;
use App\Support\CatalogPayload;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(Business $business): Response
    {
        $services = $business->services()
            ->published()
            ->with('serviceCategory')
            ->limit(4)
            ->get()
            ->map(fn (Service $service): array => CatalogPayload::service($service, $business->currency))
            ->values();

        $projects = $business->projects()
            ->published()
            ->with('images')
            ->limit(3)
            ->get()
            ->map(fn (Project $project): array => CatalogPayload::projectSummary($project, $business->currency))
            ->values();

        return Inertia::render('catalog/home', [
            'business' => CatalogPayload::business($business),
            'services' => $services,
            'projects' => $projects,
        ]);
    }
}
