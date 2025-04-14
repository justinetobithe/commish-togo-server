<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Notification;
use App\Models\User;
use App\Traits\ApiResponse;
use Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $pageSize = $request->input('page_size');
        $filter = $request->input('filter');
        $sortColumn = $request->input('sort_column', 'first_name');
        $sortDesc = $request->input('sort_desc', false) ? 'desc' : 'asc';

        $query = User::query();

        if ($filter) {
            $query->where(function ($q) use ($filter) {
                $q->where('first_name', 'like', "%{$filter}%")
                    ->orWhere('last_name', 'like', "%{$filter}%")
                    ->orWhere('email', 'like', "%{$filter}%")
                    ->orWhere('phone', 'like', "%{$filter}%")
                    ->orWhere('address', 'like', "%{$filter}%");
            });
        }

        if (in_array($sortColumn, ['first_name', 'last_name', 'email', 'phone', 'address'])) {
            $query->orderBy($sortColumn, $sortDesc);
        }

        if ($pageSize) {
            $users = $query->paginate($pageSize);
        } else {
            $users = $query->get();
        }

        return $this->success($users);
    }
    public function store(UserRequest $request)
    {
        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            return response()->json([
                'status' => 'error',
                'message' => __('messages.errors.email_exists'),
                'data' => $existingUser,
            ]);
        }

        $user = User::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.created'),
            'user' => $user,
        ]);
    }

    public function update(UserRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        if ($request->email && $request->email !== $user->email) {
            if (User::where('email', $request->email)->where('id', '!=', $id)->exists()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This email is already in use by another user.',
                ]);
            }
        }

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Current password is incorrect.',
                ]);
            }

            if ($request->filled('new_password')) {
                $user->password = Hash::make($request->new_password);
            }
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = md5(uniqid() . now()) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/image', $imageName);

            $user->image = $imageName;
        }

        $user->fill($request->except(['image', 'password', 'current_password', 'new_password']))->save();

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.updated'),
            'user' => $user,
        ]);
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.deleted'),
            'user' => $user,
        ]);
    }

    public function notifications(User $user)
    {
        try {
            return $user->notifications;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     * */
    public function markAsRead(string $id)
    {
        try {
            $notification = Notification::find($id);
            $notification->markAsRead();

            return $this->success([
                'read_at' => Date::now()
            ], __('messages.success.updated'));
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
