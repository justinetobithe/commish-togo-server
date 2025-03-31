<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->uuid = (string) Str::uuid();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Service::class, 'post_tags')->withTimestamps();
    }

    public function applicants(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }
}
