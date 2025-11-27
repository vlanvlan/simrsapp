<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = [
        'code',
        'no_bilyet',
        'bank_account_id',
        'deposit_date',
        'amount',
        'interest_rate',
        'interest_amount',
        'total_amount',
        'penempatan',
        'placement_date',
        'maturity_date',
        'financial_institution_id',
        'notes',
    ];

    public function bankAccount()
    {
        return $this->belongsTo(Bank::class, 'bank_account_id');
    }

    public function financialInstitution()
    {
        return $this->belongsTo(FinancialInstitution::class, 'financial_institution_id');
    }

    // Helper method to get formatted penempatan value
    public function getFormattedPenempatanAttribute()
    {
        $translations = [
            'pembukaan' => 'Pembukaan (Opening)',
            'perpanjangan' => 'Perpanjangan (Extension)',
            'pencairan' => 'Pencairan (Withdrawal/Liquidation)'
        ];

        return $translations[$this->penempatan] ?? ucfirst($this->penempatan);
    }

    // Helper method to get calculated principal amount
    public function getCalculatedPrincipalAttribute()
    {
        return $this->amount + $this->interest_amount; // principal = base amount + interest
    }

    // Helper method to check if principal amount is correctly calculated
    public function isPrincipalAmountCorrect()
    {
        return abs($this->total_amount - $this->calculated_principal) < 0.01;
    }

    // Helper method to generate deposit code
    public static function generateCode($id)
    {
        return 'DEP-' . str_pad($id, 4, '0', STR_PAD_LEFT);
    }

    // Helper method to get the next available code
    public static function getNextCode()
    {
        $lastDeposit = self::latest('id')->first();
        $nextId = $lastDeposit ? $lastDeposit->id + 1 : 1;
        return self::generateCode($nextId);
    }
}
