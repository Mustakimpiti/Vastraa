<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use App\Models\Order;

class AccountController extends Controller
{
    /**
     * Display the user account page
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get user statistics
        $totalOrders = Order::where('user_id', $user->id)->count();
        $totalSpent = Order::where('user_id', $user->id)
            ->whereIn('order_status', ['completed', 'processing'])
            ->sum('total');
        
        // Get recent orders (last 5)
        $recentOrders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('account.index', compact(
            'totalOrders',
            'totalSpent',
            'recentOrders'
        ));
    }

    /**
     * Update the user account information
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate the request
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        // Update name and email
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Handle password change if provided
        if ($request->filled('current_password')) {
            // Verify current password (plain text comparison)
            if ($request->current_password !== $user->password) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.']);
            }

            // Update to new password (plain text)
            if ($request->filled('new_password')) {
                $user->password = $request->new_password;
            }
        }

        $user->save();

        return back()->with('success', 'Account updated successfully!');
    }
}