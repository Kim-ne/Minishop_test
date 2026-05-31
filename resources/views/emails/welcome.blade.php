<x-mail::message>
# Chào mừng {{ $user->name }}! 🎉

Thanks for joining **Mini Shop**.

Your account registration details are as follows:

- **Email:** {{ $user->email }}
- **Created At:** {{ $user->created_at->format('d/m/Y') }}

Happy shopping!

<x-mail::button :url="'/'">
Go to Mini Shop
</x-mail::button>

Best regards,<br>
**Mini Shop Team**
</x-mail::message>
