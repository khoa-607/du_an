@extends('frontend.layout.app2')

@section('content')
<div class="col-sm-9">
    <h2 class="title text-center">Edit Product</h2>
    <form method="POST" action="{{ route('account.update-product', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="form-group">
            <label for="id_user">User ID</label>
            <input type="text" id="id_user" name="id_user" class="form-control" value="{{ $product->id_user }}" readonly>
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" id="price" name="price" class="form-control" value="{{ $product->price }}" required>
        </div>
        <div class="form-group">
            <label for="id_category">Category</label>
            <select id="id_category" name="id_category" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->id_category == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="id_brand">Brand</label>
            <select id="id_brand" name="id_brand" class="form-control" required>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ $product->id_brand == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control" required>
                <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>New</option>
                <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Sale</option>
            </select>
        </div>
        <div class="form-group" id="sale_group" style="display: {{ $product->status == 1 ? 'block' : 'none' }};">
            <label for="sale">Sale (%)</label>
            <input type="text" id="sale" name="sale" class="form-control" value="{{ $product->sale }}">
        </div>
        <div class="form-group">
            <label for="company">Company</label>
            <input type="text" id="company" name="company" class="form-control" value="{{ $product->company }}">
        </div>
        <div class="form-group">
            <label for="image">Images (max 3 images)</label>
            <input type="file" id="image" name="image[]" class="form-control-file" multiple accept="image/*">
            @if (!empty($product->image))
                @php
                    $images = json_decode($product->image, true);
                @endphp
                @if (is_array($images))
                    @foreach ($images as $key => $image)
                        <div class="img-container" style="margin-bottom: 10px;">
                            <img src="{{ asset('avatars/' . $image) }}" alt="Product Image" width="150px" class="img-thumbnail">
                            <label>
                                <input type="checkbox" name="delete_images[]" value="{{ $key }}"> Delete
                            </label>
                        </div>
                    @endforeach
                @endif
            @endif
        </div>
        <div class="form-group">
            <label for="detail">Detail</label>
            <textarea id="detail" name="detail" class="form-control">{{ $product->detail }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusSelect = document.getElementById('status');
        const salePercentageGroup = document.getElementById('sale_group');

        statusSelect.addEventListener('change', function () {
            if (this.value === '1') {
                salePercentageGroup.style.display = 'block';
            } else {
                salePercentageGroup.style.display = 'none';
            }
        });
    });
</script>
@endsection
