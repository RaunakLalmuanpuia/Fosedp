<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Auditable;

class BankAccount extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory,Auditable;

    protected $fillable = ['ac_holder', 'bank_name','branch_name','ac_no', 'ifsc','application_id'];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
