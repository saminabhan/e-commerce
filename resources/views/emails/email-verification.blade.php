<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 30px 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: normal;
        }
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        .verification-code {
            background-color: #f8f9fa;
            border: 2px dashed #007bff;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 8px;
            color: #007bff;
            font-family: 'Courier New', monospace;
        }
        .message {
            color: #333;
            line-height: 1.6;
            margin: 20px 0;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: left;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Email Verification</h1>
        </div>
        
        <div class="content">
            <h2>Verify Your New Email Address</h2>
            
            <p class="message">
                You have requested to change your email address. To complete this process, 
                please use the verification code below:
            </p>
            
            <div class="verification-code">
                {{ $verificationCode }}
            </div>
            
            <div class="warning">
                <strong>Important:</strong>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>This code will expire in <strong>5 minutes</strong></li>
                    <li>Do not share this code with anyone</li>
                    <li>If you didn't request this change, please ignore this email</li>
                </ul>
            </div>
            
            <p class="message">
                If you have any questions or need assistance, please contact our support team.
            </p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Sami Store. All rights reserved.</p>
            <p>This is an automated message, please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>