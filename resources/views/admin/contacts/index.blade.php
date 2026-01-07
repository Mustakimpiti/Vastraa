@extends('admin.layouts.app')

@section('title', 'Manage Contact Messages')
@section('page-title', 'Contact Messages')

@section('content')

{{-- ALWAYS SHOW SUCCESS/ERROR MESSAGES AT TOP --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: relative; z-index: 9999;">
        <strong>✅ Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: relative; z-index: 9999;">
        <strong>❌ Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position: relative; z-index: 9999;">
        <strong>❌ Validation Errors:</strong>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Contact Messages</h5>
        <div>
            <!-- Filter Buttons -->
            <a href="{{ route('admin.contacts.index') }}" 
               class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">
                All ({{ \App\Models\Contact::count() }})
            </a>
            <a href="{{ route('admin.contacts.index', ['status' => 'unread']) }}" 
               class="btn btn-sm {{ request('status') == 'unread' ? 'btn-danger' : 'btn-outline-danger' }}">
                Unread ({{ \App\Models\Contact::where('status', 'unread')->count() }})
            </a>
            <a href="{{ route('admin.contacts.index', ['status' => 'read']) }}" 
               class="btn btn-sm {{ request('status') == 'read' ? 'btn-warning' : 'btn-outline-warning' }}">
                Read ({{ \App\Models\Contact::where('status', 'read')->count() }})
            </a>
            <a href="{{ route('admin.contacts.index', ['status' => 'replied']) }}" 
               class="btn btn-sm {{ request('status') == 'replied' ? 'btn-success' : 'btn-outline-success' }}">
                Replied ({{ \App\Models\Contact::where('status', 'replied')->count() }})
            </a>
        </div>
    </div>
    
    <!-- Search Bar -->
    <div class="card-body border-bottom">
        <form action="{{ route('admin.contacts.index') }}" method="GET" class="row g-3">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="col-md-10">
                <input type="text" 
                       name="search" 
                       class="form-control" 
                       placeholder="Search by name, email, phone, or message..." 
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
        @if($contacts->count() > 0)
        <!-- Bulk Actions -->
        <div class="mb-3">
            <form action="{{ route('admin.contacts.bulk-action') }}" method="POST" id="bulk-action-form">
                @csrf
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Bulk Actions</label>
                        <select name="action" class="form-select" required>
                            <option value="">Select Action</option>
                            <option value="mark_read">Mark as Read</option>
                            <option value="mark_replied">Mark as Replied</option>
                            <option value="delete">Delete</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-secondary w-100" 
                                onclick="return confirm('Are you sure you want to perform this action?')">
                            Apply
                        </button>
                    </div>
                    <div class="col-md-7 text-end">
                        <small class="text-muted">
                            <span id="selected-count">0</span> message(s) selected
                        </small>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 40px;">
                            <input type="checkbox" id="select-all" class="form-check-input">
                        </th>
                        <th>Customer</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                    <tr class="{{ $contact->status == 'unread' ? 'table-warning' : '' }}">
                        <td>
                            <input type="checkbox" 
                                   name="contact_ids[]" 
                                   value="{{ $contact->id }}" 
                                   class="form-check-input contact-checkbox"
                                   form="bulk-action-form">
                        </td>
                        <td>
                            <div>
                                <strong>{{ $contact->name }}</strong>
                                @if($contact->status == 'unread')
                                    <span class="badge bg-danger ms-2" style="font-size: 10px;">NEW</span>
                                @endif
                            </div>
                            <small class="text-muted">{{ $contact->email }}</small><br>
                            @if($contact->phone)
                                <small class="text-muted">
                                    <i class="fa fa-phone"></i> {{ $contact->phone }}
                                </small>
                            @endif
                        </td>
                        <td>
                            <div style="max-width: 300px;">
                                {{ Str::limit($contact->message, 100) }}
                                @if(strlen($contact->message) > 100)
                                    <a href="#" 
                                       data-bs-toggle="modal" 
                                       data-bs-target="#contactModal{{ $contact->id }}"
                                       onclick="markAsRead({{ $contact->id }})">
                                        <small>Read more</small>
                                    </a>
                                @endif
                            </div>
                        </td>
                        <td>
                            <small>{{ $contact->created_at->format('M d, Y') }}</small><br>
                            <small class="text-muted">{{ $contact->created_at->format('h:i A') }}</small>
                            @if($contact->replied_at)
                                <br><small class="text-success">
                                    <i class="fa fa-reply"></i> Replied: {{ $contact->replied_at->format('M d') }}
                                </small>
                            @endif
                        </td>
                        <td>
                            @if($contact->status == 'unread')
                                <span class="badge bg-danger">Unread</span>
                            @elseif($contact->status == 'read')
                                <span class="badge bg-warning">Read</span>
                            @elseif($contact->status == 'replied')
                                <span class="badge bg-success">Replied</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" 
                                        class="btn btn-sm btn-info btn-action" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#contactModal{{ $contact->id }}"
                                        onclick="markAsRead({{ $contact->id }})"
                                        title="View Details">
                                    <i class="fa fa-eye"></i>
                                </button>
                                
                                @if($contact->status != 'replied')
                                <button type="button" 
                                        class="btn btn-sm btn-success btn-action" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#replyModal{{ $contact->id }}"
                                        title="Reply">
                                    <i class="fa fa-reply"></i>
                                </button>
                                @endif
                                
                                @if($contact->status == 'unread')
                                <form action="{{ route('admin.contacts.mark-read', $contact->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-sm btn-warning btn-action" 
                                            title="Mark as Read">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('admin.contacts.mark-unread', $contact->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-sm btn-secondary btn-action" 
                                            title="Mark as Unread">
                                        <i class="fa fa-envelope"></i>
                                    </button>
                                </form>
                                @endif
                                
                                <form action="{{ route('admin.contacts.destroy', $contact->id) }}" 
                                      method="POST" 
                                      class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this message?')">
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

                    <!-- Contact Details Modal -->
                    <div class="modal fade" id="contactModal{{ $contact->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Contact Message Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <strong>Name:</strong> {{ $contact->name }}
                                    </div>
                                    <div class="mb-3">
                                        <strong>Email:</strong> 
                                        <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                                    </div>
                                    @if($contact->phone)
                                    <div class="mb-3">
                                        <strong>Phone:</strong> 
                                        <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                                    </div>
                                    @endif
                                    <div class="mb-3">
                                        <strong>Message:</strong>
                                        <div class="mt-2 p-3 bg-light rounded">
                                            {{ $contact->message }}
                                        </div>
                                    </div>
                                    
                                    @if($contact->admin_reply)
                                    <div class="mb-3">
                                        <strong>Your Reply:</strong>
                                        <div class="mt-2 p-3 bg-success bg-opacity-10 rounded border border-success">
                                            {{ $contact->admin_reply }}
                                        </div>
                                        <small class="text-muted">
                                            Replied on: {{ $contact->replied_at->format('F d, Y h:i A') }}
                                        </small>
                                    </div>
                                    @endif
                                    
                                    <div class="mb-3">
                                        <strong>Received:</strong> {{ $contact->created_at->format('F d, Y h:i A') }}
                                    </div>
                                    <div>
                                        <strong>Status:</strong>
                                        @if($contact->status == 'unread')
                                            <span class="badge bg-danger">Unread</span>
                                        @elseif($contact->status == 'read')
                                            <span class="badge bg-warning">Read</span>
                                        @else
                                            <span class="badge bg-success">Replied</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    @if($contact->status != 'replied')
                                    <button type="button" 
                                            class="btn btn-success" 
                                            data-bs-dismiss="modal"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#replyModal{{ $contact->id }}">
                                        <i class="fa fa-reply"></i> Reply to Customer
                                    </button>
                                    @endif
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reply Modal -->
                    <div class="modal fade" id="replyModal{{ $contact->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="{{ route('admin.contacts.reply', $contact->id) }}" 
                                      method="POST" 
                                      id="replyForm{{ $contact->id }}"
                                      onsubmit="console.log('Form submitting for contact {{ $contact->id }}'); return true;">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title">Reply to {{ $contact->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <strong>Customer's Message:</strong>
                                            <div class="mt-2 p-3 bg-light rounded">
                                                {{ $contact->message }}
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="admin_reply{{ $contact->id }}" class="form-label">
                                                <strong>Your Reply:</strong>
                                            </label>
                                            <textarea class="form-control" 
                                                      id="admin_reply{{ $contact->id }}"
                                                      name="admin_reply" 
                                                      rows="6" 
                                                      required
                                                      minlength="10"
                                                      placeholder="Type your response here (minimum 10 characters)..."></textarea>
                                            <small class="text-muted">
                                                This reply will be sent to {{ $contact->email }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success" id="sendBtn{{ $contact->id }}">
                                            <i class="fa fa-paper-plane"></i> Send Reply
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $contacts->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fa fa-envelope fa-3x text-muted mb-3"></i>
            <p class="text-muted">
                @if(request('search'))
                    No contact messages found matching your search.
                @else
                    No contact messages found yet. Messages will appear here when customers contact you!
                @endif
            </p>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-primary">Clear Filters</a>
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
                <h3>{{ \App\Models\Contact::count() }}</h3>
                <p class="text-muted mb-0">Total Messages</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-danger">{{ \App\Models\Contact::where('status', 'unread')->count() }}</h3>
                <p class="text-muted mb-0">Unread</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-warning">{{ \App\Models\Contact::where('status', 'read')->count() }}</h3>
                <p class="text-muted mb-0">Read</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success">{{ \App\Models\Contact::where('status', 'replied')->count() }}</h3>
                <p class="text-muted mb-0">Replied</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.btn-action {
    margin: 0 2px;
}
.modal-body strong {
    color: #2c3e50;
}
.table-warning {
    background-color: #fff3cd !important;
}
</style>
@endpush

@push('scripts')
<script>
console.log('Contact management page loaded');

// Select All Checkbox
document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.contact-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateSelectedCount();
});

// Update selected count
document.querySelectorAll('.contact-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateSelectedCount);
});

function updateSelectedCount() {
    const selected = document.querySelectorAll('.contact-checkbox:checked').length;
    document.getElementById('selected-count').textContent = selected;
}

// Mark as read via AJAX when viewing details
function markAsRead(contactId) {
    console.log('Marking contact as read:', contactId);
    fetch(`/admin/contacts/${contactId}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    }).then(response => {
        console.log('Mark as read response:', response.status);
    }).catch(error => {
        console.error('Mark as read error:', error);
    });
}

// Initialize count on page load
updateSelectedCount();

// Debug: Log all reply forms
document.querySelectorAll('[id^="replyForm"]').forEach(form => {
    console.log('Found reply form:', form.id);
    form.addEventListener('submit', function(e) {
        console.log('Reply form submitted:', form.id);
        const textarea = form.querySelector('textarea[name="admin_reply"]');
        console.log('Reply content:', textarea.value);
        console.log('Reply length:', textarea.value.length);
        
        if (textarea.value.length < 10) {
            e.preventDefault();
            alert('Please enter at least 10 characters in your reply.');
            return false;
        }
    });
});

// Scroll to top on page load if there's a success/error message
window.addEventListener('load', function() {
    if (document.querySelector('.alert')) {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});
</script>
@endpush