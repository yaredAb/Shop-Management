@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Monthly Sales Report</h1>

    <form method="GET" action="{{ route('sales.report') }}" class="mb-4">
        <label for="month">Select Month:</label>
        <input type="month" name="month" id="month" value="{{ $month }}">
        <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
    </form>

    <div class="space-y-4">
        <p><strong>Total Revenue:</strong> {{ $totalRevenue }} Birr</p>

        @if ($topProduct)
            <p><strong>Top Product:</strong> {{ $topProduct->product->name }} ({{ $topProduct->total_quantity }} sold)</p>
        @endif

        @if ($topDay)
            <p><strong>Best Day:</strong> {{ $topDay->day }} ({{ $topDay->total }} Birr)</p>
        @endif
    </div>

    <div class="chart">
        <div class="reportChart">
            <h3>Today's Sale</h3>
            <canvas id="dailySalesChart"></canvas>
        </div>
        <div class="reportChart">
            <h3>Top 5 Products This Month</h3>
            <canvas id="topProductsChart"></canvas>
        </div>
        <div class="reportChart">
            <h3>Hourly Sales Trend</h3>
            <canvas id="hourlySalesChart"></canvas>
        </div>
    </div>

    <a href="{{route('sales.report.pdf', ['month' => $month])}}" class="exportBtn">Export as PDF</a>
@endsection


@section('scripts')
{{-- Include Chart.js first --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('dailySalesChart').getContext('2d');
    const dailySalesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Daily Sales (Birr)',
                data: {!! json_encode($chartData) !!},
                backgroundColor: '#60a5fa',
                borderColor: '#3b82f6',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + ' ብር';
                        }
                    }
                }
            }
        }
    });

    // Pie chart for top products
    const pieCtx = document.getElementById('topProductsChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($pieLabels) !!},
            datasets: [{
                data: {!! json_encode($pieData) !!},
                backgroundColor: [
                    '#f87171', '#facc15', '#34d399', '#60a5fa', '#c084fc'
                ]
            }]
        },
        options: {
            responsive: true
        }
    });



    const hourlyCtx = document.getElementById('hourlySalesChart').getContext('2d');
    new Chart(hourlyCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($hourLabels) !!},
            datasets: [{
                label: 'Sales by Hour (Birr)',
                data: {!! json_encode($hourData) !!},
                borderColor: '#4ade80', // Tailwind green-400
                backgroundColor: '#bbf7d0', // Tailwind green-200
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + ' ብር';
                        }
                    }
                }
            }
        }
    });

</script>
@endsection
