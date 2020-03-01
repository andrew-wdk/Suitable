<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
    * The events that the user participates in.
    */
    public function events()
    {
        return $this->belongsToMany('App\Event');
    }

    /**
    * The events that the user hosts.
    */
    public function hosted()
    {
        return $this->hasMany('App\Event', host_id);
    }


    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

  
    public function unavailables()
    {
        return $this->hasMany('App\Unavailable');
    }

    public function repeatables()
    {
        return $this->hasMany('App\Repeatable');
    }
}
