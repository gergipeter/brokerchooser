@extends('layout')

@section('content')

    <div class="container">
        @if(session('successCreated'))
            <div class="alert alert-success" role="alert">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session('successCreated') }}
            </div>
        @endif
        <div id="main-box">
            <h1 class="display-4 mb-3">A/B Testing System</h1>
            <p class="lead">Welcome to the A/B testing system. Choose an action below:</p>

            <hr class="my-4">

            <div class="row mb-5">
                <div class="col-md-6">
                    <h2>Create A/B Test</h2>
                    <p class="subText">Create a new A/B test with two default variants (A, B).</p>
                    <a class="btn btn-primary" href="{{ route('create-test.get') }}" role="button"><i class="fas fa-circle-plus"></i> Create Test</a>
                </div>

                <div class="col-md-6">
                    <h2>List All Tests</h2>
                    <p class="subText">View and manage all tests, also here you can start/step them.</p>
                    <a class="btn btn-primary" href="{{ route('list-all-tests') }}" role="button"><i class="fas fa-list"></i> List All Tests</a>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <h2>Show Chart</h2>
                    <p class="subText">Display an illustrative chart showcasing the possibilities we can do with A/B test data.</p>
                    <a class="btn btn-primary" href="{{ route('get-chart-data') }}" role="button"><i class="fas fa-chart-simple"></i> Show Chart</a>
                </div>

                <div class="col-md-6">
                    <h2>List All Variants</h2>
                    <p class="subText">View and manage all variants which have been selected for the running tests.</p>
                    <a class="btn btn-primary" href="{{ route('list-all-variants') }}" role="button"><i class="fas fa-spell-check"></i> List All Variants</a>
                </div>
            </div>     
        </div>
    </div>

@endsection
