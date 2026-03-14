<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::all();

        return response()->json([
            'status' => true,
            'message' => 'Successfully Fetch all invoices',
            'invoices' => $invoices,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateInvoice = Validator::make($request->all(), [
            'product_name' => 'required|max:50',
            'description' => 'required|min:20',
            'quantity' => 'required|numeric|min:1',
            'sub_total' => 'required|numeric',
            'tax_amount' => 'required|numeric',
        ]);

        if ($validateInvoice->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validateInvoice->errors()->all(),
            ], 422);
        }


        try {
            $invoiceNo = uniqid('invoice_') . time();

            $totalAmount = $request->sub_total + $request->tax_amount;

            Invoice::create([
                'invoice_number' => $invoiceNo,
                'product_name' => $request->product_name,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'sub_total' => $request->sub_total,
                'tax_amount' => $request->tax_amount,
                'total_amount' => $totalAmount,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Invoice created Successfully',
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error in invoice creation ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $invoice = Invoice::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Successfully Fetch invoice',
            'invoices' => $invoice,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $invoice = Invoice::findOrFail($id);
        $validateInvoice = Validator::make($request->all(), [
            'product_name' => 'required|max:50',
            'description' => 'required|min:20',
            'quantity' => 'required|numeric|min:1',
            'sub_total' => 'required|numeric',
            'tax_amount' => 'required|numeric',
        ]);

        if ($validateInvoice->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validateInvoice->errors()->all(),
            ], 422);
        }


        try {
            $invoiceNo = uniqid('invoice_') . time();

            $totalAmount = $request->sub_total + $request->tax_amount;

            $invoice->update([
                'invoice_number' => $invoiceNo,
                'product_name' => $request->product_name,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'sub_total' => $request->sub_total,
                'tax_amount' => $request->tax_amount,
                'total_amount' => $totalAmount,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Invoice updated Successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error in invoice updated ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $invoice = Invoice::findOrFail($id);

            $invoice->delete();

            return response()->json([
                'status' => true,
                'message' => 'Invoice Deleted Successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error in invoice deletion ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * For Generate Invoice PDF
     */

    public function generateInvoicePDF($id)
    {
        try {
            $invoice = Invoice::findOrFail($id);

            $pdf = Pdf::loadView('invoice_pdf', compact('invoice'));

            $fileName = 'invoice_' . $invoice->invoice_number . '.pdf';
            $path = 'invoices/' . $fileName;

            // Save PDF to storage/app/public/invoices
            Storage::disk('public')->put($path, $pdf->output());

            // Generate URL
            $url = asset('storage/' . $path);

            return response()->json([
                'status' => true,
                'message' => 'Invoice PDF generated successfully',
                'url' => $url
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error in invoice generation: ' . $e->getMessage()
            ], 500);
        }
    }
}