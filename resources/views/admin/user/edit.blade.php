@extends('layouts.site')

@section('content')
<div class="row hide-on-med-and-up"></div>
<div class="container container-content">
	<div class="row">
		@if($editable == true)
		<h3 class="center-align hide-on-small-only">Edit User</h3>
	    <h5 class="center-align hide-on-med-and-up">Edit User</h3>
	    @else
	    <h3 class="center-align hide-on-small-only">User Details</h3>
	    <h5 class="center-align hide-on-med-and-up">User Details</h3>
	    @endif
		<div class="divider"></div>
	</div>
	<div class="row">
		<form action="{{ route('admin.user.update', Session::get('register')->id) }}" method="post" onsubmit="removeMasks();" enctype="multipart/form-data">
			
			{{ csrf_field() }}

			<input type="hidden" name="_method" value="put">

			@include('admin.user._form')

			@if($editable == true)
			<button class="btn waves-effect waves-light hide-on-small-only">Confirm</button>
			<div class="row center-align hide-on-med-and-up">
				<button class="btn waves-effect waves-light hide-on-med-and-up">Confirm</button>
			</div>
			@endif
		</form>
	</div>	
</div>
<div class="row"></div>
@endsection