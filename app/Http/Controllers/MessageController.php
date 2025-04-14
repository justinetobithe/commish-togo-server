<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Events\MessageSent;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    use ApiResponse;
    
    public function index(Request $request)
    {
        return Message::where(function ($query) use ($request) {
            $query->where('sender_id', $request->user()->id)
                ->where('recipient_id', $request->query('recipient_id'));
        })->orWhere(function ($query) use ($request) {
            $query->where('sender_id', $request->query('recipient_id'))
                ->where('recipient_id', $request->user()->id);
        })->get();
    }

    public function send_message(MessageRequest $request)
    {
        $validated = $request->validated();
        $validated = collect($validated)->merge([
            'sender_id' => $request->user()->id
        ])->toArray();

        $store_message = Message::create($validated);
        if ($store_message) {
            $store_message->fresh();
            broadcast(new MessageSent([
                'id' => $store_message->id,
                'sender_id' => $store_message->sender_id,
                'recipient_id' => $store_message->recipient_id,
                'content' => $store_message->content,
            ]));
        }
        return $this->success($store_message);
    }
}
