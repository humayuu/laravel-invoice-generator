<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }

        .invoice-header {
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f2f2f2;
            text-align: left;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .total-section {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="invoice-header">
        <h2>Invoice: {{ $invoice->invoice_number }}</h2>
        <p>Status: <strong>{{ strtoupper($invoice->status) }}</strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $invoice->product_name }}</td>
                <td>{{ $invoice->description }}</td>
                <td>{{ $invoice->quantity }}</td>
                <td>{{ number_format($invoice->sub_total, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="total-section">
        <p>Tax: {{ number_format($invoice->tax_amount, 2) }}</p>
        <h3>Total Amount: {{ number_format($invoice->total_amount, 2) }}</h3>
    </div>
</body>

</html>
