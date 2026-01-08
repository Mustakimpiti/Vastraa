<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Auth::user()->orders()
            ->with(['items.saree'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show($orderNumber)
    {
        $order = Auth::user()->orders()
            ->with(['items.saree.images'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }
}