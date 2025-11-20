<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialBranch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fi_branches';

    protected $fillable = [
        'name',
        'code',
        'institution_id',
        'address',
        'city',
        'phone',
    ];

    public function financialInstitution()
    {
        return $this->belongsTo(FinancialInstitution::class, 'institution_id');
    }
}
