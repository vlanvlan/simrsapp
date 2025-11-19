<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'is_managerial',
        'position_level_id',
        'parent_id',
    ];

    public function positionLevel()
    {
        return $this->belongsTo(PositionLevel::class);
    }

    public function parent()
    {
        return $this->belongsTo(Position::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Position::class, 'parent_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
