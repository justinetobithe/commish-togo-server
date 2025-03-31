<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Service;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $pageSize = $request->input('page_size');
        $filter = $request->input('filter');
        $sortColumn = $request->input('sort_column', 'name');
        $sortDesc = $request->input('sort_desc', false) ? 'desc' : 'asc';

        $query = Service::query();

        if ($filter) {
            $query->where(function ($q) use ($filter) {
                $q->where('name', 'like', "%{$filter}%")
                    ->orWhere('description', 'like', "%{$filter}%");
            });
        }

        if (in_array($sortColumn, ['designation', 'description'])) {
            $query->orderBy($sortColumn, $sortDesc);
        }

        if ($pageSize) {
            $services = $query->paginate($pageSize);
        } else {
            $services = $query->get();
        }

        return $this->success($services);
    }

    public function show(Service $service)
    {
        return $this->success(['status' => true, 'data' => $service]);
    }

    public function store(ServiceRequest $request)
    {
        $existingService = Service::withTrashed()
            ->where('name', $request->name)
            ->first();

        if ($existingService) {
            $existingService->restore();
            $existingService->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => __('messages.success.restored'),
                'data' => $existingService,
            ]);
        }

        $service = Service::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.created'),
            'data' => $service,
        ]);
    }


    public function update(ServiceRequest $request, string $id)
    {
        $service = Service::findOrFail($id);

        $service->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.updated'),
            'data' => $service,
        ]);
    }

    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.deleted'),
            'data' => $service,
        ]);
    }
}
