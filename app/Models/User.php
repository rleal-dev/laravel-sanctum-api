<?php

namespace App\Models;

use App\Casts\Password;
use EloquentFilter\Filterable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends BaseModel implements AuthenticatableContract
{
    use HasApiTokens,
        HasRoles,
        HasFactory,
        Notifiable,
        Filterable,
        SoftDeletes,
        Authenticatable;

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
}
