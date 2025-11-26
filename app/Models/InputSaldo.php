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
        'previous_balance',
        'balance_amount',
        'in',
        'out',
        'masuk_pindah_buku',
        'keluar_pindah_buku',
        'masuk_from_account_id',
        'keluar_to_account_id',
        'notes',
    ];

    public function bankAccount()
    {
        return $this->belongsTo(Bank::class, 'bank_account_id');
    }

    public function masukFromAccount()
    {
        return $this->belongsTo(Bank::class, 'masuk_from_account_id');
    }

    public function keluarToAccount()
    {
        return $this->belongsTo(Bank::class, 'keluar_to_account_id');
    }
}
