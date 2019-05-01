@extends('layouts.site')

@section('content')
<div class="row hide-on-med-and-up"></div>
<div class="container container-content">
	<div class="row">
		<h3 class="center-align hide-on-small-only">Add User</h3>
	    <h5 class="center-align hide-on-med-and-up">Add User</h3>
		<div class="divider"></div>
	</div>
	<div class="row">
		<form action="{{ route('admin.user.save') }}" method="post" onsubmit="removeMasks();" enctype="multipart/form-data">
			
			{{ csrf_field() }}
            
            <div class="row hide-on-small-only">
                <div class="col s12 m12" style="margin-left: 20px;">
                    <div class="file-field input-field">
                        <div class="btn-floating waves-effect waves-light"><i class="material-icons left">add_a_photo</i>
                            <input type="file" name="image-med" value="{{ Session::get('avatar') }}">
                        </div>
                    </div>
                    <img class="responsive-img" src="{{ asset('img/user-avatar.png') }}" width="200">
                </div>
            </div>
            <div class="row hide-on-med-and-up center">
                <div class="col s12 m12">
                    <div class="file-field input-field">
                        <div class="btn-floating waves-effect waves-light" style="left: 85px;"><i class="material-icons left">add_a_photo</i>
                            <input type="file" name="image-mobile" value="{{ Session::get('avatar') }}">
                        </div>
                    </div>
                    <img class="responsive-img" src="{{ asset('img/user-avatar.png') }}" width="200">
                </div>
            </div>

            <div class="row">
                <div class="col s12 m6">
                    <div class="input-field">
                        <input class="validate" type="text" name="name" maxlength="100" data-length="100" value="{{ ucwords(Session::get('name')) }}">
                        <label>Name *</label>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="input-field">
                        <input class="validate" type="text" name="email" maxlength="100" data-length="100" value="{{ Session::get('email') }}">
                        <label>E-mail *</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col s12 m6">
                    <div class="input-field">
                        <input class="validate" type="password" name="password" maxlength="50" data-length="50" value="">
                        <label>Password</label>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="input-field">
                        <input class="validate" type="password" name="confirmPassword" maxlength="50" data-length="50" value="">
                        <label>Confirm Password</label>
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