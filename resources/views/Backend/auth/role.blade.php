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

                {{-- Breadcrumb --}}
                <div class="page-title">
                    <div class="row">
                        <div class="col-6">
                            <h3>Role Management</h3>
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
                                <li class="breadcrumb-item active">Role Management</li>
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

                {{-- Page Header + Add Button --}}
                {{-- Only manager can add new user --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="mb-0">User Management</h4>
                        <p class="text-muted mb-0">Manage users and their roles</p>
                    </div>
                    @if(auth()->guard('user')->user()->isManager())
                        <button type="button"
                                class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#addUserModal">
                            <i class="bi bi-person-plus me-2"></i>Add User
                        </button>
                    @endif
                </div>

                {{-- Users Table --}}
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Users Directory</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created At</th>
                                        {{-- Only manager can see Actions --}}
                                        @if(auth()->guard('user')->user()->isManager())
                                            <th style="width: 120px;">Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $index => $user)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="badge {{ $user->role === 'manager' ? 'bg-danger' : 'bg-primary' }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td>{{ $user->created_at->format('d/m/Y') }}</td>

                                            @if(auth()->guard('user')->user()->isManager())
                                                <td>
                                                    @if($user->id !== auth()->guard('user')->id())
                                                        <div class="d-flex gap-1">

                                                            {{--  Edit Button --}}
                                                            <button type="button"
                                                                    class="btn btn-sm btn-outline-warning"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#editRoleModal"
                                                                    data-user-id="{{ $user->id }}"
                                                                    data-user-name="{{ $user->name }}"
                                                                    data-user-role="{{ $user->role }}">
                                                                <i class="bi bi-pencil"></i> Edit
                                                            </button>

                                                            {{--  Delete Button --}}
                                                            <form action="{{ route('roles.destroy', $user->id) }}"
                                                                  method="POST"
                                                                  onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                    <i class="bi bi-trash"></i> Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @else
                                                        <span class="badge bg-secondary">You</span>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @empty

                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">
                                                <i class="bi bi-people me-2"></i>No users found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- End Users Table --}}

            </div>
        </div>
        {{-- End page-body --}}

    </div>
</div>

{{-- ============================================ --}}
{{-- MODALS — ONLY MANAGER CAN SEE                --}}
{{-- ============================================ --}}
@if(auth()->guard('user')->user()->isManager())

    {{-- Modal: Add User --}}
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">

                            {{-- Name --}}
                            <div class="col-12">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-12">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email"
                                       name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="col-12 position-relative">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       required>
                                <div class="show-hide" style="top: 43px; right:16px"
                                        data-target="#password">
                                    <span class="show"> </span></div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>

                            {{-- Password Confirmation --}}
                            <div class="col-12 position-relative">
                                <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password"
                                       name="password_confirmation"
                                       id="password_confirmation"
                                       class="form-control"
                                       required>
                                <div class="show-hide" style="top: 43px; right:16px"
                                        data-target="#password_confirmation">
                                    <span class="show"> </span></div>
                            </div>

                            {{-- Role --}}
                            <div class="col-12">
                                <label class="form-label">Role <span class="text-danger">*</span></label>
                                <select name="role"
                                        class="form-select @error('role') is-invalid @enderror"
                                        required>
                                    <option value="">-- Select Role --</option>
                                    <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Modal Add User --}}

    {{-- Modal: Edit Role --}}
    <div class="modal fade" id="editRoleModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                {{-- ✅ Action URL is injected from JS --}}
                <form id="editRoleForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">

                        <p class="mb-3">
                            Changing role for: <strong id="editUserName"></strong>
                        </p>

                        <div class="mb-3">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" id="editUserRole" class="form-select" required>
                                <option value="manager">Manager</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Update Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Modal Edit Role --}}

@endif
{{-- End Manager-only Modals --}}


<script>
    const editRoleModal = document.getElementById('editRoleModal');

    if (editRoleModal) {
        editRoleModal.addEventListener('show.bs.modal', function (event) {
            // Lấy data từ button đã click
            const button   = event.relatedTarget;
            const userId   = button.getAttribute('data-user-id');
            const userName = button.getAttribute('data-user-name');
            const userRole = button.getAttribute('data-user-role');

            // Inject vào modal
            document.getElementById('editUserName').textContent = userName;
            document.getElementById('editUserRole').value       = userRole;

            // ✅ Set action URL động theo user id
            document.getElementById('editRoleForm').action =
                `/user/roles/${userId}/update`;
        });
    }
</script>

@endsection
