@extends('layouts.site')

@section('content')
<div class="row hide-on-med-and-up"></div>
<div class="container container-content">
	<div class="row">
		<h3 class="center-align hide-on-small-only">Add Menu Extra</h3>
	    <h5 class="center-align hide-on-med-and-up">Add Menu Extra</h3>
		<div class="divider"></div>
	</div>
	<div class="row"></div>	
	<div class="row">
		<form action="{{ route('admin.menutype.menuitem.menuextra.save', $menuitem->id) }}" method="post" onsubmit="removeMasks();">
			
			{{ csrf_field() }}

			@include('admin.menuextra._form')

			<button class="btn waves-effect waves-light hide-on-small-only">Confirm</button>
			<div class="row center-align hide-on-med-and-up">
				<button class="btn waves-effect waves-light hide-on-med-and-up">Confirm</button>
			</div>
		</form>
	</div>	
</div>
<div class="row"></div>
@endsection