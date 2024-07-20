@extends('admin.layout.app')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Blog</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th> 
                            <th scope="col">Description</th> 
                            <th scope="col">Image</th> 
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blogs as $blog) 
                        <tr>
                            <td scope="row">{{ $blog->id }}</td> 
                            <td>{{ $blog->title }}</td> 
                            <td>{!! $blog->description !!}</td>
                            <td>
                                <img src="{{ url('/avatars/' . $blog->image) }}" alt="Blog Image" style="max-width: 100px;">
                            </td>
                            <td class="m-icon">
                                <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-primary">
                                    <i class="mdi mdi-account-edit"></i> Edit
                                </a>
                                <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" >
                                        <i class="mdi mdi-delete"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ route('blogs.create') }}" class="btn btn-secondary">Add Blog</a>
            </div>
        </div>
    </div>
</div>
@endsection
