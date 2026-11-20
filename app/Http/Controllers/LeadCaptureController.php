<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;
use Illuminate\Http\RedirectResponse;

class LeadCaptureController extends Controller
{
    public function store(StoreLeadRequest $request): RedirectResponse
    {
        $lead = Lead::create([
            ...$request->safe()->except('website'),
            'source' => 'site',
            'tracking' => $request->session()->get('tracking', []),
        ]);

        $lead->activities()->create(['type' => 'created', 'description' => 'Lead capturado pelo site.']);

        return back()->with('success', 'Contato recebido! Abriremos o WhatsApp para continuar.');
    }
}
