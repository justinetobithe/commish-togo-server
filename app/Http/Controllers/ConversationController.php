<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConversationRequest;
use App\Models\Conversation;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    use ApiResponse;

    public function store(ConversationRequest $request)
    {
        $validated = $request->validated();

        $existing = Conversation::where(function ($q) use ($validated) {
            $q->where('user_one_id', $validated['user_one_id'])
                ->where('user_two_id', $validated['user_two_id']);
        })->orWhere(function ($q) use ($validated) {
            $q->where('user_one_id', $validated['user_two_id'])
                ->where('user_two_id', $validated['user_one_id']);
        })->first();

        if ($existing) {
            return;
        }

        $conversation = Conversation::create($validated);

        return $this->success($conversation, 'Conversation created', 201);
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $conversations = Conversation::where('user_one_id', $user->id)
            ->orWhere('user_two_id', $user->id)
            ->with(['userOne', 'userTwo', 'messages', 'latestMessage', 'latestMessage.sender'])
            ->get();

        return $this->success($conversations, 'Conversations retrieved');
    }

    public function show($id)
    {
        $conversation = Conversation::with('messages.sender')->find($id);

        if (!$conversation) {
            return $this->error('Conversation not found', 404);
        }

        return $this->success($conversation, 'Conversation details');
    }
}
