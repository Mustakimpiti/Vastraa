<!DOCTYPE html>
<html>
<head>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            line-height: 1.6; 
            color: #333; 
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container { 
            max-width: 600px; 
            margin: 20px auto; 
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header { 
            background: #2c3e50; 
            color: white; 
            padding: 30px 20px; 
            text-align: center; 
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
        }
        .content { 
            padding: 30px 20px; 
        }
        .content p {
            margin: 15px 0;
        }
        .original-message {
            background: #f9f9f9;
            border-left: 4px solid #2c3e50;
            padding: 15px;
            margin: 20px 0;
        }
        .original-message h4 {
            margin: 0 0 10px 0;
            color: #666;
            font-size: 14px;
            text-transform: uppercase;
        }
        .admin-reply {
            background: #e8f5e9;
            border-left: 4px solid #4caf50;
            padding: 15px;
            margin: 20px 0;
        }
        .admin-reply h4 {
            margin: 0 0 10px 0;
            color: #2e7d32;
            font-size: 14px;
            text-transform: uppercase;
        }
        .footer {
            background: #f9f9f9;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #ddd;
        }
        .footer p {
            margin: 5px 0;
            font-size: 13px;
            color: #666;
        }
        .contact-info {
            margin-top: 15px;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Reply from Artfauj</h2>
        </div>
        
        <div class="content">
            <p>Dear {{ $contact->name }},</p>
            
            <p>Thank you for reaching out to us. We are pleased to respond to your inquiry:</p>
            
            <div class="admin-reply">
                <h4>Our Response:</h4>
                <p>{{ $contact->admin_reply }}</p>
            </div>
            
            <div class="original-message">
                <h4>Your Original Message:</h4>
                <p>{{ $contact->message }}</p>
                <p style="font-size: 12px; color: #999; margin-top: 10px;">
                    <em>Sent on {{ $contact->created_at->format('M d, Y h:i A') }}</em>
                </p>
            </div>
            
            <p>If you have any further questions or need additional assistance, please don't hesitate to contact us.</p>
            
            <div class="contact-info">
                <p><strong>Contact Information:</strong></p>
                <p>Phone: +91 94267 24282 / +91 94294 08688</p>
                <p>Email: info@artfauj.com</p>
            </div>
        </div>
        
        <div class="footer">
            <p><strong>Best regards,</strong></p>
            <p><strong>Team Artfauj</strong></p>
            <p style="margin-top: 15px; color: #999; font-size: 12px;">
                This is an automated response. Please do not reply directly to this email.
            </p>
        </div>
    </div>
</body>
</html>