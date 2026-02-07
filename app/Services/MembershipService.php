<?php

namespace App\Services;

use App\Models\MembershipRequest;
use App\Models\Member;

class MembershipService
{
    public function submitApplication(array $data): MembershipRequest
    {
        // set default status
        $data['status'] = 'pending';

        // if user agreed to rules, set timestamp
        if (!empty($data['agreed_to_rules'])) {
            $data['agreed_at'] = now();
        }

        // create record
        return MembershipRequest::create($data);
    }

    public function getPendingRequests()
    {
        return MembershipRequest::query()
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);
    }

    public function approveRequest(int $id, int $adminId)
    {
        $request = \App\Models\MembershipRequest::findOrFail($id);

        if ($request->status !== 'pending') {
            throw new \Exception('Request already processed.');
        }

        $request->status = 'approved';
        $request->reviewed_by = $adminId;
        $request->reviewed_at = now();
        $request->save();

        Member::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'country' => $request->country,
            'province' => $request->province,
            'city' => $request->city,
            'barangay' => $request->barangay,
            'training_types' => $request->training_types,
            'experience_level' => $request->experience_level,
            'years_running' => $request->years_running,
            'joined_at' => now(),
        ]);

        return $request;
    }

    public function rejectRequest(int $id, int $adminId, ?string $notes = null)
    {
        $request = \App\Models\MembershipRequest::findOrFail($id);

        if ($request->status !== 'pending') {
            abort(409, 'Request already processed.');
        }

        $request->status = 'rejected';
        $request->reviewed_by = $adminId;
        $request->reviewed_at = now();
        $request->admin_notes = $notes;
        $request->save();

        return $request;
    }
}
