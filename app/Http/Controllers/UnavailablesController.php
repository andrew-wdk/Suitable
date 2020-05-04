<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unavailable;
use App\Repeatable;
use Illuminate\Support\Facades\Auth;
Use App\Http\Requests\UnavailableRequest;

class UnavailablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unavailables = Unavailable::where('user_id', '=', Auth::id())
                                    ->orderBy('start', 'asc')
                                    ->get();

        $repeatables = Repeatable::where('user_id', '=', Auth::id())->get();

        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        return view('ViewUnavailables', compact('unavailables', 'repeatables', 'days'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('InsertUnavailables');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnavailableRequest $request)
    {
        $user_id = Auth::id();

        $repeat = false;

        for ($i = 1; $i < 8; $i++)
        {
            if ($request->$i){
                $repeat = true; break;}
        }
        if ($repeat == false)
        {
            $unavailable = new Unavailable;

            $unavailable['user_id'] = $user_id;
            $unavailable['start'] = $request['start'];
            $unavailable['end'] = $request['end'];
            $unavailable['title'] = $request['title'];
            $unavailable['priority'] = $request['priority'];

            $unavailable->save();
        }
        else
        {
            $repeatable = new Repeatable;

            $repeatable['user_id'] = $user_id;
            $repeatable['start'] = $request['start'];
            $repeatable['end'] = $request['end'];
            $repeatable['title'] = $request['title'];
            $repeatable['Mon'] = $request['1'];
            $repeatable['Tue'] = $request['2'];
            $repeatable['Wed'] = $request['3'];
            $repeatable['Thu'] = $request['4'];
            $repeatable['Fri'] = $request['5'];
            $repeatable['Sat'] = $request['6'];
            $repeatable['Sun'] = $request['7'];
            $repeatable['priority'] = $request['priority'];

            $repeatable->save();

        }
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
        //
    }

    /**
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
     * Remove the specified unavailable from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Unavailable::Find($id)->delete();
        return back();
    }

    /**
     * Remove the specified repeatable from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function RepDestroy($id)
     {
         Repeatable::Find($id)->delete();
         return back();
     }
}
