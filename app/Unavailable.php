<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unavailable extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'start', 'end', 'user_id', 'title', 'priority',
    ];

    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
