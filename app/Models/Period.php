<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Period extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected $casts = [
        'period_time' => 'datetime'
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function scopeCurrentAttendances($query)
    {
        return $query->whereHas('attendance', function (Builder $q)
        {
            $q->where('academic_year_id', AcademicYear::current()->id);
        });
    }
}
