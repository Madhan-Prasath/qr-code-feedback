<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Asset;
use App\Models\Report;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\UserActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($name = null)
    {
        $users              = User::count();
        $assets             = Asset::count();
        $reports            = Report::count();
        $activity_logs      = ActivityLog::count();
        $user_activity_logs = UserActivityLog::count();

        return view('home',compact('name', 'users', 'user_activity_logs','reports', 'assets', 'activity_logs'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function log($name = null)
    {

        $url                   = url()->current();

        $asset                 = Asset::where('link','=', $url)
                                     ->select('link')
                                     ->first();

        $description           = Asset::where('link','=', $url)
                                     ->select('description')
                                     ->first();

        $location              = Asset::where('link','=', $url)
                                     ->select('location')
                                     ->first();

        $asset                 = Asset::where('link','=', $url)
                                     ->select('id')
                                     ->first();

        $current_datetime      = Carbon::now();

        $date_format           = $current_datetime->format('Y-m-d H:i:s');

        $current_date          = Carbon::today();

        $user                  = Auth::user();

        $user_created_report   = Report::where('created_by', '=', $user->email)
                                        ->where('asset_id', '=', $asset->id ?? null)
                                        ->select('created_at')
                                        ->first();

        $created_at            = Report::select('created_at')->get();

        // Subtract current     datetime
        $subMinutes            = Carbon::now()->subMinutes(240)->toDateTimeString();

        if($created_at == null){
            $report_time = $user_created_report->created_at->format('Y-m-d H:i:s');
        }
        else{
            $report_time = null;
        }

        $reportuser    = Report::whereNotBetween('created_at',[$report_time, $subMinutes])
                                ->where('created_by', '=', $user->email)
                                ->where('asset_id', '=', $asset->id ?? null)
                                ->select('created_by')
                                ->count('created_by');

        $report        = Report::where('asset_id', '=', $asset->id ?? null)
                                ->whereDate('created_at', $current_date)
                                ->count();

        $reports       = Report::where('asset_id', '=', $asset->id ?? null)
                                ->whereDate('created_at', $current_date)
                                ->count()-1;

        // Ensure the URL name

        if ($name = $asset)
        {
            if($reportuser >= 1) {
                return view('feedback.submittedfeedback', compact('name', 'asset', 'description', 'location', 'date_format', 'report', 'reportuser', 'reports'));
            }

            else {
                return view('log', compact('name', 'asset', 'description', 'location' ,'date_format', 'report', 'reports'));
            }
        }

        else
        {
            return redirect(404);
        }
    }


    public function feedback($name = null)
    {
        $current_date   = Carbon::now();

        $date_format    = $current_date->format('Y-m-d H:i:s');

        $url            = url()->previous();

        $asset          = Asset::where('link','=', $url)
                                ->select('link')
                                ->first();

        $description    = Asset::where('link','=', $url)
                                 ->select('description')
                                 ->first();

        $location       = Asset::where('link','=', $url)
                                    ->select('location')
                                    ->first();

        $asset          = Asset::where('link','=', $url)
                                 ->select('id')
                                 ->first();

        $current_date   =  Carbon::today();

        $report         = Report::where('asset_id', '=', $asset->id ?? null)
                                 ->whereDate('created_at', $current_date)
                                 ->count();

        $reports        = Report::where('asset_id', '=', $asset->id ?? null)
                                  ->whereDate('created_at', $current_date)
                                  ->count()-1;

        // Ensure the URL name

        if ($name = $asset)
        {
            return view('feedback.feedback', compact('name', 'asset', 'description', 'location', 'date_format', 'report', 'reports'));
        }

        else
        {
            return redirect(404);
        }
    }
}
