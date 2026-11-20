<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LeadStatus;
use App\Models\Lead;
use App\Models\Property;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'propertyCount' => Property::count(),
            'newLeadCount' => Lead::where('status', LeadStatus::New)->count(),
            'openLeadCount' => Lead::whereNotIn('status', [LeadStatus::Won, LeadStatus::Lost])->count(),
            'recentLeads' => Lead::with('property')->latest()->limit(8)->get(),
        ]);
    }
}
