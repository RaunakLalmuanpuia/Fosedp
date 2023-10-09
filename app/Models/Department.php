<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name','description'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'user_departments');
    }
    public function trades(): HasMany
    {
        return $this->hasMany(Trade::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
