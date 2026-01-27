@extends('layouts.app')

@section('title', 'Shopping Cart - Saree Shop')

@section('content')
<!--== Start Page Title Area ==-->
<section class="page-title-area bg-img" data-bg-img="{{ asset('assets/img/photos/bg-page5.jpg') }}" style="background-color: #f8f8f8; padding: 80px 0 60px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-content">
                    <h2 class="title" style="font-size: 36px; font-weight: 600; margin-bottom: 15px;">Cart</h2>
                    <div class="bread-crumbs">
                        <a href="{{ route('home') }}">Home<span class="breadcrumb-sep"> > </span></a>
                        <span class="active">Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Page Title Area ==-->

<!--== Start Shopping Cart Area ==-->
<section class="shopping-cart-area">
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($cartItems->isEmpty())
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="lastudioicon-shopping-cart-3" style="font-size: 80px; color: #ddd;"></i>
                    <h3 class="mt-4">Your cart is empty</h3>
                    <p class="text-muted">Add some beautiful sarees to your cart!</p>
                    <a href="{{ route('shop') }}" class="btn btn-theme btn-black mt-3">Continue Shopping</a>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-table-wrap">
                    <div class="cart-table table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="width-thumbnail">Image</th>
                                    <th class="width-name">Product</th>
                                    <th class="width-price">Price</th>
                                    <th class="width-quantity">Quantity</th>
                                    <th class="width-subtotal">Subtotal</th>
                                    <th class="width-remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                <tr data-cart-id="{{ $item->id }}">
                                    <td class="product-thumbnail">
                                        <a href="{{ route('product.show', $item->saree->slug) }}">
                                            @php
                                                $imageUrl = $item->saree->featured_image 
                                                    ? asset($item->saree->featured_image) 
                                                    : asset('assets/img/shop/default.jpg');
                                            @endphp
                                            <img src="{{ $imageUrl }}" alt="{{ $item->saree->name }}" width="80">
                                        </a>
                                    </td>
                                    <td class="product-name">
                                        <a href="{{ route('product.show', $item->saree->slug) }}">{{ $item->saree->name }}</a>
                                        @if($item->saree->sku)
                                        <div class="product-sku">SKU: {{ $item->saree->sku }}</div>
                                        @endif
                                        @if(!$item->saree->isInStock())
                                        <div class="text-danger small mt-1">Out of Stock</div>
                                        @elseif($item->quantity > $item->saree->stock_quantity)
                                        <div class="text-warning small mt-1">Only {{ $item->saree->stock_quantity }} left in stock</div>
                                        @endif
                                    </td>
                                    <td class="product-price">
                                        <span class="amount">₹{{ number_format((float)$item->price, 2) }}</span>
                                    </td>
                                    <td class="cart-quality">
                                        <div class="product-quality">
                                            <div class="custom-qty-wrapper">
                                                <span class="dec qtybtn" data-action="decrease" data-cart-id="{{ $item->id }}">-</span>
                                                <input type="text" 
                                                       class="quantity-input" 
                                                       value="{{ $item->quantity }}" 
                                                       data-cart-id="{{ $item->id }}"
                                                       data-max="{{ $item->saree->stock_quantity }}"
                                                       readonly>
                                                <span class="inc qtybtn" data-action="increase" data-cart-id="{{ $item->id }}">+</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="product-subtotal">
                                        <span class="amount subtotal-{{ $item->id }}">₹{{ number_format((float)$item->getSubtotal(), 2) }}</span>
                                    </td>
                                    <td class="product-remove">
                                        <form action="{{ route('cart.remove') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="cart_id" value="{{ $item->id }}">
                                            <button type="submit" class="btn-remove" onclick="return confirm('Remove this item from cart?')">
                                                <i class="lastudioicon-e-remove"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="cart-update-actions">
                    <a href="{{ route('shop') }}" class="btn btn-theme btn-light">Continue Shopping</a>
                    <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-theme btn-border" onclick="return confirm('Clear all items from cart?')">
                            Clear Cart
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="cart-totals-wrap">
                    <h3>Cart Totals</h3>
                    
                    <!-- Coupon Code Section -->
                    {{-- <div class="coupon-wrap mb-4">
                        @if(session('applied_coupon'))
                        <div class="applied-coupon">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-success">
                                    <i class="lastudioicon-check-1"></i> Coupon Applied: <strong>{{ session('applied_coupon')['code'] }}</strong>
                                </span>
                                <form action="{{ route('cart.coupon.remove') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0">Remove</button>
                                </form>
                            </div>
                        </div>
                        @else
                        <form action="{{ route('cart.coupon.apply') }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" 
                                       name="coupon_code" 
                                       class="form-control" 
                                       placeholder="Enter coupon code" 
                                       required>
                                <button type="submit" class="btn btn-theme btn-black">Apply</button>
                            </div>
                        </form>
                        @endif
                    </div> --}}

                    <!-- Cart Totals -->
                    <div class="cart-calculate-items">
                        <div class="cart-calculate-item">
                            <div class="cart-calculate-item-left">
                                <span>Subtotal</span>
                            </div>
                            <div class="cart-calculate-item-right">
                                <span id="cart-subtotal">₹{{ number_format((float)$subtotal, 2) }}</span>
                            </div>
                        </div>

                        @if(session('applied_coupon'))
                        <div class="cart-calculate-item">
                            <div class="cart-calculate-item-left">
                                <span class="text-success">Discount</span>
                            </div>
                            <div class="cart-calculate-item-right">
                                <span class="text-success">-₹{{ number_format((float)session('applied_coupon')['discount'], 2) }}</span>
                            </div>
                        </div>
                        @endif

                        <div class="cart-calculate-item">
                            <div class="cart-calculate-item-left">
                                <span>Shipping</span>
                            </div>
                            <div class="cart-calculate-item-right">
                                <span id="cart-shipping">
                                    @if($shippingCost == 0)
                                        <span class="text-success">Free</span>
                                    @else
                                        ₹{{ number_format((float)$shippingCost, 2) }}
                                    @endif
                                </span>
                            </div>
                        </div>

                        @if($subtotal < 2000 && $shippingCost > 0)
                        <div class="shipping-notice">
                            <small class="text-muted">
                                <i class="lastudioicon-information"></i> 
                                Spend ₹{{ number_format((float)(2000 - $subtotal), 2) }} more for free shipping!
                            </small>
                        </div>
                        @endif

                        <div class="cart-calculate-item cart-calculate-total">
                            <div class="cart-calculate-item-left">
                                <span>Total</span>
                            </div>
                            <div class="cart-calculate-item-right">
                                <span id="cart-total">₹{{ number_format((float)($total - (session('applied_coupon')['discount'] ?? 0)), 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('checkout') }}" class="btn btn-theme btn-black btn-block">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
<!--== End Shopping Cart Area ==-->
<!--== Start Divider Area Wrapper ==-->
    <section class="divider-area bg-overlay4 bg-img" data-bg-img="assets/img/photos/bg-d7.jpg">
      <div class="container">
        <div class="row">
          <div class="col-md-8 m-auto">
            <div class="divider-content divider-content-style5">
              <h2>HOT TREND</h2>
              <a href="{{ route('shop') }}" class="btn-theme btn-border">shop now</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End Divider Area Wrapper ==-->

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle quantity increase/decrease
    document.querySelectorAll('.qtybtn').forEach(button => {
        button.addEventListener('click', function() {
            const cartId = this.dataset.cartId;
            const action = this.dataset.action;
            const input = document.querySelector(`.quantity-input[data-cart-id="${cartId}"]`);
            const max = parseInt(input.dataset.max);
            let currentValue = parseInt(input.value);
            
            if (action === 'increase' && currentValue < max) {
                currentValue++;
            } else if (action === 'decrease' && currentValue > 1) {
                currentValue--;
            } else {
                if (action === 'increase') {
                    alert('Maximum stock limit reached!');
                }
                return;
            }
            
            input.value = currentValue;
            updateCartQuantity(cartId, currentValue);
        });
    });
    
    function updateCartQuantity(cartId, quantity) {
        // Show loading state
        const row = document.querySelector(`tr[data-cart-id="${cartId}"]`);
        row.style.opacity = '0.6';
        
        fetch('{{ route("cart.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                cart_id: cartId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update item subtotal
                document.querySelector(`.subtotal-${cartId}`).textContent = '₹' + data.itemSubtotal;
                
                // Update cart totals
                document.getElementById('cart-subtotal').textContent = '₹' + data.subtotal;
                document.getElementById('cart-shipping').innerHTML = data.shipping === '0.00' 
                    ? '<span class="text-success">Free</span>' 
                    : '₹' + data.shipping;
                document.getElementById('cart-total').textContent = '₹' + data.total;
                
                // Show success message
                showNotification('Cart updated successfully!', 'success');
            } else {
                showNotification(data.message, 'error');
                location.reload();
            }
            row.style.opacity = '1';
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to update cart. Please try again.', 'error');
            row.style.opacity = '1';
            location.reload();
        });
    }
    
    function showNotification(message, type) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
                 role="alert" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        document.body.insertAdjacentHTML('beforeend', alertHtml);
        
        // Auto dismiss after 3 seconds
        setTimeout(() => {
            const alert = document.querySelector('.position-fixed.alert');
            if (alert) {
                alert.remove();
            }
        }, 3000);
    }
});
</script>
@endpush

@endsection

<style>
.shopping-cart-area {
    padding: 80px 0;
}

.cart-table-wrap {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 30px;
}

.cart-table table {
    margin-bottom: 0;
}

.cart-table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 14px;
    padding: 15px 10px;
    border-top: none;
}

.cart-table td {
    vertical-align: middle;
    padding: 20px 10px;
}

.product-name a {
    color: #333;
    font-weight: 500;
    text-decoration: none;
}

.product-name a:hover {
    color: #d4af37;
}

.product-sku {
    font-size: 12px;
    color: #999;
    margin-top: 5px;
}

.product-price .amount {
    font-weight: 600;
    color: #333;
}

/* Custom Quantity Wrapper - Changed from .pro-qty */
.custom-qty-wrapper {
    display: flex;
    align-items: center;
    border: 1px solid #e5e5e5;
    border-radius: 4px;
    overflow: hidden;
    max-width: 120px;
}

.custom-qty-wrapper span.qtybtn {
    width: 35px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f8f8;
    cursor: pointer;
    user-select: none;
    transition: all 0.3s;
}

.custom-qty-wrapper span.qtybtn:hover {
    background: #d4af37;
    color: #fff;
}

.custom-qty-wrapper input {
    width: 50px;
    height: 40px;
    text-align: center;
    border: none;
    font-weight: 600;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

/* Hide any browser default number input controls */
.custom-qty-wrapper input::-webkit-outer-spin-button,
.custom-qty-wrapper input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    display: none !important;
}

