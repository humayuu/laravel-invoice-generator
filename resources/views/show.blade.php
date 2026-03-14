<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice - {{ $invoice->invoice_number }}</title>
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .invoice-header {
            border-bottom: 2px solid #f8f9fa;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .table thead {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm">
                    <div class="card-body p-5">

                        <div class="invoice-header d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="text-success fw-bold mb-0"><i
                                        class="fas fa-file-invoice-dollar me-2"></i>INVOICE</h2>
                                <p class="text-muted">#{{ $invoice->invoice_number }}</p>
                            </div>
                            <div class="text-end">
                                <span
                                    class="badge {{ $invoice->status == 'Paid' ? 'bg-success' : 'bg-warning text-dark' }} fs-6">
                                    {{ strtoupper($invoice->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <h6 class="text-muted">Billed To:</h6>
                                <p class="fw-bold mb-1">Customer Name</p>
                                <p class="text-muted small">Customer contact or address details go here.</p>
                            </div>
                            <div class="col-sm-6 text-sm-end">
                                <h6 class="text-muted">Invoice Details:</h6>
                                <p class="mb-0"><strong>Date:</strong> {{ date('M d, Y') }}</p>
                                <p class="mb-0"><strong>Due Date:</strong> {{ date('M d, Y', strtotime('+7 days')) }}
                                </p>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead class="border-bottom">
                                    <tr>
                                        <th>Description</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Sub Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-bottom">
                                        <td>
                                            <p class="fw-bold mb-0">{{ $invoice->product_name }}</p>
                                            <small class="text-muted">{{ $invoice->description }}</small>
                                        </td>
                                        <td class="text-center align-middle">{{ $invoice->quantity }}</td>
                                        <td class="text-end align-middle">${{ number_format($invoice->sub_total, 2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row justify-content-end mt-4">
                            <div class="col-md-5 col-lg-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Sub Total:</span>
                                    <span>${{ number_format($invoice->sub_total, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax Amount:</span>
                                    <span>${{ number_format($invoice->tax_amount, 2) }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold">Total Amount:</span>
                                    <span
                                        class="fw-bold text-success fs-5">${{ number_format($invoice->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 pt-4 border-top text-center text-muted small">
                            <p>Thank you for your business! If you have any questions, contact us at support@example.com
                            </p>
                        </div>

                    </div>
                </div>

                <div class="text-center mt-4 no-print">
                    <button onclick="window.print()" class="btn btn-secondary ">
                        <i class="fas fa-print me-1"></i> Print Invoice
                    </button>
                    <a href="{{ route('invoice.index') }}" class="btn btn-success px-5">Back</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
