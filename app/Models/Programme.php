<?php

namespace App\Models;

use App\Models\Award;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Programme extends Model
{
    use SoftDeletes;
    use HasSlug;

    protected $guarded = [

    ];


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

    public function department()
    {
        return $this->belongsTo(Department::class)->withTrashed();
    }

    public function programmeCourses()
    {
        return $this->hasMany(CourseProgramme::class, 'programme_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class)
        ->withPivot([
            'unit', 'semester', 'type', 'academic_year_id', 'id', 'level', 'deleted_at'
        ])
        ->withTrashed();
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function award()
    {
        return $this->belongsTo(Award::class);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('slug', $value)->withTrashed()->firstOrFail();
    }

    public function specializationProgrammes()
    {
        return $this->hasMany(SpecializationProgramme::class, 'programme_id');
    }
}
