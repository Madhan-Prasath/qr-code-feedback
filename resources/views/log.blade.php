@extends('layouts.master')
@section('menu')
@endsection
@section('content')
<style>
    .card {
        margin: 0 auto; /* Added */
        float: none; /* Added */
        margin-bottom: 10px; /* Added */
}
</style>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h6> Hello </h6>
                    <br>
                     <h6> {{ Auth::user()->name }} </h6>
                    <br>
                    <h6>  {{date("d-M-Y h:i:s A", strtotime($date_format))}} </h6>
                    <br>
                    <h6> Location : {{ $location->location ?? null }} </h6>
                    <br>
                    <h6>  Description : {{ $description->description }}</h6>
                    <br>
                </div>
                {!! Toastr::message() !!}
                <div class="card-content" id="feedback">
                    <div class="card-body">
                        <form class="form form-horizontal" action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <div class="row">

                                    <div class="col-md-4">
                                        <label class="feedback" style="color: black">Feedback</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <div class="position-relative">
                                                <textarea class="form-control @error('feedback') is-invalid @enderror" value="{{ old('feedback') }}"
                                                    placeholder="Please write your feedback" id="feedback" name="feedback"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="col-md-4">
                                        <label>Image</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <div class="position-relative">
                                                <input type="file" name="image" placeholder="Choose image" id="image" class="form-control @error('image') is-invalid @enderror" value="{{old('image')}}">
                                            </div>
                                            <br>
                                            <img id="preview-image" src="{{ asset('images/photo.jpg') }}"
                                            alt="preview image" style="max-width: 100%;min-width: 300px;height: auto;border: 1px solid #bebdf7">
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1" onclick="return confirm('Are you sure to want to submit it?')">Submit</button>
                                    </div>
                                </div>
                            </div>
                            @if ($report >= 1)
                            <h6 style="color: red">*Already {{$report}} user has submitted the feedback </h6>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
    $('#image').change(function(){

    let reader = new FileReader();
    reader.onload = (e) => {
      $('#preview-image').attr('src', e.target.result);
    }
    reader.readAsDataURL(this.files[0]);

   });
  </script>
@endsection
