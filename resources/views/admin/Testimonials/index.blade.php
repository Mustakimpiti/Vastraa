@extends('admin.layouts.app')

@section('title', 'Manage Testimonials')
@section('page-title', 'Manage Testimonials')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Testimonials</h5>
        <div>
            <!-- Filter Buttons -->
            <a href="{{ route('admin.testimonials.index') }}" 
               class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">
                All ({{ \App\Models\Testimonial::count() }})
            </a>
            <a href="{{ route('admin.testimonials.index', ['status' => 'active']) }}" 
               class="btn btn-sm {{ request('status') == 'active' ? 'btn-success' : 'btn-outline-success' }}">
                Active ({{ \App\Models\Testimonial::where('is_active', true)->count() }})
            </a>
            <a href="{{ route('admin.testimonials.index', ['status' => 'featured']) }}" 
               class="btn btn-sm {{ request('status') == 'featured' ? 'btn-warning' : 'btn-outline-warning' }}">
                Featured ({{ \App\Models\Testimonial::where('is_featured', true)->count() }})
            </a>
            
            <!-- Add New Button -->
            <a href="{{ route('admin.testimonials.create') }}" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i> Add New Testimonial
            </a>
        </div>
    </div>
    
    <!-- Search Bar -->
    <div class="card-body border-bottom">
        <form action="{{ route('admin.testimonials.index') }}" method="GET" class="row g-3">
            <div class="col-md-10">
                <input type="text" 
                       name="search" 
                       class="form-control" 
                       placeholder="Search by customer name or testimonial..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa fa-search"></i> Search
                </button>
            </div>
        </form>
    </div>

    <div class="card-body">
        @if($testimonials->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 80px;">Image</th>
                        <th>Customer</th>
                        <th>Testimonial</th>
                        <th style="width: 100px;">Rating</th>
                        <th style="width: 80px;">Sort Order</th>
                        <th style="width: 100px;">Status</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($testimonials as $testimonial)
                    <tr>
                        <td>
                            @if($testimonial->customer_image)
                                <img src="{{ asset($testimonial->customer_image) }}" 
                                     alt="{{ $testimonial->customer_name }}" 
                                     class="testimonial-img-thumb">
                            @else
                                <div class="testimonial-img-thumb bg-secondary d-flex align-items-center justify-content-center">
                                    <i class="fa fa-user text-white"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $testimonial->customer_name }}</strong><br>
                            @if($testimonial->customer_location)
                                <small class="text-muted">
                                    <i class="fa fa-map-marker"></i> {{ $testimonial->customer_location }}
                                </small>
                            @endif
                        </td>
                        <td>
                            <div style="max-width: 300px;">
                                {{ Str::limit($testimonial->testimonial, 100) }}
                                @if(strlen($testimonial->testimonial) > 100)
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#testimonialModal{{ $testimonial->id }}">
                                        <small>Read more</small>
                                    </a>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $testimonial->rating)
                                    <span style="color: #d4af37; font-size: 16px;">★</span>
                                    @else
                                    <span style="color: #ddd; font-size: 16px;">★</span>
                                    @endif
                                @endfor
                                <br>
                                <small class="text-muted">({{ $testimonial->rating }}/5)</small>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info">{{ $testimonial->sort_order ?? 0 }}</span>
                        </td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                @if($testimonial->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                                
                                @if($testimonial->is_featured)
                                    <span class="badge bg-warning">Featured</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <!-- Toggle Active -->
                                <button type="button" 
                                        class="btn btn-sm {{ $testimonial->is_active ? 'btn-success' : 'btn-secondary' }} btn-action" 
                                        onclick="toggleStatus({{ $testimonial->id }}, 'active')"
                                        title="{{ $testimonial->is_active ? 'Deactivate' : 'Activate' }}">
                                    <i class="fa {{ $testimonial->is_active ? 'fa-check' : 'fa-times' }}"></i>
                                </button>
                                
                                <!-- Toggle Featured -->
                                <button type="button" 
                                        class="btn btn-sm {{ $testimonial->is_featured ? 'btn-warning' : 'btn-outline-warning' }} btn-action" 
                                        onclick="toggleStatus({{ $testimonial->id }}, 'featured')"
                                        title="{{ $testimonial->is_featured ? 'Unfeature' : 'Feature' }}">
                                    <i class="fa fa-star"></i>
                                </button>
                                
                                <!-- Edit -->
                                <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" 
                                   class="btn btn-sm btn-primary btn-action" 
                                   title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                
                                <!-- Delete -->
                                <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" 
                                      method="POST" 
                                      class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this testimonial?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger btn-action" 
                                            title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- Testimonial Details Modal -->
                    <div class="modal fade" id="testimonialModal{{ $testimonial->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Testimonial Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center mb-4">
                                        @if($testimonial->customer_image)
                                            <img src="{{ asset($testimonial->customer_image) }}" 
                                                 alt="{{ $testimonial->customer_name }}" 
                                                 class="testimonial-img-large mb-3">
                                        @endif
                                        <h5>{{ $testimonial->customer_name }}</h5>
                                        @if($testimonial->customer_location)
                                            <p class="text-muted">
                                                <i class="fa fa-map-marker"></i> {{ $testimonial->customer_location }}
                                            </p>
                                        @endif
                                    </div>
                                    
                                    <div class="mb-3">
                                        <strong>Rating:</strong>
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $testimonial->rating)
                                            <span style="color: #d4af37; font-size: 20px;">★</span>
                                            @else
                                            <span style="color: #ddd; font-size: 20px;">★</span>
                                            @endif
                                        @endfor
                                        ({{ $testimonial->rating }}/5)
                                    </div>
                                    
                                    <div class="mb-3">
                                        <strong>Testimonial:</strong>
                                        <p class="mt-2" style="font-style: italic;">"{{ $testimonial->testimonial }}"</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <strong>Status:</strong>
                                        @if($testimonial->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                        
                                        @if($testimonial->is_featured)
                                            <span class="badge bg-warning">Featured</span>
                                        @endif
                                    </div>
                                    
                                    <div>
                                        <strong>Created:</strong> {{ $testimonial->created_at->format('F d, Y h:i A') }}
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" 
                                       class="btn btn-primary">
                                        <i class="fa fa-edit"></i> Edit Testimonial
                                    </a>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $testimonials->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fa fa-quote-left fa-3x text-muted mb-3"></i>
            <p class="text-muted">
                @if(request('search'))
                    No testimonials found matching your search.
                @else
                    No testimonials found yet. Click "Add New Testimonial" to create one!
                @endif
            </p>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-primary">Clear Filters</a>
            @else
                <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Add New Testimonial
                </a>
            @endif
        </div>
        @endif
    </div>
</div>

<!-- Quick Stats Card -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3>{{ \App\Models\Testimonial::count() }}</h3>
                <p class="text-muted mb-0">Total Testimonials</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success">{{ \App\Models\Testimonial::where('is_active', true)->count() }}</h3>
                <p class="text-muted mb-0">Active</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-warning">{{ \App\Models\Testimonial::where('is_featured', true)->count() }}</h3>
                <p class="text-muted mb-0">Featured</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-info">{{ number_format(\App\Models\Testimonial::avg('rating'), 1) }}</h3>
                <p class="text-muted mb-0">Average Rating</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleStatus(id, type) {
    const route = type === 'active' ? 'toggle-active' : 'toggle-featured';
    
    fetch(`/admin/testimonials/${id}/${route}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
}
</script>
@endpush

@push('styles')
<style>
.rating {
    line-height: 1;
}
.btn-action {
    margin: 0 2px;
}
.testimonial-img-thumb {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #ddd;
}
.testimonial-img-large {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #ddd;
}
.gap-1 {
    gap: 0.25rem;
}
</style>
@endpush