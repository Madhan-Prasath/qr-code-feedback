<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserActivityLog;
use Brian2694\Toastr\Facades\Toastr;

class UserActivityLogController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $user_activity_log = UserActivityLog::all();

        $this->authorize('viewAny', UserActivityLog::class);

        return view('user_activity_logs.index', compact('user_activity_log'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_activity_log = UserActivityLog::findOrFail($id);

        $this->authorize('delete', $user_activity_log);

        $user_activity_log->delete();

        Toastr::success('Data deleted successfully :)','Success');

        return redirect('/user_activity_logs');
    }
}
