<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasUuids;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public $incrementing = false;

    protected $fillable = [
        'name',
        'password',
        'balance',
        'email',
        'phone',
        'id'
    ];

    public $timestamps = false;

    public function balanceHistory()
    {
        return $this->hasMany(BalanceHistories::class, 'user_id');
    }
    public function application()
    {
        return $this->hasMany(Application::class, 'user_id');
    }
    public function booking()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }
    public function category()
    {
        return $this->hasMany(Categories::class, 'user_id');
    }

}
