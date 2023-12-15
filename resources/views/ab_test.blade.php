@extends('layout')

@section('content')
    <div class="container">
        <h1>A/B Test Information</h1>

        @if($abTest)
            <p><strong>Test Name:</strong> {{ $abTest->name }}</p>
            <p><strong>Status:</strong> {{ ucfirst($abTest->status) }}</p>

            <h2>Variants</h2>
            <ul>
                @foreach($abTest->variants as $variant)
                    <li>
                        <strong>{{ $variant->name }}:</strong>
                        Targeting Ratio: {{ $variant->targeting_ratio }}
                    </li>
                @endforeach
            </ul>
            @isset($selectedVariant)
                <p><strong>Selected Variant:</strong> {{ $selectedVariant->name }}</p>
            @endisset
            @isset($randomNumber, $cumulativeWeight) 
                <p>Variables used for the calculation: 
                    <strong>Random Number:</strong> {{ $randomNumber }}
                    <strong>Cumulative Weight:</strong> {{ $cumulativeWeight }}
                </p>
            @endisset
        @else
            <p>No active A/B test.</p>
        @endif
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>

    </div>

@endsection
