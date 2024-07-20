@extends('frontend.layout.app1')

@section('content')
<div class="col-sm-9 padding-right">
    <div class="features_items">
        <h2 class="title text-center">Features Items</h2>
        <div class="search-form">
            <form id="searchForm" action="{{ route('member-home.search') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="price" class="form-control">
                                <option value="">Select price</option>
                                <option value="<50">< $50</option>
                                <option value="50-100">$50 - $100</option>
                                <option value="100-200">$100 - $200</option>
                                <option value="200-500">$200 - $500</option>
                                <option value=">500">> $500</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="category" class="form-control">
                                <option value="">Select category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id_category }}">{{ $category->id_category }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="brand" class="form-control">
                                <option value="">Select brand</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id_brand }}">{{ $brand->id_brand }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="status" class="form-control">
                                <option value="">Select status</option>
                                <option value="1">On Sale</option>
                                <option value="0">Not on Sale</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="price_min" id="price_min">
                <input type="hidden" name="price_max" id="price_max">
            </form>
        </div>
        <div id="products">
            @include('frontend.home.products', ['products' => $products])
        </div>
    </div>
</div>
@endsection

