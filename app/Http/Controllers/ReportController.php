<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Exports\ReportsExport;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $report = Report::orderBy('id', 'DESC')->get();

        $this->authorize('viewAny', Report::class);

        return view('reports.index', compact('report'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Report::class);

        return view('reports.create');
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
            'feedback'   => 'max:1000',
            'image'      => 'image|mimes:jpg,png,jpeg,gif,svg|max:10000',
        ]);

        // For image convertion filed Update
        $convert = 25;

        if ($files = $request->file('image')) {

            $destinationPath = 'storage'. DIRECTORY_SEPARATOR. 'reports'. DIRECTORY_SEPARATOR. Auth::user()->email; // upload path

            // Storage creation mode
            File::makeDirectory($destinationPath, $mode = 0777, true, true);

            $image           = auth()->user()->name . ' - ' . date('YmdHis') . "." . $files->getClientOriginalExtension();

            $imagePath       = $destinationPath. DIRECTORY_SEPARATOR. $image;

            $imageFile       = Image::make($files);

            $imageFile->save(($destinationPath. DIRECTORY_SEPARATOR. $image), $convert);

            }

        $url      = url()->previous();

        //URL last parameter
        $lastWord = substr($url, strrpos($url, '/') + 1);

        $asset    = Asset::where('link','=', $url)
                     ->select('id')
                     ->first();

        $report = new Report;

        $report->feedback  = $request->feedback;
        $report->asset_id  = $asset->id ?? null;
        $report->image     = $imagePath ?? null;

        // To check type Positve or Negative feedback
        if((substr($lastWord, 0, 1) == 'P')){
            $report->type    = "Positive" ?? null;
        }
        if((substr($lastWord, 0, 1) == 'N')){
            $report->type    = "Negative" ?? null;
        }

        $report->save();

        Toastr::success('Created New Feedback successfully :)','Success');

        return redirect('/feedback');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $report = Report::find($id);

        $this->authorize('view', $report);

        return view('reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $report = Report::findOrFail($id);

        $this->authorize('update', $report);

        return view('reports.edit', compact('report'));
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
        $updateData = $request->validate([

            'feedback'       => 'max:1500',
            'image'          => 'image|mimes:jpg,png,jpeg,gif,svg',
            'status'         => 'required|max:255',
            'type'           => 'required|max:255',
            'remarks'        => 'required',
            'closed_date'    => 'required',

        ],

        [
            'remarks.required'     => 'The Action Taken field is required.',
            'status.required'      => 'The Status field is required.',
            'type.required'        => 'The Feedback Type field is required.',
            'closed_date.required' => 'The Closed Date field is required.',
        ]);

        // For image convertion filed Update
        $convert  = 25;

        if ($files = $request->file('image')) {

            $destinationPath = 'storage'. DIRECTORY_SEPARATOR. 'reports'. DIRECTORY_SEPARATOR. Auth::user()->email; // upload path

            // Storage creation mode
            File::makeDirectory($destinationPath, $mode = 0777, true, true);

            $image           = auth()->user()->name . ' - ' . date('YmdHis') . "." . $files->getClientOriginalExtension();

            $imagePath       = $destinationPath. DIRECTORY_SEPARATOR. $image;

            $imageFile       = Image::make($files);

            $imageFile->save(($destinationPath. DIRECTORY_SEPARATOR. $image), $convert);

            $updateData['image'] = "$imagePath";

            }

        Report::whereId($id)->update($updateData);

        Toastr::success('Feedback updated successfully :)','Success');

        return redirect('/reports');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $report = Report::findOrFail($id);

        // When delete image is deleted from the storage
        File::delete(public_path($report->image));

        $this->authorize('delete', $report);

        $report->delete();

        Toastr::success('Data deleted successfully :)','Success');

        return redirect('/reports');
    }

    public function export()
    {
        return Excel::download(new ReportsExport, 'Reports.xlsx');
    }

    public function report($image = null)
    {

        return response()->file($image);

    }

    public function asset($image = null)
    {

        return response()->file($image);

    }
}
