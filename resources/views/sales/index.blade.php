@extends('layouts.app')

@section('content')
    <div class="cat-header"><h1>Order History</h1></div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-wrapper">
        <table class="order-table">
            <thead>
            <tr>
                <th class="p-2">Product</th>
                <th class="p-2">Quantity</th>
                <th class="p-2">Price</th>
                <th class="p-2">Total</th>
                <th class="p-2">Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->product->name ?? 'N/A' }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ number_format($order->price) }} Birr</td>
                    <td>{{ number_format($order->price * $order->quantity) }} Birr</td>
                    <td>{{ \Carbon\Carbon::parse($order->sold_at)->format('F d, Y h:i A') }}</td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
