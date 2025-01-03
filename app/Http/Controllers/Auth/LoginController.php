<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
        $this->middleware('guest')->except([
            'logout',
            'locked',
            'unlock'
        ]);
    }

    public function login()
    {

    return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $email    = $request->email;
        $password = $request->password;

        $dt         = Carbon::now();
        $todayDate  = $dt->toDayDateTimeString();

        $url = Session::get('url.intended', url('/'));

        $asset = Asset::where('link','=', $url)
                       ->select('id')
                       ->first();

        $activityLog = [

            'name'        => $email,
            'email'       => $email,
            'description' => 'has log in',
            'location'    => $url,
            'asset_id'    => $asset->id ?? null,
            'date_time'   => $todayDate,
        ];

        if (Auth::attempt(['email'=>$email,'password'=>$password])) {
            DB::table('activity_logs')->insert($activityLog);
            Toastr::success('Login successfully :)','Success');
            return redirect()->intended('home');
        }
        elseif (Auth::attempt(['email'=>$email,'password'=>$password])) {
            DB::table('activity_logs')->insert($activityLog);
            Toastr::success('Login successfully :)','Success');
            return redirect()->intended('home');
        }
        else{
            Toastr::error('fail, WRONG USERNAME OR PASSWORD :)','Error');
            return redirect('login');
        }

    }

    public function logout()
    {
        Auth::logout();
        Toastr::success('Logout successfully :)','Success');
        return redirect('login');
    }

}
