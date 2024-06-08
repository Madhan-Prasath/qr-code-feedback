<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class ActivityLogController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $activity_log = ActivityLog::all();

        $this->authorize('viewAny', ActivityLog::class);

        return view('activity_logs.index', compact('activity_log'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $activity_log = ActivityLog::findOrFail($id);

        $this->authorize('delete', $activity_log);

        $activity_log->delete();

        Toastr::success('Data deleted successfully :)','Success');

        return redirect('/activity_logs');
    }
}
