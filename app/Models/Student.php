<?php

namespace App\Models;

use App\Models\Programme;
use DarkGhostHunter\Larapass\Contracts\WebAuthnAuthenticatable;
use DarkGhostHunter\Larapass\WebAuthnAuthentication;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable implements WebAuthnAuthenticatable
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;
    use WebAuthnAuthentication;

    protected $guarded = [];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
        ->generateSlugsFrom('username')
        ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getFullNameAttribute()
    {
        return $this->first_name
        . ' '
        .($this->middle_name?"$this->middle_name ":'')
        .$this->last_name;
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    

    public function courseAttendance($course_id, $academicYear)
    {
        return $this->attendances()->where([['course_id', $course_id], ['academic_year_id', $academicYear->id]]);
    }

    public function scopeHasCourse($query, $course_id)
    {
        return $query->whereHas('enrollments', function (Builder $q) use ($course_id)
        {
            $q->where([['course_id', $course_id], ['academic_year_id', AcademicYear::current()->id]]);
        });
    }
}
