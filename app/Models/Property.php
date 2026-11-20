<?php

namespace App\Models;

use App\PropertyStatus;
use Database\Factories\PropertyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Property extends Model
{
    /** @use HasFactory<PropertyFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'reference', 'slug', 'title', 'type', 'purpose', 'status', 'city', 'neighborhood',
        'address', 'description', 'price', 'condominium_fee', 'property_tax', 'area',
        'bedrooms', 'suites', 'bathrooms', 'parking_spaces', 'features', 'featured', 'published_at',
    ];

    protected static function booted(): void
    {
        static::saving(function (Property $property): void {
            $property->slug = $property->slug ?: Str::slug($property->title);
        });
    }

    protected function casts(): array
    {
        return [
            'status' => PropertyStatus::class,
            'features' => 'array',
            'featured' => 'boolean',
            'published_at' => 'datetime',
            'price' => 'decimal:2',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->orderBy('position');
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    public function coverUrl(): ?string
    {
        $path = $this->images->firstWhere('is_cover', true)?->path ?? $this->images->first()?->path;

        if (! $path) {
            return null;
        }

        return Str::startsWith($path, ['http://', 'https://']) ? $path : asset('storage/'.$path);
    }
}
