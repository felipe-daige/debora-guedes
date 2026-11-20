<?php

namespace Tests\Feature\Admin;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_move_lead_through_funnel_and_record_note(): void
    {
        $user = User::factory()->create();
        $lead = Lead::factory()->create();

        $this->actingAs($user)->put(route('admin.leads.update', $lead), ['status' => 'qualified', 'note' => 'Busca imóvel até R$ 1 milhão.'])->assertRedirect();

        $this->assertDatabaseHas('leads', ['id' => $lead->id, 'status' => 'qualified']);
        $this->assertDatabaseHas('lead_activities', ['lead_id' => $lead->id, 'type' => 'note']);
    }
}
