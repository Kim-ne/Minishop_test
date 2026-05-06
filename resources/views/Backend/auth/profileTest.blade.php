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
                <ul class="nav nav-tabs" >
                    <li class="nav-items">
                        <button href="#info" data-toggle="tab"
                        class="nav-link {{ request('tab') === 'info' || !request('tab') ? 'active' : '' }}">User Infomation</button>
                    </li>
                    <li class="nav-items">
                        <button href="#password" data-toggle="tab"
                        class="nav-link {{ request('tab') === 'password' ? 'active' : '' }}">Change password</button>
                    </li>
                </ul>
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="tab-content mt-5 ">
                <!-- tab infomation -->
                    <div class="tab-pane fade {{ request('tab') === 'info' || !request('tab') ? 'show active' : '' }} " id="info">
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
                                    <button class="btn btn-dark btn-block btn-login" type="submit" data-toggle="modal"
                                        data-target="#editProfileModal">Update</button>
                                </div>

                                <div class="col-md-12 text-center mt-2">
                                    <a class="btn btn-dark btn-block btn-login" href="{{ route('home') }}">Back to
                                        home</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <!--end tab infomation -->

                <!--tab password-->
                    <div class="tab-pane fade {{ request('tab') === 'password' ? 'show active' : '' }}" id="password">
                        <div class="bg-light p-30 mb-5 col-lg-6 offset-lg-3 rounded ">
                            <h4 class="text-center mb-3">Change Password</h4>
                            <form action="{{ route('userPassword.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group position-relative">
                                    <label> Current password</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                        name="current_password" required placeholder="Enter Current Password" id="current_password"
                                        value="{{ old('current_password') }}">
                                    <span class="toggle-password" data-target="#current_password">
                                        <i class="fa fa-eye"></i>
                                    </span>

                                    @error('current_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group position-relative">
                                    <label> New password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" required placeholder="Enter new Password" id="password1"
                                        value="{{ old('password') }}">
                                    <span class="toggle-password"  data-target="#password1">
                                        <i class="fa fa-eye"></i>
                                    </span>

                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group position-relative">
                                    <label> Re-enter new password</label>
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" required placeholder="Re-enter new Password"
                                        value="{{ old('password_confirmation') }}" id="password_confirmation">
                                    <span class="toggle-password" data-target="#password_confirmation">
                                        <i class="fa fa-eye"></i>
                                    </span>
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
                            </form>
                        </div>

                    </div>
                </div>
                <!-- end tab password -->
            </div>
        </div>
    </div>

    <!-- Modal edit profile -->
    <div class="modal fade" id="editProfileModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Profile</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('userInfo.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="">Username</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ auth()->guard('user')->user()->name }}" required disabled>
                        </div>
                        <div class="form-group mb-3">
                            <label >Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ auth()->guard('user')->user()->email }}" required disabled>
                        </div>
                        <div class="form-group mb-3">
                            <label >Phone</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                value="{{ auth()->guard('user')->user()->phone }}">
                        </div>
                        <div class="form-group mb-3">
                            <label >Country</label>
                            <input type="text" name="country" class="form-control @error('country') is-invalid @enderror"
                                value="{{ auth()->guard('user')->user()->country }}">
                        </div>
                        <div class="col-md-12 text-center py-4">
                            <button class="btn btn-dark btn-block btn-login" type="submit">Update</button>
                        </div>
                        <div class="col-md-12 text-center mt-2">
                            <a class="btn btn-dark btn-block btn-login" href="{{ route('userProfile') }}">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal edit profile -->
    </div>

    <!-- Profile End -->

@endsection
