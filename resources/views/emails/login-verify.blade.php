<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Verification Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #28a745;
            padding-bottom: 20px;
        }
        .shield-icon {
            font-size: 48px;
            color: #28a745;
            margin-bottom: 10px;
        }
        .verification-code {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border-radius: 8px;
            padding: 25px;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 8px;
            margin: 25px 0;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        .security-note {
            background: #e8f5e8;
            border: 1px solid #c3e6c3;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #ffc107;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
        .greeting {
            font-size: 18px;
            color: #28a745;
            font-weight: bold;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="shield-icon">🛡️</div>
            <h1 style="color: #28a745; margin: 0;">Login Security Verification</h1>
            <p style="color: #666; margin: 5px 0 0 0;">Infinity Account Protection</p>
        </div>

        <div class="greeting">
            Hello {{ $userName }}!
        </div>

        <p>We detected a login attempt to your Infinity account. For your security, please verify this login with the code below:</p>
        
        <div class="verification-code">
            {{ $verificationCode }}
        </div>

        <div class="security-note">
            <strong>🔒 Security Information:</strong>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>This code is valid for <strong>5 minutes only</strong></li>
                <li>Use this code to complete your login securely</li>
                <li>Each code can only be used once</li>
            </ul>
        </div>

        <div class="warning">
            <strong>⚠️ Important Security Notice:</strong><br>
            If you didn't attempt to log in, please:
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Do not share this code with anyone</li>
                <li>Consider changing your password immediately</li>
                <li>Contact our support team if needed</li>
            </ul>
        </div>

        <p><strong>Login Details:</strong></p>
        <ul>
            <li><strong>Time:</strong> {{ now()->format('F j, Y \a\t g:i A') }}</li>
            <li><strong>Account:</strong> {{ $userName }}</li>
        </ul>

        <p>Enter this code on the verification page to access your account securely.</p>

        <div class="footer">
            <p>This is an automated security email from Infinity. Please do not reply to this email.</p>
            <p><strong>Need Help?</strong> Contact our support team at support@infinity.com</p>
            <p>&copy; {{ date('Y') }} Infinity. All rights reserved.</p>
        </div>
    </div>
</body>
</html>