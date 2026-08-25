<?php

namespace Database\Factories;

use App\Enums\ProjectImageKind;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectImage>
 */
class ProjectImageFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $seed = fake()->unique()->slug();

        return [
            'project_id' => Project::factory(),
            'kind' => fake()->randomElement(ProjectImageKind::cases()),
            'url' => "https://picsum.photos/seed/{$seed}/1200/800",
            'alt' => fake()->sentence(4),
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}
