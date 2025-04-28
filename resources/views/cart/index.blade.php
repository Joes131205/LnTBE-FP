@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ __('Your Cart') }}</span>
                        <a href="{{ route('products.index') }}" class="btn btn-sm btn-secondary">Continue Shopping</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($cartItems && count($cartItems) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $id => $item)
                                    <tr>
                                        <td>{{ $item['name'] }}</td>
                                        <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                        <td>
                                            <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <div class="input-group input-group-sm" style="width: 100px;">
                                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="100" class="form-control">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-outline-secondary">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                                        <td>
                                            <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                        <td>Rp {{ number_format($totalAmount, 0, ',', '.') }}</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <form action="{{ route('cart.clear') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">Clear Cart</button>
                                </form>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{ route('invoices.create') }}" class="btn btn-success">Proceed to Checkout</a>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <p>Your cart is empty.</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">Browse Products</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection