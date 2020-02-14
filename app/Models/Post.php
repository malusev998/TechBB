<?php


namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use function dd;

/**
 * Class Post
 *
 * @package App\Models
 * @property \Carbon\Carbon $created_at
 */
class Post extends Model
{
    protected $fillable = [
        'title',
        'status',
        'description',
        'number_of_likes',
        'number_of_comments',
        'user_id',
    ];

    protected $hidden = [
        'user_id',
        'pivot'
    ];

    protected $appends = ['time_ago'];

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(PostsData::class);
    }
}
