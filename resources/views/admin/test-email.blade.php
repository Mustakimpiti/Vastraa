<?php

/**
 * SIMPLE INLINE EMAIL TEST
 * 
 * Add this route to your routes/web.php INSIDE the admin group:
 * 
 * Route::get('/test-email-now', function() {
 *     return view('admin.test-email');
 * });
 * 
 * Route::post('/test-email-send', function(\Illuminate\Http\Request $request) {
 *     // ... code below
 * });
 */

// For the GET route - create this view at: resources/views/admin/test-email.blade.php
?>
<!DOCTYPE html>
<html>
<head>
    <title>Email Test</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <style>
        body { padding: 40px; background: #f5f5f5; }
        .container { max-width: 800px; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .result { padding: 20px; margin: 20px 0; border-radius: 5px; }
        .success { background: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .error { background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📧 Simple Email Test</h1>
        
        @if(session('success'))
            <div class="result success">
                <strong>✅ SUCCESS!</strong><br>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="result error">
                <strong>❌ ERROR!</strong><br>
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ url('/admin/test-email-send') }}">
            @csrf
            
            <div class="mb-3">
                <label class="form-label"><strong>Select Contact to Test:</strong></label>
                <select name="contact_id" class="form-control" required>
                    @php
                        $contacts = \App\Models\Contact::latest()->limit(10)->get();
                    @endphp
                    @foreach($contacts as $contact)
                        <option value="{{ $contact->id }}">
                            {{ $contact->name }} ({{ $contact->email }}) - ID: {{ $contact->id }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Test Reply Message:</strong></label>
                <textarea name="test_reply" class="form-control" rows="4" required>This is a test reply from the admin panel. If you receive this email, the reply system is working correctly!</textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-lg">
                📤 Send Test Email Now
            </button>
        </form>

        <hr style="margin: 30px 0;">
        
        <h3>What This Test Does:</h3>
        <ol>
            <li>Updates the contact in the database</li>
            <li>Attempts to send an email</li>
            <li>Shows you the exact result</li>
        </ol>

        <p><a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">← Back to Contacts</a></p>
    </div>
</body>
</html>