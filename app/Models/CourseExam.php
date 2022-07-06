<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseExam extends Pivot
{
    protected $casts = [
        'students_id' => 'array'
    ];
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
