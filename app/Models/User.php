<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mobile',
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
    ];

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class,'user_departments');
    }

    public function districts(): BelongsToMany
    {
        return $this->belongsToMany(District::class, 'user_districts');
    }

    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'associated_users', 'parent_id');
    }

    public function children(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'associated_users', 'user_id');
    }

    public function associatedUsers(): HasMany
    {
        return $this->hasMany(AssociatedUser::class);
    }

}
