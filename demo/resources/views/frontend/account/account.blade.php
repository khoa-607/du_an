@extends('frontend.layout.app2')

@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <div class="blog-post-area">
                    <h2 class="title text-center">Update User Profile</h2>
                    <div class="signup-form"><!-- User Profile Update Form -->
                        <form method="POST" action="{{ route('account.update') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ auth()->user()->name }}" />
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ auth()->user()->email }}" />
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="text" id="phone" name="phone" class="form-control" value="{{ auth()->user()->phone }}" />
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea id="address" name="address" class="form-control" rows="5">{{ auth()->user()->address }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="id_country">Country</label>
                                <select name="id_country" class="form-control form-control-line">
                                    <option value="">{{ auth()->user()->id_country }}</option>
                                    <option value="London" {{ auth()->user()->id_country == 'London' ? 'selected' : '' }}>London</option>
                                    <option value="India" {{ auth()->user()->id_country == 'India' ? 'selected' : '' }}>India</option>
                                    <option value="USA" {{ auth()->user()->id_country == 'Usa' ? 'selected' : '' }}>Usa</option>
                                    <option value="Canada" {{ auth()->user()->id_country == 'Canada' ? 'selected' : '' }}>Canada</option>
                                    <option value="Thailand" {{ auth()->user()->id_country == 'Thailand' ? 'selected' : '' }}>Thailand</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="avatar">Avatar</label>
                                <input type="file" id="avatar" name="avatar" class="form-control-file" />
                                <img src="{{ url('/avatars/' . auth()->user()->avatar) }}" width="100px"/>
                            </div>
                            <button type="submit" class="btn btn-default">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
