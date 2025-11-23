<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class InputSaldo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bank_account_balances';

    protected $fillable = [
        'bank_account_id',
        'balance_date',
        'balance_amount',
        'notes',
    ];

    public function bankAccount()
    {
        return $this->belongsTo(Bank::class, 'bank_account_id');
    }
}
