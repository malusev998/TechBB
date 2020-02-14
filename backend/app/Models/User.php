<?php


namespace App\Models;


use App\Services\Jwt\JwtSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Model implements JwtSubject
{
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'email_verified_at',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'role_id',
        'updated_at',
        'id',
        'email_verified_at',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getIdentifier()
    {
        return $this->id;
    }

    public function getCustomClaims(): array
    {
        return [
            'name'    => $this->name,
            'surname' => $this->surname,
            'email'   => $this->email,
            'role'    => $this->role->name,
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(PostsData::class);
    }
}
