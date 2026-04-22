<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invigilator extends Model
{
    protected $fillable = [
        'name',
        'staff_id',
        'email',
        'phone',
        'is_active'
    ];
}