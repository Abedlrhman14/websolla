@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">All Orders</h2>

    @if(count($orders) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Products</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    @php
                        $cartItems = json_decode($order->cart, true);
                        $cartItems = is_array($cartItems) ? $cartItems : [];
                        $total = 0;
                    @endphp
                    <tr>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->address }}</td>
                        <td>
                            <ul>
                                @foreach($cartItems as $productId => $item)
                                    <li>
                                        {{ $item['name'] }} (x{{ $item['quantity'] }}) - {{ $item['price'] }} EGP
                                    </li>
                                    @php $total += $item['price'] * $item['quantity']; @endphp
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $total }} EGP</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No orders found.</p>
    @endif
</div>
@endsection
