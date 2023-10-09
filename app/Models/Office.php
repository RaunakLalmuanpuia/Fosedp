<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Office extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description','parent_id','district_id','department_id'];

    public function parentOffice(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'parent_id');
    }

    public function childrenOffice(): HasMany
    {
        return $this->hasMany(Office::class,'parent_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
