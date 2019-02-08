<div class="row hide-on-small-only">
	<div class="col s12 m12" style="margin-left: 20px;">
		<div class="file-field input-field">
			<div class="btn-floating waves-effect waves-light"><i class="material-icons left">add_a_photo</i>
				<input type="file" name="image-med">
			</div>
		</div>
		<img class="responsive-img" src="{{ Session::has('register') && isset(Session::get('register')->image) ? asset(Session::get('register')->image) : asset('img/menu/'.strtolower($menutype->name).'.jpg') }}" width="200">
	</div>
</div>
<div class="row hide-on-med-and-up center">
	<div class="col s12 m12">
		<div class="file-field input-field">
			<div class="btn-floating waves-effect waves-light" style="left: 85px;"><i class="material-icons left">add_a_photo</i>
				<input type="file" name="image-mobile">
			</div>
		</div>
		<img class="responsive-img" src="{{ Session::has('register') && isset(Session::get('register')->image) ? asset(Session::get('register')->image) : asset('img/menu/'.strtolower($menutype->name).'.jpg') }}" width="200">
	</div>
</div>
<div class="row">
	<div class="col s12 m4">
		<div class="input-field">
			<input class="validate" type="text" name="name" maxlength="100" data-length="100" value="{{ Session::has('register') ? Session::get('register')->name : '' }}">
			<label>Name *</label>
		</div>
	</div>
	<div class="col s12 m8">
		<div class="input-field">
			<input class="validate" type="text" name="description" maxlength="200" data-length="200" value="{{ Session::has('register') ? Session::get('register')->description : '' }}">
			<label>Description</label>
		</div>
	</div>
</div>
<div class="row">
	<div class="col s12 m4">
		<div class="input-field">
			<input class="validate currency" type="text" name="price" maxlength="8" value="{{ Session::has('register') ? Session::get('register')->price : '' }}">
			<label>Price *</label>
		</div>
	</div>
</div>