<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #333; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Thank You for Contacting Artfauj</h2>
        </div>
        <div class="content">
            <p>Dear {{ $contact->name }},</p>
            <p>Thank you for reaching out to us. We have received your message and our team will get back to you within 24-48 hours.</p>
            <p><strong>Your Message:</strong><br>{{ $contact->message }}</p>
            <p>If you have any urgent queries, please feel free to call us at:<br>
            +91 94267 24282 or +91 94294 08688</p>
            <p>Best regards,<br>
            <strong>Team Artfauj</strong></p>
        </div>
    </div>
</body>
</html>