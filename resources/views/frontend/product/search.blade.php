@extends('frontend.layout')
@section('main_contain')

    <div class="container-fluid px-xl-5">
        <h4 class="d-flex justify-content-right">Kết quả tìm kiếm cho: "{{ $keyword }} "</h4>
        <div class="row mb-3 ">
            @forelse ($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 my-4">
                    <div class="product-item bg-light">
                        <img src="{{ $product->image }}" class="img-fluid w-100" alt="">
                        <div class="text-center py-3 text-truncate text-decoration-none h6">
                            <a href="{{ route('product.detail', $product->alias) }}" style="color: #3D464D">
                                {{ Str::ucfirst($product->name) }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="my-4 text-center px-3">Nothing found</p>
            @endforelse
        </div>
        {{ $products->links() }}
    </div>
@endsection
