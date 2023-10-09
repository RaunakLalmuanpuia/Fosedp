<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssociatedUser extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id','user_id', 'district_id'];
    protected $with = ['district'];
    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class,'parent_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }


}
