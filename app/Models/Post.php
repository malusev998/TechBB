<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
