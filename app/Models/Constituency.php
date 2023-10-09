<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Constituency extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'district_id','description'];

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
