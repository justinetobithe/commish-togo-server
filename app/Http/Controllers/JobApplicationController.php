<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplicationRequest;
use App\Models\JobApplication;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of job applications.
     */
    public function index(Request $request)
    {
        $pageSize = $request->input('page_size');
        $filter = $request->input('filter');
        $sortColumn = $request->input('sort_column', 'created_at');
        $sortDesc = $request->input('sort_desc', false) ? 'desc' : 'asc';

        $query = JobApplication::query();

        if ($filter) {
            $query->where(function ($q) use ($filter) {
                $q->where('cover_letter', 'like', "%{$filter}%")
                    ->orWhere('status', 'like', "%{$filter}%");
            });
        }

        if (in_array($sortColumn, ['status', 'created_at'])) {
            $query->orderBy($sortColumn, $sortDesc);
        }

        if ($pageSize) {
            $jobApplications = $query->paginate($pageSize);
        } else {
            $jobApplications = $query->get();
        }

        return $this->success($jobApplications);
    }

    /**
     * Display the specified job application.
     */
    public function show(JobApplication $jobApplication)
    {
        return $this->success(['status' => true, 'data' => $jobApplication]);
    }

    /**
     * Store a newly created job application.
     */
    public function store(JobApplicationRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $fileName = md5(uniqid() . date('u')) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/resume', $fileName);

            if ($path) {
                $validated['resume'] = $fileName;
            }
        }

        $jobApplication = JobApplication::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.applied'),
            'data' => $jobApplication,
        ]);
    }

    /**
     * Update the specified job application.
     */
    public function update(JobApplicationRequest $request, string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $validated = $request->validated();

        if ($request->hasFile('resume')) {
            if ($jobApplication->resume) {
                Storage::delete("public/resume/{$jobApplication->resume}");
            }

            $file = $request->file('resume');
            $fileName = md5(uniqid() . date('u')) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/resume', $fileName);

            if ($path) {
                $validated['resume'] = $fileName;
            }
        }

        $jobApplication->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.updated'),
            'data' => $jobApplication,
        ]);
    }

    /**
     * Remove the specified job application.
     */
    public function destroy(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->delete();

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.deleted'),
            'data' => $jobApplication,
        ]);
    }
}
