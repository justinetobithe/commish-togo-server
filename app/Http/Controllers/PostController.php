<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $pageSize = $request->input('page_size');
        $search = $request->input('search');
        $sortColumn = $request->input('sort_column', 'title');
        $sortDesc = $request->input('sort_desc', false) ? 'desc' : 'asc';

        $query = Post::with(['user', 'likes.user', 'comments.user', 'files', 'tags', 'applicants']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        if (in_array($sortColumn, ['title'])) {
            $query->orderBy($sortColumn, $sortDesc);
        }

        $query->orderBy('created_at', 'desc');

        if ($pageSize) {
            $posts = $query->paginate($pageSize);
        } else {
            $posts = $query->get();
        }

        return $this->success($posts);
    }

    public function userPosts(Request $request)
    {
        $search = $request->input('search');
        $userId = $request->input('user_id');

        $query = Post::with(['user', 'likes.user', 'comments.user', 'files', 'tags', 'applicants.user']);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhereHas('tags', function ($tagQuery) use ($search) {
                        $tagQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $posts = $query->orderBy('created_at', 'desc')->get();

        return $this->success($posts);
    }

    public function show(Post $post)
    {
        return $this->success(['status' => true, 'data' => $post]);
    }

    public function store(PostRequest $request)
    {
        $postData = $request->all();
        $postData['uuid'] = Str::uuid();
        $postData['user_id'] = auth()->id();
        $postData['posted_date'] = now();

        $post = Post::create($postData);

        if ($request->has('service_id')) {
            $post->tags()->sync($request->service_id);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.created'),
            'data' => $post,
        ]);
    }

    public function update(PostRequest $request, string $id)
    {
        $post = Post::findOrFail($id);

        $post->update($request->except('services'));

        if ($request->has('service_id')) {
            $post->tags()->sync($request->service_id);
        }

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.updated'),
            'data' => $post,
        ]);
    }

    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json([
            'status' => 'success',
            'message' => __('messages.success.deleted'),
            'data' => $post,
        ]);
    }
}
