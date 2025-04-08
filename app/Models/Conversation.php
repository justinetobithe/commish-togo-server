<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function getLatestMessageAttribute()
    {
        return $this->latestMessage?->content;
    }

    public function getLastMessageTimeAttribute()
    {
        return $this->latestMessage?->created_at?->toDateTimeString();
    }

    protected $appends = ['latest_message', 'last_message_time'];
}
