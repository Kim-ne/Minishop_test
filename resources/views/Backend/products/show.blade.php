@extends('backend.layout')
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
                                <h3>Product Detail</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('user.dashboard') }}">
                                            <svg class="stroke-icon">
                                                <use href="{{ asset('Backend/assets/svg/icon-sprite.svg#stroke-home') }}">
                                                </use>
                                            </svg>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('user.products') }}">Products</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{ $product->name }}</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Flash Messages --}}
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        {{-- LEFT: Image --}}
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('Backend/assets/images/dashboard/product-placeholder.png') }}"
                                        class="img-fluid rounded" style="max-height: 300px; object-fit: cover; width: 100%;"
                                        alt="{{ $product->name }}">

                                    <div class="mt-3 d-flex justify-content-center gap-2 flex-wrap">

                                        {{-- Status Badge --}}
                                        @if($product->isActive())
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif

                                        {{-- Featured Badge --}}
                                        @if($product->isFeatured())
                                            <span class="badge bg-warning text-dark">
                                                <i class="fa fa-star-fill me-1"></i>Featured
                                            </span>
                                        @endif

                                    </div>

                                    {{-- Manager Actions --}}
                                    @if(auth()->guard('user')->user()->isManager())
                                        <div class="mt-3 d-flex gap-2 justify-content-center flex-wrap">

                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil me-1"></i>Edit
                                            </a>

                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Permanently delete this product?')">
                                                    <i class="bi bi-trash me-1"></i>Delete
                                                </button>
                                            </form>

                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>

                        {{-- RIGHT: Detail Info --}}
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header card-no-border">
                                    <h5>Product Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <th width="30%" class="text-muted">Product Name</th>
                                                <td>{{ $product->name }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted">Category</th>
                                                <td>{{ $product->category->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted">Price</th>
                                                <td class="fw-bold text-primary">
                                                    ${{ number_format($product->price, 2) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted">Stock</th>
                                                <td>
                                                    <span class="{{ $product->qty <= 5 ? 'text-danger fw-bold' : '' }}">
                                                        {{ $product->qty }} units
                                                        @if($product->qty <= 5)
                                                            <span class="badge bg-danger ms-1">Low Stock</span>
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted">SKU</th>
                                                <td>{{ $product->sku ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted">Keywords</th>
                                                <td>{{ $product->keywords ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted">Alias (URL)</th>
                                                <td>
                                                    <code>{{ $product->alias }}</code>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted">Created At</th>
                                                <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted">Last Updated</th>
                                                <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                            @if($product->description)
                                                <tr>
                                                    <th class="text-muted">Description</th>
                                                    <td>{{ $product->description }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Back Button --}}
                            <div class="mt-2">
                                <a href="{{ route('user.products') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Back to Products
                                </a>
                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection
