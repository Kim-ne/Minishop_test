
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 8px; padding: 32px; }
        .btn { display: inline-block; padding: 12px 28px; background: #4f46e5; color: #fff;
               text-decoration: none; border-radius: 6px; font-size: 15px; margin: 24px 0; }
        .footer { margin-top: 32px; font-size: 13px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hello, {{ $user->name }}!</h2>
        <p>Thank you for registering. Please click the button below to verify your email address.</p>

        <a href="{{ $verificationUrl }}" class="btn">Verify Email</a>

        <p>This link will expire in <strong>60 minutes</strong>.</p>
        <p>If you did not register, please ignore this email.</p>

        <div class="footer">
            If the button is not working, copy the link below into your browser:<br>
            <a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a>
        </div>
    </div>
</body>
</html>
