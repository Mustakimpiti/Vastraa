@extends('admin.layouts.app')

@section('title', 'Contact Settings')
@section('page-title', 'Contact Settings')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="fa fa-cog me-2"></i>Manage Contact Information
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.contact-settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Address Information -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fa fa-map-marker me-2"></i>Address Information
                        </h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Address Line 1 <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="address_line1" 
                                           class="form-control @error('address_line1') is-invalid @enderror" 
                                           value="{{ old('address_line1', $settings->address_line1) }}"
                                           placeholder="Building number, Street name"
                                           required>
                                    @error('address_line1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Address Line 2</label>
                                    <input type="text" 
                                           name="address_line2" 
                                           class="form-control @error('address_line2') is-invalid @enderror" 
                                           value="{{ old('address_line2', $settings->address_line2) }}"
                                           placeholder="Area, Locality">
                                    @error('address_line2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Address Line 3</label>
                                    <input type="text" 
                                           name="address_line3" 
                                           class="form-control @error('address_line3') is-invalid @enderror" 
                                           value="{{ old('address_line3', $settings->address_line3) }}"
                                           placeholder="Landmark">
                                    @error('address_line3')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="city" 
                                           class="form-control @error('city') is-invalid @enderror" 
                                           value="{{ old('city', $settings->city) }}"
                                           required>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="state" 
                                           class="form-control @error('state') is-invalid @enderror" 
                                           value="{{ old('state', $settings->state) }}"
                                           required>
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">ZIP/Postal Code <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="zip" 
                                           class="form-control @error('zip') is-invalid @enderror" 
                                           value="{{ old('zip', $settings->zip) }}"
                                           required>
                                    @error('zip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Country <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="country" 
                                           class="form-control @error('country') is-invalid @enderror" 
                                           value="{{ old('country', $settings->country) }}"
                                           required>
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fa fa-phone me-2"></i>Contact Information
                        </h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Primary Phone <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="phone1" 
                                           class="form-control @error('phone1') is-invalid @enderror" 
                                           value="{{ old('phone1', $settings->phone1) }}"
                                           placeholder="+91 94267 24282"
                                           required>
                                    @error('phone1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Secondary Phone</label>
                                    <input type="text" 
                                           name="phone2" 
                                           class="form-control @error('phone2') is-invalid @enderror" 
                                           value="{{ old('phone2', $settings->phone2) }}"
                                           placeholder="+91 94294 08688">
                                    @error('phone2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           name="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email', $settings->email) }}"
                                           placeholder="contact@example.com"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Links -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fa fa-share-alt me-2"></i>Social Media Links
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fa fa-facebook text-primary"></i> Facebook URL
                                    </label>
                                    <input type="url" 
                                           name="facebook_url" 
                                           class="form-control @error('facebook_url') is-invalid @enderror" 
                                           value="{{ old('facebook_url', $settings->facebook_url) }}"
                                           placeholder="https://facebook.com/yourpage">
                                    @error('facebook_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fa fa-instagram text-danger"></i> Instagram URL
                                    </label>
                                    <input type="url" 
                                           name="instagram_url" 
                                           class="form-control @error('instagram_url') is-invalid @enderror" 
                                           value="{{ old('instagram_url', $settings->instagram_url) }}"
                                           placeholder="https://instagram.com/yourpage">
                                    @error('instagram_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fa fa-twitter text-info"></i> Twitter URL
                                    </label>
                                    <input type="url" 
                                           name="twitter_url" 
                                           class="form-control @error('twitter_url') is-invalid @enderror" 
                                           value="{{ old('twitter_url', $settings->twitter_url) }}"
                                           placeholder="https://twitter.com/yourpage">
                                    @error('twitter_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fa fa-pinterest text-danger"></i> Pinterest URL
                                    </label>
                                    <input type="url" 
                                           name="pinterest_url" 
                                           class="form-control @error('pinterest_url') is-invalid @enderror" 
                                           value="{{ old('pinterest_url', $settings->pinterest_url) }}"
                                           placeholder="https://pinterest.com/yourpage">
                                    @error('pinterest_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Map Settings -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fa fa-map me-2"></i>Map Settings
                        </h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Map Embed URL/Code</label>
                                    <textarea name="map_embed_url" 
                                              class="form-control @error('map_embed_url') is-invalid @enderror" 
                                              rows="3"
                                              placeholder="Paste Google Maps embed code here">{{ old('map_embed_url', $settings->map_embed_url) }}</textarea>
                                    @error('map_embed_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">
                                        Go to Google Maps → Share → Embed a map → Copy HTML
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Latitude</label>
                                    <input type="text" 
                                           name="latitude" 
                                           class="form-control @error('latitude') is-invalid @enderror" 
                                           value="{{ old('latitude', $settings->latitude) }}"
                                           placeholder="22.3039">
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Longitude</label>
                                    <input type="text" 
                                           name="longitude" 
                                           class="form-control @error('longitude') is-invalid @enderror" 
                                           value="{{ old('longitude', $settings->longitude) }}"
                                           placeholder="73.1812">
                                    @error('longitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">
                            <i class="fa fa-eye me-2"></i>Preview
                        </h6>
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Full Address:</strong></p>
                                        <p class="text-muted">{{ $settings->getFullAddress() }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2"><strong>Contact:</strong></p>
                                        <p class="text-muted mb-1">
                                            <i class="fa fa-phone"></i> {{ $settings->phone1 }}
                                            @if($settings->phone2)
                                                <br><i class="fa fa-phone"></i> {{ $settings->phone2 }}
                                            @endif
                                        </p>
                                        <p class="text-muted mb-0">
                                            <i class="fa fa-envelope"></i> {{ $settings->email }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save me-2"></i>Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-update preview on input change
    document.addEventListener('DOMContentLoaded', function() {
        // You can add JavaScript here to live-update the preview section
        // as the user types in the form fields
    });
</script>
@endpush