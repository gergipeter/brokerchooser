@extends('layout')

@section('content')

    <div class="container">
        <h1>Create A/B Test</h1>

        <form method="post" action="{{ route('create-test.post') }}">
        @csrf
            <div class="mb-3">
                <label for="test_name" class="form-label">Test Name:</label>
                <input type="text" class="form-control @error('test_name') is-invalid @enderror" id="test_name" name="test_name" value="{{ old('test_name') }}" required>                @error('test_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Create Test</button>
        </form>
        <br>
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>

    </div>
    
@endsection
