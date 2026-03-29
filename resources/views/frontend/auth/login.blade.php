@extends('frontend.layout')
@section('main_contain')

    <body>
        <!-- Breadcrumb Start -->
        <div class="container-fluid">
            <div class="row px-xl-5">
                <div class="col-12">
                    <nav class="breadcrumb bg-light mb-30">
                        <a class="breadcrumb-item text-dark" href="/">Home</a>
                        <span class="breadcrumb-item active">Login</span>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Breadcrumb End -->

        <!-- Login Start -->
        <form action="{{ route('login.post') }}" method="post">
            @csrf
            <div class="container-fluid">
                <div class="row px-xl-5">
                    <div class="col-lg-12">
                        @if (session()->has('error'))
                            <div class="text-danger py-2"  >
                                {{ session('error') }}
                            </div>
                        @endif

                        <h5 class="section-title position-relative text-uppercase mb-5 text-center">
                            <span class="bg-secondary pr-3">Login</span>
                        </h5>
                        <div class="bg-light p-30 mb-5 col-lg-6 offset-lg-3">
                            <div class="row">
                                <div class="col-md-12 form-group py-3">
                                    <input class="form-control" style="border-radius:15px" type="text"
                                        placeholder="ID/Username" name="username" value="{{ old('username') }}">
                                    @error('username')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12 form-group  ">
                                    <input class="form-control " style="border-radius:15px" type="text"
                                        placeholder="Password" name="password" value="">
                                    @error('password')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                               <div class="form-check ml-3">
                                 <label class="form-check-label">
                                   <input type="checkbox" class="form-check-input" name="remember" id="remember" value="1" >
                                   Remember me
                                 </label>
                               </div>
                                <div class="col-md-12 form-group text-center py-5">
                                    <button class="btn btn-dark btn-block btn-login" type="submit">Login</button>
                                </div>
                                <div class="col-md-12 form-group text-center ">
                                    <a class="btn btn-light btn-block btn-login" href="#">Forgot Password?</a>
                                </div>
                                <div class="col-md-12 form-group text-center">
                                    <a class="btn btn-dark btn-block btn-login" href="#">Register</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- Login End -->
    </body>
@endsection
