<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Asset;
use App\Models\ActivityLog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;


class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
            $socialUser = Socialite::driver('google')->user();
        } catch (InvalidStateException $exception) {
            return redirect()->route('login')
                ->withErrors([
                    'email' => [
                        __('Google Login failed, please try again.'),
                    ],
                ]);
        }

        // Very Important! Stops anyone with any google accessing auth!
        $googleLoginDomain = env('GOOGLE_LOGIN_DOMAIN', null);
        if (! Str::endsWith($socialUser->getEmail(), $googleLoginDomain)) {
            return redirect()->route('login')
                ->withErrors([
                    'email' => [
                        __('Only Domain email addresses are accepted.'),
                    ],
                ]);
        }

        $user = User::where('email', $socialUser->getEmail())->first();

        // if user already found
        if( $user ) {
            // update the avatar that might have changed
            $user->update([
                'avatar'   => $socialUser->avatar,
            ]);

            $user_role = $user->getRoleNames();

            if($user_role->count() == 0){

                $role = Role::where('name', '=', 'User')->firstOrFail();

                $user->roles()->attach($role->id);
            }

        }
        else {
            // create a new user
            $user = User::create([
                'name'          => $socialUser->getName(),
                'email'         => $socialUser->getEmail(),
                'avatar'        => $socialUser->getAvatar(),
                'password'      => Str::random(32)
            ]);

            $role = Role::where('name', '=', 'User')->firstOrFail();

            $user->roles()->attach($role->id);
        }

        $log        = ActivityLog::where('email', $socialUser->getEmail())->first();

        $dt         = Carbon::now();
        $todayDate  = $dt->toDayDateTimeString();

        $url        = Session::get('url.intended', url('/'));

        $asset      = Asset::where('link','=', $url)
                            ->select('id')
                            ->first();

        // if user already found
        if( $log ) {

            $log = ActivityLog::create([
                'name'          => $socialUser->getName(),
                'email'         => $socialUser->getEmail(),
                'description'   => 'has log in',
                'location'      => $url,
                'asset_id'      => $asset->id ?? NULL,
                'date_time'     => $todayDate,
            ]);

        }
        else {
            // create a new user
            $log = ActivityLog::create([
                'name'          => $socialUser->getName(),
                'email'         => $socialUser->getEmail(),
                'description'   => 'has log in',
                'location'      => $url,
                'asset_id'      => $asset->id ?? NULL,
                'date_time'     => $todayDate,
            ]);
        }

        Auth::login($user);

        return redirect()->intended('/home');
    }

}
