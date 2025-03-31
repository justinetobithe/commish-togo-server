<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkExperienceRequest;
use App\Models\WorkExperience;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class WorkExperienceController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $workExperiences = WorkExperience::where('user_id', $request->user_id)
            ->orderBy('start_date', 'asc')
            ->get();

        return $this->success($workExperiences);
    }

    public function store(WorkExperienceRequest $request)
    {
        $workExperience = WorkExperience::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.created'),
            'data' => $workExperience,
        ]);
    }


    public function update(WorkExperienceRequest $request, string $id)
    {
        $workExperience = WorkExperience::findOrFail($id);

        $workExperience->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.updated'),
            'data' => $workExperience,
        ]);
    }

    public function destroy(string $id)
    {
        $workExperience = WorkExperience::findOrFail($id);
        $workExperience->delete();

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.deleted'),
            'data' => $workExperience,
        ]);
    }
}
