@extends('layout')

@section('content')
    <div class="container">
        <h1>Running tests with their variants:</h1>
        <a href="{{ url()->previous() }}" class="btn btn-primary mt-3 mb-5">Back</a>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Variant Name</th>
                    <th scope="col">Targeting Ratio</th>
                    <th scope="col">Test Name</th>
                    <th scope="col">Test Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($variants as $variant)
                    <tr>
                        <td>{{ $variant->name }}</td>
                        <td>{{ $variant->targeting_ratio }}</td>
                        <td>{{ $variant->abTest->name }}</td>
                        <td>{{ $variant->abTest->status }}</td>
                @empty
                    <tr>
                        <td colspan="3">No variants found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="row mb-3">
            @foreach($variants as $variant)
                <a href="#">
                    <div class="trackMouse square-box">
                        <h1 class="variant_name text-center">{{ $variant->name }}</h1>
                        <div class="test_name text-center">{{ $variant->abTest->name }}</div>
                    </div>
                </a> <br>
            @endforeach
        </div>

    </div>

@endsection
