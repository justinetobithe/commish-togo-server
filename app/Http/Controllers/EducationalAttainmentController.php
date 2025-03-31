<?php

namespace App\Http\Controllers;

use App\Http\Requests\EducationalAttainmentRequest;
use App\Models\EducationalAttainment;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class EducationalAttainmentController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $educationalAttainments = EducationalAttainment::where('user_id', $request->user_id)
            ->orderBy('start_date', 'asc')
            ->get();

        return $this->success($educationalAttainments);
    }

    public function store(EducationalAttainmentRequest $request)
    {
        $educationalAttainment = EducationalAttainment::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.created'),
            'data' => $educationalAttainment,
        ]);
    }


    public function update(EducationalAttainmentRequest $request, string $id)
    {
        $educationalAttainment = EducationalAttainment::findOrFail($id);

        $educationalAttainment->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.updated'),
            'data' => $educationalAttainment,
        ]);
    }

    public function destroy(string $id)
    {
        $educationalAttainment = EducationalAttainment::findOrFail($id);
        $educationalAttainment->delete();

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.deleted'),
            'data' => $educationalAttainment,
        ]);
    }
}
