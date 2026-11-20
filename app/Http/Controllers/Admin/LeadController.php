<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateLeadRequest;
use App\LeadStatus;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        Gate::authorize('viewAny', Lead::class);

        return view('admin.leads.index', [
            'leads' => Lead::with(['property', 'assignee'])->latest()->get()->groupBy(fn (Lead $lead) => $lead->status->value),
            'statuses' => LeadStatus::cases(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('admin.leads.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(): RedirectResponse
    {
        return redirect()->route('admin.leads.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead): View
    {
        Gate::authorize('view', $lead);

        return view('admin.leads.show', [
            'lead' => $lead->load(['property', 'assignee', 'activities.user']),
            'statuses' => LeadStatus::cases(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead): RedirectResponse
    {
        return redirect()->route('admin.leads.show', $lead);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeadRequest $request, Lead $lead): RedirectResponse
    {
        Gate::authorize('update', $lead);
        $previousStatus = $lead->status;
        $data = $request->safe()->except('note');
        $lead->update($data);

        if ($previousStatus !== $lead->status) {
            $lead->activities()->create(['user_id' => $request->user()->id, 'type' => 'status_changed', 'description' => "Etapa alterada de {$previousStatus->label()} para {$lead->status->label()}."]);
        }
        if ($request->filled('note')) {
            $lead->activities()->create(['user_id' => $request->user()->id, 'type' => 'note', 'description' => $request->string('note')->toString()]);
        }

        return back()->with('success', 'Lead atualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead): RedirectResponse
    {
        Gate::authorize('delete', $lead);
        $lead->delete();

        return redirect()->route('admin.leads.index')->with('success', 'Lead removido.');
    }
}
