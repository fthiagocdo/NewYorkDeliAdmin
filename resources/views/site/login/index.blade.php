@extends('layouts.site')

@section('content')
<div class="row hide-on-med-and-up"></div>
<div class="container">
		<div class="login-container">
			<div class="login-wrap">
				<form action="{{ route('site.login') }}" method="post" id="form_login" name="form_login">
					<input type="hidden" id="idToken" name="idToken">
					<input type="hidden" id="provider" name="provider">
					{{csrf_field()}}
					@if(false)
					<!--Removed at 20/02/19
					<div class="row center-align">
						<div class="col s12 m6">
							<a href="route('site.login.social', 'facebook') }}" class="btn btn-social-facebook waves-effect waves-light"></a>
						</div>
						<div class="col s12 m6">
						<a href="route('site.login.social', 'google') }}" class="btn btn-social-google waves-effect waves-light"></a>
						</div>
					</div>
					-->
					@endif
					<div class="input-field">
						<input class="validate" type="text" id="email" name="email" value="{{ Session::get('email') }}">
						<label>E-mail</label>
					</div>
					<div class="input-field">
						<input class="validate" type="password" id="password" name="password">
						<label>Password</label>
					</div>
					<div class="row login-link">
						<div class="col offset-m6">
							<a href="{{ route('site.login.forgot') }}">Reset password</a>
						</div>
					</div>
					<div class="row center-align">
						@if(false)
						<!-- Removed at 20/02/19
						<div class="col s12 m6">
							<a class="btn login-btn waves-effect waves-light" href="route('site.login.signup') }}">Sign up</a>
						</div>
						<-->
						@endif
						<a class="btn login-btn waves-effect waves-light" href="#" onclick="signin()">Log in</a>
					</div>
				</form>
			</div>
		</div>
</div>



@endsection