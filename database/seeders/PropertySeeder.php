<?php

namespace Database\Seeders;

use App\Models\Property;
use App\PropertyStatus;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('site.properties', []) as $index => $item) {
            $property = Property::updateOrCreate(['slug' => $item['slug']], [
                'reference' => 'DG-'.str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT),
                'title' => $item['title'], 'type' => $item['type'], 'purpose' => 'sale',
                'status' => PropertyStatus::Published, 'city' => 'Itapema', 'neighborhood' => $item['location'],
                'description' => $item['description'], 'price' => $this->price($item['price']),
                'area' => $this->area($item['area']), 'bedrooms' => $item['rooms'] ?? null,
                'suites' => $item['suites'] ?? null, 'parking_spaces' => $item['parking'] ?? null,
                'featured' => $index < 3, 'published_at' => now()->subMinutes($index),
            ]);
            $property->images()->updateOrCreate(['position' => 0], ['path' => $item['image'], 'alt_text' => $item['title'], 'is_cover' => true]);
        }
    }

    private function price(string $value): ?float
    {
        return str_contains($value, 'R$') ? (float) str_replace(['R$', '.', ','], ['', '', '.'], $value) : null;
    }

    private function area(string $value): ?float
    {
        preg_match('/[\d.]+/', str_replace('.', '', $value), $matches);

        return isset($matches[0]) ? (float) $matches[0] : null;
    }
}
