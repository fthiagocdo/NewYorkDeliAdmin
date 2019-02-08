@extends('layouts.site')

@section('content')
<div class="row hide-on-med-and-up"></div>
<div class="container container-content">
	<div class="row">
		<h3 class="center-align hide-on-small-only">Inform the delivery details</h3>
	    <h5 class="center-align hide-on-med-and-up">Inform the delivery details</h3>
		<div class="divider"></div>
	</div>
	<div class="row">
		<form action="{{ route('site.checkout.confirmAddress') }}" method="post" onsubmit="removeMasks();">
			
			{{ csrf_field() }}

			<input type="hidden" name="_method" value="put">
			<input type="hidden" name="preferredShop" id="preferredShop" value="{{ $preferredShop }}">

			<div class="row">
				<div class="col s12 m3">
					<div class="input-field">
						<input class="validate phone" type="text" name="phone_number" maxlength="11" value="{{ $phone_number }}">
						<label>Phone Number</label>
					</div>
				</div>
				<div class="col s12 m3">
					<div class="input-field">
						<input class="validate" type="text" name="postcode" maxlength="10" data-length="10" value="{{ $postcode }}">
						<label>Post Code</label>
					</div>
				</div>
				<div class="col s12 m6">
					<div class="input-field">
						<input class="validate" type="text" name="address" maxlength="100" data-length="100" value="{{ $address }}">
						<label>Address</label>
					</div>
				</div>
			</div>

			<button class="btn waves-effect waves-light hide-on-small-only">Confirm</button>
			<div class="row center-align hide-on-med-and-up">
				<button class="btn waves-effect waves-light hide-on-med-and-up">Confirm</button>
			</div>
		</form>
	</div>	
</div>
<div class="row"></div>
@endsection