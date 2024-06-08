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
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Reports View</h4>
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
                          <form method="post" action="{{ route('reports.update', $report->id) }}" enctype="multipart/form-data">
                              <div class="form-group">
                                  @csrf
                                  @method('PUT')
                                  <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Feedback</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control"
                                                        placeholder="Feedback" id="feedback" name="feedback" value="{{ $report->feedback }}">
                                                    <div class="form-control-icon">
                                                        {{-- <i class="bi bi-person"></i> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Feedback Type</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <div class="position-relative">
                                                    <select name="type" class="form-control" id="type">
                                                        <option value="Positive" @if($report->type == 'Positive') selected @endif>Positive</option>
                                                        <option value="Negative" @if($report->type == 'Negative') selected @endif>Negative</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Status</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <div class="position-relative">
                                                    <select name="status" class="form-control" id="status">
                                                        <option value="Open" @if($report->status == 'Open') selected @endif>Open</option>
                                                        <option value="Closed" @if($report->status == 'Closed') selected @endif>Closed</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div  id="closed-date-field">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Closed Date</label>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <div class="position-relative">
                                                        <input type="date" name="closed_date" placeholder="Closed Date" id="closed_date" alt="{{$report->closed_date}}" class="form-control" value="{{ $report->closed_date }}">
                                                        <div class="form-control-icon">
                                                            {{-- <i class="bi bi-person"></i> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Action Taken</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group mb-3">
                                                <div class="position-relative">
                                                    <textarea rows="2"
                                                        placeholder="Action Taken" id="remarks" name="remarks" class="form-control @error('remarks') is-invalid @enderror" value="{{ $report->remarks }}">
                                                    </textarea>
                                                    <div class="form-control-icon">
                                                        {{-- <i class="bi bi-person"></i> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Report Image</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <div class="position-relative">
                                                     <input type="file" name="image" placeholder="Choose image" id="image" alt="{{$report->image}}" class="form-control" value="{{ $report->image }}">
                                                    <div class="form-control-icon">
                                                        {{-- <i class="bi bi-person"></i> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Report View</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <div class="position-relative">
                                                    <img src="{{ asset($report->image) }}" style="max-height: 400px;"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Update Report</button>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var statusField = document.getElementById('status');
        var closedDateField = document.getElementById('closed-date-field');

        // Show or hide the "Closed Date" field based on the selection of the "Status" field
        statusField.addEventListener('change', function () {
            if (this.value === 'Closed') {
                closedDateField.style.display = 'block';
            } else {
                closedDateField.style.display = 'none';
            }
        });

        // Initialize the "Closed Date" field based on the initial value of the "Status" field
        if (statusField.value === 'Closed') {
            closedDateField.style.display = 'block';
        } else {
            closedDateField.style.display = 'none';
        }
    });
</script>
@endsection
