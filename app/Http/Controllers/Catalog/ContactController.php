<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Support\CatalogPayload;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function __invoke(Business $business): Response
    {
        return Inertia::render('catalog/contact', [
            'business' => CatalogPayload::business($business),
            'contact' => CatalogPayload::contact($business),
        ]);
    }
}
