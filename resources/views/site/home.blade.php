@extends('layouts.site')

@section('content')
<div class="container">
	@include('layouts._site._slides')
	<form id="form_menu" action="{{ route('site.checkout.additem') }}" method="post">
		{{ csrf_field() }}
		@include('layouts._site._menu')
	</form>
</div>
@if(Auth::check())
<div class="fixed-action-btn">
  <a class="btn-floating btn-large" href="{{ route('site.checkout.shoppingcart') }}" title="Proceed to checkout">
    <i class="large material-icons">shopping_cart</i>
  </a>
</div>
@endif
@endsection