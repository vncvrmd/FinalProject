@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Transaction</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="form-label">Customer</label>
            <select name="customer_id" class="form-control" required>
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->customer_id }}">{{ $customer->customer_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="form-label">Payment Method</label>
            <select name="payment_method" class="form-control" required>
                <option value="cash">Cash</option>
                <option value="credit card">Credit Card</option>
            </select>
        </div>

        <div class="card mb-4">
            <div class="card-header">Products</div>
            <div class="card-body">
                <table class="table" id="product-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="product-list">
                        </tbody>
                </table>
                <button type="button" class="btn btn-secondary btn-sm" onclick="addProductRow()">+ Add Product</button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Complete Sale</button>
    </form>
</div>

<script>
    function addProductRow() {
        const rowId = Date.now();
        const html = `
            <tr id="row-${rowId}">
                <td>
                    <select name="products[]" class="form-control" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->product_id }}">
                                {{ $product->product_name }} (Stock: {{ $product->quantity_available }} | ${{ $product->price }})
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="quantities[]" class="form-control" min="1" value="1" required>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(${rowId})">Remove</button>
                </td>
            </tr>
        `;
        document.getElementById('product-list').insertAdjacentHTML('beforeend', html);
    }

    function removeRow(id) {
        document.getElementById(`row-${id}`).remove();
    }

    // Add one row by default
    document.addEventListener('DOMContentLoaded', addProductRow);
</script>
@endsection