<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border: 1px solid #ddd;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #333;
        }
        .company-info h1 {
            margin-bottom: 10px;
            color: #2c3e50;
        }
        .invoice-details {
            text-align: right;
        }
        .invoice-details h2 {
            margin-bottom: 10px;
        }
        .addresses {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }
        .address-block {
            flex: 1;
        }
        .address-block h3 {
            margin-bottom: 10px;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background: #f8f9fa;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #ddd;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        .text-right {
            text-align: right;
        }
        .totals {
            margin-left: auto;
            width: 300px;
        }
        .totals tr td {
            padding: 8px 12px;
        }
        .totals .grand-total {
            font-size: 1.2em;
            font-weight: bold;
            background: #f8f9fa;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-success {
            background: #28a745;
            color: white;
        }
        .badge-warning {
            background: #ffc107;
            color: #333;
        }
        .badge-info {
            background: #17a2b8;
            color: white;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Print Button -->
        <div class="no-print" style="text-align: right; margin-bottom: 20px;">
            <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">
                Print Invoice
            </button>
        </div>

        <!-- Invoice Header -->
        <div class="invoice-header">
            <div class="company-info">
                <h1>Your Company Name</h1>
                <p>123 Street Address</p>
                <p>City, State 12345</p>
                <p>Phone: (123) 456-7890</p>
                <p>Email: info@company.com</p>
            </div>
            <div class="invoice-details">
                <h2>INVOICE</h2>
                <p><strong>Order #:</strong> {{ $order->order_number }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                <p>
                    @if($order->payment_status == 'paid')
                        <span class="badge badge-success">PAID</span>
                    @elseif($order->payment_status == 'pending')
                        <span class="badge badge-warning">PENDING</span>
                    @else
                        <span class="badge badge-info">{{ strtoupper($order->payment_status) }}</span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Addresses -->
        <div class="addresses">
            <div class="address-block">
                <h3>Bill To:</h3>
                <p><strong>{{ $order->first_name }} {{ $order->last_name }}</strong></p>
                <p>{{ $order->street_address }}</p>
                @if($order->apartment)
                <p>{{ $order->apartment }}</p>
                @endif
                <p>{{ $order->city }}, {{ $order->state }} {{ $order->zip }}</p>
                <p>{{ $order->country }}</p>
                <p>{{ $order->email }}</p>
                <p>{{ $order->phone }}</p>
            </div>

            @if($order->ship_to_different)
            <div class="address-block">
                <h3>Ship To:</h3>
                <p><strong>{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</strong></p>
                <p>{{ $order->shipping_street_address }}</p>
                @if($order->shipping_apartment)
                <p>{{ $order->shipping_apartment }}</p>
                @endif
                <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
                <p>{{ $order->shipping_country }}</p>
            </div>
            @endif
        </div>

        <!-- Order Items -->
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>SKU</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->saree_name }}</strong><br>
                        <small>{{ $item->fabric }}</small>
                    </td>
                    <td>{{ $item->saree_sku }}</td>
                    <td class="text-right">₹{{ number_format($item->price, 2) }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">₹{{ number_format($item->getSubtotal(), 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <table class="totals">
            <tr>
                <td>Subtotal:</td>
                <td class="text-right">₹{{ number_format($order->subtotal, 2) }}</td>
            </tr>
            @if($order->discount > 0)
            <tr>
                <td>Discount:</td>
                <td class="text-right" style="color: #dc3545;">-₹{{ number_format($order->discount, 2) }}</td>
            </tr>
            @endif
            <tr>
                <td>Shipping:</td>
                <td class="text-right">₹{{ number_format($order->shipping_cost, 2) }}</td>
            </tr>
            <tr class="grand-total">
                <td>Grand Total:</td>
                <td class="text-right">₹{{ number_format($order->total, 2) }}</td>
            </tr>
        </table>

        <!-- Payment Info -->
        <div style="margin-bottom: 30px;">
            <h3>Payment Information</h3>
            <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
            <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
        </div>

        <!-- Order Notes -->
        @if($order->order_notes)
        <div style="margin-bottom: 30px;">
            <h3>Order Notes</h3>
            <p>{{ $order->order_notes }}</p>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>If you have any questions about this invoice, please contact us.</p>
        </div>
    </div>
</body>
</html>