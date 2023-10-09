<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Application extends Model implements Auditable
{
    use HasFactory,SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['head_of_family','mobile','epic_no','address','district_id','address','constituency_id','trade_id','department_id','sub_trade_id'];

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function constituency(): BelongsTo
    {
        return $this->belongsTo(Constituency::class);
    }

    public function trade(): BelongsTo
    {
        return $this->belongsTo(Trade::class);
    }

    public function subTrade(): BelongsTo
    {
        return $this->belongsTo(SubTrade::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function bankAccount(): HasOne
    {
        return $this->hasOne(BankAccount::class);
    }

    public function currentStatus(): HasOne
    {
        return $this->hasOne(ApplicationStatus::class)->latestOfMany();
    }
    public function applicationStatuses(): HasMany
    {
        return $this->hasMany(ApplicationStatus::class);
    }
    public function firstMovement(): HasOne
    {
        return $this->hasOne(ApplicationMovement::class)->oldestOfMany();
    }
    public function lastMovement(): HasOne
    {
        return $this->hasOne(ApplicationMovement::class)->latestOfMany();
    }
    public function applicationMovements(): HasMany
    {
        return $this->hasMany(ApplicationMovement::class);
    }
}
