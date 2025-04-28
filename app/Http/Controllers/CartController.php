<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index()
    {
        $cartItems = session()->get('cart', []);
        $totalAmount = 0;
        
        // Calculate total and ensure products still exist
        foreach ($cartItems as $id => $details) {
            $totalAmount += $details['price'] * $details['quantity'];
            
            // Verify product still exists and update product information if needed
            $product = Product::find($id);
            if ($product) {
                $cartItems[$id]['current_quantity'] = $product->quantity;
            } else {
                // Product was deleted, remove from cart
                unset($cartItems[$id]);
            }
        }
        
        session()->put('cart', $cartItems);
        
        return view('cart.index', compact('cartItems', 'totalAmount'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        
        $quantity = $request->quantity;
        
        // Check if requested quantity is available
        if ($quantity > $product->quantity) {
            return redirect()->back()->with('error', 'Requested quantity not available in stock.');
        }
        
        $cart = session()->get('cart', []);
        
        // If product already in cart, update quantity
        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $quantity;
            
            // Check if total requested quantity is available
            if ($newQuantity > $product->quantity) {
                return redirect()->back()->with('error', 'Requested quantity not available in stock.');
            }
            
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            // Add product to cart
            $cart[$product->id] = [
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $product->price,
                'image' => $product->image,
                'current_quantity' => $product->quantity
            ];
        }
        
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }

    /**
     * Update the cart quantities.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cart = session()->get('cart', []);
        $id = $request->id;
        $quantity = $request->quantity;
        
        // Check if product exists
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        
        // Check if requested quantity is available
        if ($quantity > $product->quantity) {
            return response()->json([
                'error' => 'Requested quantity not available in stock.',
                'available' => $product->quantity
            ], 422);
        }
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            $cart[$id]['current_quantity'] = $product->quantity;
            session()->put('cart', $cart);
        }
        
        return response()->json([
            'success' => 'Cart updated successfully',
            'total' => $this->calculateTotal($cart)
        ]);
    }

    /**
     * Remove a product from cart.
     */
    public function remove(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
        ]);
        
        $id = $request->id;
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Product removed from cart.');
    }

    /**
     * Clear the entire cart.
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared successfully.');
    }
    
    /**
     * Calculate total price of items in cart.
     */
    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return number_format($total, 2);
    }
}