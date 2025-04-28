<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-secondary">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="text-muted small mb-1">
                                Total Products
                            </div>
                            <div class="fs-3 fw-bold">
                                {{ $productCount }}
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('products.index') }}" class="text-primary text-decoration-none">View all</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="text-muted small mb-1">
                                Total Categories
                            </div>
                            <div class="fs-3 fw-bold">
                                {{ $categoryCount }}
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('categories.index') }}" class="text-primary text-decoration-none">View all</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="text-muted small mb-1">
                                Total Users
                            </div>
                            <div class="fs-3 fw-bold">
                                {{ $userCount }}
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('admin.users') }}" class="text-primary text-decoration-none">Manage users</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="text-muted small mb-1">
                                Total Orders
                            </div>
                            <div class="fs-3 fw-bold">
                                {{ $orderCount }}
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('admin.orders') }}" class="text-primary text-decoration-none">View orders</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Low Stock Products -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-warning text-dark">
                    <h5 class="mb-0">Low Stock Products</h5>
                    <a href="{{ route('products.index') }}" class="text-dark">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowStockProducts as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div style="width: 40px; height: 40px;">
                                                    @if($product->image)
                                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail h-100 w-100 object-fit-cover">
                                                    @else
                                                        <div class="h-100 w-100 bg-light rounded d-flex align-items-center justify-content-center">
                                                            <span class="text-muted small">No IMG</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ms-3">
                                                    <div class="fw-medium">
                                                        {{ $product->name }}
                                                    </div>
                                                    <div class="text-muted small">
                                                        ID: {{ $product->id }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $product->category->name ?? 'No Category' }}</td>
                                        <td>
                                            <span class="badge bg-danger">{{ $product->stock }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-primary">Update Stock</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-3">No low stock products found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Recent Invoices -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center bg-info text-dark">
                    <h5 class="mb-0">Recent Invoices</h5>
                    <a href="{{ route('invoices.index') }}" class="text-dark">View All</a>
                </div>
                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentInvoices as $invoice)
                                    <tr>
                                        <td>#{{ $invoice->invoice_number }}</td>
                                        <td>
                                            <div class="fw-medium">
                                                {{ $invoice->user->name }}
                                            </div>
                                        </td>
                                        <td>{{ $invoice->created_at->format('M d, Y') }}</td>
                                        <td>${{ number_format($invoice->total, 2) }}</td>
                                        <td>
                                            <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-3">No recent invoices found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
