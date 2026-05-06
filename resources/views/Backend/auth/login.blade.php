@extends('Backend.layout-light')
@section('admin_contain')

    <form action="{{ route('userLogin.post') }}" method="post">
        @csrf
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 p-0">
                    <div class="login-card">
                        <div class="login-main">
                            <form class="theme-form">
                                <h4>Sign in to account</h4>
                                <p>Enter your email & password to login</p>
                                @if (session()->has('error'))
                                    <div class="text-danger py-2">
                                        {{ session('error') }}
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="col-form-label">Email Address</label>
                                    <input class="form-control @error('username') is-invalid @enderror" type="email"
                                        required="" placeholder="Test@gmail.com" value="{{ old('username') }}" name="username">

                                    @error('username')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control @error('password') is-invalid @enderror"
                                        type="password" name="password" required id="password"
                                        placeholder="*********">
                                        <div class="show-hide" data-target="#password"><span class="show"> </span></div>
                                    </div>
                                    @error('password')
                                    <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-0">
                                    <div class="checkbox p-0">
                                        <input id="checkbox1" type="checkbox">
                                        <label class="text-muted" for="checkbox1">Remember password</label>
                                    </div><a class="link" href="forget-password-2.html">Forgot password?</a>
                                    <div class="text-end mt-3">
                                        <button class="btn btn-primary btn-block w-100" type="submit">Sign in</button>
                                    </div>
                                </div>
                                <h6 class="text-muted mt-4 or">Or Sign in with</h6>
                                <div class="social mt-4">
                                    <div class="btn-showcase"><a class="btn btn-light" href="https://www.linkedin.com/login"
                                            target="_blank"><i class="txt-linkedin" data-feather="linkedin"></i> LinkedIn
                                        </a><a class="btn btn-light" href="https://twitter.com/login?lang=en"
                                            target="_blank"><i class="txt-twitter" data-feather="twitter"></i>twitter</a><a
                                            class="btn btn-light" href="https://www.facebook.com/" target="_blank"><i
                                                class="txt-fb" data-feather="facebook"></i>facebook</a></div>
                                </div>
                                <p class="mt-4 mb-0 text-center">Don't have account?<a class="ms-2"
                                        href="sign-up-2.html">Create
                                        Account</a></p>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
