<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormFive extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','department_id', 'remark','path','type'];
    protected $appends = ['fullPath'];

    public function getFullPathAttribute(): string
    {
        return env('APP_URL').'/storage/'.$this->path;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
