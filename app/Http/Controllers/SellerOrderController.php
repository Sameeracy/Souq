<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerOrderController extends Controller
{
    /**
     * Display the full order delivery inbox for the seller.
     */
    public function index()
    {
        $orderItems = Auth::user()->sellerOrderItems()
            ->with(['order.user', 'product', 'option'])
            ->latest()
            ->paginate(15);
                        
        return view('seller.order', compact('orderItems'));
    }
}