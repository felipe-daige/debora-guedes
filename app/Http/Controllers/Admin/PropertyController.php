<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\Property;
use App\PropertyStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('viewAny', Property::class);

        return view('admin.properties.index', ['properties' => Property::with('images')->latest()->paginate(20)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        Gate::authorize('create', Property::class);

        return view('admin.properties.form', ['property' => new Property, 'statuses' => PropertyStatus::cases()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyRequest $request): RedirectResponse
    {
        Gate::authorize('create', Property::class);
        $property = Property::create($this->propertyData($request->validated()));
        $this->storeImages($request, $property);

        return redirect()->route('admin.properties.edit', $property)->with('success', 'Imóvel cadastrado.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property): RedirectResponse
    {
        return redirect()->route('admin.properties.edit', $property);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property): View
    {
        Gate::authorize('update', $property);

        return view('admin.properties.form', ['property' => $property->load('images'), 'statuses' => PropertyStatus::cases()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyRequest $request, Property $property): RedirectResponse
    {
        Gate::authorize('update', $property);
        $property->update($this->propertyData($request->validated()));
        $this->storeImages($request, $property);

        return back()->with('success', 'Imóvel atualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property): RedirectResponse
    {
        Gate::authorize('delete', $property);
        $property->delete();

        return redirect()->route('admin.properties.index')->with('success', 'Imóvel arquivado.');
    }

    /** @param array<string, mixed> $data */
    private function propertyData(array $data): array
    {
        unset($data['images']);
        $data['featured'] = (bool) ($data['featured'] ?? false);
        $data['published_at'] = $data['status'] === PropertyStatus::Published->value ? now() : null;

        return $data;
    }

    private function storeImages(StorePropertyRequest $request, Property $property): void
    {
        foreach ($request->file('images', []) as $position => $image) {
            $property->images()->create([
                'path' => $image->store('properties', 'public'),
                'alt_text' => $property->title,
                'position' => $property->images()->count() + $position,
                'is_cover' => ! $property->images()->exists() && $position === 0,
            ]);
        }
    }
}
