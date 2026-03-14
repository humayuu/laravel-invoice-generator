<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h1 class="text-success fw-bold">
                                <i class="fa-regular fa-file-lines me-2"></i>Edit Invoice
                            </h1>
                            <p class="text-muted">Fill in the details below to generate a new invoice.</p>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('invoice.update', $invoice->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="product_name" class="form-label">Product Name</label>
                                    <input type="text" name="product_name" id="product_name" class="form-control"
                                        placeholder="e.g. Web Development Service" autofocus
                                        value="{{ $invoice->product_name }}">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="2" placeholder="Brief details...">{{ $invoice->description }}</textarea>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control"
                                        min="1" value="{{ $invoice->quantity }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="sub_total" class="form-label">Sub Total</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" name="sub_total" id="sub_total"
                                            class="form-control" value="{{ $invoice->sub_total }}">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tax_amount" class="form-label">Tax Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" name="tax_amount" id="tax_amount"
                                            class="form-control" value="{{ $invoice->tax_amount }}">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="total_amount" class="form-label">Total Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text fw-bold">$</span>
                                        <input type="number" step="0.01" name="total_amount" id="total_amount"
                                            class="form-control fw-bold border-success"
                                            value="{{ $invoice->total_amount }}">
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="status" class="form-label">Invoice Status</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="draft" {{ $invoice->status === 'draft' ? 'selected' : '' }}>
                                            Draft</option>
                                        <option value="pending" {{ $invoice->status === 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="paid" {{ $invoice->status === 'paid' ? 'selected' : '' }}>Paid
                                        </option>
                                        <option value="cancelled"
                                            {{ $invoice->status === 'cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg"></i>Save Changes
                                </button>
                                <a href="{{ url('/') }}"
                                    class="btn btn-link text-secondary text-decoration-none">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
