@extends('layouts.site')

@section('content')
<div class="container">
	@include('layouts._site._slides')
	<!--
		Removed at 11/02/19
	<form id="form_menu" action="route('site.checkout.additem') }}" method="post">
	-->
	<form id="form_menu" action="{{ route('site.home') }}" method="post">
		{{ csrf_field() }}
		@include('layouts._site._menu')
	</form>
</div>
<!--
	Remover at 11/02/19
@if(Auth::check())
<div class="fixed-action-btn">
  <a class="btn-floating btn-large" href="route('site.checkout.shoppingcart') }}" title="Proceed to checkout">
    <i class="large material-icons">shopping_cart</i>
  </a>
</div>
@endif
-->
@endsection