<x-mail::message>
# Status Order Update: {{ $order->code }}

Order **{{ $order->code }}** of yours has been updated.

---

## Order Information

- **Order Code:** {{ $order->code }}
- **Order Date:** {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}
- **New Status:** {{ $order->status_label }}

---

@switch($order->status)
    @case(1)
<x-mail::panel>
🧾 Your order is received and is being processed.
</x-mail::panel>
    @break

    @case(2)
<x-mail::panel>
🚚 Your order is on its way to you.
</x-mail::panel>
    @break

    @case(3)
<x-mail::panel>
✅ Your order has been delivered. We hope you enjoy your purchase!
</x-mail::panel>
    @break

    @case(4)
<x-mail::panel>
❌ Your order has been cancelled. If you have any questions, please contact our support team.
</x-mail::panel>
    @break
@endswitch

---

## Order Details

<x-mail::table>
| Product | Quantity | Price | Total |
|:---------|:--------:|--------:|-----------:|
@foreach ($order->items as $item)
| {{ $item->product->name }} | {{ $item->qty }} | {{ number_format($item->price, 0, ',', '.') }} USD | {{ number_format($item->price * $item->qty, 0, ',', '.') }} USD |
@endforeach
</x-mail::table>

**Total amount: {{ number_format($order->total_amount, 0, ',', '.') }} USD**

Thanks for your order,<br>
**Mini Shop Team**
</x-mail::message>
