@extends('users.layouts.master')

@section('title', 'MM Laptops-Shop')

@section('content')
    <!-- Shopping Cart Section -->
    <div class="col-12 my-4">
        <h1 class="fw-bolder text-center mb-3 border-bottom border-3 pb-3 text-white bg-info">
            Shopping Cart
        </h1>
        <div class="table-responsive">
            @if ($cartProducts->count() > 0)
                <table class="table">
                    <thead>
                        <tr class="fw-bold">
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="dataTable">
                        @foreach ($cartProducts as $cart)
                            <tr>
                                <td>
                                    <img src="{{ asset('storage/product_images/' . $cart->product_image) }}"
                                        style="width: 80px">
                                    <span class="text-nowrap">{{ $cart->product_name }}</span>
                                </td>
                                <td class="fw-bold price">${{ $cart->product_price }}</td>
                                <td class="d-flex flex-nowrap">
                                    <button type="button" class="btn btn-white border-0 p-1 minus-btn">
                                        <i class="fa-solid fa-minus"></i>
                                    </button>
                                    <input type="text" class="border-0 text-center quantity-input" style="width:50px;"
                                        value="{{ $cart->quantity }}" min="1" disabled>
                                    <button type="button" class="btn btn-white border-0 p-1 plus-btn">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </td>
                                <td class="fw-bold" id="total">${{ $cart->quantity * $cart->product_price }}</td>
                                <td>
                                    <input type="hidden" class="user_id" value="{{ auth()->user()->id }}">
                                    <input type="hidden" class="product_id" value="{{ $cart->product_id }}">
                                    <input type="hidden" class="cartId" value="{{ $cart->id }}">
                                    <button type="button" class="border-0 cross-btn">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h1 class="text-center text-warning my-5 py-5">No products found in cart...</h1>
            @endif
        </div>
    </div>
    <!-- Cart Total Section -->
    <div class="col-12 col-md-6 mb-3">
        <table class="table bg-light">
            <thead>
                <tr class="fw-bolder h4">
                    <th>Cart Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr class="fw-bolder">
                    <td>Subtotal</td>
                    <td class="text-danger fs-5 subtotal">${{ $total }}</td>
                </tr>
                <tr class="fw-bolder">
                    <td>Shipping</td>
                    <td class="text-danger fs-5 shipping">$2.00</td>
                </tr>
                <tr class="fw-bolder">
                    <td>Total</td>
                    <td class="text-danger fs-5 final-total">${{ $total + 2.0 }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="button" id="checkout"
                            class="btn btn-info text-white fw-bold text-uppercase py-3 w-100">
                            Proceed to checkout
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let successMessage = sessionStorage.getItem('successMessage');

            if (successMessage) {
                Swal.fire(
                    'Good job!',
                    `${successMessage}`,
                    'success'
                );
                sessionStorage.removeItem('successMessage');
            }

            // for click cross button
            $('.cross-btn').click(function() {
                Swal.fire({
                    title: 'Oops!',
                    text: "Sure to remove this product from cart?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    if (result.isConfirmed) {
                        let parentNode = $(this).closest('tr');
                        let cartId = parentNode.find('.cartId').val();
                        let cartCount = $('#cartCount');
                        let cartCountValue = Number($('#cartCount').text());

                        $.ajax({
                            type: 'get',
                            url: '/shop/products/ajax/clear-current-product',
                            data: {
                                'cartId': cartId,
                            },
                            dataType: 'json',
                        });

                        // to decrease cart count badge
                        cartCount.text(cartCountValue - 1);
                        // to remove row
                        parentNode.remove();
                        // to calculate final
                        finalCalculation();
                    }
                })
            })

            // for finally proceed to checkout
            $('#checkout').click(function() {
                let orderLists = [];

                $('#dataTable tr').each(function(index, row) {
                    orderLists.push({
                        'product_id': $(row).find('.product_id').val(),
                        'user_id': $(row).find('.user_id').val(),
                        'quantity': $(row).find('.quantity-input').val(),
                        'total': $(row).find('#total').text().replace('$', ''),
                    })
                })

                $.ajax({
                    type: 'get',
                    url: '/shop/products/ajax/proceed-to-checkout',
                    data: Object.assign({}, orderLists),
                    dataType: 'json',
                    success: function(response) {
                        if (response.message == 'success') {
                            sessionStorage.setItem('successMessage',
                                'Your order is on its way!');
                            window.location.href = '/shop/products/checkout';
                        } else if (response.message == 'emptyError') {
                            // orderLists is empty array
                            return Swal.fire(
                                'Oops! Your order is empty.',
                                'Please select products to add to your order.',
                                'warning'
                            );
                        } else {
                            // some order's quantity is '0'
                            return Swal.fire(
                                'Invalid Quantity!',
                                'Please select a quantity greater than zero for each item in your order.',
                                'warning'
                            );
                        }
                    }
                })
            })

            function finalCalculation() {
                // for calculate cart total
                let subtotal = $('.subtotal');
                let shipping = $('.shipping');
                const shippingCost = parseFloat(shipping.text().replace('$', ''));
                let finalTotal = $('.final-total');
                // calculate subtotal and finaltotal
                let allTotalSum = 0;
                $('#dataTable tr').each(function(index, tr) {
                    allTotalSum += parseFloat($(tr).find('#total').text().replace('$', ''));
                })
                subtotal.text('$' + allTotalSum.toFixed(2));
                // for calculate final total
                let calculateFinalTotal = parseFloat(allTotalSum.toFixed(2)) + shippingCost;
                finalTotal.text('$' + calculateFinalTotal);
            }
        })
    </script>
@endsection
