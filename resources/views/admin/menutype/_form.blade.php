<div class="input-field">
	<input class="validate" type="text" name="name" maxlength="50" data-length="50" value="{{ Session::has('register') ? Session::get('register')->name : '' }}">
	<label>Name</label>
</div>