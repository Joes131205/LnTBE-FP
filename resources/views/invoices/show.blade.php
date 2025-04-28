@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ __('Invoice #') }} {{ $invoice->id }}</span>
                        <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-secondary">Back to Invoices</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <h6 class="mb-3">From:</h6>
                            <div>
                                <strong>Chipi-Chapa Inventory</strong>
                            </div>
                            <div>Company Address</div>
                            <div>Email: info@chipichapa.com</div>
                            <div>Phone: 123-456-7890</div>
                        </div>

                        <div class="col-sm-6">
                            <h6 class="mb-3">To:</h6>
                            <div>
                                <strong>{{ $invoice->user->name }}</strong>
                            </div>
                            <div>{{ $invoice->user->email }}</div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <div><strong>Invoice Date:</strong> {{ $invoice->created_at->format('Y-m-d') }}</div>
                            <div><strong>Status:</strong> {{ $invoice->status }}</div>
                        </div>
                    </div>

                    <div class="table-responsive-sm">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="center">#</th>
                                    <th>Item</th>
                                    <th>Description</th>
                                    <th class="right">Unit Price</th>
                                    <th class="center">Quantity</th>
                                    <th class="right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->invoiceItems as $index => $item)
                                <tr>
                                    <td class="center">{{ $index + 1 }}</td>
                                    <td class="left">{{ $item->product->name }}</td>
                                    <td class="left">{{ $item->product->description }}</td>
                                    <td class="right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                    <td class="center">{{ $item->quantity }}</td>
                                    <td class="right">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-sm-5">
                        </div>

                        <div class="col-lg-4 col-sm-5 ml-auto">
                            <table class="table table-clear">
                                <tbody>
                                    <tr>
                                        <td class="left"><strong>Subtotal</strong></td>
                                        <td class="right">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="left"><strong>Total</strong></td>
                                        <td class="right"><strong>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection