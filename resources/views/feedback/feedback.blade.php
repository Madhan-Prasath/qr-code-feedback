@extends('layouts.master')
@section('menu')
@endsection
@section('content')
<style>
    .card {
        margin: 0 auto; /* Added */
        float: none; /* Added */
        margin-bottom: 10px; /* Added */
}
</style>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <br>
                    <h6> Hello,
                    <br>
                    <br> {{ Auth::user()->name }} </h6>
                    <br>
                    <h6> Date : {{date("d-M-Y h:i:s A", strtotime($date_format))}} </h6>
                    <br>
                    <h6> Location : {{ $location->location ?? null }} </h6>
                    <br>
                    <h6> Description : {{ $description->description ?? null }} </h6>
                    <br>
                        @if ($report == 1)
                        <h6> Thank you for submitting the feedback!</h6>
                        @endif
                        @if ($report > 1)
                        <h6> Thank you for submitting the feedback! </h6>
                        <br>
                        <h6 style="color: red">*Already {{$reports}} user has submitted the feedback </h6>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
