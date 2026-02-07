<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'name' => $this->first_name . ' ' . $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,

            'location' => [
                'country' => $this->country,
                'province' => $this->province,
                'city' => $this->city,
                'barangay' => $this->barangay,
            ],

            'training' => [
                'types' => $this->training_types,
                'experience_level' => $this->experience_level,
                'years_running' => $this->years_running,
                'average_run_pace' => $this->average_run_pace,
                'weekly_distance_km' => $this->weekly_distance_km,
            ],

            'status' => $this->status,
            'submitted_at' => $this->created_at,
            'reviewed_at' => $this->reviewed_at,
        ];
    }
}
