@extends('frontend.layout.app1')

@section('content')
<div class="col-sm-9 padding-right">
    <div class="product-details">
        <div class="col-sm-5">
            <div class="view-product">
                @if (!empty($product->image))
                    @php
                        $images = json_decode($product->image, true);
                    @endphp
                    @if (is_array($images) && count($images) > 0)
                        <img id="main-product-image" src="{{ asset('avatars/' . $images[0]) }}" alt="" />
                        <a id="zoom-link" href="{{ asset('avatars/' . $images[0]) }}" rel="prettyPhoto"><h3>ZOOM</h3></a>
                    @endif
                @endif
            </div>
            <div id="similar-product" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="item active">
                        @if (!empty($product->image))
                            @php
                                $images = json_decode($product->image, true);
                            @endphp
                            @if (is_array($images) && count($images) > 0)
                                @foreach ($images as $image)
                                    <img class="thumbnail-img" src="{{ asset('avatars/' . $image) }}" alt="" width="60px" />
                                @endforeach
                            @endif
                        @endif
                    </div>
                </div>
                <a class="left item-control" href="#similar-product" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="right item-control" href="#similar-product" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="product-information">
                <img src="{{ asset('/frontend/images/product-details/new.jpg') }}" class="newarrival" alt="" />
                <h2>{{ $product->name }}</h2>
                <p>Web ID: {{ $product->id }}</p>
                <img src="{{ asset('/frontend/images/product-details/rating.png') }}" alt="" />
                <span>
                    <span>US ${{ $product->price }}</span>
                    <label>Quantity:</label>
                    <input type="number" id="quantity" value="1" min="1" />
                    <button type="button" id="add-to-cart" class="btn btn-default cart" data-product-id="{{ $product->id }}">
                        <i class="fa fa-shopping-cart"></i>
                        Add to cart
                    </button>
                </span>
                <p><b>Availability:</b> In Stock</p>
                <p><b>Condition:</b> {{ $product->sale }} (sale)</p>
                <p><b>Brand:</b> {{ $product->id_brand }}</p>
                <a href=""><img src="{{ asset('/frontend/images/product-details/share.png') }}" class="share img-responsive" alt="" /></a>
            </div>
        </div>
    </div>

    <div class="category-tab shop-details-tab">
        <div class="col-sm-12">
            <ul class="nav nav-tabs">
                <li><a href="#details" data-toggle="tab">Details</a></li>
                <li><a href="#companyprofile" data-toggle="tab">Company Profile</a></li>
                <li><a href="#tag" data-toggle="tab">Tag</a></li>
                <li class="active"><a href="#reviews" data-toggle="tab">Reviews (5)</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="reviews">
                <div class="col-sm-12">
                    <ul>
                        @if ($user)
                            <li><a href=""><i class="fa fa-user"></i>{{ $user->name }}</a></li>
                        @else
                            <li><a href=""><i class="fa fa-user"></i>Guest</a></li>
                        @endif
                        <li><a href=""><i class="fa fa-clock-o"></i>{{ $product->created_at }}</a></li>
                        <li><a href=""><i class="fa fa-calendar-o"></i>{{ $product->updated_at }}</a></li>
                    </ul>
                    <p>{{ $product->detail }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#add-to-cart').on('click', function() {
            var productId = $(this).data('product-id');
            var quantity = $('#quantity').val();
            
            $.ajax({
                url: '{{ route("cart.add") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    quantity: quantity
                },
                success: function(response) {
                    $('#cart-quantity').text(response.cartQuantity);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
