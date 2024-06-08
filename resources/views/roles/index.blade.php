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
                     <h3>Roles Management Control</h3>
                 </div>
                 <div class="col-12 col-md-6 order-md-2 order-first">
                     <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                         <ol class="breadcrumb">
                             <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                             <li class="breadcrumb-item active" aria-current="page">Roles Mangement</li>
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
                    @can('create-roles')
                    <a href="{{ route('roles.create') }}">
                        <span class="btn btn-primary rounded-pill">Add New Role</span>
                    </a>
                    @endcan
                </div>

                <div class="card-body">
                    <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Name</td>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $role)
                            <tr>
                                <td class="id">{{ ++$key }}</td>

                                <td>{{ $role->name }}</td>

                                <td class="text-center">
                                    <a href="{{ route('roles.show',$role->id) }}">
                                        <span class="badge bg-Secondary"><i class="bi bi-Eye Fill"></i></span></a>
                                    @can('edit-roles')
                                        <a href="{{ route('roles.edit',$role->id) }}">
                                            <span class="badge bg-success"><i class="bi bi-pencil-square"></i></span></a>
                                    @endcan
                                    @can('delete-roles')
                                        <a href="{{ url('role_delete/'.$role->id) }}" onclick="return confirm('Are you sure to want to delete it?')"><span class="badge bg-danger">
                                            <i class="bi bi-trash"></i></span></a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
