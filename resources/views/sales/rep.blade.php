<!DOCTYPE html>
<html>
<head>
    <title>Daily Sales Report</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 40px;
            font-size: 14px;
            color: #333;
        }

        h2, h3 {
            margin-top: 30px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .summary {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .section {
            margin-top: 40px;
        }

        ul {
            margin-left: 20px;
        }

        .no-data {
            color: green;
        }

    </style>
</head>
<body>
<h2>📄 Daily Sales Report - {{ $date }}</h2>

<div class="summary">
    <p><strong>Total Revenue:</strong> {{ number_format($totalRevenue, 2) }} Birr</p>
</div>

<h3>🛒 Sales Details</h3>
<table>
    <thead>
    <tr>
        <th>Sale ID</th>
        <th>Product</th>
        <th>Qty</th>
        <th>Unit Price</th>
        <th>Total</th>
        <th>Sold At</th>
    </tr>
    </thead>
    <tbody>
    @foreach($sales as $sale)
        @foreach($sale->items as $item)
            <tr>
                <td>{{ $sale->id }}</td>
                <td>{{ $item->product->name ?? 'N/A' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }} Birr</td>
                <td>{{ number_format($item->price * $item->quantity, 2) }} Birr</td>
                <td>{{ \Carbon\Carbon::parse($sale->sold_at)->format('F d, Y h:i A') }}</td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>

<div class="section">
    <h3>📉 Low Stock Products</h3>
    @if ($lowStockProducts->count())
        <ul>
            @foreach ($lowStockProducts as $product)
                <li>{{ $product->name }} - Remaining: {{ $product->quantity }}</li>
            @endforeach
        </ul>
    @else
        <p class="no-data">🎉 No low stock products</p>
    @endif
</div>

<div class="section">
    <h3>⏳ Products Expiring Soon</h3>
    @if ($expiringSoon->count())
        <ul>
            @foreach($expiringSoon as $product)
                <li>{{ $product->name }} - Expires on {{ \Carbon\Carbon::parse($product->expiry_date)->format('F d, Y') }}</li>
            @endforeach
        </ul>
    @else
        <p class="no-data">🎉 No products expiring soon</p>
    @endif
</div>
</body>
</html>
