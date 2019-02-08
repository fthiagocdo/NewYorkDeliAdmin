<div class="row">
	<div class="col s12 m8">
		<div class="input-field">
			<input class="validate" type="text" name="name" maxlength="100" data-length="100" value="{{ Session::has('register') ? Session::get('register')->name : '' }}">
			<label>Name</label>
		</div>
	</div>
	<div class="col s12 m4">
		<div class="input-field">
			<input class="validate currency" type="text" name="price" maxlength="8" value="{{ Session::has('register') ? Session::get('register')->price : '' }}">
			<label>Price</label>
		</div>
	</div>
</div>