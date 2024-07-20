@extends('frontend.layout.app2')

@section('content')
<div class="col-sm-9">
    <h2 class="title text-center">Add New Product</h2>
    <form method="POST" action="{{ route('account.add-product') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="id_user" name="id_user" value="{{ Auth::id() }}">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" id="price" name="price" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="id_category">Category</label>
            <select id="id_category" name="id_category" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="id_brand">Brand</label>
            <select id="id_brand" name="id_brand" class="form-control" required>
                @foreach($brands as $brand)
                    <option value="{{ $brand->name }}">{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" class="form-control" required>
                <option value="0">New</option>
                <option value="1">Sale</option>
            </select>
        </div>
        <div class="form-group" id="sale_group" style="display:none;">
            <label for="sale">Sale (%)</label>
            <input type="text" id="sale" name="sale" class="form-control">
        </div>
        <div class="form-group">
            <label for="company">Company</label>
            <input type="text" id="company" name="company" class="form-control">
        </div>
        <div class="form-group">
            <label for="image">Images (max 3 images)</label>
            <input type="file" id="image" name="image[]" class="form-control-file" multiple accept="image/*" required>
        </div>
        <div class="form-group">
            <label for="detail">Detail</label>
            <textarea id="detail" name="detail" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Product</button>
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
