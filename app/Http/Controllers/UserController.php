<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

use Brian2694\Toastr\Facades\Toastr;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();

        $this->authorize('viewAny', User::class);

        return view('users.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        $this->authorize('create', User::class);

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'avatar'                => 'required|image',
            'email'                 => 'required|string|email|max:255|unique:users',
            'roles'                 => 'required',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        $convert = 10;

        // For image filed

        if ($files = $request->file('avatar')) {

            $destinationPath = 'storage'. DIRECTORY_SEPARATOR. 'users'. DIRECTORY_SEPARATOR. 'avatar'. DIRECTORY_SEPARATOR. Auth::user()->email; // upload path
            // Storage creation mode
            File::makeDirectory($destinationPath, $mode = 0777, true, true);

            $image           = auth()->user()->name . ' - ' . date('YmdHis') . "." . $files->getClientOriginalExtension();

            $imagePath       = $destinationPath. DIRECTORY_SEPARATOR. $image;

            $imageFile       = Image::make($files);

            $imageFile->save(($destinationPath. DIRECTORY_SEPARATOR. $image), $convert);

            }

        $user = new User;
        $user->name         = $request->name;
        $user->avatar       = $imagePath;
        $user->email        = $request->email;
        $user->password     = Hash::make($request->password);

        $user->save();

        $user->assignRole($request->input('roles'));

        Toastr::success('Create new account successfully :)', 'Success');

        return redirect('/users');

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
        $user     = User::find($id);

        $this->authorize('update', $user);

        $roles    = Role::all();

        $userRole = $user->roles->pluck('id', 'id')->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
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
        $update = $request->validate([
            'name'         => 'required|string|max:255',
            'avatar'       => 'nullable|image',
            'email'        => 'required',
            'roles'        => 'required',
        ]);

        $dt                = Carbon::now();
        $todayDate         = $dt->toDayDateTimeString();

        $activityLog = [

            'user_name'    => $request->name,
            'email'        => $request->email,
            'modify_user'  => 'Update',
            'date_time'    => $todayDate,
        ];


        // For image filed Update
        $convert  = 50;

        if ($files = $request->file('avatar')) {

            $destinationPath = 'storage'. DIRECTORY_SEPARATOR. 'users'. DIRECTORY_SEPARATOR. 'avatar'. DIRECTORY_SEPARATOR. Auth::user()->email; // upload path

            // Storage creation mode
            File::makeDirectory($destinationPath, $mode = 0777, true, true);

            $image           = auth()->user()->name . ' - ' . date('YmdHis') . "." . $files->getClientOriginalExtension();

            $imagePath       = $destinationPath. DIRECTORY_SEPARATOR. $image;

            $imageFile         = Image::make($files);

            $imageFile->save(($destinationPath. DIRECTORY_SEPARATOR. $image), $convert);

            $update['avatar'] = "$imagePath";

            }

        DB::table('user_activity_logs')->insert($activityLog);

        $user = User::find($id);
        $user->update($update);


        DB::table('model_has_roles')
            ->where('model_id', $id)
            ->delete();

        $user->assignRole($request->input('roles'));

        Toastr::success('User updated successfully :)','Success');

        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // When delete avatar is deleted from the storage
        File::delete(public_path($user->avatar));

        $this->authorize('delete', $user);

        $user->delete();

        Toastr::success('Data deleted successfully :)','Success');

        return redirect('/users');
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'Users.xlsx');
    }
}
