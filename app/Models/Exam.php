<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{
    use HasSlug;
    use HasFactory;
    use SoftDeletes;

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
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

    protected $guarded = [];
    protected $casts = [
        'sit_date' => 'datetime'
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function examCourses()
    {
        return $this->hasMany(CourseExam::class, 'course_id');       
    }
}
