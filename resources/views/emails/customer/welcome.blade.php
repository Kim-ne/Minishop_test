<x-mail::message>
# Welcome {{ $customer->full_name }}! 🎉

Thanks for registering to **Mini Shop**.

Your account registration details are as follows:

- **Name:** {{ $customer->full_name }}
- **Email:** {{ $customer->email }}
- **Created At:** {{ $customer->created_at->format('d/m/Y') }}

Happy shopping!

<x-mail::button :url="'/'">
Go to Mini Shop
</x-mail::button>

Best regards,<br>
**Mini Shop Team**
</x-mail::message>
