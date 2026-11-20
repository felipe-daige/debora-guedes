<?php

namespace Database\Factories;

use App\Models\Property;
use App\PropertyStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(4);

        return [
            'reference' => 'IM-'.fake()->unique()->numberBetween(1000, 9999),
            'slug' => fake()->unique()->slug(), 'title' => $title, 'type' => 'Apartamento',
            'purpose' => 'sale', 'status' => PropertyStatus::Draft, 'city' => 'Itapema',
            'neighborhood' => 'Meia Praia', 'description' => fake()->paragraph(), 'price' => 850000,
            'area' => 110, 'bedrooms' => 3, 'suites' => 1, 'parking_spaces' => 2,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (): array => ['status' => PropertyStatus::Published, 'published_at' => now()]);
    }
}
