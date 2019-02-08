@extends('layouts.site')

@section('content')

<div class="container">
		<div class="login-container">
			<div class="login-wrap">
				<div class="row"></div>
			    <div class="row">
			    	<h4 class="center-align hide-on-small-only">Inform your e-mail</h3>
			        <h5 class="center-align hide-on-med-and-up">Inform your e-mail</h3>
			    	<div class="divider"></div>
			    </div>
				<form action="{{ route('site.login.forgot') }}" method="post">
					{{csrf_field()}}
					<div class="input-field">
						<input class="validate" type="text" name="email">
						<label>E-mail</label>
					</div>
					<div class="row" align="center">
						<button class="btn waves-effect waves-light">Send</button>
					</div>
				</form>
				<div class="row"></div>
			</div>
		</div>
</div>

@endsection