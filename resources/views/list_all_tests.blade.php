@extends('layout')

@section('content')
    <div class="container">
        <h1>List All Tests with Variants</h1>
        <a href="{{ url()->previous() }}" class="btn btn-primary mt-3 mb-5">Back</a>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Test Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Variants (Targeting Ratio)</th>
                    <th scope="col">Actions</th>
                    <th scope="col">Test Started</th>
                    <th scope="col">Test Duration</th>
                    <th scope="col">Test Result</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tests as $test)
                    <tr>
                        <td>{{ $test->name }}</td>
                        <td>{{ $test->status }}</td>
                        <td>
                            @forelse ($test->variants as $variant)
                                {{ $variant->name }} ({{ $variant->targeting_ratio }})
                                @unless($loop->last)
                                    ,
                                @endunless
                            @empty
                                No variants found
                            @endforelse
                        </td>
                        <td>
                            @if ($test->status == 'new')
                                <form action="{{ route('start-test', $test->id) }}" method="post" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Start Test</button>
                                </form>
                            @elseif ($test->status == 'started')
                                <form action="{{ route('stop-test', $test->id) }}" method="post" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Stop Test</button>
                                </form>
                            @else
                                <button type="submit" class="btn btn-dark disabled">Test Finished</button>
                            @endif
                        </td>
                        <td>
                            {{ $test->testStarted() }}
                        </td>
                        <td>
                            {{ $test->testDuration() }}
                        </td>
                        <td>
                            {{ $test->testResult($test->name) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No tests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
