@extends('frontend.layout.app3')

@section('content')
	<div class="col-sm-4 col-sm-offset-1">
		<div class="login-form"><!--login form-->
			<h2>Login to your account</h2>
			<form method="POST" action="{{ route('login.submit') }}">
				@csrf
				<input type="email" name="email" placeholder="Email Address" required />
				<input type="password" name="password" placeholder="Password" required />
				<span>
					<input type="checkbox" name="remember_me" class="checkbox"> 
					Keep me signed in
				</span>
				<button type="submit" class="btn btn-default">Login</button>
			</form>
		</div><!--/login form-->
	</div>
@endsection
