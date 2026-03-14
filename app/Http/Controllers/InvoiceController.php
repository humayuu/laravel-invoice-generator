<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Spatie\LaravelPdf\Facades\Pdf;
use Exception;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::orderBy('id', 'DESC')->paginate(5);

        return view('index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|max:50',
            'description' => 'required|min:20',
            'quantity' => 'required|numeric|min:1',
            'sub_total' => 'required|numeric',
            'tax_amount' => 'required|numeric',
        ]);


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

            return redirect()->back()->with('success', 'Invoice Created Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error in invoice creation ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return view('show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        return view('edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'product_name' => 'required|max:50',
            'description' => 'required|min:20',
            'quantity' => 'required|numeric|min:1',
            'sub_total' => 'required|numeric',
            'tax_amount' => 'required|numeric',
        ]);


        try {

            $totalAmount = $request->sub_total + $request->tax_amount;

            $invoice->update([
                'product_name' => $request->product_name,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'sub_total' => $request->sub_total,
                'tax_amount' => $request->tax_amount,
                'total_amount' => $totalAmount,
                'status' => $request->status,
            ]);

            return redirect()->back()->with('success', 'Invoice Updated Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error in invoice update ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {

        try {
            $invoice->delete();

            return redirect()->back()->with('success', 'Invoice Deleted Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error in invoice deletion ' . $e->getMessage());
        }
    }

    /**
     * For Generate Invoice PDF
     */
// ... other methods ...
    /**
     * For Generate Invoice PDF
     */
    public function generateInvoicePDF($id)
    {
        try {
            $invoice = Invoice::findOrFail($id);

            // Generate a dynamic filename
            $fileName = 'invoice_' . $invoice->invoice_number . '.pdf';

            // Use 'download()' to prompt the user to download the file
            return Pdf::view('invoice_pdf', ['invoice' => $invoice])
                ->format('a4')
                ->download($fileName); // Changed from ->save() to ->download()

        } catch (Exception $e) {
            // Log the error for debugging
            return redirect()->back()->with('error', 'Error in generate invoice pdf ' . $e->getMessage());
        }
    }
}