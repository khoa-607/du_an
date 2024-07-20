@extends('frontend.layout.app2')

@section('content')
<div class="row">
    <div class="col-sm-9">
        <h2 class="title text-center">Products List</h2>
        <a href="{{ route('account.add-product') }}" class="btn btn-primary mb-3">Add Product</a>
        <div class="table-responsive cart_info">
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="id">ID</td>
                        <td class="image">Image</td>
                        <td class="description">Name</td>
                        <td class="price">Price</td>
                        <td class="total">Action</td>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($products) && $products->isNotEmpty())
                        @foreach ($products as $product)
                            <tr>
                                <td class="id_product">
                                    <p>{{ $product->id }}</p>
                                </td>
                                <td class="cart_product">
                                    @if (!empty($product->image))
                                        @php
                                            $images = json_decode($product->image, true);
                                        @endphp
                                        @if (is_array($images) && count($images) > 0)
                                            <img src="{{ asset('avatars/' . $images[0]) }}" alt="Product Image" width="150px" class="img-thumbnail">
                                        @endif
                                    @endif
                                </td>
                                <td class="cart_description">
                                    <p>{{ $product->name }}</p>
                                </td>
                                <td class="cart_price">
                                    <p>${{ $product->price }}</p>
                                </td>
                                <td class="cart_total">
                                    <a href="{{ route('account.edit-product', $product->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('account.delete-product', $product->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">No products found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
