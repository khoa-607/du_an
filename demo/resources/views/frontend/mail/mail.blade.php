@extends('frontend.layout.app3')

@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="#">Home</a></li>
              <li class="active">Check out</li>
            </ol>
        </div><!--/breadcrums-->

        <div class="review-payment">
            <h2>Review & Payment</h2>
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
                                    <a href=""><img src="{{ asset('avatars/' . json_decode($details['image'], true)[0]) }}" alt="" width="100px"></a>
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
                                        <input class="cart_quantity_input" type="text" name="quantity" value="{{ $details['quantity'] }}" autocomplete="off" size="2" readonly>
                                    </div>
                                </td>
                                <td class="cart_total">
                                    <p class="cart_total_price">${{ $details['price'] * $details['quantity'] }}</p>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4">&nbsp;</td>
                            <td colspan="2">
                                <table class="table table-condensed total-result">
                                    <tr>
                                        <td>Cart Sub Total</td>
                                        <td>${{ array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], session('cart'))) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Eco Tax</td>
                                        <td>$2</td>
                                    </tr>
                                    <tr class="shipping-cost">
                                        <td>Shipping Cost</td>
                                        <td>Free</td>                                        
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td><span>${{ array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], session('cart'))) + 2 }}</span></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="6" class="text-center">Your cart is empty</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="payment-options">
            <span>
                <label><input type="checkbox"> Direct Bank Transfer</label>
            </span>
            <span>
                <label><input type="checkbox"> Check Payment</label>
            </span>
            <span>
                <label><input type="checkbox"> Paypal</label>
            </span>
            <button id="sendMailButton">Send Mail</button>
        </div>
    </div>
</section>

<script>
    document.getElementById('sendMailButton').addEventListener('click', function() {
        const cart = @json(session('cart'));
        const cartHTML = document.querySelector('.table-responsive').innerHTML;
        const queryString = new URLSearchParams({
            cart: JSON.stringify(cart),
            cartHTML: cartHTML
        }).toString();

        window.location.href = "{{ route('mail.send') }}" + "?" + queryString;
    });
</script>

@endsection
