<?php

namespace App\Models;

use Laravolt\Avatar\Avatar;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as ContractsAuditable;

class User extends Authenticatable implements ContractsAuditable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Auditable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

    public function getTwoNamesAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getImageAttribute()
    {
        // generate user initials avatar
        $avatar = new Avatar();
        return $avatar->create($this->two_names)->setBackground('#505d69')->toBase64();
    }

    public function scopeGetUsers($query)
    {
        return $query->where([['id', '!=', 1], ['id', '!=', auth()->id()]])->withTrashed()->get();
    }

    public function myCourses()
    {
        return $this->hasMany(CourseLecturer::class, 'lecturer_id');
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->withTrashed()->where('username', $value)->first();
    }
}
