<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    public function constituencies(): HasMany
    {
        return $this->hasMany(Constituency::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_districts');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
