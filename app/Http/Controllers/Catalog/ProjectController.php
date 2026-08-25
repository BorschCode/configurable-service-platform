<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Project;
use App\Support\CatalogPayload;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(Business $business): Response
    {
        $projects = $business->projects()
            ->published()
            ->with('images')
            ->get()
            ->map(fn (Project $project): array => CatalogPayload::projectSummary($project, $business->currency))
            ->values();

        return Inertia::render('catalog/portfolio/index', [
            'business' => CatalogPayload::business($business),
            'projects' => $projects,
        ]);
    }

    public function show(Business $business, Project $project): Response
    {
        $project->load('images');

        return Inertia::render('catalog/portfolio/show', [
            'business' => CatalogPayload::business($business),
            'project' => CatalogPayload::projectDetail($project, $business->currency),
        ]);
    }
}
