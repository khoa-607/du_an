@extends('admin.layout.app')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add Country</h4>
            <form action="{{ route('countries.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter country name">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Add Country</button>
                <a href="{{ route('countries.index') }}" class="btn btn-secondary">Back to list</a>
            </form>
        </div>
    </div>
</div>
@endsection
