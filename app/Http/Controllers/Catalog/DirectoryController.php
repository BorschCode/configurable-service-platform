<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Support\CatalogPayload;
use Inertia\Inertia;
use Inertia\Response;

class DirectoryController extends Controller
{
    public function __invoke(): Response
    {
        $businesses = Business::query()
            ->published()
            ->orderBy('name')
            ->get()
            ->map(fn (Business $business): array => CatalogPayload::directoryItem($business))
            ->values();

        return Inertia::render('catalog/directory', [
            'businesses' => $businesses,
        ]);
    }
}
