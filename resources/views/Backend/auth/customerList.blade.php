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
                            <h3>Customer Management</h3>
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
                                <li class="breadcrumb-item">Home</li>
                                <li class="breadcrumb-item active">Customer Management</li>
                            </ol>
                        </div>
                    </div>
                </div>

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Summary Cards --}}
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card text-center border-0 shadow-sm">
                            <div class="card-body">
                                <h4 class="text-primary mb-0">{{ $customers->count() }}</h4>
                                <small class="text-muted">Total Customers</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center border-0 shadow-sm">
                            <div class="card-body">
                                <h4 class="text-success mb-0">
                                    {{ $customers->where('status', 1)->count() }}
                                </h4>
                                <small class="text-muted">Active</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-center border-0 shadow-sm">
                            <div class="card-body">
                                <h4 class="text-danger mb-0">
                                    {{ $customers->where('status', 0)->count() }}
                                </h4>
                                <small class="text-muted">Banned</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Customers Table --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Customers Directory</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>

                                        <th>Status</th>
                                        <th>Registered</th>
                                        <th style="width: 130px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($customers as $index => $customer)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $customer->fullname }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $customer->phone ?? '-' }}</td>

                                            <td>
                                                @if($customer->isActive())
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Banned</span>
                                                @endif
                                            </td>
                                            <td>{{ $customer->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <div class="d-flex gap-1">

                                                    {{-- View Button --}}
                                                    <a href="{{ route('customer.show', $customer->id) }}"
                                                       class="btn btn-sm btn-outline-info"
                                                       title="View Profile">
                                                        <i class="fa fa-eye"></i>View
                                                    </a>

                                                    {{--  Toggle Status + Delete Button - only for Manager --}}
                                                    @if(auth()->guard('user')->user()->isManager())

                                                        {{-- Toggle Status --}}
                                                        <form action="{{ route('customer.toggleStatus', $customer->id) }}"
                                                              method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="mx-1">
                                                                <button type="submit"
                                                                        class="btn btn-sm {{ $customer->isActive() ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                                                        title="{{ $customer->isActive() ? 'Ban Customer' : 'Unban Customer' }}"
                                                                        onclick="return confirm('{{ $customer->isActive() ? 'Ban this customer?' : 'Unban this customer?' }}')">
                                                                    <i class="fa {{ $customer->isActive() ? 'fa-lock' : 'fa-unlock' }}"></i> Baned
                                                                </button>
                                                            </div>
                                                        </form>

                                                        {{-- Delete --}}
                                                        <form action="{{ route('customer.destroy', $customer->id) }}"
                                                              method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="btn btn-sm btn-outline-danger"
                                                                    title="Delete Customer"
                                                                    onclick="return confirm('Permanently delete this customer?')">
                                                                <i class="fa fa-trash"></i>Delete
                                                            </button>
                                                        </form>

                                                    @endif
                                                    {{-- End manager-only actions --}}

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4 text-muted">
                                                <i class="bi bi-people me-2"></i>No customers found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- End Customers Table --}}

            </div>
        </div>

    </div>
</div>

@endsection
