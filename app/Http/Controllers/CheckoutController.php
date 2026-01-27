<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderConfirmation;

class CheckoutController extends Controller
{
    public function index()
    {
        // Get cart items
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())
                ->with('saree')
                ->get();
        } else {
            $sessionId = Session::getId();
            $cartItems = Cart::where('session_id', $sessionId)
                ->with('saree')
                ->get();
        }

        // Check if cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        // Check stock availability
        foreach ($cartItems as $item) {
            if (!$item->saree->isInStock() || $item->quantity > $item->saree->stock_quantity) {
                return redirect()->route('cart')->with('error', 'Some items in your cart are out of stock or quantity exceeds available stock.');
            }
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function ($item) {
            return $item->getSubtotal();
        });

        // Get coupon discount if applied
        $discount = 0;
        $couponCode = Session::get('coupon_code');
        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->first();
            if ($coupon && $coupon->isValid()) {
                $discount = $coupon->calculateDiscount($subtotal);
            } else {
                Session::forget(['coupon_code', 'coupon_discount']);
            }
        }

        $shippingCost = 50.00; // Flat rate shipping
        $total = $subtotal - $discount + $shippingCost;

        // Get saved addresses for logged-in users
        $savedAddresses = Auth::check() ? Auth::user()->addresses()->get() : collect();
        $defaultAddress = Auth::check() ? Auth::user()->defaultAddress : null;

        return view('pages.shop-checkout', compact(
            'cartItems',
            'subtotal',
            'discount',
            'shippingCost',
            'total',
            'couponCode',
            'savedAddresses',
            'defaultAddress'
        ));
    }

    public function processCheckout(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'use_saved_address' => 'nullable|boolean',
            'saved_address_id' => 'nullable|exists:addresses,id',
            'save_address' => 'nullable|boolean',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'street_address' => 'required|string|max:255',
            'apartment' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip' => 'required|string|max:20',
            'ship_to_different' => 'nullable|boolean',
            'shipping_first_name' => 'required_if:ship_to_different,1|nullable|string|max:255',
            'shipping_last_name' => 'required_if:ship_to_different,1|nullable|string|max:255',
            'shipping_street_address' => 'required_if:ship_to_different,1|nullable|string|max:255',
            'shipping_apartment' => 'nullable|string|max:255',
            'shipping_city' => 'required_if:ship_to_different,1|nullable|string|max:255',
            'shipping_state' => 'required_if:ship_to_different,1|nullable|string|max:255',
            'shipping_country' => 'required_if:ship_to_different,1|nullable|string|max:255',
            'shipping_zip' => 'required_if:ship_to_different,1|nullable|string|max:20',
            'payment_method' => 'required|in:bank_transfer,check,cod,paypal',
            'order_notes' => 'nullable|string|max:1000',
        ]);

        // Get cart items
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())
                ->with('saree')
                ->get();
        } else {
            $sessionId = Session::getId();
            $cartItems = Cart::where('session_id', $sessionId)
                ->with('saree')
                ->get();
        }

        // Check if cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function ($item) {
            return $item->getSubtotal();
        });

        // Get coupon discount
        $discount = 0;
        $couponCode = Session::get('coupon_code');
        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->first();
            if ($coupon && $coupon->isValid()) {
                $discount = $coupon->calculateDiscount($subtotal);
            }
        }

        $shippingCost = 50.00;
        $total = $subtotal - $discount + $shippingCost;

        try {
            DB::beginTransaction();

            // Convert ship_to_different to boolean properly
            $shipToDifferent = $request->boolean('ship_to_different');

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'street_address' => $validated['street_address'],
                'apartment' => $validated['apartment'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'country' => $validated['country'],
                'zip' => $validated['zip'],
                'ship_to_different' => $shipToDifferent,
                'shipping_first_name' => $shipToDifferent ? $validated['shipping_first_name'] : null,
                'shipping_last_name' => $shipToDifferent ? $validated['shipping_last_name'] : null,
                'shipping_street_address' => $shipToDifferent ? $validated['shipping_street_address'] : null,
                'shipping_apartment' => $shipToDifferent ? ($validated['shipping_apartment'] ?? null) : null,
                'shipping_city' => $shipToDifferent ? $validated['shipping_city'] : null,
                'shipping_state' => $shipToDifferent ? $validated['shipping_state'] : null,
                'shipping_country' => $shipToDifferent ? $validated['shipping_country'] : null,
                'shipping_zip' => $shipToDifferent ? $validated['shipping_zip'] : null,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'discount' => $discount,
                'total' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'order_notes' => $validated['order_notes'] ?? null,
            ]);

            // Save address if user checked "save address" and is logged in
            if (Auth::check() && $request->boolean('save_address') && !$request->boolean('use_saved_address')) {
                Address::create([
                    'user_id' => Auth::id(),
                    'address_type' => 'both',
                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'],
                    'street_address' => $validated['street_address'],
                    'apartment' => $validated['apartment'],
                    'city' => $validated['city'],
                    'state' => $validated['state'],
                    'country' => $validated['country'],
                    'zip' => $validated['zip'],
                    'phone' => $validated['phone'],
                    'is_default' => false,
                ]);
            }

            // Create order items and update stock
            foreach ($cartItems as $cartItem) {
                // Check stock again
                if ($cartItem->saree->stock_quantity < $cartItem->quantity) {
                    throw new \Exception('Insufficient stock for ' . $cartItem->saree->name);
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'saree_id' => $cartItem->saree_id,
                    'saree_name' => $cartItem->saree->name,
                    'saree_sku' => $cartItem->saree->sku,
                    'fabric' => $cartItem->saree->fabric,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                ]);

                // Update stock quantity
                $cartItem->saree->decrement('stock_quantity', $cartItem->quantity);
            }

            // Update coupon usage if applied
            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)->first();
                if ($coupon) {
                    $coupon->increment('used_count');
                }
            }

            // Clear cart
            if (Auth::check()) {
                Cart::where('user_id', Auth::id())->delete();
            } else {
                Cart::where('session_id', Session::getId())->delete();
            }

            // Clear coupon session
            Session::forget(['coupon_code', 'coupon_discount']);

            DB::commit();

            // Send confirmation email to customer
            try {
                // Load order with items for email
                $order->load('items.saree');

                // Send confirmation email to customer
                Mail::to($order->email)
                    ->send(new OrderConfirmation($order));

            } catch (\Exception $e) {
                Log::error('Order confirmation email error: ' . $e->getMessage());
                // Don't fail the order if email fails
            }

            return redirect()->route('order.success', $order->order_number)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to process order: ' . $e->getMessage());
        }
    }

    public function orderSuccess($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('items.saree')
            ->firstOrFail();

        // Check if user owns this order (if logged in)
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('pages.order-success', compact('order'));
    }
}