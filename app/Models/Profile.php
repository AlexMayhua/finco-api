<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'phone',
        'address',
        'profile_photo',
        'bio',
        'occupation'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
