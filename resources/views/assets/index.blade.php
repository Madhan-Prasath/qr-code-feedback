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
                    <h3>Asset Management Control</h3>
                    {{-- <p class="text-subtitle text-muted">For user to check they list</p> --}}
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
        {{-- message --}}
        {!! Toastr::message() !!}
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('asset.create') }}">
                        <span class="btn btn-primary rounded-pill">Add New Asset</span>
                        <a href="{{route('assetexport')}}" class="export" style="float: right;">
                            <span class="btn btn-primary rounded-pill">Export Assets</span>
                        </a>
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Asset ID</th>
                                <th>Asset Name</th>
                                <th>Location</th>
                                <th>Description</th>
                                <th>Link</th>
                                <th>Created At</th>
                                <th>Asset Image</th>
                                <th class="text-center">Modify</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($asset as $key => $item)
                                <tr>
                                    <td class="id">{{ ++$key }}</td>
                                    <td class="asset_id">{{ $item->asset_id }}</td>
                                    <td class="name">{{ $item->asset_name }}</td>
                                    <td class="location">{{ $item->location }}</td>
                                    <td class="description">{{ $item->description }}</td>
                                    <td class="link">{{ $item->link }}</td>
                                    <td class="created_at">{{ $item->created_at }}</td>

                                    @if ($item->image==null)
                                    <td class="image"><a href="{{ asset('images/image.jpg') }}"><img src="{{ asset('images/image.jpg') }}" width="100" height="100" alt="image"/></a></td>
                                    @endif
                                    @if ($item->image)
                                    <td class="image"><a href="{{ asset($item->image) }}"><img src="{{ asset($item->image) }}" width="100" height="100" alt="image"/> </a></td>
                                    @endif

                                    <td class="text-center">
                                        <a href="{{ route('asset.show', $item->id) }}"><span class="badge bg-Secondary">
                                            <i class="bi bi-Eye Fill"></i></span>
                                        </a>
                                        <a href="{{ route('asset.edit', $item->id) }}">
                                            <span class="badge bg-success"><i class="bi bi-pencil-square"></i></span>
                                        </a>
                                        <a href="{{ url('asset_delete/'.$item->id) }}" onclick="return confirm('Are you sure to want to delete it?')"><span class="badge bg-danger">
                                        <i class="bi bi-trash"></i></span></a>
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
<script>
    setTimeout(function() {
        $('div.alert').delay(1000).slideUp(500);
    });
</script>
@endsection
