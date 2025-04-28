@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h2>Welcome to Chipi Chapa Inventory System</h2>
                    <p class="lead">You are logged in!</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body text-center">
                                    <h3 class="card-title">Products</h3>
                                    <p class="card-text">Browse and manage inventory products</p>
                                    <a href="{{ route('products.index') }}" class="btn btn-primary">View Products</a>
                                </div>
                            </div>
                        </div>
                        
                        @if(auth()->user()->role === 'admin')
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body text-center">
                                    <h3 class="card-title">Categories</h3>
                                    <p class="card-text">Manage product categories</p>
                                    <a href="{{ route('categories.index') }}" class="btn btn-success">Manage Categories</a>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body text-center">
                                    <h3 class="card-title">My Invoices</h3>
                                    <p class="card-text">View your purchase history</p>
                                    <a href="{{ route('invoices.index') }}" class="btn btn-info text-white">View Invoices</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
