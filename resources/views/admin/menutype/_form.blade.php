<div class="row">
	<div class="col s12 m4">
		<div class="input-field">
			<select name="shop_id">
				<option value=""></option>
				@foreach($shops as $shop)
				@if(Session::has('register') && Session::get('register')->shop_id == $shop->id)
				<option value="{{ $shop->id }}" selected>{{ $shop->name }}</option>
				@else
				<option value="{{ $shop->id }}">{{ $shop->name }}</option>
				@endif
				@endforeach
			</select>
			<label>Shops</label>
		</div>
	</div>
	<div class="col s12 m8">
		<div class="input-field">
			<input class="validate" type="text" name="name" maxlength="50" data-length="50" value="{{ Session::has('register') ? Session::get('register')->name : '' }}">
			<label>Name</label>
		</div>
	</div>
</div>