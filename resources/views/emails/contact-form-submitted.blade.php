<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #333; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .info-row { margin: 10px 0; }
        .label { font-weight: bold; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Contact Form Submission</h2>
        </div>
        <div class="content">
            <div class="info-row">
                <span class="label">Name:</span> {{ $contact->name }}
            </div>
            <div class="info-row">
                <span class="label">Email:</span> {{ $contact->email }}
            </div>
            @if($contact->phone)
            <div class="info-row">
                <span class="label">Phone:</span> {{ $contact->phone }}
            </div>
            @endif
            <div class="info-row">
                <span class="label">Message:</span><br>
                {{ $contact->message }}
            </div>
            <div class="info-row">
                <span class="label">Submitted:</span> {{ $contact->created_at->format('d M Y, h:i A') }}
            </div>
        </div>
    </div>
</body>
</html>