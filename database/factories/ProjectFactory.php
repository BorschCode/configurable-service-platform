<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->sentence(3);

        return [
            'business_id' => Business::factory(),
            'service_id' => null,
            'name' => Str::title($name),
            'slug' => Str::slug($name).'-'.fake()->unique()->numerify('##'),
            'description' => fake()->paragraph(),
            'work_items' => fake()->words(4),
            'price_from' => fake()->randomFloat(2, 500, 15000),
            'currency' => null,
            'cta_label' => 'I Want The Same',
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
