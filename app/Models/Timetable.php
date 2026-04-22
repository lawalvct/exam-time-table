<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $fillable = [
        'academic_session',
        'semester',
        'course_id',
        'time_slot_id',
        'hall_id',
        'invigilator_id',
        'exam_date'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

    public function invigilator()
    {
        return $this->belongsTo(Invigilator::class);
    }
}