<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Rules\Uppercase;
use Illuminate\Http\Request;
use App\Exports\AssetsExport;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;


class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asset = Asset::all();

        $this->authorize('viewAny', Asset::class);

        return view('assets.index',compact('asset'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Asset::class);

        return view('assets.create');
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
            'asset_id'       => 'required|max:25|unique:assets,asset_id,NULL,NULL,link,'.$request['link'],
            'asset_name'     => ['required', 'max:255', new Uppercase],
            'location'       => 'required|max:255',
            'description'    => 'required|max:255',
            'link'           => 'required|max:255|unique:assets,link,NULL,NULL,asset_id,'.$request['asset_id'],
            'image'          => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ],
        [
          'asset_id.required'    => 'The Asset ID field is required.',
          'asset_name.required'  => 'The Asset Name field is required.',
          'location.required'    => 'The Asset Location field is required.',
          'description.required' => 'The Description field is required.',
          'link.required'        => 'The Asset Link field is required.',
          'image.required'       => 'The Image is required.',
          'asset_id.unique'      => 'The Asset ID has already been taken.',
          'link.unique'          => 'The Link has already been taken.'

        ]);

        // For image filed

        $convert = 25;

        if ($files = $request->file('image')) {

            $destinationPath = 'storage'. DIRECTORY_SEPARATOR. 'assets'. DIRECTORY_SEPARATOR. Auth::user()->email; // upload path

            // Storage creation mode
            File::makeDirectory($destinationPath, $mode = 0777, true, true);

            $image           = $request->asset_id.' - '. $request->asset_name . ' - ' . date('YmdHis') . "." . $files->getClientOriginalExtension();

            $imagePath       = $destinationPath. DIRECTORY_SEPARATOR. $image;

            $imageFile       = Image::make($files);

            $imageFile->save(($destinationPath. DIRECTORY_SEPARATOR. $image), $convert);

            }

        $asset = new Asset;

        $asset->asset_id    = $request->asset_id;
        $asset->asset_name  = $request->asset_name;
        $asset->location    = $request->location;
        $asset->description = $request->description;
        $asset->link        = $request->link;
        $asset->image       = $imagePath;

        $asset->save();

        Toastr::success('Created New Asset successfully :)','Success');

        return redirect()->route('asset');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asset = Asset::find($id);

        $this->authorize('view', $asset);

        return view('assets.show', compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asset = Asset::findOrFail($id);

        $this->authorize('update', $asset);

        return view('assets.edit', compact('asset'));
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
        // Validation Rule on update
        $update = $request->validate([

            'asset_id'       =>  ['required',
                                  Rule::unique('assets')->where(function ($query) {
                                      $query->where('asset_id', \request()->input('asset_id'))
                                         ->where('link', \request()->input('link'));
                                  })->ignore($id)
                                 ],

            'asset_name'     =>  ['required', 'max:255', new Uppercase],
            'location'       =>  'required|max:255',
            'description'    =>  'required|max:255',

            'link'           =>  ['required',
                                  Rule::unique('assets')->where(function ($query) {
                                      $query->where('link', \request()->input('link'))
                                         ->where('asset_id', \request()->input('asset_id'));
                                  })->ignore($id)
                                 ],

            'image'          =>  'nullable|image|mimes:jpg,png,jpeg,gif,svg',

        ],

        [
          'asset_id.required'    => 'The Asset ID field is required.',
          'asset_name.required'  => 'The Asset Name field is required.',
          'location.required'    => 'The Asset Location field is required.',
          'description.required' => 'The Description field is required.',
          'link.required'        => 'The Asset Link field is required.',
          'image.required'       => 'The Image is required.',
          'asset_id.unique'      => 'The Similar Asset ID has already been taken.',
          'link.unique'          => 'The Similar Link has already been taken.'
        ]);

        $asset_id          = $request->asset_id;
        $asset_name        = $request->asset_name;

        // For image filed Update
        $convert = 25;

        if ($files = $request->file('image')) {

            $destinationPath = 'storage'. DIRECTORY_SEPARATOR. 'assets'; // upload path

            // Storage creation mode
            File::makeDirectory($destinationPath, $mode = 0777, true, true);

            $image           = $asset_name. ' - '. $asset_id . ' - ' . date('YmdHis') . "." . $files->getClientOriginalExtension();

            $imagePath       = $destinationPath. DIRECTORY_SEPARATOR. $image;

            $imageFile       = Image::make($files);

            $imageFile->save(($destinationPath. DIRECTORY_SEPARATOR. $image), $convert);

            $update['image'] = "$imagePath";

            }

        Asset::whereId($id)->update($update);

        Toastr::success('Asset updated successfully :)','Success');

        return redirect()->route('asset');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);

        // When delete image is deleted from the storage
        File::delete(public_path($asset->image));

        $this->authorize('delete', $asset);

        $delete = Asset::where('id' ,$id)->firstorfail()->delete();

        Toastr::success('Data deleted successfully :)','Success');

        return redirect('/asset');
    }

    public function export()
    {
        return Excel::download(new AssetsExport, 'Assets.xlsx');
    }
}
