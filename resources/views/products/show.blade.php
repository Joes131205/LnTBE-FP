<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-semibold fs-4 text-secondary">
                {{ $product->name }}
            </h2>
            <a href="{{ route('products.index') }}" class="text-secondary text-decoration-none">
                &larr; Back to Products
            </a>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="bg-light rounded h-100" style="min-height: 250px;">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded w-100 h-100 object-fit-cover">
                                @else
                                    <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                        <span class="text-secondary">No Image</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <h1 class="fs-2 fw-bold mb-2">{{ $product->name }}</h1>
                            <div class="mb-3">
                                <span class="badge bg-secondary me-2">
                                    {{ $product->category->name ?? 'No Category' }}
                                </span>
                                <span class="badge bg-secondary">
                                    Stock: {{ $product->stock }}
                                </span>
                            </div>
                            
                            <div class="mb-3">
                                <h3 class="fs-3 fw-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>
                            </div>
                            
                            <div class="mb-4">
                                <h4 class="fs-5 fw-bold">Description</h4>
                                <p>{{ $product->description ?: 'No description available.' }}</p>
                            </div>
                            
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                @auth
                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            Add to Cart
                                        </button>
                                    </form>
                                    
                                    @if(auth()->user()->isAdmin)
                                        <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-primary">
                                            Edit
                                        </a>
                                        
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
