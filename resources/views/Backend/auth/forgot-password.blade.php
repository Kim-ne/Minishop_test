@extends('Backend.layout')

@section('admin_contain')

    <div class="page-wrapper compact-wrapper" id="pageWrapper">

        @include('Backend.widget.pageheader')

        <div class="page-body-wrapper">

            @include('Backend.widget.sidebar')

            <div class="page-body">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 p-0">
                            <div class="login-card">
                                <div class="login-main">
                                    <form class="theme-form" action="{{ route('user.forgot-password.post') }}"
                                        method="POST">
                                        @csrf
                                        <h4>Forgot Password</h4>
                                        <p>Enter your email to receive a password reset link</p>

                                        @if (session('success'))
                                            <div class="alert alert-success py-2">{{ session('success') }}</div>
                                        @endif

                                        @if (session('error'))
                                            <div class="text-danger py-2">{{ session('error') }}</div>
                                        @endif

                                        <div class="form-group">
                                            <label class="col-form-label">Email Address</label>
                                            <input class="form-control @error('email') is-invalid @enderror" type="email"
                                                name="email" value="{{ old('email') }}" placeholder="Test@gmail.com"
                                                required>
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-0">
                                            <div class="text-end mt-3">
                                                <button class="btn btn-primary btn-block w-100" type="submit">
                                                    Send Reset Link
                                                </button>
                                            </div>
                                        </div>

                                         <div class="form-group mb-0">
                                            <div class="text-end mt-3">
                                                <a href="{{ route('user.login') }}" class="btn btn-primary btn-block w-100">
                                                    Back to Login
                                                </a>
                                            </div>
                                        </div>

                                        <p class="mt-4 mb-0 text-center">
                                            Already have an password?
                                            <a class="ms-2" href="{{ route('user.login') }}">Sign in</a>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
