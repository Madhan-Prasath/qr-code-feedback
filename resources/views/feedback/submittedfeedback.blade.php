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

    body{
    background-image:url(images/banner.jpg);
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    /* font-family: sans-serif; */
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
                    <h6> Location : {{ $location->location ?? null }} </h6>
                    <br>
                    <h6> Description : {{ $description->description }} </h6>
                    <br>
                        @if ($report <= 1)
                        <h6 style="color: red"> *  Already you have submitted the feedback! </h6>
                        @else
                        <h6 style="color: red"> *  Already {{ $report }} users submitted this feedback!</h6>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
