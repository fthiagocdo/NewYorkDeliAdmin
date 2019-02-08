<div class="input-field">
	<input class="validate" type="text" name="name" maxlength="50" data-length="50" value="{{ Session::has('register') ? Session::get('register')->name : '' }}">
	<label>Name *</label>
</div>
<div class="input-field">
	<input class="validate" type="text" name="description" maxlength="100" data-length="100" value="{{ Session::has('register') ? Session::get('register')->description : '' }}">
	<label>Description *</label>
</div>