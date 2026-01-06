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

    <!--== Start Featured Area Wrapper ==-->
    <section class="featured-area featured-style3-area">
      <div class="container">
        <div class="row featured-style3">
          <div class="col-sm-6 col-md-4">
            <div class="featured-item">
              <div class="content">
                <span class="icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="76" height="46" fill="none" viewBox="0 0 76 46"><path fill="currentColor" d="M74.757 45.702H1.243a1.08 1.08 0 0 1-1.08-1.08V33.593a1.081 1.081 0 0 1 .864-1.06 9.73 9.73 0 0 0 0-19.07 1.081 1.081 0 0 1-.865-1.059V1.378A1.081 1.081 0 0 1 1.243.297h73.514a1.08 1.08 0 0 1 1.08 1.081v11.027a1.082 1.082 0 0 1-.864 1.06 9.73 9.73 0 0 0 0 19.07 1.081 1.081 0 0 1 .865 1.06V44.62a1.08 1.08 0 0 1-1.081 1.081zM2.324 43.54h71.352v-9.097a11.892 11.892 0 0 1 0-22.887V2.46H2.324v9.097a11.892 11.892 0 0 1 0 22.887v9.097z"></path><path fill="currentColor" d="M54.216 6.39a1.081 1.081 0 0 1-1.08-1.081V1.378a1.081 1.081 0 0 1 2.161 0v3.93a1.081 1.081 0 0 1-1.08 1.082zm0 9.828a1.08 1.08 0 0 1-1.08-1.08v-3.932a1.081 1.081 0 0 1 2.161 0v3.931a1.081 1.081 0 0 1-1.08 1.081zm0 9.828a1.08 1.08 0 0 1-1.08-1.081v-3.93a1.081 1.081 0 0 1 2.161 0v3.931a1.081 1.081 0 0 1-1.08 1.08zm0 9.828a1.08 1.08 0 0 1-1.08-1.08v-3.931a1.082 1.082 0 0 1 2.161 0v3.93a1.081 1.081 0 0 1-1.08 1.081zm0 9.828a1.08 1.08 0 0 1-1.08-1.08V40.69a1.082 1.082 0 0 1 2.161 0v3.931a1.081 1.081 0 0 1-1.08 1.081zm-33.59-11.305a1.081 1.081 0 0 1-.764-1.846l20.034-20.045a1.082 1.082 0 1 1 1.529 1.529L21.39 34.08a1.082 1.082 0 0 1-.764.316zm16.704.516a4.993 4.993 0 1 1 4.994-4.994 5 5 0 0 1-4.993 4.994zm0-7.826a2.832 2.832 0 1 0 .001 5.663 2.832 2.832 0 0 0 0-5.663zm-13.796-6.079a4.994 4.994 0 1 1 4.994-4.995 5 5 0 0 1-4.994 4.995zm0-7.826a2.832 2.832 0 1 0 0 5.663 2.832 2.832 0 0 0 0-5.663z"></path></svg>       </span>
                <div class="inner-content">
                <h4 class="title">NEW DISCOUNT</h4>
                <p>Save up to 40% on your first order! Exclusive deals that make premium quality affordable.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-4">
            <div class="featured-item mt-xs-30">
              <div class="content">
                <span class="icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="76" height="72" fill="none" viewBox="0 0 76 72"><path fill="currentColor" d="M64.733 71.123H11.267a4.432 4.432 0 0 1-4.422-4.42V31.614a1.081 1.081 0 0 1 1.081-1.08h60.147a1.081 1.081 0 0 1 1.082 1.08v35.089a4.432 4.432 0 0 1-4.422 4.42zM9.008 32.695v34.008a2.263 2.263 0 0 0 2.26 2.26h53.465a2.262 2.262 0 0 0 2.26-2.26V32.695H9.007z"></path><path fill="currentColor" d="M73.085 32.695H2.915a2.755 2.755 0 0 1-2.753-2.749v-8.357a2.755 2.755 0 0 1 2.753-2.751h70.17a2.755 2.755 0 0 1 2.753 2.751v8.357a2.755 2.755 0 0 1-2.753 2.75zM2.915 21a.59.59 0 0 0-.59.59v8.356a.59.59 0 0 0 .59.59h70.17a.59.59 0 0 0 .59-.59v-8.357a.59.59 0 0 0-.59-.589H2.915z"></path><path fill="currentColor" d="M40.23 21a1.081 1.081 0 0 1-1.032-1.404c1.336-4.276 3.732-10.054 7.554-13.333A7.946 7.946 0 0 1 57.08 18.34a17.38 17.38 0 0 1-4.117 2.558 1.082 1.082 0 0 1-1.267-1.718c.102-.104.224-.186.36-.242a15.29 15.29 0 0 0 3.614-2.235 5.782 5.782 0 1 0-7.507-8.796C44.55 11 42.29 16.963 41.265 20.242A1.081 1.081 0 0 1 40.23 21z"></path><path fill="currentColor" d="M40.23 21a1.08 1.08 0 0 1-1.031-.757c-1.281-4.094-4.108-11.54-8.636-15.42a7.433 7.433 0 0 0-9.66 11.3 19.242 19.242 0 0 0 4.55 2.816 1.08 1.08 0 1 1-.908 1.962 21.321 21.321 0 0 1-5.052-3.136A9.597 9.597 0 0 1 31.968 3.178c4.695 4.02 7.645 11.147 9.297 16.419A1.081 1.081 0 0 1 40.23 21zm3.932 50.123H31.838a1.081 1.081 0 0 1-1.081-1.08v-38.43a1.081 1.081 0 0 1 1.08-1.08h12.325a1.081 1.081 0 0 1 1.081 1.08v38.428a1.081 1.081 0 0 1-1.08 1.081zM32.92 68.961h10.16V32.695H32.92v36.266z"></path></svg></span>
                <div class="inner-content">
                <h4 class="title">GIFT VOUCHERS</h4>
                <p>Surprise someone special with the perfect gift. Digital vouchers delivered instantly to their inbox.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-4">
            <div class="featured-item mt-sm-30">
              <div class="content">
                <span class="icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="76" height="74" fill="none" viewBox="0 0 76 74"><path fill="currentColor" d="M74.757 73.649H1.243a1.08 1.08 0 0 1-1.08-1.081V20.4a1.081 1.081 0 0 1 1.08-1.081h73.514a1.08 1.08 0 0 1 1.08 1.081v52.168a1.08 1.08 0 0 1-1.08 1.08zM2.324 71.487h71.352V21.48H2.324v50.006z"></path><path fill="currentColor" d="M74.757 21.481H1.243a1.08 1.08 0 0 1-.865-1.73L14.607.785a1.081 1.081 0 0 1 .864-.432H60.53a1.081 1.081 0 0 1 .865.432l14.228 18.968a1.081 1.081 0 0 1-.865 1.73zM3.405 19.32h69.19L59.988 2.514H16.012L3.405 19.319z"></path><path fill="currentColor" d="M47.19 21.481H28.81a1.082 1.082 0 0 1-1.059-1.297l3.784-18.968a1.08 1.08 0 0 1 1.06-.864h10.81a1.08 1.08 0 0 1 1.06.864l3.784 18.971a1.08 1.08 0 0 1-1.06 1.297v-.003zM30.128 19.32H45.87L42.52 2.514h-9.038L30.13 19.319z"></path><path fill="currentColor" d="M47.19 41.848a1.08 1.08 0 0 1-.685-.245L38 34.653l-8.505 6.95a1.08 1.08 0 0 1-1.765-.836V20.4a1.08 1.08 0 0 1 1.08-1.081h18.38a1.08 1.08 0 0 1 1.08 1.081v20.367a1.08 1.08 0 0 1-1.08 1.08zM38 32.176c.25 0 .491.087.684.245l7.424 6.066V21.48H29.892v17.006l7.424-6.067a1.08 1.08 0 0 1 .684-.244z"></path></svg></span>
                <div class="inner-content">
                <h4 class="title">FREE DELIVERY</h4>
                <p>Enjoy complimentary shipping on orders over ₹2000. Fast, reliable delivery straight to your door.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--== End Featured Area Wrapper ==-->

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