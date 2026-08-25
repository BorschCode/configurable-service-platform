<?php

namespace Database\Seeders;

use App\Enums\ProjectImageKind;
use App\Models\Business;
use App\Models\Project;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\TelegramBot;
use Illuminate\Database\Seeder;

class ApexConstructionSeeder extends Seeder
{
    /**
     * Seed the Apex Construction demo business.
     */
    public function run(): void
    {
        Business::query()->where('slug', 'apex-construction')->delete();

        $business = Business::query()->create([
            'name' => 'Apex Construction',
            'slug' => 'apex-construction',
            'description' => 'Residential renovation and building: bathrooms, kitchens, roofing, and new houses. See completed work, approximate prices, and estimated timelines.',
            'logo_url' => 'https://picsum.photos/seed/apex-construction-logo/240/240',
            'currency' => 'USD',
            'phone' => '+1 555 019 4410',
            'email' => 'hello@apexconstruction.example',
            'telegram' => 'apexbuilds',
            'address' => '92 Harbor Street, Portland, OR',
            'services_cta_label' => 'View Services',
            'portfolio_cta_label' => 'View Projects',
            'contact_cta_label' => 'Request a Quote',
            'is_published' => true,
        ]);

        $token = config('telegram.seed_tokens.apex-construction');

        TelegramBot::query()->create([
            'business_id' => $business->id,
            'username' => 'apexconstruction_bot',
            'mini_app_short_name' => 'catalog',
            'token' => filled($token) ? $token : null,
        ]);

        $interior = ServiceCategory::query()->create([
            'business_id' => $business->id,
            'name' => 'Interiors',
            'slug' => 'interiors',
            'sort_order' => 1,
        ]);

        $exterior = ServiceCategory::query()->create([
            'business_id' => $business->id,
            'name' => 'Structure',
            'slug' => 'structure',
            'sort_order' => 2,
        ]);

        $bathroom = $this->service($business, $interior, [
            'name' => 'Bathroom Renovation',
            'slug' => 'bathroom-renovation',
            'description' => 'Full bathroom gut and rebuild: waterproofing, tile, fixtures, and lighting. We handle permits for typical residential work.',
            'price_from' => 8500,
            'duration_estimate' => '3–5 weeks',
            'sort_order' => 1,
        ]);

        $kitchen = $this->service($business, $interior, [
            'name' => 'Kitchen Renovation',
            'slug' => 'kitchen-renovation',
            'description' => 'Cabinets, counters, appliances, and layout changes. Approximate pricing assumes mid-range finishes.',
            'price_from' => 18000,
            'duration_estimate' => '5–8 weeks',
            'sort_order' => 2,
        ]);

        $house = $this->service($business, $exterior, [
            'name' => 'House Construction',
            'slug' => 'house-construction',
            'description' => 'Custom home building from foundation through finishes. Quoted after site visit and drawings.',
            'price_from' => 220000,
            'duration_estimate' => '8–14 months',
            'sort_order' => 3,
        ]);

        $roofing = $this->service($business, $exterior, [
            'name' => 'Roofing',
            'slug' => 'roofing',
            'description' => 'Tear-off and reroof for asphalt, metal, or architectural shingles, including flashing and ventilation.',
            'price_from' => 12000,
            'duration_estimate' => '3–10 days',
            'sort_order' => 4,
        ]);

        $this->project($business, $bathroom, [
            'name' => 'Cedar Bath Refresh',
            'slug' => 'cedar-bath-refresh',
            'description' => 'Small bathroom converted to a walk-in shower with heated floor and recessed lighting.',
            'work_items' => ['Waterproofing', 'Walk-in shower', 'Heated floor', 'Lighting'],
            'price_from' => 11200,
            'sort_order' => 1,
            'image_seed' => 'cedar-bath',
        ]);

        $this->project($business, $kitchen, [
            'name' => 'Oak Street Kitchen',
            'slug' => 'oak-street-kitchen',
            'description' => 'Galley kitchen opened to the dining room with quartz counters and custom oak cabinets.',
            'work_items' => ['Layout change', 'Cabinets', 'Quartz counters', 'Lighting'],
            'price_from' => 24500,
            'sort_order' => 2,
            'image_seed' => 'oak-kitchen',
        ]);

        $this->project($business, $house, [
            'name' => 'Hillside New Build',
            'slug' => 'hillside-new-build',
            'description' => 'Three-bedroom hillside house with a daylight basement and covered deck.',
            'work_items' => ['Foundation', 'Framing', 'Exterior', 'Interiors'],
            'price_from' => 310000,
            'sort_order' => 3,
            'image_seed' => 'hillside-house',
        ]);

        $this->project($business, $roofing, [
            'name' => 'Harbor Street Reroof',
            'slug' => 'harbor-street-reroof',
            'description' => 'Architectural shingle reroof with new vents and ice-and-water shield.',
            'work_items' => ['Tear-off', 'Underlayment', 'Shingles', 'Flashing'],
            'price_from' => 14800,
            'sort_order' => 4,
            'image_seed' => 'harbor-roof',
        ]);
    }

    /**
     * @param  array{name: string, slug: string, description: string, price_from: float|int, duration_estimate: string, sort_order: int}  $attributes
     */
    private function service(Business $business, ServiceCategory $category, array $attributes): Service
    {
        return Service::query()->create([
            ...$attributes,
            'business_id' => $business->id,
            'service_category_id' => $category->id,
            'cta_label' => 'Request service',
            'is_published' => true,
        ]);
    }

    /**
     * @param  array{name: string, slug: string, description: string, work_items: list<string>, price_from: float|int, sort_order: int, image_seed: string}  $attributes
     */
    private function project(Business $business, Service $service, array $attributes): void
    {
        $seed = $attributes['image_seed'];
        unset($attributes['image_seed']);

        $project = Project::query()->create([
            ...$attributes,
            'business_id' => $business->id,
            'service_id' => $service->id,
            'cta_label' => 'I Want The Same',
            'is_published' => true,
        ]);

        $project->images()->createMany([
            [
                'kind' => ProjectImageKind::Before,
                'url' => "https://picsum.photos/seed/{$seed}-before/1200/800",
                'alt' => $project->name.' before',
                'sort_order' => 1,
            ],
            [
                'kind' => ProjectImageKind::After,
                'url' => "https://picsum.photos/seed/{$seed}-after/1200/800",
                'alt' => $project->name.' after',
                'sort_order' => 1,
            ],
        ]);
    }
}
