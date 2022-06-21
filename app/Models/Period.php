<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
