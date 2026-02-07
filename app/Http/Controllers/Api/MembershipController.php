<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMembershipRequest;
use App\Services\MembershipService;
use Illuminate\Http\JsonResponse;

class MembershipController extends Controller
{
    protected MembershipService $membershipService;

    public function __construct(MembershipService $membershipService)
    {
        $this->membershipService = $membershipService;
    }

    public function store(StoreMembershipRequest $request): JsonResponse
    {
        $membership = $this->membershipService
            ->submitApplication($request->validated());

        return response()->json([
            'message' => 'Application submitted successfully',
            'data' => [
                'id' => $membership->id,
                'status' => $membership->status
            ]
        ], 201);
    }
}
