<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostsData extends Model
{
    protected $fillable = [
        'post_id',
        'user_left',
        'user_id',
        'browser',
        'browser_type',
    ];
    protected $casts = ['user_left' => 'datetime'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo {
        return $this->belongsTo(Post::class);
    }
}
