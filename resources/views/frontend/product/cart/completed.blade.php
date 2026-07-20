@extends('frontend.layout')
@section('main_contain')

    <body>
        <!-- Breadcrumb Start -->
        <div class="container-fluid">
            <div class="row px-xl-5">
                <div class="col-12">
                    <nav class="breadcrumb bg-light mb-30">
                        <a class="breadcrumb-item text-dark" href="{{ route('home') }}">Home</a>
                        <a class="breadcrumb-item text-dark" href="{{ route('product.index') }}">Product</a>
                        <span class="breadcrumb-item active">Checkout</span>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Breadcrumb End -->


        <!-- Checkout Start -->
        <div class="container-fluid">
            <div class="row px-xl-5">
                <div class="col-lg-12 justify-content-between">
                    <h5 class="section-title position-relative text-uppercase mb-3">
                        <span class="bg-secondary pr-3">Oder Completed</span>
                    </h5>
                </div>
                <div class="col-lg-8 offset-lg-2 mt-5">
                    <div class="bg-light p-30 mb-5">
                        <div class="border-bottom">
                            <h1 class="mb-2 text-center text-uppercase" style="font-size: 30px; font-weight:bold">
                                Your Oders</h1>
                            <p style="font-weight: 500; margin-bottom: 5px">Code: {{ $order->code }}</p>
                            <p style="font-weight: 500; margin-bottom: 5px">Status: {{ $order->statusLabel }}</p>
                            <p style="font-weight: 500; margin-bottom: 5px">Order Date: {{ $order->created_at }}</p>
                            <h1 class="py-3 text-center text-uppercase" style="font-size: 21px; font-weight:bold">
                                Products Recieve
                            </h1>

                            <div class="mb-2 justify-content-between">
                                <div class="row">
                                    @php
                                        $sub_total = 0;
                                    @endphp
                                    <div class="col-lg-12 table-responsive mb-5">
                                        <table class="table table-light table-borderless table-hover text-center mb-0">
                                            <thead class="thead-dark">
                                                <tr class="text-center">
                                                    <th>Products</th>
                                                    <th>Price<br style="font-size: small">(VND)</th>
                                                    <th>Quantity</th>
                                                    <th>Total<br style="font-size: small">(VND)</th>
                                                </tr>
                                            </thead>
                                            @foreach ($ordered as $item)
                                                <div class="">
                                                    @php
                                                        (float)$price = $item->price;
                                                        (float)$sub_total += $item->price * $item->buy_qty;
                                                        (float)$shipping = $sub_total * 0.05;
                                                        (float)$total = $sub_total + $shipping;

                                                    @endphp
                                                    <tbody class="align-middle">
                                                        <td class="align-middle"> {{ $loop->iteration }}. {{  $item->name }}</td>
                                                        <td class="align-middle">  {{ $price * 1000 }}</td>
                                                        <td class="align-middle">  {{  (int)$item->buy_qty }}</td>
                                                        <td class="align-middle"> {{$sub_total * 1000}}</td>
                                                    </tbody>
                                                </div>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom pt-2 pb-2">
                            <div class="d-flex justify-content-between mb-2">
                                <h6>Subtotal</h6>
                                <h6>{{ number_format($sub_total * 1000) }} VND</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Shipping</h6>
                                <h6 class="font-weight-medium">{{ number_format($shipping * 1000) }} VND</h6>
                            </div>
                        </div>
                        <div class="pt-2">
                            <div class="d-flex justify-content-between mt-2">
                                <h5>Total</h5>
                                <h5>{{ number_format($total * 1000) }} VND</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Checkout End -->



@endsection
