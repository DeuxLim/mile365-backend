<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMembershipRequest;
use App\Services\MembershipService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\MembershipRequestResource;

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

    public function index()
    {
        $membershipRequests = $this->membershipService->getPendingRequests();

        return MembershipRequestResource::collection($membershipRequests);
    }

    public function approve(Request $request, $id)
    {
        $adminId = $request->user()->id;

        $membership = $this->membershipService->approveRequest($id, $adminId);

        return response()->json([
            'message' => 'Application approved',
            'data' => new MembershipRequestResource($membership)
        ]);
    }

    public function reject(Request $request, $id)
    {
        $adminId = $request->user()->id;

        $membership = $this->membershipService->rejectRequest(
            $id,
            $adminId,
            $request->input('admin_notes')
        );

        return response()->json([
            'message' => 'Application rejected',
            'data' => new MembershipRequestResource($membership)
        ]);
    }
}
