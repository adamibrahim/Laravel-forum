<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * The roles that belong to the user.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }


    /**
     * The threads that belong to the user.
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function threads()
    {
        return $this->hasMany('App\Thread');
    }


    /**
     * The comments that belong to the user.
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }


     /**
     * Check if user is Admin
     *
     * @return array
     */
    public function isAdmin()
    {
        return $this->roles()->pluck('role_id')
            ->intersect([Role::ROLE_ADMIN])->toArray();
    }
}
