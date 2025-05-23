<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['subject'] }}</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; }
        .email-container { max-width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .email-header { background-color: #4062B1; color: #fff; padding: 15px; text-align: center; font-size: 18px; }
        .email-body { padding: 20px; }
        .email-footer { background-color: #f8f8f8; padding: 10px; text-align: center; font-size: 14px; color: #666; }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            Sami Technology Store - New Contact Message
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2>New Message from {{ $data['name'] }}</h2>
            <p><strong>Subject:</strong> {{ $data['subject'] }}</p>
            <p><strong>Phone:</strong> {{ $data['phone'] }}</p>
            <p><strong>Email:</strong> {{ $data['email'] }}</p>
            <p><strong>Message:</strong><br>{{ $data['message'] }}</p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            © 2025 Infinity Co. - Designed by Sami W. Nabhan
        </div>
    </div>
</body>
</html>
