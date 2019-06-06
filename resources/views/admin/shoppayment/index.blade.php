@extends('layouts.site')

@section('content')
<div class="row hide-on-med-and-up"></div>
<div class="container container-content">
	<div class="row">
		<h3 class="center-align hide-on-small-only">Payment Setup</h3>
	    <h5 class="center-align hide-on-med-and-up">Payment Setup</h3>
		<div class="divider"></div>
	</div>
	<div class="row"></div>	
	<div class="row">
		<form action="{{ route('admin.shop.paymentsetup.save', Session::get('register')->id) }}" method="post">
			
			{{ csrf_field() }}

			<div class="row">
                <div class="col s12 m6">
                    <div class="input-field">
                        <input class="validate" type="text" name="url" maxlength="200" data-length="200" value="{{ Session::get('register')->url }}">
                        <label>Url</label>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="input-field">
                        <input class="validate" type="text" name="vendor_name" maxlength="30" data-length="30" value="{{ Session::get('register')->vendor_name }}">
                        <label>Vendor Name</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6">
                    <div class="input-field">
                        <input class="validate" type="text" name="integration_key" maxlength="190" data-length="190" value="{{ Session::get('register')->integration_key }}">
                        <label>Integration Key</label>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="input-field">
                        <input class="validate" type="text" name="integration_password" maxlength="190" data-length="190" value="{{ Session::get('register')->integration_password }}">
                        <label>Integration Password</label>
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