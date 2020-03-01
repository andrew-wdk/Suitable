<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Event;
use App\Comment;
use App\Unavailable;
use App\Repeatable;

class AdminController extends Controller
{
    public function MakeAdmin($id){

        $user = User::Find($id);
        $user->assignRole('admin');

        return back();
    }

    public function Home(){
        $users = User::count();
        $events = Event::count();
        $comments = Comment::count();
        $unavailables = Unavailable::count() + Repeatable::count();

        return view('admin.admin-home', compact('users', 'events', 'comments', 'unavailables'));
    }

    public function events()
    {
        $events = Event::paginate(15);

        $hosts = [];

        foreach ($events as $event) {
            array_push($hosts, $event->host);
        }

        return view('admin.admin-events', compact('events', 'hosts'));
    }

    public function comments()
    {
        $comments = Comment::all();

        $users = [];

        foreach ($comments as $comment) {
            array_push($users, $comment->user);
        }

        return view('admin.admin-comments', compact('comments', 'users'));
    }

    public function unavailables()
    {
        $unavailables = Unavailable::all();

        $users = [];

        foreach ($unavailables as $unavailable) {
            array_push($users, $unavailable->user);
        }

        $repeatables = Repeatable::all();
        
        $users2 = [];

        foreach ($repeatables as $repeatable) {
            array_push($users2, $repeatable->user);
        }
        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        return view('admin.admin-unavailables', compact('unavailables', 'users', 'repeatables', 'users2', 'days'));
    }
}
