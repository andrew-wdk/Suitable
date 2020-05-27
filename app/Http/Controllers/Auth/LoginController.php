<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleProviderCallback()
    {
        $facebook_user = Socialite::driver('facebook')->user();

        $name = $facebook_user->getName();
        $email = $facebook_user->getEmail();
        $social_id = $facebook_user->getId();

        $user = User::where('email', $email)->first();
        if($user){
            if($user->social_type != 'facebook'){
                $user->update(['social_type' => 'facebook', 'social_id' => $social_id]);
            }
        }
        else{
            $user = User::create(['name' => $name, 'email' => $email,
            'social_type' => 'facebook', 'social_id' => $social_id]);
        }

        Auth::login($user);
        return redirect('/home');
    }
}
