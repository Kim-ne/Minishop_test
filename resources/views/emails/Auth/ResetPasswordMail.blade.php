<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reset Password</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; }
        .btn { display: inline-block; padding: 12px 24px; background: #4F46E5; color: #fff;
               text-decoration: none; border-radius: 6px; margin: 20px 0; }
        .footer { margin-top: 20px; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hello, {{ $user->name }}!</h2>
        <p>We received a request to reset your password.</p>
        <p>Click the button below to reset it. This link will expire in <strong>60 minutes</strong>.</p>

        <a href="{{ $resetLink }}" class="btn">Reset Password</a>

        <p>If you did not request a password reset, no further action is required. your password will not be changed.</p>
        <p>If the button doesn't work, copy and paste this link into your browser:</p>
        <p>{{ $resetLink }}</p>

        <div class="footer">
            &copy; {{ date('Y') }} — This email was sent automatically by our system. Please do not reply.
        </div>
        </div>
    </div>
</body>
</html>
