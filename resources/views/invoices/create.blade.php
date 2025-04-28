@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ __('Create New Invoice') }}</span>
                        <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-secondary">Back to Invoices</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('invoices.store') }}">
                        @csrf
                        <div class="cart-items">
                            @if($cartItems && count($cartItems) > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cartItems as $item)
                                            <tr>
                                                <td>{{ $item['name'] }}</td>
                                                <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                                <td>{{ $item['quantity'] }}</td>
                                                <td>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                                <td>Rp {{ number_format($totalAmount, 0, ',', '.') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary">Create Invoice</button>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <p>Your cart is empty. Please add products to your cart first.</p>
                                    <a href="{{ route('products.index') }}" class="btn btn-primary">Browse Products</a>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection