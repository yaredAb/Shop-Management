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
    <h2>Monthly Sales Report - {{ $month }}</h2>

    <p><strong>Total Revenue:</strong> {{ $totalRevenue }} Birr</p>

    @if ($topProduct)
        <p><strong>Top Product:</strong> {{ $topProduct->product->name }} ({{ $topProduct->total_quantity }} sold)</p>
    @endif

    @if ($topDay)
        <p><strong>Best Day:</strong> {{ $topDay->day }} ({{ $topDay->total }} Birr)</p>
    @endif
</body>
</html>
