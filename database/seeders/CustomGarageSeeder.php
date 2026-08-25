<?php

namespace Database\Seeders;

use App\Enums\ProjectImageKind;
use App\Models\Business;
use App\Models\Project;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\TelegramBot;
use Illuminate\Database\Seeder;

class CustomGarageSeeder extends Seeder
{
    /**
     * Seed the Custom Garage automotive demo business.
     */
    public function run(): void
    {
        Business::query()->where('slug', 'custom-garage')->delete();

        $business = Business::query()->create([
            'name' => 'Custom Garage',
            'slug' => 'custom-garage',
            'description' => 'Car customization and restoration. Body kits, wraps, performance work, and show-ready paint — with approximate pricing and completed builds you can request.',
            'logo_url' => 'https://picsum.photos/seed/custom-garage-logo/240/240',
            'currency' => 'USD',
            'phone' => '+1 555 014 2200',
            'email' => 'hello@customgarage.example',
            'telegram' => 'customgarage',
            'address' => '1840 Industrial Way, Los Angeles, CA',
            'services_cta_label' => 'View Services',
            'portfolio_cta_label' => 'View Projects',
            'contact_cta_label' => 'Request a Quote',
            'is_published' => true,
        ]);

        $token = config('telegram.seed_tokens.custom-garage');

        TelegramBot::query()->create([
            'business_id' => $business->id,
            'username' => 'customgarage_bot',
            'mini_app_short_name' => 'catalog',
            'token' => filled($token) ? $token : null,
        ]);

        $body = ServiceCategory::query()->create([
            'business_id' => $business->id,
            'name' => 'Body',
            'slug' => 'body',
            'sort_order' => 1,
        ]);

        $appearance = ServiceCategory::query()->create([
            'business_id' => $business->id,
            'name' => 'Appearance',
            'slug' => 'appearance',
            'sort_order' => 2,
        ]);

        $performance = ServiceCategory::query()->create([
            'business_id' => $business->id,
            'name' => 'Performance',
            'slug' => 'performance',
            'sort_order' => 3,
        ]);

        $bodyKit = $this->service($business, $body, [
            'name' => 'Body Kit Installation',
            'slug' => 'body-kit-installation',
            'description' => 'Fitment, alignment, and finishing for aftermarket body kits. We mock up, paint-match when needed, and leave panel gaps consistent.',
            'price_from' => 800,
            'duration_estimate' => '3–7 days',
            'sort_order' => 1,
        ]);

        $this->service($business, $appearance, [
            'name' => 'Full Car Wrap',
            'slug' => 'full-car-wrap',
            'description' => 'Color change or printed vinyl wrap, including door jams on request. Paint protection film available as an add-on.',
            'price_from' => 1200,
            'duration_estimate' => '4–8 days',
            'sort_order' => 2,
        ]);

        $this->service($business, $performance, [
            'name' => 'Custom Exhaust',
            'slug' => 'custom-exhaust',
            'description' => 'Mandrel-bent systems, valved setups, and sound tuning without drowning the cabin.',
            'price_from' => 950,
            'duration_estimate' => '2–5 days',
            'sort_order' => 3,
        ]);

        $this->service($business, $performance, [
            'name' => 'Suspension Setup',
            'slug' => 'suspension-setup',
            'description' => 'Coilovers, alignment, and corner balancing for street or track use.',
            'price_from' => 1100,
            'duration_estimate' => '1–3 days',
            'sort_order' => 4,
        ]);

        $this->service($business, $appearance, [
            'name' => 'Show Paint',
            'slug' => 'show-paint',
            'description' => 'Correction, respray, and ceramic-ready finishing for custom colors.',
            'price_from' => 2500,
            'duration_estimate' => '2–4 weeks',
            'sort_order' => 5,
        ]);

        $project = Project::query()->create([
            'business_id' => $business->id,
            'service_id' => $bodyKit->id,
            'name' => 'BMW M4 Custom Build',
            'slug' => 'bmw-m4-custom-build',
            'description' => 'Full visual and chassis refresh: kit, exhaust, suspension, and a custom paint match for a weekend car that still drives daily.',
            'work_items' => [
                'Body kit',
                'Custom exhaust',
                'Suspension',
                'Paint',
            ],
            'price_from' => 4500,
            'cta_label' => 'I Want The Same',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        $project->images()->createMany([
            [
                'kind' => ProjectImageKind::Before,
                'url' => 'https://picsum.photos/seed/bmw-m4-before/1200/800',
                'alt' => 'BMW M4 before customization',
                'sort_order' => 1,
            ],
            [
                'kind' => ProjectImageKind::After,
                'url' => 'https://picsum.photos/seed/bmw-m4-after/1200/800',
                'alt' => 'BMW M4 after custom build',
                'sort_order' => 1,
            ],
            [
                'kind' => ProjectImageKind::Gallery,
                'url' => 'https://picsum.photos/seed/bmw-m4-detail/1200/800',
                'alt' => 'Detail shot of the finished M4',
                'sort_order' => 1,
            ],
        ]);

        $wrapProject = Project::query()->create([
            'business_id' => $business->id,
            'name' => 'Midnight Wrap GT',
            'slug' => 'midnight-wrap-gt',
            'description' => 'Satin black wrap with a gloss roof and color-matched calipers.',
            'work_items' => [
                'Full wrap',
                'Roof gloss black',
                'Caliper color',
            ],
            'price_from' => 1800,
            'sort_order' => 2,
            'is_published' => true,
        ]);

        $wrapProject->images()->createMany([
            [
                'kind' => ProjectImageKind::Before,
                'url' => 'https://picsum.photos/seed/gt-before/1200/800',
                'alt' => 'GT before wrap',
                'sort_order' => 1,
            ],
            [
                'kind' => ProjectImageKind::After,
                'url' => 'https://picsum.photos/seed/gt-after/1200/800',
                'alt' => 'GT after midnight wrap',
                'sort_order' => 1,
            ],
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
}
