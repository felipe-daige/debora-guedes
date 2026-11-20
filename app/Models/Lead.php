<?php

namespace App\Models;

use App\LeadStatus;
use Database\Factories\LeadFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    /** @use HasFactory<LeadFactory> */
    use HasFactory;

    protected $fillable = [
        'property_id', 'assigned_to', 'name', 'phone', 'email', 'interest', 'message',
        'source', 'status', 'lost_reason', 'potential_value', 'next_contact_at', 'tracking',
    ];

    protected function casts(): array
    {
        return [
            'status' => LeadStatus::class,
            'next_contact_at' => 'datetime',
            'tracking' => 'array',
            'potential_value' => 'decimal:2',
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(LeadActivity::class)->latest();
    }
}
