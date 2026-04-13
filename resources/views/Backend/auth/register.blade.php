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

<!-- Register Start -->
<form action="{{ route('userRegister.post') }}" method="post">
    @csrf

    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-12">
                @if(session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif

                <h5 class="section-title position-relative text-uppercase mb-5 text-center">
                    <span class="bg-secondary pr-3">Sign up</span>
                </h5>

                <div class="bg-light p-30 mb-5 col-lg-6 offset-lg-3">

                    <div class="row">

                        {{-- USERNAME --}}
                        <div class="col-md-12 form-group">
                            <label>Username <span class="text-danger">*</span></label>

                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="Username"
                                   required>

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if(old('name') && !$errors->has('name'))
                                <div class="valid-feedback">Username accepted</div>
                            @endif
                        </div>

                        {{-- PASSWORD --}}
                        <div class="col-md-6 form-group">
                            <label>Password <span class="text-danger">*</span></label>

                            <input type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   data-bs-toggle="tooltip" data-placement="top"
                                   title="Password at least 8 characters, 1 number and 1 uppercase letter"
                                   placeholder="Password" id="password"
                                   required>
                            <span class="toggle-password register" data-target="#password">
                                <i class="fa fa-eye"></i>
                            </span>

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- CONFIRM PASSWORD --}}
                        <div class="col-md-6 form-group">
                            <label>Re-Password <span class="text-danger">*</span></label>

                            <input type="password"
                                   name="password_confirmation" id="password_confirmation"
                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                   placeholder="Re-Password"
                                   required>
                            <span class="toggle-password register" data-target="#password_confirmation">
                                <i class="fa fa-eye"></i>
                            </span>

                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- EMAIL --}}
                        <div class="col-md-6 form-group">
                            <label>Email <span class="text-danger">*</span></label>

                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   placeholder="Email"
                                   required>

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- CONFIRM EMAIL --}}
                        <div class="col-md-6 form-group">
                            <label>Re-email <span class="text-danger">*</span></label>

                            <input type="email"
                                   name="email_confirmation"
                                   class="form-control"
                                   placeholder="Re-Email"
                                   required>
                        </div>

                        {{-- PHONE --}}
                        <div class="col-md-6 form-group">
                            <label>Phone</label>

                            <input type="text"
                                   name="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone') }}"
                                   placeholder="Phone">

                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- COUNTRY --}}
                        <div class="col-md-6 form-group">
                            <label>Country</label>

                            <input type="text"
                                   name="country"
                                   class="form-control @error('country') is-invalid @enderror"
                                   value="{{ old('country') }}"
                                   placeholder="Country">

                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 form-group text-center py-3">
                            <button class="btn btn-dark btn-block">Sign Up</button>
                        </div>

                        <div class="col-md-12 form-group text-center">
                            <a class="btn btn-dark btn-block" href="{{ route('home') }}">Back to home</a>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

</form>
<!-- Register End -->

@endsection
