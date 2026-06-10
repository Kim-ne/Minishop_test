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
                                    <form class="theme-form" action="{{ route('user.reset-password.post') }}" method="POST">
                                        @csrf

                                        {{-- Hidden fields — token và email lấy từ link trong email --}}
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <input type="hidden" name="email" value="{{ $email }}">

                                        <h4>Reset Password</h4>
                                        <p>Enter your new password below</p>

                                        @if (session('error'))
                                            <div class="text-danger py-2">{{ session('error') }}</div>
                                        @endif

                                        <div class="form-group">
                                            <label class="col-form-label">New Password</label>
                                            <div class="form-input position-relative">
                                                <input class="form-control @error('password') is-invalid @enderror"
                                                    type="password" name="password" id="password" placeholder="*********"
                                                    required>
                                                <div class="show-hide" data-target="#password">
                                                    <span class="show"></span>
                                                </div>
                                            </div>
                                            @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="col-form-label">Confirm New Password</label>
                                            <div class="form-input position-relative">
                                                <input class="form-control" type="password" name="password_confirmation"
                                                    id="password_confirmation" placeholder="*********" required>
                                                <div class="show-hide" data-target="#password_confirmation">
                                                    <span class="show"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-0">
                                            <div class="text-end mt-3">
                                                <button class="btn btn-primary btn-block w-100" type="submit">
                                                    Reset Password
                                                </button>
                                            </div>
                                        </div>

                                        <p class="mt-4 mb-0 text-center">
                                            Remember your password?
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
