<form action="{{ route('admin.user.search') }}">
	<div class="row">
		<div class="input-field col s12 m2">
		    <input class="validate number" type="text" name="id" maxlength="8" value="{{ isset($filters) ? $filters['id'] : '' }}">
		    <label>Id</label>
		</div>
		<div class="input-field col s12 m5">
		    <input class="validate" type="text" name="name" maxlength="100" data-length="100" value="{{ isset($filters) ? $filters['name'] : '' }}">
		    <label>Name</label>
		</div>
		<div class="input-field col s12 m5">
		    <input class="validate" type="text" name="email" maxlength="100" data-length="100" value="{{ isset($filters) ? $filters['email'] : '' }}">
		    <label>E-mail</label>
		</div>
	</div>
	<div class="row right hide-on-small-only">
		<button class="btn waves-effect waves-light">Search</button>
	</div>
	<div class="row center-align hide-on-med-and-up">
		<button class="btn waves-effect waves-light">Search</button>
	</div>
</form>