<div class="row">
	<div class="col s12 m4">
		<div class="input-field">
			<select name="day_week">
				<option value="sunday" {{ Session::has('register') && Session::get('register')->day_week == 'sunday' ? 'selected' : '' }}>Sunday</option>
				<option value="monday" {{ Session::has('register') && Session::get('register')->day_week == 'monday' ? 'selected' : '' }}>Monday</option>
				<option value="tuesday" {{ Session::has('register') && Session::get('register')->day_week == 'tuesday' ? 'selected' : '' }}>Tuesday</option>
				<option value="wednesday" {{ Session::has('register') && Session::get('register')->day_week == 'wednesday' ? 'selected' : '' }}>Wednesday</option>
				<option value="thursday" {{ Session::has('register') && Session::get('register')->day_week == 'thursday' ? 'selected' : '' }}>Thursday</option>
				<option value="friday" {{ Session::has('register') && Session::get('register')->day_week == 'friday' ? 'selected' : '' }}>Friday</option>
				<option value="saturday" {{ Session::has('register') && Session::get('register')->day_week == 'saturday' ? 'selected' : '' }}>Saturday</option>
			</select>
			<label>Day of Week *</label>
		</div>
	</div>
	<div class="col s12 m4">
		<div class="input-field">
			<input class="validate time" type="text" name="opening_time" maxlength="5" value="{{ Session::has('register') ? Session::get('register')->opening_time : '' }}">
			<label>Opening Time *</label>
		</div>
	</div>
	<div class="col s12 m4">
		<div class="input-field">
			<input class="validate time" type="text" name="closing_time" maxlength="5" value="{{ Session::has('register') ? Session::get('register')->closing_time : '' }}">
			<label>Closing Time *</label>
		</div>
	</div>
</div>