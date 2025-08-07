<?php

namespace App\Models;


use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'token',
        'abilities',
        'expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'abilities' => 'array',
        'expires_at' => 'datetime',
        'last_used_at' => 'datetime',
    ];


    /**
     * Get the parent model that the token belongs to.
     */
    public function tokenable(): MorphTo
    {
        return $this->morphTo();
    }
}
