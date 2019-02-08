@extends('layouts.site')

@section('content')

<div class="container">
		<div class="login-container">
			<div class="login-wrap">
				<div class="row"></div>
			    <div class="row">
			    	<h4 class="center-align hide-on-small-only">Inform a new password</h3>
			        <h5 class="center-align hide-on-med-and-up">Inform a new password</h3>
			    	<div class="divider"></div>
			    </div>
				<form action="{{ route('site.login.save', $user->id) }}" method="post">
					{{csrf_field()}}
					<input type="hidden" name="email" id="email" value="{{ $user->email }}">
					<div class="input-field">
						<input class="validate" type="password" name="password">
						<label>New Password</label>
					</div>
					<div class="input-field">
						<input class="validate" type="password" name="confirm_password">
						<label>Confirm New Password</label>
					</div>
					<div class="row" align="center">
						<button class="btn waves-effect waves-light">Confirm</a>
					</div>
				</form>
				<div class="row"></div>
			</div>
		</div>
</div>

@endsection