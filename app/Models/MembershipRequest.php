<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipRequest extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'birthdate',
        'gender',
        'country',
        'province',
        'city',
        'barangay',
        'training_types',
        'experience_level',
        'years_running',
        'average_run_pace',
        'weekly_distance_km',
        'preferred_run_time',
        'goals',
        'emergency_contact_name',
        'emergency_contact_phone',
        'medical_conditions',
        'how_did_you_hear',
        'motivation',
        'agreed_to_rules',
        'agreed_at',
        'status',
        'reviewed_by',
        'reviewed_at',
        'admin_notes',
    ];

    protected $casts = [
        'training_types' => 'array',
        'birthdate' => 'date',
        'agreed_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];
}
