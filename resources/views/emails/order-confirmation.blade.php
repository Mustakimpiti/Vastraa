<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Artfauj</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 30px 20px;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
            text-align: center;
            border: 1px solid #c3e6cb;
        }
        .success-message h2 {
            margin: 0 0 10px 0;
            font-size: 22px;
        }
        .success-message p {
            margin: 0;
            font-size: 16px;
        }
        .order-details {
            background-color: #f9f9f9;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #4CAF50;
            border-radius: 5px;
        }
        .order-details h3 {
            margin-top: 0;
            color: #4CAF50;
            font-size: 18px;
        }
        .order-details p {
            margin: 8px 0;
        }
        
        /* Desktop Table Styles */
        .order-items {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .order-items th,
        .order-items td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .order-items th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }
        .order-items tr:hover {
            background-color: #f9f9f9;
        }
        .total-row {
            font-weight: bold;
            background-color: #f0f0f0;
        }
        .total-row td {
            font-size: 16px;
        }
        
        /* Mobile-Friendly Order Items */
        .mobile-order-items {
            display: none;
        }
        .mobile-order-item {
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .mobile-order-item-header {
            font-weight: bold;
            color: #333;
            font-size: 15px;
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e0e0e0;
        }
        .mobile-order-item-sku {
            font-size: 12px;
            color: #999;
            margin-top: 3px;
        }
        .mobile-order-item-details {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 14px;
        }
        .mobile-order-item-detail {
            text-align: center;
            flex: 1;
        }
        .mobile-order-item-detail-label {
            font-size: 11px;
            color: #999;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        .mobile-order-item-detail-value {
            font-weight: bold;
            color: #333;
        }
        .mobile-order-summary {
            background-color: white;
            border: 2px solid #4CAF50;
            border-radius: 5px;
            padding: 15px;
            margin-top: 15px;
        }
        .mobile-summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
        }
        .mobile-summary-row.total {
            border-top: 2px solid #e0e0e0;
            margin-top: 8px;
            padding-top: 12px;
            font-weight: bold;
            font-size: 16px;
            color: #4CAF50;
        }
        .mobile-summary-row.discount {
            color: #28a745;
        }
        
        .button {
            display: inline-block;
            padding: 14px 28px;
            background-color: #4CAF50;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
            text-align: center;
        }
        .button:hover {
            background-color: #45a049;
        }
        .next-steps {
            background-color: #e8f5e9;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .next-steps h3 {
            margin-top: 0;
            color: #2e7d32;
        }
        .next-steps p {
            margin: 10px 0;
            padding-left: 25px;
            position: relative;
        }
        .next-steps p:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #4CAF50;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            padding: 25px 20px;
            background-color: #f9f9f9;
            border-top: 3px solid #4CAF50;
        }
        .footer-brand {
            margin: 0 0 5px 0;
            color: #4CAF50;
            font-size: 26px;
            font-family: Georgia, serif;
            font-weight: bold;
        }
        .footer-tagline {
            margin: 0 0 20px 0;
            color: #999;
            font-size: 13px;
            font-style: italic;
        }
        .footer-contact {
            margin: 8px 0;
            font-size: 14px;
            color: #555;
        }
        .footer-contact a {
            color: #333;
            text-decoration: none;
        }
        .footer-contact a:hover {
            color: #4CAF50;
        }
        .footer-hours {
            margin: 8px 0;
            font-size: 13px;
            color: #666;
        }
        .footer-social {
            margin: 20px 0 15px 0;
        }
        .footer-social a {
            display: inline-block;
            margin: 0 5px;
            text-decoration: none;
        }
        .social-icon {
            display: inline-block;
            width: 36px;
            height: 36px;
            line-height: 36px;
            border-radius: 50%;
            text-align: center;
            font-weight: bold;
            color: white;
            font-size: 18px;
        }
        .footer-divider {
            border-top: 1px solid #e0e0e0;
            margin: 20px 0;
        }
        .footer-copyright {
            margin: 5px 0;
            font-size: 12px;
            color: #999;
        }
        .footer-thanks {
            margin: 10px 0 5px 0;
            font-size: 13px;
            color: #4CAF50;
            font-weight: bold;
        }
        .footer-links {
            margin: 10px 0 5px 0;
            font-size: 12px;
        }
        .footer-links a {
            color: #4CAF50;
            text-decoration: none;
            margin: 0 8px;
        }
        .footer-links a:hover {
            text-decoration: underline;
        }
        .footer-links span {
            color: #ccc;
        }
        .highlight {
            color: #4CAF50;
            font-weight: bold;
        }
        
        /* Mobile Styles */
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }
            .content {
                padding: 20px 15px;
            }
            .header h1 {
                font-size: 24px;
            }
            .success-message h2 {
                font-size: 20px;
            }
            
            /* Hide desktop table on mobile */
            .order-items {
                display: none;
            }
            
            /* Show mobile-friendly version */
            .mobile-order-items {
                display: block;
            }
            
            .order-details {
                padding: 15px;
            }
            .order-details h3 {
                font-size: 16px;
            }
            .button {
                padding: 12px 20px;
                font-size: 14px;
            }
            .footer-brand {
                font-size: 22px;
            }
            .social-icon {
                width: 32px;
                height: 32px;
                line-height: 32px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>✅ Thank You for Your Order!</h1>
        </div>

        <div class="content">
            <div class="success-message">
                <h2>Order Confirmed!</h2>
                <p>Hi <strong>{{ $order->first_name }}</strong>, your order has been received and is being processed.</p>
            </div>

            <div class="order-details">
                <h3>📋 Order Information</h3>
                <p><strong>Order Number:</strong> <span class="highlight">#{{ $order->order_number }}</span></p>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y h:i A') }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
            </div>

            <div class="order-details">
                <h3>🛍️ Order Items</h3>
                
                <!-- Desktop Table View -->
                <table class="order-items">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->saree_name }}</strong><br>
                                <small style="color: #666;">SKU: {{ $item->saree_sku }}</small>
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹{{ number_format($item->price, 2) }}</td>
                            <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="3" style="text-align: right;"><strong>Subtotal:</strong></td>
                            <td>₹{{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        @if($order->discount > 0)
                        <tr>
                            <td colspan="3" style="text-align: right;"><strong>Discount:</strong></td>
                            <td style="color: #28a745;">-₹{{ number_format($order->discount, 2) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="3" style="text-align: right;"><strong>Shipping:</strong></td>
                            <td>₹{{ number_format($order->shipping_cost, 2) }}</td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                            <td><strong>₹{{ number_format($order->total, 2) }}</strong></td>
                        </tr>
                    </tbody>
                </table>

                <!-- Mobile Card View -->
                <div class="mobile-order-items">
                    @foreach($order->items as $item)
                    <div class="mobile-order-item">
                        <div class="mobile-order-item-header">
                            {{ $item->saree_name }}
                            <div class="mobile-order-item-sku">SKU: {{ $item->saree_sku }}</div>
                        </div>
                        <div class="mobile-order-item-details">
                            <div class="mobile-order-item-detail">
                                <div class="mobile-order-item-detail-label">Quantity</div>
                                <div class="mobile-order-item-detail-value">{{ $item->quantity }}</div>
                            </div>
                            <div class="mobile-order-item-detail">
                                <div class="mobile-order-item-detail-label">Price</div>
                                <div class="mobile-order-item-detail-value">₹{{ number_format($item->price, 2) }}</div>
                            </div>
                            <div class="mobile-order-item-detail">
                                <div class="mobile-order-item-detail-label">Subtotal</div>
                                <div class="mobile-order-item-detail-value">₹{{ number_format($item->price * $item->quantity, 2) }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Mobile Order Summary -->
                    <div class="mobile-order-summary">
                        <div class="mobile-summary-row">
                            <span>Subtotal:</span>
                            <span>₹{{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        @if($order->discount > 0)
                        <div class="mobile-summary-row discount">
                            <span>Discount:</span>
                            <span>-₹{{ number_format($order->discount, 2) }}</span>
                        </div>
                        @endif
                        <div class="mobile-summary-row">
                            <span>Shipping:</span>
                            <span>₹{{ number_format($order->shipping_cost, 2) }}</span>
                        </div>
                        <div class="mobile-summary-row total">
                            <span>Total:</span>
                            <span>₹{{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="order-details">
                <h3>📍 Delivery Address</h3>
                <p>
                    @if($order->ship_to_different)
                        <strong>{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</strong><br>
                        {{ $order->shipping_street_address }}<br>
                        @if($order->shipping_apartment){{ $order->shipping_apartment }}<br>@endif
                        {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}<br>
                        {{ $order->shipping_country }}
                    @else
                        <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                        {{ $order->street_address }}<br>
                        @if($order->apartment){{ $order->apartment }}<br>@endif
                        {{ $order->city }}, {{ $order->state }} {{ $order->zip }}<br>
                        {{ $order->country }}<br>
                        <strong>Phone:</strong> {{ $order->phone }}
                    @endif
                </p>
            </div>

            @if($order->order_notes)
            <div class="order-details">
                <h3>📝 Order Notes</h3>
                <p>{{ $order->order_notes }}</p>
            </div>
            @endif

            <div style="text-align: center;">
                <a href="{{ route('order.success', $order->order_number) }}" class="button">View Order Details</a>
            </div>

            <div class="next-steps">
                <h3>What's Next?</h3>
                <p>We'll send you another email when your order ships</p>
                <p>You can track your order status anytime using your order number</p>
                <p>If you have any questions, please don't hesitate to contact us</p>
            </div>
        </div>

        <!-- Professional Footer -->
        <div class="footer">
            @php
                $contactSettings = \App\Models\ContactSetting::getSettings();
            @endphp
            
            <!-- Brand -->
            <h2 class="footer-brand">Artfauj</h2>
            <p class="footer-tagline">Elegant Sarees, Timeless Beauty</p>
            
            <!-- Contact Information -->
            <div class="footer-contact">
                📞 
                @if($contactSettings->phone1)
                    <a href="tel:{{ $contactSettings->phone1 }}">{{ $contactSettings->phone1 }}</a>
                @else
                    <a href="tel:+919876543210">+91 98765 43210</a>
                @endif
                @if($contactSettings->phone2)
                    <span style="color: #ccc;"> | </span>
                    <a href="tel:{{ $contactSettings->phone2 }}">{{ $contactSettings->phone2 }}</a>
                @endif
            </div>
            
            <div class="footer-contact">
                ✉️ 
                @if($contactSettings->email)
                    <a href="mailto:{{ $contactSettings->email }}">{{ $contactSettings->email }}</a>
                @else
                    <a href="mailto:info@artfauj.com">info@artfauj.com</a>
                @endif
            </div>
            
            <div class="footer-hours">
                📍 Vadodara, Gujarat, India
            </div>
            
            <div class="footer-hours">
                ⏰ Mon - Sat: 9:00 AM - 7:00 PM
            </div>

            <!-- Social Media - Facebook, Instagram, Pinterest Only -->
            <div class="footer-social">
                @if($contactSettings->facebook_url ?? false)
                    <a href="{{ $contactSettings->facebook_url }}" target="_blank" title="Facebook">
                        <span class="social-icon" style="background-color: #3b5998;">f</span>
                    </a>
                @endif
                
                @if($contactSettings->instagram_url ?? false)
                 <a href="{{ $contactSettings->instagram_url }}" target="_blank" title="Instagram">
                    <span class="social-icon" style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); display: flex; align-items: center; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="white">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </span>
                </a>
                @endif
                
                @if($contactSettings->pinterest_url ?? false)
                    <a href="{{ $contactSettings->pinterest_url }}" target="_blank" title="Pinterest">
                        <span class="social-icon" style="background-color: #E60023;">P</span>
                    </a>
                @endif
            </div>

            <!-- Divider -->
            <div class="footer-divider"></div>

            <!-- Thank You Message -->
            <p class="footer-thanks">Thank you for choosing Artfauj!</p>
            
            <!-- Links -->
            <div class="footer-links">
                <a href="{{ route('home') }}">Home</a>
                <span>|</span>
                <a href="{{ route('shop') }}">Shop</a>
                <span>|</span>
                <a href="{{ route('contact') }}">Contact</a>
            </div>
            
            <!-- Copyright -->
            <p class="footer-copyright">
                &copy; {{ date('Y') }} Artfauj. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>