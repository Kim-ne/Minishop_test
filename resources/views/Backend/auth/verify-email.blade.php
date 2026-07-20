@extends('Backend.layout')
@section('admin_contain')

    <div class="page-wrapper compact-wrapper" id="pageWrapper">

        {{-- Page Header --}}
        @include('Backend.widget.pageheader')

        <div class="page-body-wrapper">

            {{-- Sidebar --}}
            @include('Backend.widget.sidebar')

            <div class="page-body">
                <div class="container-fluid">
                    <div class="justify-content-between align-items-center text-center mt-5">
                        <h2>Email verify</h2>
                        @if (session('unverified_email'))
                            <p>Email <strong>{{ session('unverified_email') }}</strong> is not verified.</p>
                        @endif
                        <p>We have sent a verification link to your email address.</p>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="text-center">
                        <form method="POST" action="{{ route('user.email.verify.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary justify-content-between">Resend verification
                                email</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection
