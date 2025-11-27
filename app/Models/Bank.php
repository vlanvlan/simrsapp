<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bank_accounts';

    protected $fillable = [
        'account_name',
        'account_number',
        'institution_id',
        'branch_id',
        'account_type',
        'instrument_type',
        'currency',
        'opened_date',
        'closed_date',
        'notes',
        'is_active',
    ];

    public function financialInstitution()
    {
        return $this->belongsTo(FinancialInstitution::class, 'institution_id');
    }

    public function branch()
    {
        return $this->belongsTo(FinancialBranch::class, 'branch_id');
    }

    // Scopes
    public function scopeByInstrumentType($query, $type)
    {
        return $query->where('instrument_type', $type);
    }

    public function scopeActiveDeposits($query)
    {
        return $query->where('is_active', true)->where('instrument_type', 'deposit');
    }

    public function scopeActiveBonds($query)
    {
        return $query->where('is_active', true)->where('instrument_type', 'bond');
    }

    public function scopeActiveCurrentAccounts($query)
    {
        return $query->where('is_active', true)->where('instrument_type', 'current_account');
    }

    // Helper method to get formatted instrument type
    public function getFormattedInstrumentTypeAttribute()
    {
        return ucwords(str_replace('_', ' ', $this->instrument_type));
    }
}
