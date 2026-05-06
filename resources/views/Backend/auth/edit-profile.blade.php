@extends('Backend.layout')
@section('admin_contain')

    <div class="page-wrapper compact-wrapper " id="pageWrapper">
        <!-- Page Header Start-->
        @include('Backend.widget.pageheader')
        <!-- Page Header Ends-->

        <!-- page-wrapper Start-->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            @include('Backend.widget.sidebar')
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="my-3">
                                @if(session()->has('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if(session()->has('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <h3>Edit-profile</h3>

                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}"><svg
                                                class="stroke-icon">
                                                <use href="Backend/assets/svg/icon-sprite.svg#stroke-home"></use>
                                            </svg></a></li>
                                    <li class="breadcrumb-item">Home</li>
                                    <li class="breadcrumb-item active">Edit-profile</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="edit-profile">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">My Profile</h4>
                                        <div class="card-options"><a class="card-options-collapse" href="#"
                                                data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                                class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                                    class="fe fe-x"></i></a></div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="profile-title">
                                                <div class="media"><a type="button" data-bs-toggle="modal"
                                                        data-bs-target="#changeAvatar"><img class="img-70 rounded-circle"
                                                            alt="avatar" src="{{ asset('storage/avatars/' . Auth()->guard('user')->user()->avatar) }}"></a>
                                                    <div class="media-body">
                                                        <h5 class="mb-1">{{ Auth()->guard('user')->user()->name }}</h5>
                                                        <p>Role</p>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="changeAvatar" tabindex="-1"
                                                    aria-labelledby="changeAvatarLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">

                                                            <form action="{{ route('userAvatar.update') }}" method="POST"
                                                                enctype="multipart/form-data">
                                                                @method('PUT')
                                                                @csrf

                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="changeAvatarLabel">Change
                                                                        Avatar</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="avatar" class="form-label">Select new
                                                                            avatar</label>
                                                                        <input class="form-control" type="file" id="avatar"
                                                                            name="avatar" accept="image/*">
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save
                                                                        changes</button>
                                                                </div>

                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="form-label">Bio</h6>
                                            <textarea class="form-control"
                                                rows="5">{{ Auth()->guard('user')->user()->about_me }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email-Address</label>
                                            <input class="form-control"
                                                placeholder="{{ Auth()->guard('user')->user()->email }}" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input class="form-control" type="password" value="password" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Phone</label>
                                            <input class="form-control" name="phone"
                                                value="{{ Auth()->guard('user')->user()->phone }}">
                                        </div>

                                        <div class="form-footer">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#changePassword">Change Password</button>
                                        </div>

                                        <div class="modal fade" id="changePassword" tabindex="-1"
                                            aria-labelledby="changePasswordLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="changePasswordLabel">Change
                                                            Password
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <form action="{{ route('userPassword.update') }}" method="POST">
                                                            @method('PUT')
                                                            @csrf
                                                            <div class="mb-3 form-input position-relative">
                                                                <label class="col-form-label">Current
                                                                    Password</label>
                                                                <input type="password"
                                                                    class="form-control @error('current_password') is-invalid @enderror"
                                                                    placeholder="Enter Current Password"
                                                                    id="current_password" name="current_password"
                                                                    value="{{ old('current_password') }}" required>
                                                                <div class="show-hide" data-target="#current_password"><span
                                                                        class="show"> </span></div>

                                                                @error('current_password')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3 form-input position-relative">
                                                                <label class="col-form-label">New Password</label>
                                                                <input type="password"
                                                                    class="form-control @error('password') is-invalid @enderror"
                                                                    placeholder="Enter New Password" id="password"
                                                                    name="password" value="{{ old('password') }}" required>
                                                                <div class="show-hide" data-target="#password"><span
                                                                        class="show"> </span></div>

                                                                @error('current_password')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3 form-input position-relative">
                                                                <label class="col-form-label">Re-enter new
                                                                    Password</label>
                                                                <input type="password"
                                                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                                                    placeholder="Enter New Password"
                                                                    id="password_confirmation" name="password_confirmation"
                                                                    value="{{ old('password_confirmation') }}" required>
                                                                <div class="show-hide" data-target="#password_confirmation">
                                                                    <span class="show"> </span>
                                                                </div>

                                                                @error('current_password')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>

                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8">
                                <form class="card" action="{{ route('userInfo.update') }}" method="POST">
                                    @method('put')
                                    @csrf
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Edit Profile</h4>
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                @foreach ($errors->all() as $error)
                                                    {{ $error }}<br>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="card-options"><a class="card-options-collapse" href="#"
                                                data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                                class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                                    class="fe fe-x"></i></a></div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="mb-3">
                                                    <label class="form-label">Company</label>
                                                    <input class="form-control" type="text" name="company"
                                                        value="{{ auth()->guard('user')->user()->company }}">
                                                </div>
                                                @error('company')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6 col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Username</label>
                                                    <input class="form-control" type="text"
                                                        value="{{ auth()->guard('user')->user()->name }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Email address</label>
                                                    <input class="form-control" type="email"
                                                        value="{{ auth()->guard('user')->user()->email }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">First Name</label>
                                                    <input class="form-control" type="text"
                                                        value="{{ auth()->guard('user')->user()->first_name }}"
                                                        name="first_name">
                                                </div>
                                                @error('first_name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Last Name</label>
                                                    <input class="form-control" type="text"
                                                        value="{{ auth()->guard('user')->user()->last_name }}"
                                                        name="last_name">
                                                </div>
                                                @error('last_name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Address</label>
                                                    <input class="form-control" type="text"
                                                        value="{{ auth()->guard('user')->user()->address }}" name="address">
                                                </div>
                                                @error('address')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">City</label>
                                                    <input class="form-control" type="text"
                                                        value="{{ auth()->guard('user')->user()->city }}" name="city">
                                                </div>
                                                @error('city')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6 col-md-3">
                                                <div class="mb-3">
                                                    <label class="form-label">Postal Code</label>
                                                    <input class="form-control" type="number"
                                                        value="{{ auth()->guard('user')->user()->Postal_code }}"
                                                        name="Postal_code">
                                                </div>
                                                @error('Postal_code')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="col-md-5">
                                                <div class="mb-3">
                                                    <label class="form-label">Country</label>
                                                    @if (auth()->guard('user')->user()->country)
                                                        <input class="form-control" type="text"
                                                            value="{{ auth()->guard('user')->user()->country }}" name="country">
                                                    @else
                                                        <select class="form-control btn-square" name="country">
                                                            <option value="">--Select--</option>
                                                            <option value="Germany">Germany</option>
                                                            <option value="Canada">Canada</option>
                                                            <option value="Usa">Usa</option>
                                                            <option value="Aus">Aus</option>
                                                        </select>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Phone</label>
                                                    <input class="form-control" name="phone"
                                                        value="{{ Auth()->guard('user')->user()->phone }}">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div>
                                                    <label class="form-label">About Me</label>
                                                    <textarea class="form-control" rows="4"
                                                        placeholder="Enter About your description"
                                                        name="about_me">{{ auth()->guard('user')->user()->about_me }}</textarea>
                                                    @error('about_me')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary" type="submit">Update Profile</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
    </div>

@endsection
