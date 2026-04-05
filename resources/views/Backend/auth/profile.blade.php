@extends('frontend.layout')
@section('main_contain')

    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <button class="breadcrumb-item text-dark" href="/">Home</button>
                    <span class="breadcrumb-item active">Profile</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Profile Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-12">
                <h3 class="section-title position-relative text-uppercase mb-5 text-center">
                    <span class="bg-secondary pr-3">Profile</span>
                </h3>
                <ul class="nav nav-tabs">
                    <li class="nav-items">
                        <button href="#info" data-toggle="tab" class="nav-link">User Infomation</button>
                    </li>
                    <li class="nav-items">
                        <button href="#password" data-toggle="tab" class="nav-link active ">Change password</button>
                    </li>
                </ul>

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="tab-content mt-5 ">
                    <!-- tab infomation -->
                    <div class="tab-pane fade " id="info">
                        <div class="bg-light p-30 mb-5 col-lg-6 offset-lg-3 rounded ">
                        <h4 class="text-center mb-3">Infomation</h4>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <strong>Username: {{ auth()->guard('user')->user()->name }}</strong>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <strong>Email: </strong>
                                    <span>{{ auth()->guard('user')->user()->email ?? 'empty' }}</span>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <strong>Phone: </strong>
                                    <span>{{ auth()->guard('user')->user()->phone ?? 'empty'}} </span>
                                </div>

                                <div class="col-md-12 mb-3 ">
                                    <strong>Country: </strong>
                                    <span>{{ auth()->guard('user')->user()->country ?? 'empty' }}</span>
                                </div>

                                <div class="col-md-12 text-center py-4">
                                    <button class="btn btn-dark btn-block btn-login" type="submit">Update</button>
                                </div>

                                <div class="col-md-12 text-center mt-2">
                                    <a class="btn btn-dark btn-block btn-login" href="{{ route('home') }}">Back to
                                        home</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--tab password-->
                    <div class="tab-pane fade show active" id="password">
                        <div class="bg-light p-30 mb-5 col-lg-6 offset-lg-3 rounded ">
                        <h4 class="text-center mb-3">Change password</h4>
                        <form action="{{ route('userPassword.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for=""> Current password</label>
                                <input type="text" class="form-control @error('current_password') is-invalid @enderror"
                                name="current_password" required
                                placeholder="Current Password" value="{{ old('current_password') }} ">
                               @error('current_password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for=""> New password</label>
                                <input type="text" class="form-control @error('new_password') is-invalid @enderror"
                                name="new_password" required
                                placeholder="Enter new Password" value="{{ old('new_password') }}">

                                @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                              <label for=""> Re-enter new password</label>
                              <input type="text" class="form-control @error('password_confirmation') is-invalid @enderror"
                                name="password_confirmation" required
                                placeholder="Re-enter new Password" value="{{ old('password_confirmation') }}">
                                @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 text-center py-4">
                                    <button class="btn btn-dark btn-block btn-login" type="submit">Update</button>
                                </div>

                                <div class="col-md-12 text-center mt-2">
                                    <a class="btn btn-dark btn-block btn-login" href="{{ route('home') }}">Back to
                                        home</a>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editProfileModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('userProfile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="text" name="email">
                        <input type="text" name="phone">
                        <input type="text" name="country">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile End -->

@endsection
