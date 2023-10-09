<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExportReport extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'path', 'user_id','status'];
    protected $appends = ['fullPath'];

    public function getFullPathAttribute()
    {
        return env('APP_URL') .'/storage/'.$this->path;
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
