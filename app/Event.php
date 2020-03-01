<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'user_id', 'title', 'description', 'duration', 'startDate', 'endDate'
    ];

    use SoftDeletes;

    /**
    * Get the event's host.
    */
    public function host()
    {
        return $this->belongsTo('App\User');
    }

    /**
    * The participants of the event.
    */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }



}
