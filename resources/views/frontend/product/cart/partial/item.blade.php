
@foreach ($cart as $item)

    <tr>
        <form action="{{ route('cart.update', ['id' => $item->id]) }}" method="post">
            @csrf
            @method('PUT')
           
            <td class="align-middle"><img src="{{ $item->image }}" alt="" style="width: 50px;"> {{ $item->name }}</td>
            <td class="align-middle">{{ number_format($item->price * 1000) }} VND</td>
            <td class="align-middle">
                <div class="input-group quantity mx-auto" style="width: 100px;">
                    <div class="input-group-btn">
                        <button class="btn btn-sm btn-primary btn-minus" type="submit" value="{{ $item->buy_qty - 1 }}"
                            name="qty"><i class=" fa fa-minus "></i>
                        </button>
                    </div>
                    <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center"
                        value="{{ $item->buy_qty }}" min="0" disabled>
                    <div class="input-group-btn">
                        <button class="btn btn-sm btn-primary btn-plus" type="submit" value="{{$item->buy_qty + 1 }}"
                            name="qty"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </td>
            <td class="align-middle">{{ number_format($item->price * 1000 * $item->buy_qty) }} VND</td>
            </form>
            <td class="align-middle"><a class="btn btn-sm btn-danger"
                    onclick="return confirm('would you like to remove this item ?')"
                    href="{{ route('cart.remove', ['id' => $item->id]) }}"><i class="fa fa-times"></i></a></td>
    </tr>
@endforeach
