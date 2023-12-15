@extends('layout')

@section('content')

<div class="container">

<!-- Chart Container -->
<div style="width: 80%; margin: auto;">
    <canvas id="abTestPerformanceLineChart"></canvas>
</div>

<script>
    // PHP variable passed from the controller
    var abTestPerformanceData = @json($abTestPerformanceData);

    var labels = abTestPerformanceData.map(function(item) {
        return item.test_name + ' - ' + item.variant;
    });

    var dataPageview = abTestPerformanceData
        .filter(function(item) { return item.action_type === 'pageview'; })
        .map(function(item) { return item.count; });

    var dataClick = abTestPerformanceData
        .filter(function(item) { return item.action_type === 'click'; })
        .map(function(item) { return item.count; });

    // Chart configuration
    var ctx = document.getElementById('abTestPerformanceLineChart').getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pageview',
                data: dataPageview,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }, {
                label: 'Click',
                data: dataClick,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    
</script>

<a href="{{ url()->previous() }}" class="btn btn-primary mb-5">Back</a>

</div>

@endsection