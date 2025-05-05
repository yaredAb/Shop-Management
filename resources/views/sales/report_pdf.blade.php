<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Monthly Sales Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Monthly Sales Report - {{ \Carbon\Carbon::parse($month)->format('F d, Y') }}</h2>

    <p><strong>Total Sale:</strong> {{ number_format($totalRevenue) }} Birr</p>

    @if ($topProduct)
        <p><strong>Top Product:</strong> {{ $topProduct->product->name }} ({{ $topProduct->total_quantity }} sold)</p>
    @endif

    @if ($topDay)
        <p><strong>Best Sale Day:</strong> {{ 
    \Carbon\Carbon::parse($topDay->day)->format('F d, Y')}} ({{ number_format($topDay->total)}} Birr)</p>
    @endif
</body>
</html>
