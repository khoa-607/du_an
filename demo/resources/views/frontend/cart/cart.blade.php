@extends('frontend.layout.app3')

@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{ route('member-home') }}">Home</a></li>
                <li class="active">Shopping Cart</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Item</td>
                        <td class="description"></td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                            <tr data-id="{{ $id }}">
                                <td class="cart_product">
                                    <a href=""><img src="{{ asset('avatars/' . json_decode($details['image'], true)[0]) }}" alt="" width = 100px></a>
                                </td>
                                <td class="cart_description">
                                    <h4><a href="">{{ $details['name'] }}</a></h4>
                                    <p>Web ID: {{ $id }}</p>
                                </td>
                                <td class="cart_price">
                                    <p>${{ $details['price'] }}</p>
                                </td>
                                <td class="cart_quantity">
                                    <div class="cart_quantity_button">
                                        <a class="cart_quantity_up" href="javascript:void(0)" data-action="increase"> + </a>
                                        <input class="cart_quantity_input" type="text" name="quantity" value="{{ $details['quantity'] }}" autocomplete="off" size="2" readonly>
                                        <a class="cart_quantity_down" href="javascript:void(0)" data-action="decrease"> - </a>
                                    </div>
                                </td>
                                <td class="cart_total">
                                    <p class="cart_total_price">${{ $details['price'] * $details['quantity'] }}</p>
                                </td>
                                <td class="cart_delete">
                                    <a class="cart_quantity_delete" href="javascript:void(0)" data-action="remove"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">Your cart is empty</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</section>

<section id="do_action">
    <div class="container">
        <div class="heading">
            <h3>What would you like to do next?</h3>
            <p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="chose_area">
                    <ul class="user_option">
                        <li>
                            <input type="checkbox">
                            <label>Use Coupon Code</label>
                        </li>
                        <li>
                            <input type="checkbox">
                            <label>Use Gift Voucher</label>
                        </li>
                        <li>
                            <input type="checkbox">
                            <label>Estimate Shipping & Taxes</label>
                        </li>
                    </ul>
                    <ul class="user_info">
                        <li class="single_field">
                            <label>Country:</label>
                            <select>
                                <option>United States</option>
                                <option>Bangladesh</option>
                                <option>UK</option>
                                <option>India</option>
                                <option>Pakistan</option>
                                <option>Ukraine</option>
                                <option>Canada</option>
                                <option>Dubai</option>
                            </select>
                        </li>
                        <li class="single_field">
                            <label>Region / State:</label>
                            <select>
                                <option>Select</option>
                                <option>Dhaka</option>
                                <option>London</option>
                                <option>Delhi</option>
                                <option>Lahore</option>
                                <option>Alaska</option>
                                <option>Canada</option>
                                <option>Dubai</option>
                            </select>
                        </li>
                        <li class="single_field zip-field">
                            <label>Zip Code:</label>
                            <input type="text">
                        </li>
                    </ul>
                    <a class="btn btn-default update" href="">Get Quotes</a>
                    <a class="btn btn-default check_out" href="">Continue</a>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        <li>Cart Sub Total <span id="cart-sub-total">${{ session('cart') ? array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], session('cart'))) : 0 }}</span></li>
                        <li>Eco Tax <span>$2</span></li>
                        <li>Shipping Cost <span>Free</span></li>
                        <li>Total <span id="cart-total">${{ session('cart') ? array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], session('cart'))) + 2 : 0 }}</span></li>
                    </ul>
                    <a class="btn btn-default update" href="">Update</a>
                    <a class="btn btn-default check_out" href="">Check Out</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        function updateCart(productId, quantity) {
            $.ajax({
                url: '{{ route("cart.update") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        function removeFromCart(productId) {
            $.ajax({
                url: '{{ route("cart.remove") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        $('.cart_quantity_up').on('click', function() {
            var tr = $(this).closest('tr');
            var productId = tr.data('id');
            var quantityInput = tr.find('.cart_quantity_input');
            var quantity = parseInt(quantityInput.val()) + 1;

            quantityInput.val(quantity);
            updateCart(productId, quantity);
        });

        $('.cart_quantity_down').on('click', function() {
            var tr = $(this).closest('tr');
            var productId = tr.data('id');
            var quantityInput = tr.find('.cart_quantity_input');
            var quantity = parseInt(quantityInput.val()) - 1;

            if (quantity > 0) {
                quantityInput.val(quantity);
                updateCart(productId, quantity);
            }
        });

        $('.cart_quantity_delete').on('click', function() {
            var tr = $(this).closest('tr');
            var productId = tr.data('id');
            removeFromCart(productId);
        });
    });
</script>

@endsection
