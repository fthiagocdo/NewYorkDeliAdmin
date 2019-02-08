<div class="row hide-on-small-only">
	<div class="col s12 m12" style="margin-left: 20px;">
		<div class="file-field input-field">
			@if($editable == true)
			<div class="btn-floating waves-effect waves-light"><i class="material-icons left">add_a_photo</i>
				<input type="file" name="image-med">
			</div>
			@endif
		</div>
		<img class="responsive-img" src="{{ Session::has('register') ? App\Business\UserBusiness::getAvatar(Auth::user()) : asset('img/user-avatar.png') }}" width="200">
	</div>
</div>
<div class="row hide-on-med-and-up center">
	<div class="col s12 m12">
		<div class="file-field input-field">
			@if($editable == true)
			<div class="btn-floating waves-effect waves-light" style="left: 85px;"><i class="material-icons left">add_a_photo</i>
				<input type="file" name="image-mobile">
			</div>
			@endif
		</div>
		<img class="responsive-img" src="{{ Session::has('register') && isset(Session::get('register')->avatar) ? asset(Session::get('register')->avatar) : asset('img/user-avatar.png') }}" width="200">
	</div>
</div>
<div class="row">
	<div class="col s12 m6">
		<div class="input-field">
			<input class="validate" type="text" name="name" maxlength="100" data-length="100" value="{{ Session::has('register') ? ucwords(Session::get('register')->name) : '' }}" {{ $editable == true ? '' : 'disabled' }}>
			<label>Name *</label>
		</div>
	</div>
	<div class="col s12 m6">
		<div class="input-field">
			<input class="validate" type="text" name="email" maxlength="100" data-length="100" value="{{ Session::has('register') ? Session::get('register')->email : '' }}" disabled>
			<label>E-mail *</label>
		</div>
	</div>
</div>
@if(Session::has('register') && isset(Session::get('register')->password))
<div class="row">
	<div class="col s12 m6">
		<div class="input-field">
			<input class="validate" type="password" name="password" maxlength="50" data-length="50" value="" {{ $editable == true ? '' : 'disabled' }}>
			<label>Password</label>
		</div>
	</div>
	<div class="col s12 m6">
		<div class="input-field">
			<input class="validate" type="password" name="confirmPassword" maxlength="50" data-length="50" value="" {{ $editable == true ? '' : 'disabled' }}>
			<label>Confirm Password</label>
		</div>
	</div>
</div>
@endif
<div class="row">
	<div class="col s12 m3">
		<div class="input-field">
			<input class="validate phone" type="text" name="phoneNumber" maxlength="11" value="{{ Session::has('register') ? Session::get('register')->phone_number : '' }}" {{ $editable == true ? '' : 'disabled' }}>
			<label>Phone Number</label>
		</div>
	</div>
	<div class="col s12 m3">
		<div class="input-field">
			<input class="validate" type="text" name="postcode" maxlength="10" data-length="10" value="{{ Session::has('register') ? strtoupper(Session::get('register')->postcode) : '' }}" {{ $editable == true ? '' : 'disabled' }}>
			<label>Post Code</label>
		</div>
	</div>
	<div class="col s12 m6">
		<div class="input-field">
			<input class="validate" type="text" name="address" maxlength="100" data-length="100" value="{{ Session::has('register') ? ucwords(Session::get('register')->address) : '' }}" {{ $editable == true ? '' : 'disabled' }}>
			<label>Address</label>
		</div>
	</div>
</div>
<div class="row">
	<div class="col s12 m6">
		@if($editable == true)
		<label class="label-radio">Preferred Shop</label>
		@else
		<label class="label-radio" style="color: rgba(0, 0, 0, 0.42) !important;">Preferred Shop</label>
		@endif
		<div class="input-field" style="margin-top: 0rem;">
			@foreach($shops as $shop)
			<input class="validate" type="radio" name="radioPreferredShop" {{ Session::has('register') && Session::get('register')->shop->id == $shop->id ? 'checked' : '' }} onclick="$('#preferredShop').val({{ $shop->id }});" {{ $editable == true ? '' : 'disabled' }}>
			<label>{{ $shop->name }} - {{ $shop->address }}</label>
			@endforeach
			<input type="hidden" id="preferredShop" name="preferredShop" value="{{ Session::has('register') ? Session::get('register')->shop_id : '' }}">
		</div>
	</div>
	<div class="col s12 m6">
		<div class="input-field">
			<input class="filled-in" type="checkbox" name="receiveNotifications" {{ Session::has('register') && Session::get('register')->receive_notifications == true ? 'checked' : '' }} {{ $editable == true ? '' : 'disabled' }}>
			@if($editable == true)
			<label>Receive notifications?</label>
			@else
			<label style="color: rgba(0, 0, 0, 0.42) !important;">Receive notifications?</label>
			@endif
		</div>
	</div>
</div>