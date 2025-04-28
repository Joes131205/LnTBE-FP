<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the invoices.
     */
    public function index()
    {
        $invoices = auth()->user()->invoices()->latest()->get();
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create()
    {
        $cart = session()->get('cart', []);
        
        if (count($cart) == 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Add products before checkout.');
        }
        
        // Calculate the total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('invoices.create', compact('cart', 'total'));
    }

    /**
     * Store a newly created invoice in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:5',
        ]);
        
        $cart = session()->get('cart', []);
        
        if (count($cart) == 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Add products before checkout.');
        }
        
        // Start a database transaction
        \DB::beginTransaction();
        
        try {
            // Create invoice
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
            
            $invoice = new Invoice();
            $invoice->user_id = auth()->id();
            $invoice->invoice_number = 'INV-' . Str::upper(Str::random(8));
            $invoice->shipping_address = $validated['shipping_address'];
            $invoice->postal_code = $validated['postal_code'];
            $invoice->total_amount = $total;
            $invoice->save();
            
            // Create invoice items and update product quantities
            foreach ($cart as $id => $details) {
                $product = Product::find($id);
                
                if (!$product) {
                    // Skip if product was deleted
                    continue;
                }
                
                // Check if requested quantity is available
                if ($details['quantity'] > $product->quantity) {
                    throw new \Exception("Product {$product->name} does not have enough stock.");
                }
                
                // Create invoice item
                $invoiceItem = new InvoiceItem();
                $invoiceItem->invoice_id = $invoice->id;
                $invoiceItem->product_id = $id;
                $invoiceItem->quantity = $details['quantity'];
                $invoiceItem->price = $details['price'];
                $invoiceItem->subtotal = $details['price'] * $details['quantity'];
                $invoiceItem->save();
                
                // Update product quantity
                $product->quantity -= $details['quantity'];
                $product->save();
            }
            
            // Clear the cart
            session()->forget('cart');
            
            // Commit the transaction
            \DB::commit();
            
            return redirect()->route('invoices.show', $invoice->id)
                ->with('success', 'Invoice created successfully. Thank you for your purchase!');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            \DB::rollback();
            
            return redirect()->route('cart.index')
                ->with('error', 'Error creating invoice: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified invoice.
     */
    public function show(Invoice $invoice)
    {
        // Make sure the user can only view their own invoices
        if ($invoice->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        
        $invoice->load(['items.product', 'user']);
        
        return view('invoices.show', compact('invoice'));
    }
}
