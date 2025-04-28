<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        $productCount = Product::count();
        $categoryCount = Category::count();
        $invoiceCount = Invoice::count();
        $userCount = User::count();
        
        $lowStockProducts = Product::where('quantity', '<', 10)->get();
        $recentInvoices = Invoice::with('user')->latest()->take(5)->get();
        
        // Calculate total revenue
        $totalRevenue = Invoice::sum('total_amount');
        
        return view('admin.dashboard', compact(
            'productCount', 
            'categoryCount', 
            'invoiceCount', 
            'userCount',
            'lowStockProducts',
            'recentInvoices',
            'totalRevenue'
        ));
    }
}
