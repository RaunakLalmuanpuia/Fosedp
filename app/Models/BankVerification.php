<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankVerification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','inp_path','res_path','offset','limit','remark'];
    protected $appends = ['inpFullPath', 'ResFullPath'];

    public function getInpFullPathAttribute()
    {
        return env('APP_URL') . '/storage/' . $this->inp_path;
    }
    public function getResFullPathAttribute()
    {
        return env('APP_URL') . '/storage/' . $this->res_path;
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
