@foreach ($cart as $item)
    <tr>
        <td class="align-middle"><img src="{{ $item->image }}" alt="" style="width: 50px;"> {{ $item->name }}</td>
        <td class="align-middle">{{ number_format($item->price *1000) }} VND</td>
        <td class="align-middle">
            <div class="input-group quantity mx-auto" style="width: 100px;">
                <div class="input-group-btn">
                    <button class="btn btn-sm btn-primary btn-minus">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
                <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center" value="{{ $item->buy_qty }}">
                <div class="input-group-btn">
                    <button class="btn btn-sm btn-primary btn-plus">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
        </td>
        <td class="align-middle">{{ number_format($item->price * 1000 * $item->buy_qty) }} VND</td>
        <td class="align-middle"><button class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button></td>
    </tr>
@endforeach
