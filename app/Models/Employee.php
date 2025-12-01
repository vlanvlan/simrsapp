<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'employee_code',
        'employment_status',
        'position_id',
        'unit_id',
        'hire_date',
        'end_date',
        'nik',
        'npwp',
        'gender',
        'birth_place',
        'birth_date',
        'address',
        'phone',
        'profile_picture',
        'supervisor_id',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
