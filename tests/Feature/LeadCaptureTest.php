<?php

namespace Tests\Feature;

use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadCaptureTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_contact_is_stored_with_initial_activity(): void
    {
        $response = $this->post(route('leads.capture'), ['name' => 'Maria Cliente', 'phone' => '(47) 99999-0000', 'email' => 'cliente@example.com', 'interest' => 'Comprar imóvel']);

        $response->assertRedirect();
        $this->assertDatabaseHas('leads', ['name' => 'Maria Cliente', 'status' => 'new', 'source' => 'site']);
        $this->assertDatabaseHas('lead_activities', ['lead_id' => Lead::firstOrFail()->id, 'type' => 'created']);
    }

    public function test_contact_requires_name_and_phone(): void
    {
        $this->post(route('leads.capture'), [])->assertSessionHasErrors(['name', 'phone']);
        $this->assertDatabaseCount('leads', 0);
    }

    public function test_honeypot_rejects_bots(): void
    {
        $this->post(route('leads.capture'), ['name' => 'Bot', 'phone' => '1', 'website' => 'spam.test'])->assertSessionHasErrors('website');
        $this->assertDatabaseCount('leads', 0);
    }
}
