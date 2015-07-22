<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Facebook extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        if(Auth::check()) {

            return redirect()->back();
        }
        
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        if(Auth::check()) {

            return redirect()->back();
        }

        $fc_user = Socialite::driver('facebook')->user();

        if(User::where('email', $fc_user->email)->get()->isEmpty()) {
            
            $explodingUserName = explode(' ', $fc_user->name);
            
            $new_user = new User;
            $new_user->first_name = $explodingUserName[0];
            $new_user->last_name = $explodingUserName[1];
            $new_user->email = $fc_user->email;
            $new_user->password = Hash::make('fc'.$fc_user->id);
            $new_user->role = 'user';
            $new_user->save();

        }

        $user = User::where('email', $fc_user->email)->first();

        Auth::login($user);

        return redirect('/');
    }
}