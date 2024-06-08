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
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>User Management Control</h3>
                    {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-user"><a href="{{ route('admin') }}">Dashboard</a></li>
                            <li class="breadcrumb-user active" aria-current="page">User Mangement</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        {{-- message --}}
        {!! Toastr::message() !!}
        <section class="section">
            <div class="card">
                <div class="card-header">
                    @can('create users')
                    <a href="{{ route('users.create') }}">
                        <span class="btn btn-primary rounded-pill">Add New User</span>
                    </a>
                    @endcan
                    <a href="{{route('userexport')}}" class="export" style="float: right;">
                        <span class="btn btn-primary rounded-pill">Export Users</span>
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Profile</th>
                                <th>Email Address</th>
                                <th>Role Name</th>
                                <th>Modify</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $key => $user)
                                <tr>
                                    <td class="id">{{ ++$key }}</td>

                                    <td class="name">{{ $user->name }}</td>
                                    <td class="user-img">
                                        <div class="avatar avatar-xl">
                                            @if(substr($user->avatar, 0, 4) == 'http')
                                            <img src="{{$user->avatar}}" alt="image" class="img-circle">
                                            @elseif($user->avatar == NULL)
                                            <img src="{{asset('images/icon.jpg')}}" alt="image" class="img-circle">
                                            @else
                                            <img src="{{ asset($user->avatar) }}" alt="image" class="img-circle">
                                            @endif
                                        </div>
                                    </td>

                                    <td class="email">{{ $user->email }}</td>

                                    <td class="email">
                                        @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $role)
                                            {{ $role }}
                                        @endforeach
                                        @endif
                                    </td>

                                    <td class="modify">
                                        @can('edit users')
                                        <a href="{{ route('users.edit', $user->id) }}">
                                            <span class="badge bg-success"><i class="bi bi-pencil-square"></i></span>
                                        </a>
                                        @endcan
                                        @can('delete users')
                                        <a href="{{ url('user_delete/'. $user->id)}}" onclick="return confirm('Are you sure to want to delete it?')"><span class="badge bg-danger">
                                             <i class="bi bi-trash"></i></span>
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

</div>
@endsection
