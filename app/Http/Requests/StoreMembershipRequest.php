<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMembershipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // public endpoint
    }

    public function rules(): array
    {
        return [
            // identity
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:membership_requests,email',
            'phone' => 'nullable|string|max:20',
            'birthdate' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',

            // location
            'country' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'barangay' => 'nullable|string|max:100',

            // training
            'training_types' => 'nullable|array',
            'training_types.*' => 'string|max:50',
            'experience_level' => 'nullable|in:beginner,intermediate,advanced',
            'years_running' => 'nullable|integer|min:0|max:80',
            'average_run_pace' => 'nullable|string|max:20',
            'weekly_distance_km' => 'nullable|integer|min:0|max:500',
            'preferred_run_time' => 'nullable|string|max:50',
            'goals' => 'nullable|string|max:2000',

            // safety
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'medical_conditions' => 'nullable|string|max:2000',

            // community
            'how_did_you_hear' => 'nullable|string|max:255',
            'motivation' => 'nullable|string|max:2000',

            // waiver
            'agreed_to_rules' => 'required|boolean'
        ];
    }
}
