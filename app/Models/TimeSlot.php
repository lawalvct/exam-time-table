<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'is_active'
    ];

    // Helper accessor for formatting date and time
    public function getFormattedSlotAttribute()
    {
        return \Carbon\Carbon::parse($this->date)->format('D, M j, Y') . 
               ' (' . \Carbon\Carbon::parse($this->start_time)->format('h:i A') . 
               ' - ' . \Carbon\Carbon::parse($this->end_time)->format('h:i A') . ')';
    }
}