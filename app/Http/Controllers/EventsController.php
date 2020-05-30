<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use App\Event;
use App\User;
use App\Unavailable;
use App\Repeatable;
use App\comment;
use Illuminate\Support\Facades\Auth;
use App\DateTimePeriod;
use Carbon\Carbon;
use Sassnowski\LaravelShareableModel\Shareable\ShareableLink;
use Illuminate\Auth\Access\AuthorizationException;


class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($link = null)
    {
        $user = User::Find(Auth::id());

        $events = $user->events;

        return view('ShowEvents', compact('events', 'link'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('CreateEvent');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        $event = new Event;

        $user_id = Auth::id();

        $event['host_id'] = $user_id;

        $event['title'] = $request['title'];
        $event['description'] = $request['description'];
        $event['duration'] = $request['duration'];
        $event['startDate'] = $request['startDate'];
        $event['endDate'] = $request['endDate'];
        $event['participants'] = $request['participants'];

        //return var_dump($event);

        $event->save();

        $event->users()->attach($user_id);

        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::Find($id);

        $this->authorize('view', $event);

        $user = Auth::user();
        $availables = EventsController::availables($id);
        $blocks = json_encode(EventsController::availables($id,1));
        $comments = [];
        foreach ($availables as $i=>$av) {
            $comments[$i] = Comment::where('event_id', '=', $id)
                                    ->where('start', '=', $av->startDate)
                                    ->get();
        }
        $guests = Event::Find($id)->users;
        return view('availables3', compact(['event', 'user', 'availables', 'comments', 'guests', 'blocks']));
    }

    /**=
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $this->authorize('delete', $event);
        Event::Find($id)->delete();
        return redirect('/events');
    }

    /**
     * Generate a sharable link for the event to allow participants to join.
     *
     * @param  int  $id
     */
    public function share($id)
    {
    $event = Event::Find($id);
    $this->authorize('getShareableLink', $event);

        if (ShareableLink::where('shareable_id', '=', $id)->exists()){
        $link = ShareableLink::where('shareable_id', '=', $id)->get();
        return EventsController::index($link[0]);
        }

        $link = ShareableLink::buildFor($event)
            ->setActive()
            ->build();

        return EventsController::index($link);
    }

     /**
     * show a summery for the event upon which the user should decide whether to participate.
     *
     * @param  shareablelink  $link
     */
     public function participate($link)
     {
        $event = $link->shareable;

        $host = $event->host;

        return view('Participate', compact('event', 'host'));
     }

     public function confirmParticipation(Request $request, $id)
     {
        $event = Event::Find($id);

        try{
            $this->authorize('participate', $event);
        }catch(\Exception $ex){
            if($ex instanceof AuthorizationException){
                // $intended = $request->session()->previousUrl();
                $intended = $request->url();
                $request->session()->put('intended', $intended);
                return redirect('/login');
            }
        }

        $user_id = Auth::id();

        $ids = $event->users->pluck('id')->toArray();

        if(!in_array($user_id, $ids))
        {
            $event->users()->attach($user_id);
        }
        return EventsController::show($id);
     }

    /**
     * generates the avialable periods based on the unavailables of the participants.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function availables($id, $js = 0)
     {

         $event = Event::findOrFail($id);

         // get an array of participants' ids.
         $ids = $event->users->pluck('id')->toArray();

         //get the unavailables of the participants during the event time period.
         $unavailables = Unavailable::whereIn('user_id', $ids)
                                    ->where('end', '>', $event->startDate)
                                    ->where('start', '<', $event->endDate)
                                    ->orderBy('start', 'asc')
                                    ->get();

        //get the repeatables of the participants.
        // if($js == 1) $repeatables = Repeatable::whereIn('user_id', $ids)->where('title', '!=', 'sleep')->get();
        // else
        $repeatables = Repeatable::whereIn('user_id', $ids)->get();


        // convert the unavailables to DateTimePeriod instances.
        $unav_periods = [];
        foreach ($unavailables as $unavailable) {
            array_push($unav_periods, New DateTimePeriod(
                $unavailable->start,
                $unavailable->end,
                $unavailable->user_id
            ));
        }


        // add the repeatbles to the unav_periods array.
        for ($i = Carbon::parse($event->startDate);
             $i <= Carbon::parse($event->endDate);
             $i->addDays('1'))
        {
            $day = $i->format('D');
            foreach ($repeatables as $repeatable) {
                if ($repeatable->$day == true)
                {
                    if ($repeatable->start >= $repeatable->end)
                    {
                        array_push($unav_periods, New DateTimePeriod(
                            new Carbon($i->format('Y-m-d') .' ' .Carbon::parse($repeatable->start)->format('H:i:s')),
                            new Carbon($i->copy()->addDays('1')->format('Y-m-d') .' ' .Carbon::parse($repeatable->end)->format('H:i:s')),
                            $repeatable->user_id
                        ));
                    }
                    else {
                        array_push($unav_periods, New DateTimePeriod(
                            new Carbon($i->format('Y-m-d') .' ' .Carbon::parse($repeatable->start)->format('H:i:s')),
                            new Carbon($i->format('Y-m-d') .' ' .Carbon::parse($repeatable->end)->format('H:i:s')),
                            $repeatable->user_id
                        ));
                    }

                }
            }
        }

        // sort the unav_periods array after adding the repeatables
        usort($unav_periods, function ($a, $b){
            if($a->startDate->lt($b->startDate)) return -1;
            else if ($a->startDate->eq($b->startDate)) return 0;
            else return 1;
        });

        // removes repeatbles that are out of the event range
        foreach($unav_periods as $key => $period){
            if($period->endDate->lt($event->startDate)
            || $period->startDate->gt($event->endDate)){
                // dd($period);
                unset($unav_periods[$key]);
            }
        }

        //separate unav_periods into single time stamps for computing the intersections
        $points = [];
        foreach ($unav_periods as $period){
            array_push($points, (object) ['time' => $period->startDate,
                'is_start' => true, 'user_id' => $period->user_id]);
            array_push($points, (object) ['time' => $period->endDate,
            'is_start' => false, 'user_id' => $period->user_id]);
        }

        usort($points, function ($a, $b){
            if($a->time->lt($b->time)) return -1;
            else if ($a->time->eq($b->time)) return 0;
            else return 1;
        });

        //creat intersections array
        $i_level = 0;
        $user_ids = [];

        $intersections[0] = new DateTimePeriod (Carbon::parse($event->startDate), null, $i_level);
        foreach ($points as $i => $point){
            if ($points[$i]->time->lt(Carbon::parse($event->startDate))){
                $points[$i]->time = Carbon::parse($event->startDate);
            }
            $intersections[$i]->setEndDate($point->time);
            if ($point->is_start){
                if (count(array_keys($user_ids, $point->user_id)) == 0){
                    $i_level++;}
                array_push($user_ids, $point->user_id);
            }
            else{
                if (count(array_keys($user_ids, $point->user_id)) == 1){
                    $i_level--;}
                unset($user_ids[array_search($point->user_id, $user_ids)]);
            }
            $intersections[$i+1] = new DateTimePeriod ($point->time, null, $i_level);
        }
        array_pop($intersections);

        if($js == 1) return $intersections;

        // creates an array of available periods.
        $event_periods = [New DateTimePeriod($event->startDate, $event->endDate)];


        //split the available periods based on the unavailables.
        foreach ($unav_periods as $period) {
            foreach ($event_periods as $event_period) {
                switch (DateTimePeriod::periodCompare($period, $event_period)){
                case 2:
                case 3:
                    $event_period->startDate = $period->endDate;
                break;
                case 4:
                    array_push($event_periods, new DateTimePeriod($period->endDate, $event_period->endDate));
                    $event_period->endDate = $period->startDate;
                break;
                case 5:
                case 10:
                    $event_period->endDate = $period->startDate;
                break;
                case 6:
                case 7:
                case 8:
                case 9:
                    unset($event_period);
                break;
                default:
                break;
                }
            }
        }

        // echo(json_encode($intersections));
        // exit;
        return $event_periods;
    }
}
