<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sassnowski\LaravelShareableModel\Shareable\Shareable;
use Sassnowski\LaravelShareableModel\Shareable\ShareableInterface;


class Event extends Model implements ShareableInterface
{

    use SoftDeletes;
    use Shareable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'user_id', 'title', 'description', 'duration', 'startDate', 'endDate'
    ];

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
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

}
