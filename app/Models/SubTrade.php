<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubTrade extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'trade_id'];

    public function trade(): BelongsTo
    {
        return $this->belongsTo(Trade::class);
    }
}
