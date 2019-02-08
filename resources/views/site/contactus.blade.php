@extends('layouts.site')

@section('content')
<div class="container container-content">
    <div class="row"></div>
    <div class="row">
    	<h3 class="center-align hide-on-small-only">Send us a message</h3>
        <h5 class="center-align hide-on-med-and-up">Send us a message</h3>
    	<div class="divider"></div>
    </div>
    <div class="row">
    	<div class="col s12 m7">
    		<img class="responsive-img" src="{{ asset('img\0'.rand(1, 6)).'.jpg' }}">
    	</div>
    	<div class="col s12 m5">
    		<form class="col s12" action="{{ route('site.contactus.send') }}" method="post">

                {{ csrf_field() }}

    			<div class="input-field">
    				<input type="text" name="name" class="validate" value="{{ Session::get('name') }}">
    				<label>Name</label>
    			</div>
    			<div class="input-field">
    				<input type="text" name="email" class="validate" value="{{ Session::get('email') }}">
    				<label>Email</label>
    			</div>
    			<div class="input-field">
    				<textarea class="materialize-textarea" name="message" maxlength="500" data-length="500">{{ Session::get('msgEmail') }}</textarea>
    				<label>Message</label>
    			</div>
                <div>
    			    <button class="btn waves-effect waves-light hide-on-small-only">Send</button>
                </div>
                <div class="center-align">
                    <button class="btn waves-effect waves-light hide-on-med-and-up">Send</button>
                </div>
    		</form>
    	</div>
    </div>
</div>
<div class="row"></div>
@endsection