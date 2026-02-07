<?php

namespace App\Services;

use App\Models\MembershipRequest;

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
}
