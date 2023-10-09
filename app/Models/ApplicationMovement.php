<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationMovement extends Model
{
    use HasFactory;

    const INSIDE = 'inside';
    const OUTSIDE = 'outside';
    protected $fillable = ['application_id','sender_id','recipient_id','received_at','sent_at','type','remark'];
    protected $with = ['sender', 'recipient'];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class,foreignKey: 'sender_id');
    }
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class,foreignKey: 'application_id');
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class,foreignKey: 'recipient_id');
    }
}
