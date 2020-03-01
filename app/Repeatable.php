<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repeatable extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'start', 'end', 'user_id', 'priority', 'title', 'day'
    ];

     
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
