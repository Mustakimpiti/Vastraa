@extends('layouts.app')

@section('title', 'Checkout - Saree Shop')

@section('content')
<!--== Start Page Title Area ==-->
<section class="page-title-area bg-img" data-bg-img="{{ asset('assets/img/photos/bg-page1.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-content">
                    <h2 class="title">Checkout</h2>
                    <div class="bread-crumbs">
                        <a href="{{ route('home') }}">Home<span class="breadcrumb-sep">></span></a>
                        <span class="active">Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Page Title Area ==-->

<!--== Start Shop Checkout Area ==-->
<section class="shop-checkout-area">
    <div class="container">
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row">
            @guest
            <div class="col-md-12">
                <div class="shop-return-login" id="returnloginAccordion">
                    <div class="card">
                        <h6>Returning customer? <span data-bs-toggle="collapse" data-bs-target="#returnloginaccordion"> Click here to login</span></h6>
                        <div id="returnloginaccordion" class="collapse" data-bs-parent="#returnloginAccordion">
                            <div class="card-body">
                                <p>If you have shopped with us before, please enter your details in the boxes below. If you are a new customer, please proceed to the Billing & Shipping section.</p>
                                <form action="{{ route('login') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="rl_username">Username or email <span class="required">*</span></label>
                                        <input class="form-control" id="rl_username" name="email" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="rl_password">Password <span class="required">*</span></label>
                                        <input class="form-control" id="rl_password" name="password" type="password" required>
                                    </div>
                                    <button class="btn btn-coupon w-100" type="submit">Login</button>
                                    <div class="remember-lostpassword">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="RadioRememberMe" name="remember">
                                            <label class="custom-control-label ps-1" for="RadioRememberMe">Remember me</label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endguest

            <div class="col-md-12">
                <div class="shop-checkout-coupon" id="checkoutloginAccordion">
                    <div class="card">
                        <h6>Have a coupon? <span data-bs-toggle="collapse" data-bs-target="#couponaccordion"> Click here to enter your code</span></h6>
                        <div id="couponaccordion" class="collapse {{ $couponCode ? 'show' : '' }}" data-bs-parent="#checkoutloginAccordion">
                            <div class="card-body">
                                @if($couponCode)
                                <div class="alert alert-success">
                                    Coupon code <strong>{{ $couponCode }}</strong> applied successfully! You saved ₹{{ number_format($discount, 2) }}
                                    <form action="{{ route('cart.coupon.remove') }}" method="post" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0">Remove</button>
                                    </form>
                                </div>
                                @else
                                <p>If you have a coupon code, please apply it below.</p>
                                <form action="{{ route('cart.coupon.apply') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="coupon_code" placeholder="Enter Your Coupon Code" required>
                                    </div>
                                    <button class="btn btn-coupon" type="submit">Apply Coupon</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="shop-billing-form">
                    <form action="{{ route('checkout.process') }}" method="post" id="checkout-form">
                        @csrf
                        <h4 class="title">Billing details</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cf_name">First name <abbr class="required" title="required">*</abbr></label>
                                    <input class="form-control" id="cf_name" name="first_name" type="text" value="{{ old('first_name', Auth::user()->name ?? '') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cf_last_name">Last name <abbr class="required" title="required">*</abbr></label>
                                    <input class="form-control" id="cf_last_name" name="last_name" type="text" value="{{ old('last_name') }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cf_country_region">Country / Region <abbr class="required" title="required">*</abbr></label>
                            <select class="form-control niceselect" id="cf_country_region" name="country" required>
                                <option value="India" {{ old('country', 'India') == 'India' ? 'selected' : '' }}>India</option>
                                <option value="United States" {{ old('country') == 'United States' ? 'selected' : '' }}>United States (US)</option>
                                <option value="United Kingdom" {{ old('country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom (UK)</option>
                                <option value="Bangladesh" {{ old('country') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                <option value="Pakistan" {{ old('country') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="cf_street_address">Street address <abbr class="required" title="required">*</abbr></label>
                            <input class="form-control" id="cf_street_address" name="street_address" type="text" placeholder="House number and street name" value="{{ old('street_address') }}" required>
                        </div>

                        <div class="form-group">
                            <input class="form-control" name="apartment" type="text" placeholder="Apartment, suite, unit, etc. (optional)" value="{{ old('apartment') }}">
                        </div>

                        <div class="form-group">
                            <label for="cf_town_city">Town / City <abbr class="required" title="required">*</abbr></label>
                            <input class="form-control" id="cf_town_city" name="city" type="text" value="{{ old('city') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="cf_state_region">State <abbr class="required" title="required">*</abbr></label>
                            <select class="form-control niceselect" id="cf_state_region" name="state" required>
                                <option value="">Select State</option>
                                <option value="Andhra Pradesh" {{ old('state') == 'Andhra Pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
                                <option value="Arunachal Pradesh" {{ old('state') == 'Arunachal Pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>
                                <option value="Assam" {{ old('state') == 'Assam' ? 'selected' : '' }}>Assam</option>
                                <option value="Bihar" {{ old('state') == 'Bihar' ? 'selected' : '' }}>Bihar</option>
                                <option value="Chhattisgarh" {{ old('state') == 'Chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
                                <option value="Goa" {{ old('state') == 'Goa' ? 'selected' : '' }}>Goa</option>
                                <option value="Gujarat" {{ old('state') == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                                <option value="Haryana" {{ old('state') == 'Haryana' ? 'selected' : '' }}>Haryana</option>
                                <option value="Himachal Pradesh" {{ old('state') == 'Himachal Pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
                                <option value="Jharkhand" {{ old('state') == 'Jharkhand' ? 'selected' : '' }}>Jharkhand</option>
                                <option value="Karnataka" {{ old('state') == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                                <option value="Kerala" {{ old('state') == 'Kerala' ? 'selected' : '' }}>Kerala</option>
                                <option value="Madhya Pradesh" {{ old('state') == 'Madhya Pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
                                <option value="Maharashtra" {{ old('state') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                                <option value="Manipur" {{ old('state') == 'Manipur' ? 'selected' : '' }}>Manipur</option>
                                <option value="Meghalaya" {{ old('state') == 'Meghalaya' ? 'selected' : '' }}>Meghalaya</option>
                                <option value="Mizoram" {{ old('state') == 'Mizoram' ? 'selected' : '' }}>Mizoram</option>
                                <option value="Nagaland" {{ old('state') == 'Nagaland' ? 'selected' : '' }}>Nagaland</option>
                                <option value="Odisha" {{ old('state') == 'Odisha' ? 'selected' : '' }}>Odisha</option>
                                <option value="Punjab" {{ old('state') == 'Punjab' ? 'selected' : '' }}>Punjab</option>
                                <option value="Rajasthan" {{ old('state') == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                                <option value="Sikkim" {{ old('state') == 'Sikkim' ? 'selected' : '' }}>Sikkim</option>
                                <option value="Tamil Nadu" {{ old('state') == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu</option>
                                <option value="Telangana" {{ old('state') == 'Telangana' ? 'selected' : '' }}>Telangana</option>
                                <option value="Tripura" {{ old('state') == 'Tripura' ? 'selected' : '' }}>Tripura</option>
                                <option value="Uttar Pradesh" {{ old('state') == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                                <option value="Uttarakhand" {{ old('state') == 'Uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>
                                <option value="West Bengal" {{ old('state') == 'West Bengal' ? 'selected' : '' }}>West Bengal</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="cf_zip">ZIP <abbr class="required" title="required">*</abbr></label>
                            <input class="form-control" id="cf_zip" name="zip" type="text" value="{{ old('zip') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="cf_phone">Phone <abbr class="required" title="required">*</abbr></label>
                            <input class="form-control" id="cf_phone" name="phone" type="text" value="{{ old('phone') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="cf_email">Email address <abbr class="required" title="required">*</abbr></label>
                            <input class="form-control" id="cf_email" name="email" type="email" value="{{ old('email', Auth::user()->email ?? '') }}" required>
                        </div>

                        <div class="checkout-box-wrap ship-different-address">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" 
                                    class="custom-control-input" 
                                    id="ship_to_different" 
                                    name="ship_to_different" 
                                    value="1" 
                                    {{ old('ship_to_different') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="ship_to_different">
                                    Ship to a different address?
                                </label>
                            </div>
                        </div>
                            <div class="ship-to-different single-form-row">
                                <div class="form-group">
                                    <label for="cf_name_2">First name <abbr class="required" title="required">*</abbr></label>
                                    <input class="form-control shipping-field" id="cf_name_2" name="shipping_first_name" type="text" value="{{ old('shipping_first_name') }}">
                                </div>

                                <div class="form-group">
                                    <label for="cf_last_name_2">Last name <abbr class="required" title="required">*</abbr></label>
                                    <input class="form-control shipping-field" id="cf_last_name_2" name="shipping_last_name" type="text" value="{{ old('shipping_last_name') }}">
                                </div>

                                <div class="form-group">
                                    <label for="cf_country_region_2">Country / Region <abbr class="required" title="required">*</abbr></label>
                                    <select class="form-control niceselect shipping-field" id="cf_country_region_2" name="shipping_country">
                                        <option value="India" {{ old('shipping_country', 'India') == 'India' ? 'selected' : '' }}>India</option>
                                        <option value="United States" {{ old('shipping_country') == 'United States' ? 'selected' : '' }}>United States (US)</option>
                                        <option value="United Kingdom" {{ old('shipping_country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom (UK)</option>
                                        <option value="Bangladesh" {{ old('shipping_country') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                        <option value="Pakistan" {{ old('shipping_country') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="cf_street_address_2">Street address <abbr class="required" title="required">*</abbr></label>
                                    <input class="form-control shipping-field" id="cf_street_address_2" name="shipping_street_address" type="text" placeholder="House number and street name" value="{{ old('shipping_street_address') }}">
                                </div>

                                <div class="form-group">
                                    <input class="form-control" name="shipping_apartment" type="text" placeholder="Apartment, suite, unit, etc. (optional)" value="{{ old('shipping_apartment') }}">
                                </div>

                                <div class="form-group">
                                    <label for="cf_town_city_2">Town / City <abbr class="required" title="required">*</abbr></label>
                                    <input class="form-control shipping-field" id="cf_town_city_2" name="shipping_city" type="text" value="{{ old('shipping_city') }}">
                                </div>

                                <div class="form-group">
                                    <label for="cf_state_region_2">State <abbr class="required" title="required">*</abbr></label>
                                    <select class="form-control niceselect shipping-field" id="cf_state_region_2" name="shipping_state">
                                        <option value="">Select State</option>
                                        <option value="Maharashtra" {{ old('shipping_state') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                                        <option value="Karnataka" {{ old('shipping_state') == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                                        <option value="Tamil Nadu" {{ old('shipping_state') == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu</option>
                                        <option value="West Bengal" {{ old('shipping_state') == 'West Bengal' ? 'selected' : '' }}>West Bengal</option>
                                        <option value="Gujarat" {{ old('shipping_state') == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                                        <option value="Rajasthan" {{ old('shipping_state') == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="cf_zip_2">ZIP <abbr class="required" title="required">*</abbr></label>
                                    <input class="form-control shipping-field" id="cf_zip_2" name="shipping_zip" type="text" value="{{ old('shipping_zip') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cf_order_notes">Order notes (optional)</label>
                            <textarea class="form-control" name="order_notes" id="cf_order_notes" placeholder="Notes about your order, e.g. special notes for delivery.">{{ old('order_notes') }}</textarea>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <h4 class="title">Your order</h4>
                <div class="order-review-details">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            <tr>
                                <td>
                                    <span class="product-title">{{ $item->saree->name }}</span>
                                    <span class="product-quantity"> × {{ $item->quantity }}</span>
                                </td>
                                <td>₹{{ number_format($item->getSubtotal(), 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="cart-subtotal">
                                <th>Subtotal</th>
                                <td>₹{{ number_format($subtotal, 2) }}</td>
                            </tr>
                            @if($discount > 0)
                            <tr class="cart-discount">
                                <th>Discount</th>
                                <td class="text-success">-₹{{ number_format($discount, 2) }}</td>
                            </tr>
                            @endif
                            <tr class="shipping">
                                <th class="shipping-title">Shipping</th>
                                <td class="shipping-check">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="validationFormCheck2" name="shipping_method" value="flat_rate" form="checkout-form" checked required>
                                        <label class="form-check-label" for="validationFormCheck2">Flat rate: <span>₹{{ number_format($shippingCost, 2) }}</span></label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="validationFormCheck3" name="shipping_method" value="local_pickup" form="checkout-form" required>
                                        <label class="form-check-label" for="validationFormCheck3">Local pickup</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="final-total">
                                <th>Total</th>
                                <td><span class="total-amount">₹{{ number_format($total, 2) }}</span></td>
                            </tr>
                        </tfoot>
                    </table>
<div class="shop-payment-method">
    <div id="accordion">
        <!-- Direct Bank Transfer -->
        <div class="card payment-card">
            <div class="card-header" id="direct_bank_transfer" data-payment="payment_bank">
                <h5 class="mb-0">
                    <div class="payment-option" data-bs-toggle="collapse" data-bs-target="#itemOne" aria-expanded="false" aria-controls="itemOne">
                        <div class="radio-wrapper">
                            <input type="radio" id="payment_bank" name="payment_method" value="bank_transfer" form="checkout-form" {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }} required>
                            <label for="payment_bank" class="payment-label">
                                <span class="payment-title">Direct Bank Transfer</span>
                            </label>
                        </div>
                        <span class="collapse-icon">▼</span>
                    </div>
                </h5>
            </div>
            <div id="itemOne" class="collapse" aria-labelledby="direct_bank_transfer" data-bs-parent="#accordion">
                <div class="card-body">
                    <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.</p>
                </div>
            </div>
        </div>

        <!-- Check Payments -->
        <div class="card payment-card">
            <div class="card-header" id="check_payments" data-payment="payment_check">
                <h5 class="mb-0">
                    <div class="payment-option" data-bs-toggle="collapse" data-bs-target="#itemTwo" aria-expanded="false" aria-controls="itemTwo">
                        <div class="radio-wrapper">
                            <input type="radio" id="payment_check" name="payment_method" value="check" form="checkout-form" {{ old('payment_method') == 'check' ? 'checked' : '' }} required>
                            <label for="payment_check" class="payment-label">
                                <span class="payment-title">Check Payments</span>
                            </label>
                        </div>
                        <span class="collapse-icon">▼</span>
                    </div>
                </h5>
            </div>
            <div id="itemTwo" class="collapse" aria-labelledby="check_payments" data-bs-parent="#accordion">
                <div class="card-body">
                    <p>Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
                </div>
            </div>
        </div>

        <!-- Cash on Delivery -->
        <div class="card payment-card">
            <div class="card-header" id="cash_on_delivery" data-payment="payment_cod">
                <h5 class="mb-0">
                    <div class="payment-option" data-bs-toggle="collapse" data-bs-target="#itemThree" aria-expanded="false" aria-controls="itemThree">
                        <div class="radio-wrapper">
                            <input type="radio" id="payment_cod" name="payment_method" value="cod" form="checkout-form" {{ old('payment_method') == 'cod' ? 'checked' : '' }} required>
                            <label for="payment_cod" class="payment-label">
                                <span class="payment-title">Cash on Delivery</span>
                            </label>
                        </div>
                        <span class="collapse-icon">▼</span>
                    </div>
                </h5>
            </div>
            <div id="itemThree" class="collapse" aria-labelledby="cash_on_delivery" data-bs-parent="#accordion">
                <div class="card-body">
                    <p>Pay with cash upon delivery.</p>
                </div>
            </div>
        </div>

        <!-- PayPal -->
        <div class="card payment-card">
            <div class="card-header" id="Pay_Pal" data-payment="payment_paypal">
                <h5 class="mb-0">
                    <div class="payment-option" data-bs-toggle="collapse" data-bs-target="#item4" aria-expanded="false" aria-controls="item4">
                        <div class="radio-wrapper">
                            <input type="radio" id="payment_paypal" name="payment_method" value="paypal" form="checkout-form" {{ old('payment_method') == 'paypal' ? 'checked' : '' }} required>
                            <label for="payment_paypal" class="payment-label">
                                <span class="payment-icon">
                                    <img src="{{ asset('assets/img/icons/paypal.png') }}" alt="PayPal" style="height: 24px;">
                                </span>
                                <span class="payment-title">PayPal</span>
                                <a href="#/" class="info-link">What is PayPal?</a>
                            </label>
                        </div>
                        <span class="collapse-icon">▼</span>
                    </div>
                </h5>
            </div>
            <div id="item4" class="collapse" aria-labelledby="Pay_Pal" data-bs-parent="#accordion">
                <div class="card-body">
                    <p>Pay via PayPal; you can pay with your credit card if you don't have a PayPal account.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.shop-payment-method {
    margin-top: 25px;
}

.payment-card {
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    margin-bottom: 12px;
    transition: all 0.3s ease;
    background: #ffffff;
    overflow: hidden;
}

.payment-card:hover {
    border-color: #d1d5db;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.payment-card.selected {
    border-color: #3b82f6;
    background: #eff6ff;
}

.payment-card .card-header {
    background: transparent;
    border: none;
    padding: 0;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.payment-card .card-header:hover {
    background: #f9fafb;
}

.payment-card.selected .card-header {
    background: #dbeafe;
}

.payment-option {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 20px;
    width: 100%;
}

.radio-wrapper {
    display: flex;
    align-items: center;
    flex: 1;
    gap: 12px;
}

.radio-wrapper input[type="radio"] {
    width: 20px;
    height: 20px;
    cursor: pointer;
    margin: 0;
    accent-color: #3b82f6;
}

.payment-label {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    margin: 0;
    font-weight: 500;
    color: #1f2937;
    flex: 1;
}

.payment-icon {
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.payment-title {
    font-size: 16px;
    font-weight: 600;
}

.info-link {
    font-size: 13px;
    color: #3b82f6;
    text-decoration: none;
    margin-left: 8px;
    font-weight: 400;
}

.info-link:hover {
    text-decoration: underline;
}

.collapse-icon {
    color: #6b7280;
    font-size: 12px;
    transition: transform 0.3s ease;
    margin-right: 5px;
}

.payment-option[aria-expanded="true"] .collapse-icon {
    transform: rotate(180deg);
}

.payment-card .card-body {
    padding: 15px 20px 20px 52px;
    background: #f9fafb;
    border-top: 1px solid #e5e7eb;
}

.payment-card .card-body p {
    margin: 0;
    color: #6b7280;
    font-size: 14px;
    line-height: 1.6;
}

/* Responsive Design */
@media (max-width: 768px) {
    .payment-option {
        padding: 15px;
    }
    
    .payment-title {
        font-size: 15px;
    }
    
    .payment-card .card-body {
        padding: 12px 15px 15px 45px;
    }
    
    .info-link {
        display: block;
        margin-left: 0;
        margin-top: 4px;
    }
}

/* Animation for selection */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.8;
    }
}

.payment-card.selected {
    animation: pulse 0.3s ease-in-out;
}
</style>
                </div>
                <p class="shop-checkout-info">Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our privacy policy.</p>
                <button class="btn place-order-btn" type="submit" form="checkout-form">Place order</button>
            </div>
        </div>
    </div>
</section>
<!--== End Shop Checkout Area ==-->

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const shipToDifferentCheckbox = document.getElementById('ship_to_different');
    const shippingFields = document.querySelector('.ship-to-different .single-form-row');
    const shippingInputs = document.querySelectorAll('.shipping-field');

    // Initial state for shipping
    if (!shipToDifferentCheckbox.checked) {
        shippingFields.style.display = 'none';
        shippingInputs.forEach(input => {
            input.removeAttribute('required');
        });
    }

    if (shipToDifferentCheckbox) {
        shipToDifferentCheckbox.addEventListener('change', function() {
            if (this.checked) {
                shippingFields.style.display = 'block';
                shippingInputs.forEach(input => {
                    input.setAttribute('required', 'required');
                });
            } else {
                shippingFields.style.display = 'none';
                shippingInputs.forEach(input => {
                    input.removeAttribute('required');
                });
            }
        });
    }

    // Payment method selection
    const paymentHeaders = document.querySelectorAll('#accordion .card-header');
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
    
    // Add visual feedback class
    function updatePaymentSelection() {
        paymentHeaders.forEach(header => {
            header.classList.remove('selected');
        });
        
        const selectedRadio = document.querySelector('input[name="payment_method"]:checked');
        if (selectedRadio) {
            const selectedHeader = document.querySelector(`[data-payment="${selectedRadio.id}"]`);
            if (selectedHeader) {
                selectedHeader.classList.add('selected');
            }
        }
    }
    
    paymentHeaders.forEach(header => {
        header.addEventListener('click', function(e) {
            // Don't trigger if clicking on a link
            if (e.target.tagName === 'A') return;
            
            const paymentId = this.getAttribute('data-payment');
            const radio = document.getElementById(paymentId);
            
            if (radio) {
                // Uncheck all radio buttons first
                paymentRadios.forEach(r => {
                    r.checked = false;
                });
                
                // Select the radio button
                radio.checked = true;
                
                // Trigger change event to ensure form recognizes it
                radio.dispatchEvent(new Event('change', { bubbles: true }));
                
                updatePaymentSelection();
                
                console.log('Payment method selected:', radio.value);
            }
        });
    });

    // Update visual selection on load
    updatePaymentSelection();

    // Form submission validation
    const checkoutForm = document.getElementById('checkout-form');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
            
            if (!selectedPayment) {
                e.preventDefault();
                e.stopPropagation();
                alert('Please select a payment method');
                
                // Scroll to payment section
                const paymentSection = document.querySelector('.shop-payment-method');
                if (paymentSection) {
                    paymentSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    paymentSection.style.border = '2px solid red';
                    setTimeout(() => {
                        paymentSection.style.border = '';
                    }, 2000);
                }
                
                return false;
            }
            
            console.log('Submitting with payment method:', selectedPayment.value);
        });
    }
});
</script>
@endpush
@endsection