@extends('frontend.layout')
@section('main_contain')

        <!-- Breadcrumb Start -->
        <div class="container-fluid">
            <div class="row px-xl-5">
                <div class="col-12">
                    <nav class="breadcrumb bg-light mb-30">
                        <a class="breadcrumb-item text-dark" href="/">Home</a>
                        <span class="breadcrumb-item active">Profile</span>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Breadcrumb End -->

        <!-- Profile Start -->
        {{-- <form action="{{ route('login.post') }}" method="post">
            @csrf --}}
            <div class="container-fluid">
                <div class="row px-xl-5">
                    <div class="col-lg-12">
                        <h5 class="section-title position-relative text-uppercase mb-5 text-center">
                            <span class="bg-secondary pr-3">Profile</span>
                        </h5>
                        <div class="bg-light p-30 mb-5 col-lg-6 offset-lg-3">
                            <div class="row">
                                <div class="col-md-12 form-group ">
                                    <label >Username: {{ auth()->guard('user')->user()->name }}</label>
                                </div>

                                <div class="col-md-6 form-group  ">
                                    <label>Pasword: </label>
                                    <input type="password" classs="form-control" value="**********" disabled>
                                </div>
                                <div class="col-md-6 form-group ">
                                    <a href="#" class="btn btn-square "><i class="fa-regular fa-pen-to-square"></i></a>
                                </div>

                                <div class="col-md-6 form-group  ">
                                    <label>Email: </label>
                                    <input type="email" classs="form-control" value="{{ auth()->guard('user')->user()->email }}" disabled>
                                </div>
                                <div class="col-md-6 form-group  ">
                                    <a href="#" class="btn btn-square "><i class="fa-regular fa-pen-to-square"></i></a>
                                </div>

                                <div class="col-md-6 form-group  ">
                                    <label>Phone: </label>
                                    <input type="text" classs="form-control" value="{{ auth()->guard('user')->user()->phone }}" disabled>
                                </div>
                                <div class="col-md-6 form-group  ">
                                    <a href="#" class="btn btn-square "><i class="fa-regular fa-pen-to-square"></i></a>
                                </div>

                                <div class="col-md-6 form-group  ">
                                    <label>Country: </label>
                                    <input type="text" classs="form-control" value="{{ auth()->guard('user')->user()->country }}" disabled>
                                </div>
                                <div class="col-md-6 form-group  ">
                                    <a href="#" class="btn btn-square "><i class="fa-regular fa-pen-to-square"></i></a>
                                </div>

                                <div class="col-md-12 form-group text-center py-5">
                                    <button class="btn btn-dark btn-block btn-login" type="submit">Update</button>
                                </div>
                                <div class="col-md-12 form-group text-center">
                                    <a class="btn btn-dark btn-block btn-login" href="{{ route('home') }}">Back to home</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- </form> --}}
        <!-- Profile End -->
   
@endsection
