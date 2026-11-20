<?php

namespace Tests\Feature\Admin;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_property_management(): void
    {
        $this->get(route('admin.properties.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_create_property(): void
    {
        $response = $this->actingAs(User::factory()->create())->post(route('admin.properties.store'), [
            'reference' => 'JG-100', 'title' => 'Apartamento frente mar', 'type' => 'Apartamento',
            'purpose' => 'sale', 'status' => 'published', 'city' => 'Itapema',
            'description' => 'Apartamento amplo com vista permanente para o mar.', 'price' => 1900000,
        ]);

        $property = Property::firstOrFail();
        $response->assertRedirect(route('admin.properties.edit', $property));
        $this->assertSame('apartamento-frente-mar', $property->slug);
    }

    public function test_only_published_properties_are_public(): void
    {
        $published = Property::factory()->published()->create(['title' => 'Imóvel público']);
        Property::factory()->create(['title' => 'Rascunho secreto']);

        $this->get(route('properties'))->assertOk()->assertSee($published->title)->assertDontSee('Rascunho secreto');
    }
}
