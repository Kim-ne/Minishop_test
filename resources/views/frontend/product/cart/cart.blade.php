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
                        <span class="breadcrumb-item active">Shopping Cart</span>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Breadcrumb End -->


        <!-- Cart Start -->
        <div class="container-fluid">
            @if($cart->isEmpty())

                <div class="col-lg-12 text-center">
                    <img src="{{ asset('upload/image/empty_cart.png') }}" alt="">
                </div>
                <div
                    class="btn col-lg-4 offset-lg-4 btn-primary font-weight-bold my-3 py-3 d-flex align-items-center justify-content-center">
                    <a class="text-uppercase text-dark" href="{{ route('product.index') }}">Continue shopping</a>
                </div>

            @else

                <div class="row px-xl-5">

                    <div class="col-lg-8 table-responsive mb-5">
                        @if (session('error'))
                            <div class="arlet danger-arlet">
                                <strong>{{ session('error') }}</strong>
                            </div>
                        @endif
                        <table class="table table-light table-borderless table-hover text-center mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @include('frontend.product.cart.partial.item', ['cart' => $cart])
                            </tbody>
                        </table>
                        <div
                            class="btn col-lg-4 offset-lg-4 btn-primary font-weight-bold my-3 py-3 d-flex align-items-center justify-content-center">
                            <a class="text-uppercase text-dark" href="{{ route('product.index') }}">Continue shopping</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <form class="mb-30" action="">
                            <div class="input-group">
                                <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code">
                                <div class="input-group-append">
                                    <button class="btn btn-primary">Apply Coupon</button>
                                </div>
                            </div>
                        </form>
                        <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart
                                Summary</span></h5>
                        <div class="bg-light p-30 mb-5">
                            <div class="border-bottom pb-2">
                                <div class="d-flex justify-content-between mb-3">
                                    <h6>Subtotal</h6>
                                    <h6>{{ number_format($sub_total * 1000)}} VND</h6>
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
                                <a class="btn btn-block btn-primary font-weight-bold my-3 py-3"
                                    href="{{ route('cart.checkout') }}">Proceed To
                                    Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <!-- Cart End -->

    </body>
@endsection
