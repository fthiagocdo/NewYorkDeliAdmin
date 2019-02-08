<div class="row">
	<div class="col s12 m4">
		<div class="input-field">
			<input class="validate" type="text" name="name" maxlength="100" data-length="100" value="{{ Session::has('register') ? Session::get('register')->name : '' }}">
			<label>Name *</label>
		</div>
	</div>
	<div class="col s12 m6">
		<div class="input-field">
			<input class="validate" type="text" name="address" maxlength="100" data-length="100" value="{{ Session::has('register') ? Session::get('register')->address : '' }}">
			<label>Address *</label>
		</div>
	</div>
	<div class="col s12 m2">
		<div class="input-field">
			<input class="filled-in" type="checkbox" name="available" {{ Session::has('register') && Session::get('register')->available == true ? 'checked' : '' }}>
			<label>Available?</label>
		</div>
	</div>
</div>