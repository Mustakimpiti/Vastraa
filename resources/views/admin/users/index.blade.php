@extends('admin.layouts.app')

@section('title', 'Manage Users')
@section('page-title', 'Manage Users')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <h5 class="mb-0">All Users</h5>
            <div class="d-flex flex-wrap gap-2">
                <!-- Filter Buttons -->
                <a href="{{ route('admin.users.index') }}" 
                   class="btn btn-sm {{ !request('role') ? 'btn-primary' : 'btn-outline-primary' }}">
                    All ({{ \App\Models\User::count() }})
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" 
                   class="btn btn-sm {{ request('role') == 'admin' ? 'btn-danger' : 'btn-outline-danger' }}">
                    Admins ({{ \App\Models\User::where('role', 'admin')->count() }})
                </a>
                <a href="{{ route('admin.users.index', ['role' => 'customer']) }}" 
                   class="btn btn-sm {{ request('role') == 'customer' ? 'btn-success' : 'btn-outline-success' }}">
                    Customers ({{ \App\Models\User::where('role', 'customer')->count() }})
                </a>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fa fa-plus"></i> <span class="d-none d-sm-inline">Add New</span>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Search Bar -->
    <div class="card-body border-bottom">
        <form action="{{ route('admin.users.index') }}" method="GET" class="row g-2">
            <div class="col-12 col-md-10">
                <input type="text" 
                       name="search" 
                       class="form-control" 
                       placeholder="Search by name or email..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-12 col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa fa-search"></i> Search
                </button>
            </div>
        </form>
    </div>

    <div class="card-body p-0">
        @if($users->count() > 0)
        <!-- Desktop Table View -->
        <div class="table-responsive d-none d-lg-block">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="align-middle">#{{ $user->id }}</td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-2">
                                    <div class="avatar-circle">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                </div>
                                <strong>{{ $user->name }}</strong>
                            </div>
                        </td>
                        <td class="align-middle">{{ $user->email }}</td>
                        <td class="align-middle">
                            @if($user->role === 'admin')
                                <span class="badge bg-danger">Admin</span>
                            @else
                                <span class="badge bg-success">Customer</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            <small>{{ $user->created_at->format('M d, Y') }}</small>
                        </td>
                        <td class="align-middle text-end">
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-info" 
                                        title="View Details"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#userModal{{ $user->id }}">
                                    <i class="fa fa-eye"></i>
                                </button>
                                
                                <button class="btn btn-sm btn-primary" 
                                        title="Edit User"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editUserModal{{ $user->id }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                
                                @if(Auth::id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                      method="POST" 
                                      class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this user? This will also delete all their orders, reviews, and cart items.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger" 
                                            title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                @else
                                <button class="btn btn-sm btn-secondary" 
                                        title="Cannot delete yourself" 
                                        disabled>
                                    <i class="fa fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="d-lg-none">
            @foreach($users as $user)
            <div class="user-card p-3 border-bottom">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="d-flex align-items-center flex-grow-1">
                        <div class="avatar-circle me-3">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $user->name }}</h6>
                            <small class="text-muted">{{ $user->email }}</small>
                        </div>
                    </div>
                    @if($user->role === 'admin')
                        <span class="badge bg-danger">Admin</span>
                    @else
                        <span class="badge bg-success">Customer</span>
                    @endif
                </div>
                
                <div class="row g-2 mb-3 small">
                    <div class="col-6">
                        <strong>ID:</strong> #{{ $user->id }}
                    </div>
                    <div class="col-6">
                        <strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <button class="btn btn-sm btn-info" 
                            data-bs-toggle="modal" 
                            data-bs-target="#userModal{{ $user->id }}">
                        <i class="fa fa-eye"></i> View
                    </button>
                    
                    <button class="btn btn-sm btn-primary" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editUserModal{{ $user->id }}">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    
                    @if(Auth::id() !== $user->id)
                    <form action="{{ route('admin.users.destroy', $user->id) }}" 
                          method="POST" 
                          class="d-inline" 
                          onsubmit="return confirm('Are you sure you want to delete this user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="p-3">
            {{ $users->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fa fa-users fa-3x text-muted mb-3"></i>
            <p class="text-muted">
                @if(request('search'))
                    No users found matching your search.
                @else
                    No users found yet.
                @endif
            </p>
            @if(request('search') || request('role'))
                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Clear Filters</a>
            @endif
        </div>
        @endif
    </div>
</div>

<!-- User Details Modals (Outside the table loop) -->
@foreach($users as $user)
<!-- User Details Modal -->
<div class="modal fade" id="userModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-user-circle"></i> User Details - {{ $user->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- User Info Section -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title mb-3"><i class="fa fa-info-circle"></i> Personal Information</h6>
                                <div class="mb-2">
                                    <strong>Name:</strong> {{ $user->name }}
                                </div>
                                <div class="mb-2">
                                    <strong>Email:</strong> {{ $user->email }}
                                </div>
                                <div class="mb-2">
                                    <strong>Role:</strong>
                                    @if($user->role === 'admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @else
                                        <span class="badge bg-success">Customer</span>
                                    @endif
                                </div>
                                <div class="mb-2">
                                    <strong>Joined:</strong> {{ $user->created_at->format('F d, Y h:i A') }}
                                </div>
                                <div>
                                    <strong>Member for:</strong> {{ $user->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title mb-3"><i class="fa fa-chart-bar"></i> Activity Statistics</h6>
                                <div class="mb-2">
                                    <strong>Total Orders:</strong> 
                                    <span class="badge bg-primary">{{ $user->orders->count() }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Total Spent:</strong> 
                                    <span class="text-success fw-bold">₹{{ number_format($user->orders->sum('total'), 2) }}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Reviews Written:</strong> 
                                    <span class="badge bg-warning">{{ $user->reviews->count() }}</span>
                                </div>
                                <div>
                                    <strong>Wishlist Items:</strong> 
                                    <span class="badge bg-info">{{ $user->wishlists->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Orders Section -->
                @if($user->orders->count() > 0)
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="fa fa-shopping-cart"></i> Order History ({{ $user->orders->count() }} orders)</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order Number</th>
                                        <th>Date</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Payment</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->orders->sortByDesc('created_at') as $order)
                                    <tr>
                                        <td class="align-middle">
                                            <strong>{{ $order->order_number }}</strong>
                                        </td>
                                        <td class="align-middle">
                                            {{ $order->created_at->format('M d, Y') }}<br>
                                            <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td class="align-middle">{{ $order->items->count() }} items</td>
                                        <td class="align-middle">
                                            <strong class="text-success">₹{{ number_format($order->total, 2) }}</strong>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge bg-{{ $order->getPaymentBadgeClass() }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge bg-{{ $order->getStatusBadgeClass() }}">
                                                {{ ucfirst($order->order_status) }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               target="_blank">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @else
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> This user hasn't placed any orders yet.
                </div>
                @endif
            </div>
            <div class="modal-footer">
                @if($user->orders->count() > 0)
                <a href="{{ route('admin.orders.index', ['user_id' => $user->id]) }}" 
                   class="btn btn-primary"
                   target="_blank">
                    <i class="fa fa-shopping-cart"></i> View All Orders in Orders Page
                </a>
                @endif
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" 
                               value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" 
                               value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-control" required>
                            <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password (leave blank to keep current)</label>
                        <input type="password" name="password" class="form-control" 
                               placeholder="Enter new password (optional)">
                        <small class="text-muted">Only fill this if you want to change the password</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-control" required>
                            <option value="customer">Customer</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Quick Stats Card -->
<div class="row mt-4 g-3">
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <h3 class="mb-1">{{ \App\Models\User::count() }}</h3>
                <p class="text-muted mb-0 small">Total Users</p>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <h3 class="text-danger mb-1">{{ \App\Models\User::where('role', 'admin')->count() }}</h3>
                <p class="text-muted mb-0 small">Admins</p>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <h3 class="text-success mb-1">{{ \App\Models\User::where('role', 'customer')->count() }}</h3>
                <p class="text-muted mb-0 small">Customers</p>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card text-center h-100">
            <div class="card-body">
                <h3 class="text-info mb-1">{{ \App\Models\User::whereDate('created_at', '>=', now()->subDays(30))->count() }}</h3>
                <p class="text-muted mb-0 small">New This Month</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 18px;
    flex-shrink: 0;
}

.modal-body strong {
    color: #2c3e50;
}

.user-card {
    transition: background-color 0.2s;
}

.user-card:hover {
    background-color: #f8f9fa;
}

/* Modal size */
.modal-xl {
    max-width: 1200px;
}

/* Responsive adjustments */
@media (max-width: 991.98px) {
    .avatar-circle {
        width: 35px;
        height: 35px;
        font-size: 16px;
    }
    
    .modal-xl {
        max-width: 95%;
    }
}

@media (max-width: 575.98px) {
    .card-header h5 {
        font-size: 1rem;
    }
    
    .btn-sm {
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
    }
}
</style>
@endpush