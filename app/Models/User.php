<?php

namespace App\Models;

use App\Casts\Password;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        Filterable,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => Password::class,
    ];

    /**
     * Get the user list.
     *
     * @param array $filters
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getList($filters)
    {
        return static::filter($filters)->orderBy('name')->paginate();
    }

    /**
     * Generate PIN token
     *
     * @return string
     */
    public function generatePin(): string
    {
        $pin = rand(100000, 999999);

        PasswordReset::create([
            'email' => $this->email,
            'token' => $pin,
            'created_at' => now(),
        ]);

        return $pin;
    }
}
