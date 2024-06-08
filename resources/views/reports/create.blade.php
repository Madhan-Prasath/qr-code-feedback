@extends('layouts.master')
@section('menu')
@extends('sidebar.dashboard')
@endsection
@section('content')
<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Report Input Information</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Report Input</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- message --}}
    {!! Toastr::message() !!}

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add New Report</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="row">

                                <div class="col-md-4">
                                    <label>Write Your Feedback</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="position-relative">
                                            <textarea class="form-control @error('feedback') is-invalid @enderror" value="{{ old('feedback') }}"
                                                placeholder="Enter The Feedback" id="feedback" name="feedback"></textarea>
                                            <div class="form-control-icon">
                                                {{-- <i class="bi bi-Chat left text"></i> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <div class="col-md-4">
                                    <label>Report Image</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="position-relative">
                                            <input type="file" name="image" placeholder="Choose image" id="image" class="form-control @error('image') is-invalid @enderror" value="{{old('image')}}">
                                            <div class="form-control-icon">
                                                {{-- <i class="bi bi-file-image fill"></i> --}}
                                            </div>
                                        </div>
                                        <br>
                                        <img id="preview-image" src="{{ asset('images/photo.jpg') }}"
                                        alt="preview image" style="max-height: 400px;">
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Create Report</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-light-secondary me-1 mb-1">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
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



