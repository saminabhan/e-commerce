<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset</title>
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
        }
        .reset-link {
            display: block;
            background: #007bff;
            color: #fff !important;
            text-decoration: none;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Password Reset Request</h1>
            <p>Hello {{ $user->name ?? 'User' }},</p>
        </div>

        <p>You are receiving this email because we received a password reset request for your account.</p>

        <a href="{{ $resetUrl }}" class="reset-link">
            🔑 Reset Your Password
        </a>

        <div class="warning">
            <strong>⚠️ Note:</strong> This password reset link will expire in 60 minutes.
        </div>

        <p>If you did not request a password reset, no further action is required.</p>

        <div class="footer">
            <p>This is an automated email from Sami Store. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} Sami Store. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
