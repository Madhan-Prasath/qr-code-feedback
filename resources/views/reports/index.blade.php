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
                        <h3>Report Management Control</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Report Mangement</li>
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
                    @can('create reports')
                    <a href="{{ url('reports/create') }}">
                        <span class="btn btn-primary rounded-pill">Add New Report</span>
                    </a>
                    <a href="{{route('reportexport')}}" class="export" style="float: right;">
                        <span class="btn btn-primary rounded-pill">Export Reports</span>
                    </a>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Feedback</td>
                                <td>Created By</td>
                                <td>Asset Name</td>
                                <td>Created Date</td>
                                <td>Image</td>
                                <td>Feedback Type</td>
                                <td>Status</td>
                                <td>Closed Date</td>
                                <td>Action Taken</td>
                                <th class="text-center">Modify</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($report as $key => $reports)
                                <tr>
                                    <td class="id">{{ ++$key }}</td>

                                    <td>{{$reports->feedback}}</td>

                                    <td>{{$reports->created_by}}</td>

                                    <td>
                                        @if ($reports->asset_id)
                                        {{ $reports->assets->asset_name. ' (' .$reports->assets->asset_id . ') ' .$reports->assets->location }}
                                        @else
                                        Empty Asset
                                        @endif
                                         </td>

                                    <td>{{$reports->created_at->format('d F Y, h:i:s A')}}</td>

                                    @if ($reports->image==null)
                                    <td class="image"><a href="{{ asset('images/image.jpg') }}"><img src="{{ asset('images/image.jpg') }}" width="100" height="100" alt="image"/></a></td>
                                    @endif
                                    @if ($reports->image)
                                    <td class="image"><a href="{{ asset($reports->image) }}"><img src="{{ asset($reports->image) }}" width="100" height="100" alt="image"/> </a></td>
                                    @endif

                                    <td>{{$reports->type}}</td>

                                    <td>{{$reports->status}}</td>

                                    @if ($reports->closed_date==null)
                                    <td>NULL</td>
                                    @endif

                                    @if ($reports->closed_date!=null)
                                    <td>{{$reports->closed_date->format('d F Y')}}</td>
                                    @endif

                                    <td>{{$reports->remarks}}</td>

                                    <td class="text-center">
                                        <a href="{{ route('reports.show', $reports->id) }}">
                                            <span class="badge bg-Secondary"><i class="bi bi-Eye Fill"></i></span>
                                        </a>
                                        @can('edit reports')
                                        <a href="{{ route('reports.edit', $reports->id) }}">
                                            <span class="badge bg-success"><i class="bi bi-pencil-square"></i></span>
                                        </a>
                                        @endcan
                                        @can('delete reports')
                                        <a href="{{ url('report_delete/'.$reports->id) }}" onclick="return confirm('Are you sure to want to delete it?')"><span class="badge bg-danger">
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
