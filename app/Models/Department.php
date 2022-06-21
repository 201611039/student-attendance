<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Department extends Model
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

    public function user()
    {
        return $this->belongsTo(User::class, 'head_id', 'id')->withTrashed();
    }

    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'id')->withTrashed();
    }

    public function programme()
    {
        return $this->hasMany(Programme::class, 'department_id', 'id')->withTrashed();
    }

    public function awards()
    {
        return $this->belongsToMany(Award::class);
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('slug', $value)->withTrashed()->firstOrFail();
    }
}
