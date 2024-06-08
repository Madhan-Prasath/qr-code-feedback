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
                <h3>Asset Input Information</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Form Input</li>
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
                <h4 class="card-title">Add New Asset</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="{{ route('asset.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Asset ID</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="position-relative">
                                            <input type="text" class="form-control @error('asset_id') is-invalid @enderror" value="{{ old('asset_id') }}"
                                                placeholder="Enter Asset ID" id="asset_id" name="asset_id">
                                                @if ($errors->has('asset_id'))
                                                     <span class="text-danger">{{ $errors->first('asset_id') }}</span>
                                                @endif
                                            <div class="form-control-icon">
                                                {{-- <i class="bi bi-person-check-fill"></i> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Asset Name</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="position-relative">
                                            <input type="text" class="form-control @error('asset_name') is-invalid @enderror" value="{{ old('asset_name') }}"
                                                placeholder="Enter Asset Name" id="asset_name" name="asset_name">
                                                @if ($errors->has('asset_name'))
                                                     <span class="text-danger">{{ $errors->first('asset_name') }}</span>
                                                @endif
                                            <div class="form-control-icon">
                                                {{-- <i class="bi bi-person-check-fill"></i> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Location</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="position-relative">
                                            <input type="text" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}"
                                                placeholder="Enter Location" id="location" name="location">
                                                @if ($errors->has('location'))
                                                     <span class="text-danger">{{ $errors->first('location') }}</span>
                                                @endif
                                            <div class="form-control-icon">
                                                {{-- <i class="bi bi-person-check-fill"></i> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Description</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="position-relative">
                                            <textarea type="text" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}"
                                                placeholder="Enter Description" id="description" name="description"></textarea>
                                                @if ($errors->has('description'))
                                                     <span class="text-danger">{{ $errors->first('description') }}</span>
                                                @endif
                                            <div class="form-control-icon">
                                                {{-- <i class="bi bi-person-check-fill"></i> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Link</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="position-relative">
                                            <input type="text" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}"
                                                placeholder="Enter Link" id="link" name="link">
                                                @if ($errors->has('link'))
                                                     <span class="text-danger">{{ $errors->first('link') }}</span>
                                                @endif
                                            <div class="form-control-icon">
                                                {{-- <i class="bi bi-Alarm fill"></i> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label>Asset Image</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="position-relative">
                                            <input type="file" name="image" placeholder="Choose image" id="image" class="form-control @error('image') is-invalid @enderror" value="{{old('image')}}">
                                            @if ($errors->has('image'))
                                                     <span class="text-danger">{{ $errors->first('image') }}</span>
                                                @endif
                                            <div class="form-control-icon">
                                                {{-- <i class="bi bi-Alarm fill"></i> --}}
                                            </div>
                                        </div>
                                        <br>
                                        <img id="preview-image" src="{{ asset('images/photo.jpg') }}"
                                        alt="preview image" style="max-height: 250px;">
                                    </div>
                                </div>


                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Create Asset</button>
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

@if(Session::has('message'))
<script>
    $(function(){
            toastr.info("{{ Session::get('message') }}");
        })
</script>
@endif
@endsection
