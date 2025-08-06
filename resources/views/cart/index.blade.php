@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Your Cart</h2>

    @if(count($cart) > 0)
        <form  id="orderForm" action="{{ route('cart.storeOrder') }}" method="POST">
            @csrf


            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price (EGP)</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $productId => $item)
                        @php $total += $item['price'] * $item['quantity']; @endphp
                        <tr>
                            <td>
                                @if($item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" style="height: 60px">
                                @endif
                            </td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['price'] }}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-between" style="max-width: 120px;">
                                    <button type="button" class="btn btn-sm btn-outline-secondary update-qty" data-id="{{ $productId }}" data-type="decrease">-</button>

                                    <span class="mx-2 quantity-value" id="qty-val-{{ $productId }}">{{ $item['quantity'] }}</span>

                                    <button type="button" class="btn btn-sm btn-outline-secondary update-qty" data-id="{{ $productId }}" data-type="increase">+</button>
                                </div>
                                <input type="hidden" name="quantities[{{ $productId }}]" id="qty-input-{{ $productId }}" value="{{ $item['quantity'] }}">
                            </td>

                            <td>{{ $item['price'] * $item['quantity'] }}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm delete-item" data-id="{{ $productId }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end mb-4">
                <h4>Total: <strong>{{ $total }} EGP</strong></h4>
            </div>


            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <h4 class="mb-3">Customer Information</h4>

            <div class="mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" name="phone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Shipping Address</label>
                <textarea name="address" class="form-control" required></textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">Place Order</button>
            </div>
        </form>
    @else
        <p>Your cart is empty.</p>
    @endif
</div>
@section('scripts')
<script>
$(document).ready(function () {

    // to increment or dicrement qty
    $(document).on('click', '.update-qty', function () {
        let productId = $(this).data('id');
        let type = $(this).data('type');

        let quantityInput = $(`#qty-input-${productId}`);
        let quantityDisplay = $(`#qty-val-${productId}`);

        let currentQty = parseInt(quantityInput.val());

        if (type === 'increase') {
            currentQty++;
        } else if (type === 'decrease' && currentQty > 1) {
            currentQty--;
        }

        quantityInput.val(currentQty);
        quantityDisplay.text(currentQty);

        updateTotal();
    });

    // to delete item from card
    $(document).on('click', '.delete-item', function () {
        if (!confirm('Are you sure you want to remove this item?')) return;

        let row = $(this).closest('tr');
        row.remove();

        updateTotal();
    });

    // to up date total price after increment
    function updateTotal() {
        let total = 0;

        $('tbody tr').each(function () {
            let price = parseFloat($(this).find('td:eq(2)').text());
            let qty = parseInt($(this).find('input[type="hidden"]').val());

            if (!isNaN(price) && !isNaN(qty)) {
                total += price * qty;
                $(this).find('td:eq(4)').text(price * qty);
            }
        });

        $('h4 strong').text(total + ' EGP');
    }

    // send the form data
    $('#orderForm').on('submit', function (e) {
        e.preventDefault();

        // to reload the quantity before sending
        $('.quantity-value').each(function () {
            let productId = $(this).attr('id').replace('qty-val-', '');
            let qty = $(this).text();
            $(`#qty-input-${productId}`).val(qty);
        });

        let form = $(this)[0];
        let formData = new FormData(form);

        // ✅ Debug فقط
        // for (let pair of formData.entries()) {
        //     console.log(`${pair[0]}: ${pair[1]}`);
        // }

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                window.location.href = '/';
            },
            error: function (xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    for (let key in errors) {
                        errorMessages += errors[key][0] + "\n";
                    }
                    alert("Error:\n" + errorMessages);
                } else {
                    console.error('Unexpected error response:', xhr.responseText);
                    alert('something wrong');
                }
            }
        });
    });

});
</script>
@endsection

@endsection
