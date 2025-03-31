<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $users = User::whereHas('profile')
            ->with([
                'profile',
                'resumes',
                'workExperience',
                'educationalAttainment'
            ])
            ->get();

        return $this->success($users);
    }

    /**
     * Show profile for a specific user
     */
    public function showForUser($userId)
    {
        $profile = Profile::where('user_id', $userId)->first();

        return $this->success(['status' => true, 'data' => $profile]);
    }

    /**
     * Store a new profile
     */
    public function store(ProfileRequest $request)
    {
        $existingProfile = Profile::withTrashed()
            ->where('user_id', $request->user_id)
            ->first();

        if ($existingProfile) {
            $existingProfile->restore();
            $existingProfile->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => __('messages.success.restored'),
                'data' => $existingProfile,
            ]);
        }

        $profile = Profile::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.created'),
            'data' => $profile,
        ]);
    }

    /**
     * Update an existing profile
     */
    public function update(ProfileRequest $request, string $id)
    {
        $profile = Profile::findOrFail($id);

        $profile->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.updated'),
            'data' => $profile,
        ]);
    }
}
