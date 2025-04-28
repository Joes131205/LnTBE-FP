<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-secondary">
                {{ __('Category') }}: {{ $category->name }}
            </h2>
            <a href="{{ route('categories.index') }}" class="text-secondary text-decoration-none">
                &larr; Back to Categories
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h3 class="fs-5 fw-semibold mb-3">Category Details</h3>
                        <div class="bg-light p-3 rounded">
                            <div class="mb-2">
                                <strong>Name:</strong> {{ $category->name }}
                            </div>
                            <div class="mb-2">
                                <strong>Description:</strong> {{ $category->description ?: 'No description available.' }}
                            </div>
                            <div>
                                <strong>Products Count:</strong> {{ $category->products->count() }}
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mb-4">
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category? All associated products will be uncategorized.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>

                    <h3 class="fs-5 fw-semibold mb-3">Products in this Category</h3>
                    
                    @if($category->products->count() > 0)
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            @foreach($category->products as $product)
                                <div class="col">
                                    <div class="card h-100">
                                        <div style="height: 150px; overflow: hidden;">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top h-100 object-fit-cover">
                                            @else
                                                <div class="h-100 bg-light d-flex align-items-center justify-content-center">
                                                    <span class="text-secondary">No Image</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text">
                                                <span class="badge bg-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                                <span class="badge bg-secondary ms-1">Stock: {{ $product->stock }}</span>
                                            </p>
                                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">No products in this category.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
