@extends('admin.layout.app')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Country</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($countries as $country)
                        <tr>
                            <td scope="row">{{ $country->id }}</td>
                            <td>{{ $country->name }}</td>
                            <td class="m-icon">
                                <a href="{{ route('countries.edit', $country->id) }}" class="btn btn-primary">
                                    <i class="mdi mdi-account-edit"></i> Edit
                                </a>
                                <form action="{{ route('countries.destroy', $country->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this country?')">
                                        <i class="mdi mdi-delete"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ route('countries.create') }}" class="btn btn-secondary">Add country</a>
            </div>
        </div>
    </div>
</div>
@endsection
