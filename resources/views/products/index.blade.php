@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ __('Products') }}</span>
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">Add New Product</a>
                            @endif
                        @endauth
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        @if($products->count() > 0)
                            @foreach($products as $product)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        @if($product->image)
                                            <img src="{{ asset('storage/products/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                                        @else
                                            <div class="card-img-top bg-light d-flex justify-content-center align-items-center" style="height: 200px;">
                                                <span class="text-muted">No Image</span>
                                            </div>
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text">
                                                <strong>Price:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}<br>
                                                <strong>In Stock:</strong> {{ $product->quantity }}<br>
                                                <strong>Category:</strong> {{ $product->category->name }}
                                            </p>
                                        </div>
                                        <div class="card-footer bg-white">
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info text-white">View Details</a>
                                                @auth
                                                    @if(auth()->user()->role === 'admin')
                                                        <div>
                                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="alert alert-info">
                                    No products available at this time.
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection