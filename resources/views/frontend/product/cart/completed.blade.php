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
                            <h1 class="mb-3 text-center text-uppercase" style="font-size: 21px; font-weight:bold">
                                Your Oders
                            </h1>

                            <div class="py-3 justify-content-between">
                                <div class="row">
                                    @php
                                        $sub_total = 0;
                                    @endphp
                                    @foreach ($ordered as $item)
                                        <div class="col-lg-6">
                                            @php
                                                $sub_total += $item->price * $item->buy_qty;
                                                $shipping = $sub_total * 0.05;
                                                $total = $sub_total + $shipping;
                                            @endphp

                                            <p>{{ $loop->iteration }}. {{  $item->name }}</p>
                                        </div>
                                        <div class="col-lg-6 ">
                                            <p class="text-right">
                                                {{ number_format($item->price * $item->buy_qty * 1000) }} VND
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom pt-3 pb-2">
                            <div class="d-flex justify-content-between mb-3">
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