.custom-qty-wrapper input[type=number] {
    -moz-appearance: textfield;
}

.btn-remove {
    background: none;
    border: none;
    color: #999;
    font-size: 20px;
    cursor: pointer;
    transition: color 0.3s;
}

.btn-remove:hover {
    color: #dc3545;
}

.cart-update-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.cart-totals-wrap {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    position: sticky;
    top: 100px;
}

.cart-totals-wrap h3 {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.cart-calculate-items {
    margin-bottom: 25px;
}

.cart-calculate-item {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
}

.cart-calculate-total {
    border-top: 2px solid #333;
    border-bottom: 2px solid #333;
    font-weight: 600;
    font-size: 18px;
    margin-top: 10px;
}

.shipping-notice {
    padding: 10px;
    background: #f8f9fa;
    border-radius: 4px;
    margin-top: 10px;
}

.coupon-wrap {
    padding-bottom: 20px;
    border-bottom: 1px solid #f0f0f0;
}

.applied-coupon {
    padding: 10px;
    background: #d4edda;
    border-radius: 4px;
}

.btn-block {
    width: 100%;
    padding: 15px;
    font-size: 16px;
    font-weight: 600;
}

@media (max-width: 991px) {
    .cart-totals-wrap {
        position: static;
        margin-top: 30px;
    }
}

@media (max-width: 767px) {
    .cart-table-wrap {
        padding: 15px;
        overflow-x: auto;
    }
    
    .cart-update-actions {
        flex-direction: column;
        gap: 10px;
    }
    
    .cart-update-actions .btn {
        width: 100%;
    }
}
</style>