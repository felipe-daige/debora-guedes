<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\PropertyStatus;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        return view('pages.home', ['properties' => $this->publishedProperties(3)]);
    }

    public function properties(): View
    {
        return view('pages.properties', ['properties' => $this->publishedProperties()]);
    }

    public function property(string $slug): View
    {
        $property = Property::with('images')->where('slug', $slug)->where('status', PropertyStatus::Published)->firstOrFail();

        return view('pages.property', ['property' => $this->toCardData($property)]);
    }

    public function services(): View
    {
        return view('pages.services');
    }

    public function photography(): View
    {
        return view('pages.photography');
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    /** @return array<int, array<string, mixed>> */
    private function publishedProperties(?int $limit = null): array
    {
        $query = Property::with('images')->where('status', PropertyStatus::Published)->latest('published_at');

        return $query->when($limit, fn ($query) => $query->limit($limit))->get()->map(fn (Property $property) => $this->toCardData($property))->all();
    }

    /** @return array<string, mixed> */
    private function toCardData(Property $property): array
    {
        return [
            'id' => $property->id, 'slug' => $property->slug, 'category' => $property->type,
            'status' => $property->purpose === 'rent' ? 'Locação' : 'Venda',
            'location' => collect([$property->neighborhood, $property->city])->filter()->join(', '),
            'type' => $property->type, 'title' => $property->title, 'description' => $property->description,
            'price' => $property->price ? 'R$ '.number_format((float) $property->price, 2, ',', '.') : 'Valor sob consulta',
            'area' => $property->area ? number_format((float) $property->area, 0, ',', '.').' m²' : 'Sob consulta',
            'rooms' => $property->bedrooms, 'suites' => $property->suites, 'parking' => $property->parking_spaces,
            'image' => $property->coverUrl() ?? asset('images/property-placeholder.svg'), 'reference' => $property->reference,
        ];
    }
}
