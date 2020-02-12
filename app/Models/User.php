<?php


namespace App\Models;


use App\Services\Jwt\JwtSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Model implements JwtSubject
{
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'email_verified_at',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'role_id',
        'updated_at',
        'id',
        'email_verified_at'
    ];

    protected $with = ['role'];

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function getIdentifier()
    {
        return $this->id;
    }

    public function getCustomClaims(): array
    {
        return [
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'role' => $this->role->name
        ];
    }
}
