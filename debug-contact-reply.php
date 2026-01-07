<?php

/**
 * COMPLETE CONTACT REPLY DEBUGGING SCRIPT
 * 
 * Add this to your routes/web.php temporarily:
 * 
 * Route::get('/debug-contact-reply', function() {
 *     include(base_path('debug-contact-reply.php'));
 * })->middleware(['auth', 'admin']);
 * 
 * Then visit: http://yoursite.com/debug-contact-reply
 */

echo "<!DOCTYPE html><html><head><title>Contact Reply Debug</title>";
echo "<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
    .test { background: white; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #007bff; }
    .success { border-left-color: #28a745; }
    .error { border-left-color: #dc3545; }
    .warning { border-left-color: #ffc107; }
    h1 { color: #333; }
    h2 { color: #666; margin-top: 30px; }
    pre { background: #f8f9fa; padding: 10px; border-radius: 3px; overflow-x: auto; }
    .icon { font-size: 20px; margin-right: 10px; }
</style></head><body>";

echo "<h1>🔍 Contact Reply Complete Diagnostic</h1>";
echo "<p>Testing all components required for contact reply functionality...</p>";

$allPassed = true;

// TEST 1: Check if Contact Model exists
echo "<h2>Test 1: Contact Model</h2>";
echo "<div class='test " . (class_exists('\App\Models\Contact') ? 'success' : 'error') . "'>";
if (class_exists('\App\Models\Contact')) {
    echo "<span class='icon'>✅</span> Contact Model exists<br>";
    
    // Check if methods exist
    $methods = ['markAsRead', 'markAsReplied'];
    foreach ($methods as $method) {
        if (method_exists('\App\Models\Contact', $method)) {
            echo "<span class='icon'>✅</span> Method '$method' exists<br>";
        } else {
            echo "<span class='icon'>❌</span> Method '$method' NOT FOUND<br>";
            $allPassed = false;
        }
    }
    
    // Check if we have any contacts
    $contactCount = \App\Models\Contact::count();
    echo "<span class='icon'>ℹ️</span> Total contacts in database: $contactCount<br>";
    
} else {
    echo "<span class='icon'>❌</span> Contact Model NOT FOUND<br>";
    $allPassed = false;
}
echo "</div>";

// TEST 2: Check Admin Contact Controller
echo "<h2>Test 2: Admin Contact Controller</h2>";
echo "<div class='test " . (class_exists('\App\Http\Controllers\Admin\ContactController') ? 'success' : 'error') . "'>";
if (class_exists('\App\Http\Controllers\Admin\ContactController')) {
    echo "<span class='icon'>✅</span> Admin ContactController exists<br>";
    
    // Check if reply method exists
    if (method_exists('\App\Http\Controllers\Admin\ContactController', 'reply')) {
        echo "<span class='icon'>✅</span> Method 'reply' exists<br>";
    } else {
        echo "<span class='icon'>❌</span> Method 'reply' NOT FOUND in controller<br>";
        $allPassed = false;
    }
} else {
    echo "<span class='icon'>❌</span> Admin ContactController NOT FOUND<br>";
    echo "<strong>Location should be:</strong> app/Http/Controllers/Admin/ContactController.php<br>";
    $allPassed = false;
}
echo "</div>";

// TEST 3: Check ContactReplyMail class
echo "<h2>Test 3: ContactReplyMail Class</h2>";
echo "<div class='test " . (class_exists('\App\Mail\ContactReplyMail') ? 'success' : 'error') . "'>";
if (class_exists('\App\Mail\ContactReplyMail')) {
    echo "<span class='icon'>✅</span> ContactReplyMail class exists<br>";
} else {
    echo "<span class='icon'>❌</span> ContactReplyMail class NOT FOUND<br>";
    echo "<strong>Location should be:</strong> app/Mail/ContactReplyMail.php<br>";
    echo "<strong>Action needed:</strong> Run 'composer dump-autoload'<br>";
    $allPassed = false;
}
echo "</div>";

// TEST 4: Check email template
echo "<h2>Test 4: Email Template</h2>";
$templatePath = resource_path('views/emails/contact-reply.blade.php');
echo "<div class='test " . (file_exists($templatePath) ? 'success' : 'error') . "'>";
if (file_exists($templatePath)) {
    echo "<span class='icon'>✅</span> Email template exists<br>";
    echo "<strong>Location:</strong> $templatePath<br>";
} else {
    echo "<span class='icon'>❌</span> Email template NOT FOUND<br>";
    echo "<strong>Expected location:</strong> $templatePath<br>";
    $allPassed = false;
}
echo "</div>";

// TEST 5: Check Mail Configuration
echo "<h2>Test 5: Mail Configuration</h2>";
$mailDriver = config('mail.default');
$mailHost = config('mail.mailers.' . $mailDriver . '.host');
$mailPort = config('mail.mailers.' . $mailDriver . '.port');
$mailFrom = config('mail.from.address');
$mailFromName = config('mail.from.name');

echo "<div class='test " . ($mailFrom ? 'success' : 'warning') . "'>";
echo "<strong>Mail Configuration:</strong><br>";
echo "Driver: " . ($mailDriver ?: '❌ NOT SET') . "<br>";
echo "Host: " . ($mailHost ?: '❌ NOT SET') . "<br>";
echo "Port: " . ($mailPort ?: '❌ NOT SET') . "<br>";
echo "From Address: " . ($mailFrom ?: '❌ NOT SET') . "<br>";
echo "From Name: " . ($mailFromName ?: '❌ NOT SET') . "<br>";

if (!$mailFrom) {
    echo "<br><span class='icon'>⚠️</span> <strong>WARNING:</strong> MAIL_FROM_ADDRESS not configured in .env<br>";
    echo "Emails will fail to send!<br>";
}
echo "</div>";

// TEST 6: Check Routes
echo "<h2>Test 6: Routes</h2>";
$routes = \Route::getRoutes();
$contactRoutes = [];

foreach ($routes as $route) {
    if (strpos($route->getName(), 'admin.contacts') !== false) {
        $contactRoutes[] = [
            'name' => $route->getName(),
            'method' => implode('|', $route->methods()),
            'uri' => $route->uri()
        ];
    }
}

echo "<div class='test " . (count($contactRoutes) > 0 ? 'success' : 'error') . "'>";
if (count($contactRoutes) > 0) {
    echo "<span class='icon'>✅</span> Admin contact routes found: " . count($contactRoutes) . "<br><br>";
    echo "<strong>Available routes:</strong><br>";
    echo "<pre>";
    foreach ($contactRoutes as $route) {
        echo str_pad($route['method'], 15) . " " . str_pad($route['uri'], 40) . " " . $route['name'] . "\n";
    }
    echo "</pre>";
    
    // Check specifically for reply route
    $hasReplyRoute = false;
    foreach ($contactRoutes as $route) {
        if ($route['name'] === 'admin.contacts.reply') {
            $hasReplyRoute = true;
            break;
        }
    }
    
    if ($hasReplyRoute) {
        echo "<span class='icon'>✅</span> Reply route exists<br>";
    } else {
        echo "<span class='icon'>❌</span> Reply route NOT FOUND<br>";
        $allPassed = false;
    }
} else {
    echo "<span class='icon'>❌</span> No admin contact routes found<br>";
    echo "<strong>Action needed:</strong> Check routes/web.php and run 'php artisan route:clear'<br>";
    $allPassed = false;
}
echo "</div>";

// TEST 7: Test Database Connection
echo "<h2>Test 7: Database & Test Contact</h2>";
try {
    $contact = \App\Models\Contact::first();
    echo "<div class='test success'>";
    echo "<span class='icon'>✅</span> Database connection working<br>";
    
    if ($contact) {
        echo "<span class='icon'>✅</span> Test contact found<br>";
        echo "<strong>Contact Details:</strong><br>";
        echo "ID: {$contact->id}<br>";
        echo "Name: {$contact->name}<br>";
        echo "Email: {$contact->email}<br>";
        echo "Status: {$contact->status}<br>";
        echo "Created: {$contact->created_at}<br>";
    } else {
        echo "<span class='icon'>⚠️</span> No contacts in database<br>";
        echo "Create a test contact through your contact form first.<br>";
    }
    echo "</div>";
} catch (\Exception $e) {
    echo "<div class='test error'>";
    echo "<span class='icon'>❌</span> Database error: " . $e->getMessage() . "<br>";
    $allPassed = false;
    echo "</div>";
}

// TEST 8: Try to send a test email
echo "<h2>Test 8: Send Test Email</h2>";
if ($mailFrom && $contact) {
    echo "<div class='test'>";
    echo "<form method='POST' action='/debug-send-test-email' style='margin: 10px 0;'>";
    echo csrf_field();
    echo "<input type='hidden' name='contact_id' value='{$contact->id}'>";
    echo "<button type='submit' style='background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;'>
            Send Test Email to {$contact->email}
          </button>";
    echo "</form>";
    echo "<small>This will attempt to send a test email using your current configuration.</small>";
    echo "</div>";
} else {
    echo "<div class='test warning'>";
    echo "<span class='icon'>⚠️</span> Cannot test email: ";
    if (!$mailFrom) echo "Mail not configured. ";
    if (!$contact) echo "No test contact available. ";
    echo "</div>";
}

// FINAL SUMMARY
echo "<h2>📊 Summary</h2>";
if ($allPassed) {
    echo "<div class='test success'>";
    echo "<h3><span class='icon'>✅</span> All Tests Passed!</h3>";
    echo "<p>Everything looks good. The reply functionality should work.</p>";
    echo "<strong>Next Steps:</strong><br>";
    echo "1. Try sending a reply from admin panel<br>";
    echo "2. If it fails, check the error message<br>";
    echo "3. Check storage/logs/laravel.log for detailed errors<br>";
    echo "</div>";
} else {
    echo "<div class='test error'>";
    echo "<h3><span class='icon'>❌</span> Issues Found</h3>";
    echo "<p>Please fix the issues marked with ❌ above and try again.</p>";
    echo "<strong>Common Fixes:</strong><br>";
    echo "1. Run: composer dump-autoload<br>";
    echo "2. Run: php artisan route:clear<br>";
    echo "3. Run: php artisan cache:clear<br>";
    echo "4. Run: php artisan config:clear<br>";
    echo "5. Check file locations match the paths shown above<br>";
    echo "</div>";
}

echo "<h2>🔗 Quick Actions</h2>";
echo "<div class='test'>";
echo "<p><a href='/admin/contacts' style='color: #007bff;'>→ Go to Contact Management</a></p>";
echo "<p><strong>Run these commands in terminal:</strong></p>";
echo "<pre>composer dump-autoload
php artisan route:clear
php artisan cache:clear
php artisan config:clear
php artisan view:clear</pre>";
echo "</div>";

echo "</body></html>";