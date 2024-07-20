@extends('admin.layout.app')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Delete Brand</h4>
            <form action="{{ route('brands.destroy', $brand->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="form-group">
                    <p>Are you sure you want to delete this brand?</p>
                </div>
                <button type="submit" class="btn btn-danger">Delete</button>
                <a href="{{ route('brands.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
