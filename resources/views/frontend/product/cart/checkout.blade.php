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
        <form action="{{ route('cart.orderpost') }}" method="post">
            <div class="container-fluid">
                <div class="row px-xl-5">
                    <div class="col-lg-8">
                        <h5 class="section-title position-relative text-uppercase mb-3"><span
                                class="bg-secondary pr-3">Billing
                                Address</span></h5>
                        <div class="bg-light p-30 mb-5">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>First Name</label>
                                    <input class="form-control" type="text" placeholder="John" name="firstname"
                                        value="{{ old('firstname') }}">
                                    @error('firstname')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Last Name</label>
                                    <input class="form-control" type="text" placeholder="Doe" name="lastname"
                                        value="{{ old('lastname') }}">
                                    @error('lastname')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>E-mail</label>
                                    <input class="form-control" type="text" placeholder="example@email.com" name="email"
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Mobile No</label>
                                    <input class="form-control" type="text" placeholder="+123 456 789" name="phone"
                                        value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12  form-group">
                                    <label>Address Line 1</label>
                                    <input class="form-control" type="text" placeholder="123 Street" name="address"
                                        value="{{ old('address') }}">
                                    @error('address')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Country</label>
                                    <select class="custom-select" name="country">
                                        <option selected>United States</option>
                                        <option>Afghanistan</option>
                                        <option>Albania</option>
                                        <option>Algeria</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>City</label>
                                    <input class="form-control" type="text" placeholder="New York" name="city"
                                        value="{{ old('city') }}">
                                    @error('city')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>State</label>
                                    <input class="form-control" type="text" placeholder="New York" name="state"
                                        value="{{ old('state') }}">
                                    @error('state')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>ZIP Code</label>
                                    <input class="form-control" type="text" placeholder="123" name="zipcode"
                                        value="{{ old('zipcode') }}">
                                    @error('zipcode')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group">
                                        <label>Notes</label>
                                        <input class="form-control" type="text" placeholder="Notes" name="notes"
                                            value={{ old('notes') }}>
                                    </div>
                                <div class="col-md-12 form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="newaccount" name="is_create"
                                            data-toggle="collapse" data-target="#newaccount">
                                        <label class="custom-control-label" for="newaccount">Create an account</label>
                                    </div>
                                    <div class="collapse mb-3 mt-3" id="newaccount">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="newaccount">Password</label>
                                                <input type="text" class="form-control" placeholder="At least 6 character">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="newaccount">Re-password</label>
                                                <input type="text" class="form-control" placeholder="Re-enter password">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="is_shipping" value="1"
                                            name="is_shipping">
                                        <label class="custom-control-label" for="is_shipping" data-toggle="collapse"
                                            data-target="#shipping-address">Ship to different address</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="collapse mb-5" id="shipping-address">
                            <h5 class="section-title position-relative text-uppercase mb-3"><span
                                    class="bg-secondary pr-3">Shipping Address</span></h5>
                            <div class="bg-light p-30">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>First Name</label>
                                        <input class="form-control" type="text" placeholder="John" name="ship_firstname"
                                            value={{ old('ship_firstname') }}>
                                        @error('ship_firstname')
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Last Name</label>
                                        <input class="form-control" type="text" placeholder="Doe" name="ship_lastname"
                                            value={{ old('ship_lastname') }}>
                                        @error('ship_lastname')
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>E-mail</label>
                                        <input class="form-control" type="text" placeholder="example@email.com"
                                            name="ship_email" value="{{ old('ship_email') }}">
                                        @error('ship_email')
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Mobile No</label>
                                        <input class="form-control" type="text" placeholder="+123 456 789" name="ship_phone"
                                            value="{{ old('ship_phone') }}">
                                        @error('ship_phone')
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label>Address Line 1</label>
                                        <input class="form-control" type="text" placeholder="123 Street" name="ship_address"
                                            value="{{ old('ship_address') }}">
                                        @error('ship_address')
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Country</label>
                                        <select class="custom-select" name="ship_country">
                                            <option selected>United States</option>
                                            <option>Afghanistan</option>
                                            <option>Albania</option>
                                            <option>Algeria</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>City</label>
                                        <input class="form-control" type="text" placeholder="New York" name="ship_city"
                                            value={{ old('ship_city') }}>
                                        @error('ship_city')
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>State</label>
                                        <input class="form-control" type="text" placeholder="New York" name="ship_state"
                                            value={{ old('ship_state') }}>
                                        @error('ship_state')
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>ZIP Code</label>
                                        <input class="form-control" type="text" placeholder="123" name="ship_zipcode"
                                            value={{ old('ship_zipcode') }}>
                                        @error('ship_zipcode')
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <h5 class="section-title position-relative text-uppercase mb-3"><span
                                class="bg-secondary pr-3">Order
                                Total</span></h5>
                        <div class="bg-light p-30 mb-5">

                            <div class="border-bottom">
                                <h1 class="mb-3 text-center text-uppercase" style="font-size: 21px; font-weight:bold">
                                    Products
                                </h1>

                                <div class="d-flex justify-content-between">
                                    <div class="row">
                                        @foreach ($order as $item)
                                            <div class="col-lg-6">
                                                <p>{{ $i++ }}. {{ $item->name }}</p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p class="text-right">{!!number_format($item->price * 1000 * $item->buy_qty) !!}
                                                    VND
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="border-bottom pt-3 pb-2">
                                <div class="d-flex justify-content-between mb-3">
                                    <h6>Subtotal</h6>
                                    <h6>{{ number_format($sub_total * 1000)  }} VND</h6>
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
                        <div class="mb-5">
                            <h5 class="section-title position-relative text-uppercase mb-3"><span
                                    class="bg-secondary pr-3">Payment</span></h5>
                            <div class="bg-light p-30">
                                <div class="form-group">
                                    @error('payment_method')
                                        <div class="text-danger mb-3">{{$message}}</div>
                                    @enderror
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="payment_method" id="PP"
                                        value="PP">
                                        <label class="custom-control-label" for="PP">Paypal</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="payment_method" id="COD"
                                        value="COD">
                                        <label class="custom-control-label" for="COD">COD</label>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="payment_method"
                                            id="BT" value="BT">
                                        <label class="custom-control-label" for="BT">Bank Transfer</label>
                                    </div>
                                </div>
                                @csrf
                                <button class="btn btn-block btn-primary font-weight-bold py-3" type="submit">Place
                                    Order</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Checkout End -->
        </form>


@endsection
