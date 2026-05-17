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
                            <h3>Edit Product</h3>
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
                                    <a href="{{ route('user.products') }}">Products</a>
                                </li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <form action="{{ route('products.update', $product->id) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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

                        {{-- LEFT: Main Info --}}
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header card-no-border">
                                    <h5>Product Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">

                                        {{-- Name --}}
                                        <div class="col-12">
                                            <label class="form-label">
                                                Product Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                   name="name"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   value="{{ old('name', $product->name) }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Price + Stock --}}
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Price ($) <span class="text-danger">*</span>
                                            </label>
                                            <input type="number"
                                                   name="price"
                                                   class="form-control @error('price') is-invalid @enderror"
                                                   value="{{ old('price', $product->price) }}"
                                                   step="0.01"
                                                   min="0">
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Stock Quantity <span class="text-danger">*</span>
                                            </label>
                                            <input type="number"
                                                   name="qty"
                                                   class="form-control @error('qty') is-invalid @enderror"
                                                   value="{{ old('qty', $product->qty) }}"
                                                   min="0">
                                            @error('qty')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- SKU + Keywords --}}
                                        <div class="col-md-6">
                                            <label class="form-label">SKU</label>
                                            <input type="text"
                                                   name="sku"
                                                   class="form-control @error('sku') is-invalid @enderror"
                                                   value="{{ old('sku', $product->sku) }}">
                                            @error('sku')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Keywords</label>
                                            <input type="text"
                                                   name="keywords"
                                                   class="form-control @error('keywords') is-invalid @enderror"
                                                   value="{{ old('keywords', $product->keywords) }}">
                                            @error('keywords')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Description --}}
                                        <div class="col-12">
                                            <label class="form-label">Description</label>
                                            <textarea name="description"
                                                      class="form-control @error('description') is-invalid @enderror"
                                                      rows="5">{{ old('description', $product->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT: Image + Settings --}}
                        <div class="col-lg-4">

                            {{-- Image --}}
                            <div class="card">
                                <div class="card-header card-no-border">
                                    <h5>Product Image</h5>
                                </div>
                                <div class="card-body">

                                    {{-- Current Image --}}
                                    <div class="text-center mb-3">
                                        <img id="imagePreview"
                                             src="{{ $product->image ? asset('storage/' . $product->image) : asset('Backend/assets/images/dashboard/product-placeholder.png') }}"
                                             class="img-fluid rounded"
                                             style="max-height: 200px; object-fit: cover; width: 100%;"
                                             alt="{{ $product->name }}">
                                    </div>

                                    <input type="file"
                                           name="image"
                                           id="imageInput"
                                           class="form-control @error('image') is-invalid @enderror"
                                           accept="image/jpg,image/jpeg,image/png,image/webp">
                                    <small class="text-muted">Leave empty to keep current image.</small>
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>

                            {{-- Settings --}}
                            <div class="card">
                                <div class="card-header card-no-border">
                                    <h5>Settings</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">

                                        {{-- Category --}}
                                        <div class="col-12">
                                            <label class="form-label">
                                                Category <span class="text-danger">*</span>
                                            </label>
                                            <select name="category_id"
                                                    class="form-select @error('category_id') is-invalid @enderror">
                                                <option value="">-- Select Category --</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Status --}}
                                        <div class="col-12">
                                            <label class="form-label">
                                                Status <span class="text-danger">*</span>
                                            </label>
                                            <select name="status"
                                                    class="form-select @error('status') is-invalid @enderror">
                                                <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>
                                                    Active
                                                </option>
                                                <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>
                                                    Inactive
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Featured --}}
                                        <div class="col-12">
                                            <div class="form-check form-switch">
                                                <input type="hidden" name="featured" value="0">
                                                <input type="checkbox"
                                                       name="featured"
                                                       id="featured"
                                                       class="form-check-input"
                                                       value="1"
                                                       {{ old('featured', $product->featured) == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="featured">
                                                    Featured Product
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-save me-1"></i>Save Changes
                                </button>
                                <a href="{{ route('user.products') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i>Cancel
                                </a>
                            </div>

                        </div>

                    </div>
                </form>

            </div>
        </div>

    </div>
</div>

{{-- Image Preview Script --}}
<script>
    document.getElementById('imageInput').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (event) {
            document.getElementById('imagePreview').src = event.target.result;
        };
        reader.readAsDataURL(file);
    });
</script>

@endsection
