<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Event;

class ShowEvent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $event = Event::Find($request->route('id'));


        if ($user->can('view', $event))
        {
            return $next($request);
        }
        return redirect('/events');
    }
}
