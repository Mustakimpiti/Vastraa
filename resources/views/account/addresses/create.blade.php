@extends('layouts.app')

@section('title', isset($address) ? 'Edit Address' : 'Add New Address')

@section('content')
<!--== Start Page Title Area ==-->
<section class="page-title-area bg-img" data-bg-img="{{ asset('assets/img/photos/bg-page1.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title-content">
                    <h2 class="title">{{ isset($address) ? 'Edit Address' : 'Add New Address' }}</h2>
                    <div class="bread-crumbs">
                        <a href="{{ route('home') }}">Home<span class="breadcrumb-sep">></span></a>
                        <a href="{{ route('account') }}">My Account<span class="breadcrumb-sep">></span></a>
                        <a href="{{ route('addresses.index') }}">Addresses<span class="breadcrumb-sep">></span></a>
                        <span class="active">{{ isset($address) ? 'Edit' : 'Add New' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Page Title Area ==-->

<!--== Start Address Form Section ==-->
<section class="contact-area">
    <div class="container">
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="contact-form">
                    <form class="contact-form-wrapper form-style" 
                          action="{{ isset($address) ? route('addresses.update', $address) : route('addresses.store') }}" 
                          method="POST">
                        @csrf
                        @if(isset($address))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <h4 class="title mb-4">Address Details</h4>
                            </div>

                            <!-- Address Type -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="address_type">Address Type <span class="required">*</span></label>
                                    <select class="form-control" id="address_type" name="address_type" required>
                                        <option value="both" {{ old('address_type', $address->address_type ?? 'both') == 'both' ? 'selected' : '' }}>Billing & Shipping</option>
                                        <option value="billing" {{ old('address_type', $address->address_type ?? '') == 'billing' ? 'selected' : '' }}>Billing Only</option>
                                        <option value="shipping" {{ old('address_type', $address->address_type ?? '') == 'shipping' ? 'selected' : '' }}>Shipping Only</option>
                                    </select>
                                </div>
                            </div>

                            <!-- First Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">First Name <span class="required">*</span></label>
                                    <input class="form-control" 
                                           id="first_name" 
                                           name="first_name" 
                                           type="text" 
                                           value="{{ old('first_name', $address->first_name ?? '') }}" 
                                           required>
                                </div>
                            </div>

                            <!-- Last Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Last Name <span class="required">*</span></label>
                                    <input class="form-control" 
                                           id="last_name" 
                                           name="last_name" 
                                           type="text" 
                                           value="{{ old('last_name', $address->last_name ?? '') }}" 
                                           required>
                                </div>
                            </div>

                            <!-- Street Address -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="street_address">Street Address <span class="required">*</span></label>
                                    <input class="form-control" 
                                           id="street_address" 
                                           name="street_address" 
                                           type="text" 
                                           placeholder="House number and street name"
                                           value="{{ old('street_address', $address->street_address ?? '') }}" 
                                           required>
                                </div>
                            </div>

                            <!-- Apartment -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="apartment">Apartment, Suite, Unit, etc. (Optional)</label>
                                    <input class="form-control" 
                                           id="apartment" 
                                           name="apartment" 
                                           type="text" 
                                           value="{{ old('apartment', $address->apartment ?? '') }}">
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city">City <span class="required">*</span></label>
                                    <input class="form-control" 
                                           id="city" 
                                           name="city" 
                                           type="text" 
                                           value="{{ old('city', $address->city ?? '') }}" 
                                           required>
                                </div>
                            </div>

                            <!-- State -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="state">State <span class="required">*</span></label>
                                    <select class="form-control" id="state" name="state" required>
                                        <option value="">Select State</option>
                                        <option value="Andhra Pradesh" {{ old('state', $address->state ?? '') == 'Andhra Pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
                                        <option value="Arunachal Pradesh" {{ old('state', $address->state ?? '') == 'Arunachal Pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>
                                        <option value="Assam" {{ old('state', $address->state ?? '') == 'Assam' ? 'selected' : '' }}>Assam</option>
                                        <option value="Bihar" {{ old('state', $address->state ?? '') == 'Bihar' ? 'selected' : '' }}>Bihar</option>
                                        <option value="Chhattisgarh" {{ old('state', $address->state ?? '') == 'Chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
                                        <option value="Goa" {{ old('state', $address->state ?? '') == 'Goa' ? 'selected' : '' }}>Goa</option>
                                        <option value="Gujarat" {{ old('state', $address->state ?? '') == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                                        <option value="Haryana" {{ old('state', $address->state ?? '') == 'Haryana' ? 'selected' : '' }}>Haryana</option>
                                        <option value="Himachal Pradesh" {{ old('state', $address->state ?? '') == 'Himachal Pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
                                        <option value="Jharkhand" {{ old('state', $address->state ?? '') == 'Jharkhand' ? 'selected' : '' }}>Jharkhand</option>
                                        <option value="Karnataka" {{ old('state', $address->state ?? '') == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                                        <option value="Kerala" {{ old('state', $address->state ?? '') == 'Kerala' ? 'selected' : '' }}>Kerala</option>
                                        <option value="Madhya Pradesh" {{ old('state', $address->state ?? '') == 'Madhya Pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
                                        <option value="Maharashtra" {{ old('state', $address->state ?? '') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                                        <option value="Manipur" {{ old('state', $address->state ?? '') == 'Manipur' ? 'selected' : '' }}>Manipur</option>
                                        <option value="Meghalaya" {{ old('state', $address->state ?? '') == 'Meghalaya' ? 'selected' : '' }}>Meghalaya</option>
                                        <option value="Mizoram" {{ old('state', $address->state ?? '') == 'Mizoram' ? 'selected' : '' }}>Mizoram</option>
                                        <option value="Nagaland" {{ old('state', $address->state ?? '') == 'Nagaland' ? 'selected' : '' }}>Nagaland</option>
                                        <option value="Odisha" {{ old('state', $address->state ?? '') == 'Odisha' ? 'selected' : '' }}>Odisha</option>
                                        <option value="Punjab" {{ old('state', $address->state ?? '') == 'Punjab' ? 'selected' : '' }}>Punjab</option>
                                        <option value="Rajasthan" {{ old('state', $address->state ?? '') == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                                        <option value="Sikkim" {{ old('state', $address->state ?? '') == 'Sikkim' ? 'selected' : '' }}>Sikkim</option>
                                        <option value="Tamil Nadu" {{ old('state', $address->state ?? '') == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu</option>
                                        <option value="Telangana" {{ old('state', $address->state ?? '') == 'Telangana' ? 'selected' : '' }}>Telangana</option>
                                        <option value="Tripura" {{ old('state', $address->state ?? '') == 'Tripura' ? 'selected' : '' }}>Tripura</option>
                                        <option value="Uttar Pradesh" {{ old('state', $address->state ?? '') == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                                        <option value="Uttarakhand" {{ old('state', $address->state ?? '') == 'Uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>
                                        <option value="West Bengal" {{ old('state', $address->state ?? '') == 'West Bengal' ? 'selected' : '' }}>West Bengal</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Country -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country">Country <span class="required">*</span></label>
                                    <select class="form-control" id="country" name="country" required>
                                        <option value="India" {{ old('country', $address->country ?? 'India') == 'India' ? 'selected' : '' }}>India</option>
                                        <option value="United States" {{ old('country', $address->country ?? '') == 'United States' ? 'selected' : '' }}>United States</option>
                                        <option value="United Kingdom" {{ old('country', $address->country ?? '') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                        <option value="Bangladesh" {{ old('country', $address->country ?? '') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                        <option value="Pakistan" {{ old('country', $address->country ?? '') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                    </select>
                                </div>
                            </div>

                            <!-- ZIP -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="zip">ZIP Code <span class="required">*</span></label>
                                    <input class="form-control" 
                                           id="zip" 
                                           name="zip" 
                                           type="text" 
                                           value="{{ old('zip', $address->zip ?? '') }}" 
                                           required>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="phone">Phone <span class="required">*</span></label>
                                    <input class="form-control" 
                                           id="phone" 
                                           name="phone" 
                                           type="text" 
                                           value="{{ old('phone', $address->phone ?? '') }}" 
                                           required>
                                </div>
                            </div>

                            <!-- Set as Default -->
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" 
                                               class="custom-control-input" 
                                               id="is_default" 
                                               name="is_default" 
                                               value="1"
                                               {{ old('is_default', $address->is_default ?? false) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_default">
                                            Set as default address
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12">
                                <div class="form-group mb-0">
                                    <button class="btn btn-theme btn-black me-2" type="submit">
                                        {{ isset($address) ? 'Update Address' : 'Save Address' }}
                                    </button>
                                    <a href="{{ route('addresses.index') }}" class="btn btn-outline-secondary">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--== End Address Form Section ==-->
@endsection