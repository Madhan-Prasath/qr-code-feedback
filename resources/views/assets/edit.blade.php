@extends('layouts.master')
@section('menu')
@extends('sidebar.dashboard')
@endsection
@section('content')
<div id="main">
    <style>
        .avatar.avatar-im .avatar-content, .avatar.avatar-xl img {
            width: 40px !important;
            height: 40px !important;
            font-size: 1rem !important;
        }
        .form-group[class*=has-icon-].has-icon-lefts .form-select {
            padding-left: 2rem;
        }

    </style>

    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Asset Management Control</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Asset Mangement</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Assets View</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if ($errors->any())
                          <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                          </div><br/>
                        @endif
                          <form method="post" action="{{ route('asset.update', $asset->id) }}" enctype="multipart/form-data">
                              <div class="form-group">
                                  @csrf
                                  @method('PUT')
                                  <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Asset ID</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control @error('asset_id') is-invalid @enderror"
                                                        placeholder="Asset ID" id="asset_id" name="asset_id" value="{{ $asset->asset_id }}">
                                                    <div class="form-control-icon">
                                                        {{-- <i class="bi bi-person"></i> --}}
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
                                                    <input type="text" class="form-control @error('asset_name') is-invalid @enderror"
                                                        placeholder="Asset Name" id="asset_name" name="asset_name" value="{{ $asset->asset_name }}">
                                                    <div class="form-control-icon">
                                                        {{-- <i class="bi bi-person"></i> --}}
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
                                                    <input type="text" class="form-control @error('location') is-invalid @enderror"
                                                        placeholder="Location" id="location" name="location" value="{{ $asset->location }}">
                                                    <div class="form-control-icon">
                                                        {{-- <i class="bi bi-person"></i> --}}
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
                                                    <input type="text" class="form-control @error('description') is-invalid @enderror"
                                                        placeholder="Description" id="description" name="description" value="{{ $asset->description }}">
                                                    <div class="form-control-icon">
                                                        {{-- <i class="bi bi-person"></i> --}}
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
                                                    <input type="text" class="form-control @error('link') is-invalid @enderror"
                                                        placeholder="Link" id="link" name="link" value="{{ $asset->link }}">
                                                    <div class="form-control-icon">
                                                        {{-- <i class="bi bi-person"></i> --}}
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
                                                     <input type="file" name="image" placeholder="Choose image" id="image" alt="{{$asset->image}}" class="form-control @error('image') is-invalid @enderror" value="{{ $asset->image }}">
                                                    <div class="form-control-icon">
                                                        {{-- <i class="bi bi-person"></i> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Asset View</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <div class="position-relative">
                                                    <br>
                                                    <img src="{{ asset($asset->image) }}" style="max-height: 600px;"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit"
                                                class="btn btn-primary me-1 mb-1">Update</button>
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
