<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->sentence(3);

        return [
            'business_id' => Business::factory(),
            'service_category_id' => null,
            'name' => Str::title($name),
            'slug' => Str::slug($name).'-'.fake()->unique()->numerify('##'),
            'description' => fake()->paragraph(),
            'price_from' => fake()->randomFloat(2, 200, 8000),
            'price_to' => null,
            'currency' => null,
            'duration_estimate' => fake()->optional()->randomElement(['1–2 weeks', '2–4 weeks', '1–3 days']),
            'cta_label' => 'Request service',
            'sort_order' => fake()->numberBetween(0, 20),
            'is_published' => false,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_published' => true,
        ]);
    }
}
