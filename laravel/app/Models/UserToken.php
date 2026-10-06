<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    protected $fillable = [
        'value',
        'hash',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

