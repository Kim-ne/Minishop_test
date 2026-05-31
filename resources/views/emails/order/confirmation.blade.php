<x-mail::message>
# Order Confirmation

Thanks for your order at **Mini Shop**!

**Order Code:** {{ $order->code }}
**Order date:** {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}
**Payment method:** {{ $order->payment_method }}

---

## Order Details

<x-mail::table>
| Product | Quantity | Unit price | Total |
|:---------|:--------:|--------:|-----------:|
@foreach ($order->items as $item)
| {{ $item->product->name }} | {{ $item->qty }} | {{ number_format($item->price, 0, ',', '.') }} USD | {{ number_format($item->price * $item->qty, 0, ',', '.') }} USD|
@endforeach
</x-mail::table>

---

**Total amount: {{ number_format($order->total_amount, 0, ',', '.') }} USD**

@if ($order->notes)
**Notes:** {{ $order->notes }}
@endif

Thanks for your order.

Best regards,<br>
**Mini Shop Team**
</x-mail::message>
