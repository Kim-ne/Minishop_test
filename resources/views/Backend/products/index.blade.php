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
                            <h3>Product Management</h3>
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
                                <li class="breadcrumb-item active">Products</li>
                            </ol>
                        </div>
                    </div>
                </div>

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

                {{-- Summary Cards --}}
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card widget-1">
                            <div class="card-body">
                                <div class="widget-content">
                                    <div class="widget-round primary">
                                        <div class="bg-round">
                                            <svg class="svg-fill">
                                                <use href="{{ asset('Backend/assets/svg/icon-sprite.svg#tag') }}"></use>
                                            </svg>
                                            <svg class="half-circle svg-fill">
                                                <use href="{{ asset('Backend/assets/svg/icon-sprite.svg#halfcircle') }}"></use>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4>{{ $products->total() }}</h4>
                                        <span class="f-light">Total Products</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card widget-1">
                            <div class="card-body">
                                <div class="widget-content">
                                    <div class="widget-round success">
                                        <div class="bg-round">
                                            <svg class="svg-fill">
                                                <use href="{{ asset('Backend/assets/svg/icon-sprite.svg#rate') }}"></use>
                                            </svg>
                                            <svg class="half-circle svg-fill">
                                                <use href="{{ asset('Backend/assets/svg/icon-sprite.svg#halfcircle') }}"></use>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4>{{ $products->getCollection()->where('status', 1)->count() }}</h4>
                                        <span class="f-light">Active</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card widget-1">
                            <div class="card-body">
                                <div class="widget-content">
                                    <div class="widget-round secondary">
                                        <div class="bg-round">
                                            <svg class="svg-fill">
                                                <use href="{{ asset('Backend/assets/svg/icon-sprite.svg#cart') }}"></use>
                                            </svg>
                                            <svg class="half-circle svg-fill">
                                                <use href="{{ asset('Backend/assets/svg/icon-sprite.svg#halfcircle') }}"></use>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4>{{ $products->getCollection()->where('status', 0)->count() }}</h4>
                                        <span class="f-light">Inactive</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card widget-1">
                            <div class="card-body">
                                <div class="widget-content">
                                    <div class="widget-round warning">
                                        <div class="bg-round">
                                            <svg class="svg-fill">
                                                <use href="{{ asset('Backend/assets/svg/icon-sprite.svg#return-box') }}"></use>
                                            </svg>
                                            <svg class="half-circle svg-fill">
                                                <use href="{{ asset('Backend/assets/svg/icon-sprite.svg#halfcircle') }}"></use>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4>{{ $products->getCollection()->where('featured', 1)->count() }}</h4>
                                        <span class="f-light">Featured</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Products Table --}}
                <div class="card">
                    <div class="card-header card-no-border">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Products Directory</h5>
                            {{-- only manager can Add --}}
                            @if(auth()->guard('user')->user()->isManager())
                                <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle me-1"></i>Add Product
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Featured</th>
                                        <th style="width: 160px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $index => $product)
                                        <tr>
                                            <td>{{ $products->firstItem() + $index }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $product->image) }}"
                                                     alt="{{ $product->name }}"
                                                     width="50" height="50"
                                                     style="object-fit: cover; border-radius: 6px;"
                                                     onerror="this.src='{{ asset('Backend/assets/images/dashboard/product-placeholder.png') }}'">
                                            </td>
                                            <td>
                                                <div class="fw-medium">{{ $product->name }}</div>
                                                <small class="text-muted">{{ $product->sku ?? '-' }}</small>
                                            </td>
                                            <td>{{ ucfirst($product->category->name ?? '-') }}</td>
                                            <td>${{ number_format($product->price, 2) }}</td>
                                            <td>
                                                {{-- Update Stock --}}
                                                <form action="{{ route('products.updateStock', $product->id) }}"
                                                      method="POST"
                                                      class="d-flex align-items-center gap-1">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number"
                                                           name="qty"
                                                           value="{{ $product->qty }}"
                                                           min="0"
                                                           class="form-control form-control-sm"
                                                           style="width: 75px;">
                                                    <button type="submit"
                                                            class="btn btn-sm btn-outline-primary"
                                                            title="Update Stock">
                                                        <i class="fa fa-check-lg"></i>Update
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                @if($product->isActive())
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->isFeatured())
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="fa fa-star-fill me-1"></i>Featured
                                                    </span>
                                                @else
                                                    <span class="badge bg-light text-muted">Normal</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1 flex-wrap">

                                                    {{-- View Button --}}
                                                    <a href="{{ route('user.productShow', $product->id) }}"
                                                       class="btn btn-sm btn-outline-info"
                                                       title="View">
                                                        <i class="fa fa-eye me-1"></i>View
                                                    </a>

                                                    {{-- Manager only actions --}}
                                                    @if(auth()->guard('user')->user()->isManager())

                                                        {{-- Edit --}}
                                                        <a href="{{ route('products.edit', $product->id) }}"
                                                           class="btn btn-sm btn-outline-warning"
                                                           title="Edit">
                                                            <i class="fa fa-pencil me-1"></i>Edit
                                                        </a>

                                                        {{-- Toggle Status --}}
                                                        <form action="{{ route('products.toggleStatus', $product->id) }}"
                                                              method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                    class="btn btn-sm {{ $product->isActive() ? 'btn-outline-secondary' : 'btn-outline-success' }}"
                                                                    title="{{ $product->isActive() ? 'Deactivate' : 'Activate' }}"
                                                                    onclick="return confirm('{{ $product->isActive() ? 'Deactivate this product?' : 'Activate this product?' }}')">
                                                                <i class="fa {{ $product->isActive() ? 'fa-eye-slash' : 'fa-eye' }} me-1"></i>{{ $product->isActive() ? 'Deactivate' : 'Activate' }}
                                                            </button>
                                                        </form>

                                                        {{-- Toggle Featured --}}
                                                        <form action="{{ route('products.toggleFeatured', $product->id) }}"
                                                              method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                    class="btn btn-sm {{ $product->isFeatured() ? 'btn-warning' : 'btn-outline-warning' }}"
                                                                    title="{{ $product->isFeatured() ? 'Unfeature' : 'Feature' }}">
                                                                <i class="fa fa-star{{ $product->isFeatured() ? '-fill' : '' }} me-1"></i>Featured
                                                            </button>
                                                        </form>

                                                        {{-- Delete --}}
                                                        <form action="{{ route('products.destroy', $product->id) }}"
                                                              method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="btn btn-sm btn-outline-danger"
                                                                    title="Delete"
                                                                    onclick="return confirm('Permanently delete this product?')">
                                                                <i class="fa fa-trash me-1"></i>Delete
                                                            </button>
                                                        </form>

                                                    @endif
                                                    {{-- End manager only --}}

                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4 text-muted">
                                                <i class="fa fa-box-seam me-2"></i>No products found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        @if($products->hasPages())
                            <div class="d-flex justify-content-between align-items-center p-3">
                                <div class="text-muted">
                                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }}
                                    of {{ $products->total() }} results
                                </div>
                                {{ $products->links() }}
                            </div>
                        @endif

                    </div>
                </div>
                {{-- End Products Table --}}

            </div>
        </div>

    </div>
</div>

@endsection
