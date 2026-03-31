@extends('frontend.layout')
@section('main_contain')

    <body>
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
                                    <p>{{ auth()->user()->fullname}}</p>
                                </div>
                                <div class="col-md-12 form-group  ">
                                    <input class="form-control " style="border-radius:15px" type="text"
                                        placeholder="Password" name="password" value="{{ session('password') }}">
                                    @error('password')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
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
    </body>
@endsection
