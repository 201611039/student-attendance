<?php

namespace App\Models;

use App\Models\Programme;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;

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

    public function scopeHasCourse($query, $course_id)
    {
        return $query->whereHas('enrollments', function (Builder $q) use ($course_id)
        {
            $q->where([['course_id', $course_id], ['academic_year_id', AcademicYear::current()->id]]);
        });
    }
}
