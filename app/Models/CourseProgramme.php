<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class CourseProgramme extends Model
{
    use SoftDeletes;
    use HasSlug;

    protected $guarded = [];

    protected $table = 'course_programme';

    protected $with = [
        'course', 'programme'
    ];


    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->doNotGenerateSlugsOnCreate()
            ->doNotGenerateSlugsOnUpdate()
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function course()
    {
        return $this->hasOne(Course::class, 'id', 'course_id')->withTrashed();
    }

    public function programme()
    {
        return $this->hasOne(Programme::class, 'id', 'programme_id')->withTrashed();
    }

    public function academicYear()
    {
        return $this->hasOne(AcademicYear::class, 'id', 'academic_year_id')->withTrashed();
    }

    public function ScopeGetCourse($query, $course_id)
    {
        $query->where('course_id', $course_id)->get();
    }

}
