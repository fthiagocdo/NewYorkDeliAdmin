@extends('layouts.site')

@section('content')
<div class="row hide-on-med-and-up"></div>
<div class="container container-content">
	<div class="row">
		<h3 class="center-align hide-on-small-only">Edit Menu Item</h3>
	    <h5 class="center-align hide-on-med-and-up">Edit Menu Item</h3>
		<div class="divider"></div>
	</div>
	<div class="row">
		<form action="{{ route('admin.menutype.menuitem.update', Session::get('register')->id) }}" method="post" onsubmit="removeMasks();" enctype="multipart/form-data">
			
			{{ csrf_field() }}

			<input type="hidden" name="_method" value="put">

			@include('admin.menuitem._form')

			<button class="btn waves-effect waves-light hide-on-small-only">Confirm</button>
			<div class="row center-align hide-on-med-and-up">
				<button class="btn waves-effect waves-light hide-on-med-and-up">Confirm</button>
			</div>
		</form>
	</div>	
</div>
<div class="row"></div>
@endsection