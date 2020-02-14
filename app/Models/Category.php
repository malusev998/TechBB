<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'number_of_posts',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [
        'pivot',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
