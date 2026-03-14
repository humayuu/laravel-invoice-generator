<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>

<body>

    <div class="container">
        <div class="row m-5 mx-auto">
            <div class="col-12">

                <h1 class="m-5 text-center text-success fw-bold"><i class="fa-regular fa-file-lines"></i> Generate
                    Invoice PDF</h1>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <a href="{{ route('invoice.create') }}" class="btn btn-lg btn-primary px-4 mb-2"><i
                        class="fa-regular fa-square-plus"></i> Add
                    Invoice</a>

                <div class="card shadow">
                    <div class="card-body">
                        @if ($invoices->count() > 0)
                            <table class="table table-stripe">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Invoice No#</th>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $invoice->invoice_number }}</td>
                                            <td>{{ $invoice->product_name }}</td>
                                            <td>{{ $invoice->quantity }}</td>
                                            <td>Rs. {{ $invoice->total_amount }}</td>
                                            <td>{{ Str::title($invoice->status) }}</td>
                                            <td>
                                                <a class="btn btn-primary"
                                                    href="{{ route('invoice.pdf', $invoice->id) }}">
                                                    <i class="fas fa-file-invoice"></i> Invoice
                                                </a>
                                                <a class="btn btn-success"
                                                    href="{{ route('invoice.show', $invoice->id) }}"
                                                    title="View Details">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a class="btn btn-dark"
                                                    href="{{ route('invoice.edit', $invoice->id) }}"
                                                    title="Edit Invoice">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('invoice.destroy', $invoice->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit" title="Delete Invoice"
                                                        onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                {!! $invoices->links() !!}
                            </div>
                        @else
                            <div class="alert alert-danger">No Record Found!</div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>
