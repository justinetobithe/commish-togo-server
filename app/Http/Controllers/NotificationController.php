<?php

namespace App\Http\Controllers;

use App\Events\NotificationSent;
use App\Http\Requests\NotificationRequest;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function store(NotificationRequest $request)
    {
        $validated = $request->validated();

        $notification = Notification::create($validated);

        event(new NotificationSent(
            $notification->user_id,
            $notification->title,
            $notification->body,
            $notification->action_url
        ));

        return response()->json(['message' => 'Notification sent successfully']);
    }
}
