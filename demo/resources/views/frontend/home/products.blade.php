@if($products->isNotEmpty())
<div class="row">
    @foreach ($products as $product)
    <div class="col-sm-4">
        <div class="product-image-wrapper">
            <div class="single-products">
                <div class="productinfo text-center">
                    @if (!empty($product->image))
                    @php
                    $images = json_decode($product->image, true);
                    @endphp
                    @if (is_array($images) && count($images) > 0)
                    <img src="{{ asset('avatars/' . $images[0]) }}" alt="Product Image" width="150px" class="img-thumbnail">
                    @endif
                    @endif
                    <h2>${{ $product->price }}</h2>
                    <p>{{ $product->name }}</p>
                    <!-- <p>{{ $product->id_brand }}</p>
                    <p>{{ $product->id_category }}</p> -->
                    <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                </div>
                <div class="product-overlay">
                    <div class="overlay-content">
                        <h2>${{ $product->price }}</h2>
                        <p>{{ $product->name }}</p>
                        <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                    </div>
                </div>
            </div>
            <div class="choose">
                <ul class="nav nav-pills nav-justified">
                    <li><a href="{{ route('member-home.detail', ['id' => $product->id]) }}"><i class="fa fa-plus-square"></i>Product Detail</a></li>
                </ul>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="col-sm-12">
    <p class="text-center">No products found</p>
</div>
@endif
