@extends('frontend.layout.app3')

@section('content')
<div class="page-wrapper " style="display: block;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form">
                    <h2>Register an Account</h2>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.submit') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required />
                        <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required />
                        <input type="password" name="password" placeholder="Password" required />
                        <input type="text" name="phone" placeholder="Phone Number" value="{{ old('phone') }}" required />
                        <textarea name="address" placeholder="Address" rows="5" required>{{ old('address') }}</textarea>
                        <br>
                        <br>
                        <select name="id_country" required>
                            <option value="">Select Country</option>
                            <option value="London">London</option>
                            <option value="India">India</option>
                            <option value="Usa">Usa</option>
                            <option value="Canada">Canada</option>
                            <option value="Thailand">Thailand</option>
                        </select>
                        <br>
                        <br>
                        <input type="file" name="avatar" required />
                        <button type="submit" class="btn btn-default">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
