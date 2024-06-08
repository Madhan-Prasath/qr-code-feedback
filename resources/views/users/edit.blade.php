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
                    <h3>User Management Control</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User Mangement</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Users View</h4>
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
                          </div><br />
                        @endif
                          <form method="post" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                              <div class="form-group">
                                  @csrf
                                  @method('PUT')
                                  <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Name</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control"
                                                        placeholder="Name" id="name" name="name" value="{{ $user->name }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Email</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <div class="position-relative">
                                                    <input type="email" class="form-control"
                                                            placeholder="Email" id="email" name="email" value="{{ $user->email }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Roles</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <div class="position-relative">
                                                    <select name="roles[]" class="form-control" id="roles">
                                                        <option value="" selected="selected">--> Select Role <--</option>
                                                        @foreach($roles as $role)
                                                          <option value="{{ $role->id }}" @if($user->roles->contains('id', $role->id)) selected @endif>{{ $role->name}}</option>
                                                        @endforeach
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Profile</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <div class="position-relative">
                                                     <input type="file" name="avatar" placeholder="Choose Avatar" id="avatar" alt="{{$user->avatar}}" class="form-control" value="{{ $user->avatar }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Profile View</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <div class="position-relative">
                                                    @if(substr($user->avatar, 0, 4) == 'http')
                                                    <img src="{{$user->avatar}}" alt="image" class="img-circle">
                                                    @elseif($user->avatar == NULL)
                                                    <img src="{{asset('images/icon.jpg')}}" alt="image" class="img-circle">
                                                    @else
                                                    <img src="{{ asset($user->avatar) }}" style="max-height: 400px;"/>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Update User</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-light-secondary me-1 mb-1">Cancel</a>
                                </div>
                          </form>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
