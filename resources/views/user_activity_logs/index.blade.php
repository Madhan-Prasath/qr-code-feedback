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
                    <h3>User Activity Log</h3>
                    <p class="text-subtitle text-muted">For user log list</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User Activity Log</li>
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
                    Log Datatable
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Email Address</th>
                                <th>Modify</th>
                                <th>Date Time</th>
                                <th class="text-center">Modify</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user_activity_log as $key => $item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $item->user_name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->modify_user }}</td>
                                    <td>{{ $item->date_time }}</td>
                                    <td class="text-center">
                                        @can('delete user_activity_logs')
                                        <a href="{{ url('user_activity_log_delete/'.$item->id) }}" onclick="return confirm('Are you sure to want to delete it?')"><span class="badge bg-danger">
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
