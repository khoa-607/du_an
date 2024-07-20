@extends('admin.layout.app')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Delete Country</h4>
            <form action="{{ route('countries.destroy', $country->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="form-group">
                    <p>Are you sure you want to delete this country?</p>
                </div>
                <button type="submit" class="btn btn-danger">Delete</button>
                <a href="{{ route('countries.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
