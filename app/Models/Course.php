<?php

namespace App\Models;

use App\Models\AcademicYear;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasSlug;
    use SoftDeletes;

	protected $guarded = [
        'id'
    ];

    protected $academicYear;

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('code')
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


    public function programmes()
    {
        return $this->belongsToMany(Programme::class)
        ->withPivot([
            'unit', 'semester', 'type', 'academic_year_id', 'id', 'level', 'deleted_at'
        ])
        ->withTrashed();
    }

    public function programme($programme_id)
    {
        return $this->programmes()->wherePivot('programme_id',$programme_id)->first();
    }

    public function courseProgrammes()
    {
        return $this->hasMany(CourseProgramme::class);
    }

    public function scopeThisSemester($query)
    {
        $academicYear = AcademicYear::current()->first();

        $query->whereHas('courseProgrammes', function (Builder $query) use ($academicYear)
        {
            $query->where([['semester', $academicYear->semester]]);
        });
    }

    public function allocations()
    {
        return $this->hasMany(CourseAllocation::class, 'course_id')->withTrashed();
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('slug', $value)->withTrashed()->firstOrFail();
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function currentAttendances()
    {
        return $this->attendances()->where('academic_year_id', AcademicYear::current()->id)->get();
    }

    public function currentEnrollments()
    {
        return $this->enrollments()->where('academic_year_id', AcademicYear::current()->id)->get();
    }

    public function getAttendancesByYear($academicYear)
    {
        return $this->attendances()->where('academic_year_id', $academicYear->id);
    }

    public function getEnrollmentsByYear($academicYear)
    {
        return $this->enrollments()->where('academic_year_id', $academicYear->id);
    }

    /**
     * Get the enrollements of a specific academic year.
     *
     * @param academicYearId
     */
    public function specificEnrollments($academicYearId = null)
    {
        return $this->enrollments()->where('academic_year_id', $academicYearId??AcademicYear::current()->id)->get();
    }

}
