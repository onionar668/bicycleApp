<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceHistories extends Model
{
    protected $fillable = [
        'type',
        'value',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
