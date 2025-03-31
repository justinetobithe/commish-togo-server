<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResumeRequest;
use App\Models\Resume;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResumeController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $user = auth()->user();

        $resumes = Resume::where('user_id', $user->id)->get();

        return $this->success($resumes);
    }

    public function store(ResumeRequest $request)
    {
        $user = auth()->user();

        if (!$request->hasFile('file')) {
            return $this->error('No file uploaded', 400);
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return $this->error('Invalid file upload', 400);
        }

        $path = $file->store('resumes', 'public');

        $fileName = str_replace('resumes/', '', $path);

        $resume = $user->resumes()->create([
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $fileName,
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.created'),
            'data' => $resume,
        ]);
    }

    public function update(ResumeRequest $request, Resume $resume)
    {
        if ($request->hasFile('file')) {
            Storage::disk('public')->delete('resumes/' . $resume->file_path);

            $file = $request->file('file');
            $path = $file->store('resumes', 'public');

            $fileName = str_replace('resumes/', '', $path);

            $resume->update([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $fileName,
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
            ]);
        } else {
            $resume->update($request->validated());
        }

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.updated'),
            'data' => $resume,
        ]);
    }


    public function destroy(Resume $resume)
    {

        Storage::disk('public')->delete($resume->file_path);
        $resume->delete();

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.deleted'),
            'data' => $resume,
        ]);
    }

    public function getUserResumes()
    {
        $user = auth()->user();

        if (!$user) {
            return $this->error('Unauthorized', 401);
        }

        $resumes = Resume::where('user_id', $user->id)->get();

        return $this->success($resumes);
    }
}
