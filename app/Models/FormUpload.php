<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormUpload extends Model
{
    use HasFactory;

    const FORM_FIVE_ONE = 'form-five-one';
    const FORM_FIVE_TWO = 'form-five-two';
    const FORM_SIX = 'form-six';
    const FORM_SEVEN = 'form-seven';
    const FORM_EIGHT = 'form-eight';
    const FORM_NINE = 'form-nine';
    const FORM_TEN = 'form-ten';
    const FORM_ELEVEN = 'form-eleven';

    protected $fillable = ['name', 'path','remark','user_id','department_id'];
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
