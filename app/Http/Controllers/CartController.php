<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Saree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display the shopping cart
     */
    public function index()
    {
        $cartItems = $this->getCartItems();
        $subtotal = $this->calculateSubtotal($cartItems);
        $shippingCost = $this->calculateShipping($subtotal);
        $total = $subtotal + $shippingCost;

        return view('pages.shop-cart', compact('cartItems', 'subtotal', 'shippingCost', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'saree_id' => 'required|exists:sarees,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $saree = Saree::findOrFail($request->saree_id);

        // Check if product is active and in stock
        if (!$saree->is_active) {
            return redirect()->back()->with('error', 'This product is not available.');
        }

        if (!$saree->isInStock() || $saree->stock_quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Sorry, we don\'t have enough stock for this product.');
        }

        $price = $saree->getActivePrice();

        // Get or create session ID for guest users
        $sessionId = $this->getOrCreateSessionId();

        // Check if item already exists in cart
        $cartItem = Cart::where('saree_id', $request->saree_id)
            ->where(function($query) use ($sessionId) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->first();

        if ($cartItem) {
            // Update quantity if item already in cart
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            // Check if new quantity exceeds stock
            if ($newQuantity > $saree->stock_quantity) {
                return redirect()->back()->with('error', 'Cannot add more items. Stock limit reached.');
            }

            $cartItem->quantity = $newQuantity;
            $cartItem->price = $price;
            $cartItem->save();

            return redirect()->back()->with('success', 'Cart updated! Quantity increased.');
        }

        // Create new cart item
        Cart::create([
            'user_id' => Auth::id(),
            'session_id' => $sessionId,
            'saree_id' => $request->saree_id,
            'quantity' => $request->quantity,
            'price' => $price,
        ]);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:cart,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $sessionId = $this->getOrCreateSessionId();

        $cartItem = Cart::where('id', $request->cart_id)
            ->where(function($query) use ($sessionId) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->firstOrFail();

        // Check stock availability
        if ($request->quantity > $cartItem->saree->stock_quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available.'
            ], 400);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        // Recalculate totals
        $cartItems = $this->getCartItems();
        $subtotal = $this->calculateSubtotal($cartItems);
        $shippingCost = $this->calculateShipping($subtotal);
        $total = $subtotal + $shippingCost;

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully!',
            'itemSubtotal' => number_format((float)$cartItem->getSubtotal(), 2),
            'subtotal' => number_format((float)$subtotal, 2),
            'shipping' => number_format((float)$shippingCost, 2),
            'total' => number_format((float)$total, 2),
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:cart,id',
        ]);

        $sessionId = $this->getOrCreateSessionId();

        $cartItem = Cart::where('id', $request->cart_id)
            ->where(function($query) use ($sessionId) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->firstOrFail();

        $cartItem->delete();

        return redirect()->back()->with('success', 'Product removed from cart.');
    }

    /**
     * Clear all items from cart
     */
    public function clear()
    {
        $sessionId = $this->getOrCreateSessionId();

        Cart::where(function($query) use ($sessionId) {
            if (Auth::check()) {
                $query->where('user_id', Auth::id());
            } else {
                $query->where('session_id', $sessionId);
            }
        })->delete();

        return redirect()->back()->with('success', 'Cart cleared successfully.');
    }

    /**
     * Get cart count for header badge
     */
    public function count()
    {
        $count = $this->getCartItems()->sum('quantity');
        
        return response()->json([
            'count' => $count
        ]);
    }

    /**
     * Apply coupon code
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $coupon = \App\Models\Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return redirect()->back()->with('error', 'Invalid or expired coupon code.');
        }

        $cartItems = $this->getCartItems();
        $subtotal = $this->calculateSubtotal($cartItems);

        // Check minimum purchase requirement
        if ($coupon->min_purchase && $subtotal < $coupon->min_purchase) {
            return redirect()->back()->with('error', 'Minimum purchase amount of ₹' . number_format((float)$coupon->min_purchase, 2) . ' required for this coupon.');
        }

        // Calculate discount
        $discount = $coupon->calculateDiscount($subtotal);

        // Store coupon in session
        Session::put('applied_coupon', [
            'code' => $coupon->code,
            'discount' => $discount,
            'coupon_id' => $coupon->id,
        ]);

        return redirect()->back()->with('success', 'Coupon applied successfully! You saved ₹' . number_format((float)$discount, 2));
    }

    /**
     * Remove applied coupon
     */
    public function removeCoupon()
    {
        Session::forget('applied_coupon');
        return redirect()->back()->with('success', 'Coupon removed.');
    }

    /**
     * Get all cart items for current user/session
     */
    protected function getCartItems()
    {
        $sessionId = $this->getOrCreateSessionId();

        return Cart::with(['saree.images'])
            ->where(function($query) use ($sessionId) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->get();
    }

    /**
     * Calculate cart subtotal
     */
    protected function calculateSubtotal($cartItems)
    {
        return $cartItems->sum(function($item) {
            return $item->getSubtotal();
        });
    }

    /**
     * Calculate shipping cost
     */
    protected function calculateShipping($subtotal)
    {
        // Free shipping over 2000
        if ($subtotal >= 2000) {
            return 0;
        }

        // Flat rate shipping
        return 100;
    }

    /**
     * Get or create session ID for guest users
     */
    protected function getOrCreateSessionId()
    {
        if (!Session::has('cart_session_id')) {
            Session::put('cart_session_id', uniqid('cart_', true));
        }

        return Session::get('cart_session_id');
    }

    /**
     * Transfer guest cart to user account after login
     */
    public function transferGuestCart()
    {
        if (!Auth::check()) {
            return;
        }

        $sessionId = Session::get('cart_session_id');
        
        if (!$sessionId) {
            return;
        }

        // Get guest cart items
        $guestCartItems = Cart::where('session_id', $sessionId)->get();

        foreach ($guestCartItems as $guestItem) {
            // Check if user already has this item in cart
            $userCartItem = Cart::where('user_id', Auth::id())
                ->where('saree_id', $guestItem->saree_id)
                ->first();

            if ($userCartItem) {
                // Merge quantities
                $userCartItem->quantity += $guestItem->quantity;
                $userCartItem->save();
                $guestItem->delete();
            } else {
                // Transfer to user
                $guestItem->user_id = Auth::id();
                $guestItem->session_id = null;
                $guestItem->save();
            }
        }

        // Clear the session ID
        Session::forget('cart_session_id');
    }
}