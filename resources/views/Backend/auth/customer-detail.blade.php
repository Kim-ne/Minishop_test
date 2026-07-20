@extends('Backend.layout')

@section('admin_contain')

<div class="page-wrapper compact-wrapper" id="pageWrapper">

    @include('Backend.widget.pageheader')

    <div class="page-body-wrapper">

        @include('Backend.widget.sidebar')

        <div class="page-body">
            <div class="container-fluid">

                {{-- Breadcrumb --}}
                <div class="page-title">
                    <div class="row">
                        <div class="col-6">
                            <h3>Customer Detail</h3>
                        </div>
                        <div class="col-6">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('user.dashboard') }}">
                                        <svg class="stroke-icon">
                                            <use href="{{ asset('Backend/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                        </svg>
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('customer.index') }}">Customers</a>
                                </li>
                                <li class="breadcrumb-item active">{{ $customer->name }}</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="row">

                    {{-- Profile Card --}}
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                {{-- Avatar --}}
                                <img src="{{ $customer->avatar
                                            ? asset('storage/' . $customer->avatar)
                                            : asset('Backend/assets/images/user/default-avatar.png') }}"
                                     class="rounded-circle mb-3"
                                     width="100"
                                     height="100"
                                     style="object-fit: cover;"
                                     alt="{{ $customer->name }}">

                                <h5 class="mb-1">{{ $customer->name }}</h5>
                                <p class="text-muted mb-2">{{ $customer->email }}</p>

                                {{-- Status Badge --}}
                                @if($customer->isActive())
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Banned</span>
                                @endif

                                {{-- Manager Actions --}}
                                @if(auth()->guard('user')->user()->isManager())
                                    <div class="mt-3 d-flex gap-2 justify-content-center">

                                        {{-- Toggle Status --}}
                                        <form action="{{ route('customer.toggleStatus', $customer->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="btn btn-sm {{ $customer->isActive() ? 'btn-warning' : 'btn-success' }}"
                                                    onclick="return confirm('{{ $customer->isActive() ? 'Ban this customer?' : 'Unban this customer?' }}')">
                                                <i class="fa {{ $customer->isActive() ? 'fa-lock' : 'fa-unlock' }} me-1"></i>
                                                {{ $customer->isActive() ? 'Ban' : 'Unban' }}
                                            </button>
                                        </form>

                                        {{-- Delete --}}
                                        <form action="{{ route('customer.destroy', $customer->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Permanently delete this customer?')">
                                                <i class="fa fa-trash me-1"></i>Delete
                                            </button>
                                        </form>

                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                    {{-- Detail Info Card --}}
                    <div class="col-md-8">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Customer Information</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <th width="35%" class="text-muted">Full Name</th>
                                            <td>{{ $customer->name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Email</th>
                                            <td>{{ $customer->email }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Phone</th>
                                            <td>{{ $customer->phone ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Address</th>
                                            <td>{{ $customer->address ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">City</th>
                                            <td>{{ $customer->city ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Country</th>
                                            <td>{{ $customer->country ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Registered</th>
                                            <td>{{ $customer->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted">Status</th>
                                            <td>
                                                @if($customer->isActive())
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Banned</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Back Button --}}
                        <div class="mt-3">
                            <a href="{{ route('customer.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Back to Customers
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

@endsection
