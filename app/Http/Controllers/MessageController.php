<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
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
            broadcast(new MessageEvent([
                'user_id' => $store_message->recepient_id
            ]));
        }
        return $this->success($store_message);
    }
}
