<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormEleven extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'department_id','remark','path'];
    protected $appends = ['full_path'];

    public function getFullPathAttribute()
    {
        return env('APP_DEBUG')?'localhost:8000/storage':'https://fosedp.in/'.$this->path;
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
