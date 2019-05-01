<nav class="navbar hide-on-small-only">
	<div class="nav-wrapper">
	    <div class="container" style="height: 180px;">
	    	<div class="row">
	    		<div class="col m6">
			    	<a href="{{ route('site.home') }}">
			    		<img src="{{ asset('img/logo.png') }}">
			    	</a>
		    	</div>
		    	<div class="col m6">
		    		<div class="margin"></div>
		    		<div class="row right">
		    			@if(Auth::guest())
		    			<ul class="med-menu-links right hide-on-med-and-down">
				          <li class="{{ isset($currentMenu) && $currentMenu == 'home' ? 'active' : '' }}"><a href="{{ route('site.home') }}">Home</a></li>
				          <li class="{{ isset($currentMenu) && $currentMenu == 'contactus' ? 'active' : '' }}"><a href="{{ route('site.contactus') }}">Contact us</a></li>
				          <li class="{{ isset($currentMenu) && $currentMenu == 'login' ? 'active' : '' }}"><a href="{{ route('site.login') }}">Login</a></li>
				        </ul>
				        @else
				        <ul class="med-menu-drawer-nav right hide-on-med-and-down">
				        	@if(isset($previousPage))
				        	@if(isset($parameterPreviousPage))
					        <li><a href="{{ route($previousPage, $parameterPreviousPage) }}">Return to the last page<i class="material-icons right">arrow_forward</i></a></li>
					        @else
					        <li><a href="{{ route($previousPage) }}">Return to the last page<i class="material-icons right">arrow_forward</i></a></li>
					        @endif
					        @else
					        <li class="dropdown-button-med-menu"><a class="dropdown-button dropdown-button-med-menu" href="#!" data-activates="dropdown">Welcome, {{ ucwords(Auth::user()->name) }}<i class="material-icons right">menu</i></a></li>
					        <a href="#!" data-activates="med-menu" class="button-collapse med-menu" style="display: none;"><i class="material-icons">menu</i></a>
					        @endif
				        </ul>
				        @endif
					    <ul class="side-nav" id="med-menu">
							@if(Auth::check())
							<li class="header">
								@if(Auth::user()->provider == 'email')
								<div class="profile-photo"><img src="{{ route('admin.avatar', Auth::user()->id) }}"></div>
								@else
								<div class="profile-photo"><img src="{{ Auth::user()->avatar }}"></div>
								@endif
						    	<a href="#" class="profile-name">{{ ucwords(Auth::user()->name) }}</a>
							</li>
							@endif
							<li class="{{ isset($currentMenu) && $currentMenu == 'home' ? 'item-menu-active' : 'item-menu' }}"><a href="{{ route('site.home') }}"><i class="material-icons">home</i>Home</a></li>
						    <li class="{{ isset($currentMenu) && $currentMenu == 'contactus' ? 'item-menu-active' : 'item-menu' }}"><a href="{{ route('site.contactus') }}"><i class="material-icons">email</i>Contact us</a></li>
						    @if(Auth::guest())
						    <li class="{{ isset($currentMenu) && $currentMenu == 'login' ? 'item-menu-active' : 'item-menu' }}"><a href="{{ route('site.login') }}"><i class="material-icons">input</i>Login</a></li>
						    @else
						    <li class="{{ isset($currentMenu) && $currentMenu == 'profile' ? 'item-menu-active' : 'item-menu' }}"><a href="{{ route('admin.user.edit', Auth::user()->id) }}"><i class="material-icons">person</i>Profile</a></li>
						    @can('users_list')
						    <li class="{{ isset($currentMenu) && $currentMenu == 'users' ? 'item-menu-active' : 'item-menu' }}"><a href="{{ route('admin.user') }}"><i class="material-icons">people</i>Users</a></li>
						    @endcan
						    @can('roles_list')
						    <li class="{{ isset($currentMenu) && $currentMenu == 'roles' ? 'item-menu-active' : 'item-menu' }}"><a href="{{ route('admin.role') }}"><i class="material-icons">recent_actors</i>Roles</a></li>
						    @endcan
						    @can('shops_list')
						    <li class="{{ isset($currentMenu) && $currentMenu == 'shops' ? 'item-menu-active' : 'item-menu' }}"><a href="{{ route('admin.shop') }}"><i class="material-icons">store_mall_directory</i>Shops</a></li>
						    @endcan
						    @can('users_list')
						    <li class="{{ isset($currentMenu) && $currentMenu == 'menu' ? 'item-menu-active' : 'item-menu' }}"><a href="{{ route('admin.menutype') }}"><i class="material-icons">list</i>Menu</a></li>
						    @endcan
						    @can('orders_list')
						    <li class="{{ isset($currentMenu) && $currentMenu == 'orders' ? 'item-menu-active' : 'item-menu' }}"><a href="{{ route('admin.order.shop') }}"><i class="material-icons">print</i>Print Orders</a></li>
						    @endcan
							<!--
								Removed at 11/02/19
						    <li class="{{ isset($currentMenu) && $currentMenu == 'orderhistory' ? 'item-menu-active' : 'item-menu' }}"><a href="route('admin.orderhistory') }}"><i class="material-icons">receipt</i>Order History</a></li>
						    <li class="{{ isset($currentMenu) && $currentMenu == 'checkout' ? 'item-menu-active' : 'item-menu' }}"><a href="route('site.checkout.shoppingcart') }}"><i class="material-icons">shopping_cart</i>Checkout</a></li>
							-->
						    <li class="{{ isset($currentMenu) && $currentMenu == 'logout' ? 'item-menu-active' : 'item-menu' }}"><a href="{{ route('admin.logout') }}"><i class="material-icons">exit_to_app</i>Logout</a></li>
						    @endif
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</nav>
<nav class="navbar navbar-mobile hide-on-med-and-up">
  <div class="nav-wrapper">
    <div class="container">
	    @if(isset($previousPage))
	    @if(isset($parameterPreviousPage))
	    <a href="{{ route($previousPage, $parameterPreviousPage) }}" class="button-collapse"><i class="material-icons">arrow_back</i></a>
	    @else
	    <a href="{{ route($previousPage) }}" class="button-collapse"><i class="material-icons">arrow_back</i></a>
	    @endif
	    @else
	    <a href="#!" class="navbar-title">New York Deli</a>
      	<a href="#!" data-activates="mobile-menu" class="button-collapse mobile-menu"><i class="material-icons">menu</i></a>
      	@endif
	    <ul class="side-nav" id="mobile-menu">
	    	@if(Auth::check())
			<li class="header">
				@if(Auth::user()->provider == 'email')
				<div class="profile-photo"><img src="{{ route('admin.avatar', Auth::user()->id) }}"></div>
				@else
				<div class="profile-photo"><img src="{{ Auth::user()->avatar }}"></div>
				@endif
		    	<a href="#" class="profile-name">{{ ucwords(Auth::user()->name) }}</a>
			</li>
			@endif
			<li class="{{ isset($currentMenu) && $currentMenu == 'home' ? 'item-menu-active' : 'item-menu' }}"><a href="{{ route('site.home') }}"><i class="material-icons">home</i>Home</a></li>
		    <li class="{{ isset($currentMenu) && $currentMenu == 'contactus' ? 'item-menu-active' : 'item-menu' }}"><a href="{{ route('site.contactus') }}"><i class="material-icons">email</i>Contact us</a></li>
		    @if(Auth::guest())
		    <li class="{{ isset($currentMenu) && $currentMenu == 'login' ? 'item-menu-active' : 'item-menu' }}"><a href="{{ route('site.login') }}"><i class="material-icons">input</i>Login</a></li>
		    @else
		    <li class="{{ isset($currentMenu) && $currentMenu == 'profile' ? 'item-menu-active' : 'item-menu' }}"><a href="{{ route('admin.user.edit', Auth::user()->id) }}"><i class="material-icons">person</i>Profile</a></li>
		    @can('users_list')
		    <li class="{{ isset($currentMenu) && $currentMenu == 'users' ? 'item-menu-active' : 'item-menu' }}"><a href="{{ route('admin.user') }}"><i class="material-icons">people</i>Users</a></li>
		    @endcan
		    @can('roles_list')
		    <li class="{{ isset($currentMenu) && $currentMenu == 'roles' ? 'item-menu-active' : 'item-menu' }}"><a href="{{ route('admin.role') }}"><i class="material-icons">recent_actors</i>Roles</a></li>
		    @endcan
		    @can('shops_list')
		    <li class="{{ isset($currentMenu) && $currentMenu == 'shops' ? 'item-menu-active' : 'item-menu' }}"><a href="{{ route('admin.shop') }}"><i class="material-icons">store_mall_directory</i>Shops</a></li>
		    @endcan
		    @can('menu_list')
		    <li class="{{ isset($currentMenu) && $currentMenu == 'menu' ? 'item-menu-active' : 'item-menu' }}"><a href="{{ route('admin.menutype') }}"><i class="material-icons">list</i>Menu</a></li>
		    @endcan
		    @can('orders_list')
		    <li class="{{ isset($currentMenu) && $currentMenu == 'orders' ? 'item-menu-active' : 'item-menu' }}"><a href="{{ route('admin.order.shop') }}"><i class="material-icons">print</i>Print Orders</a></li>
		    @endcan
			<!--
				Removed at 11/02/19
		    <li class="{{ isset($currentMenu) && $currentMenu == 'orderhistory' ? 'item-menu-active' : 'item-menu' }}"><a href="route('admin.orderhistory') }}"><i class="material-icons">receipt</i>Order History</a></li>
		    <li class="{{ isset($currentMenu) && $currentMenu == 'checkout' ? 'item-menu-active' : 'item-menu' }}"><a href="route('site.checkout.shoppingcart') }}"><i class="material-icons">shopping_cart</i>Checkout</a></li>
			-->
		    <li class="{{ isset($currentMenu) && $currentMenu == 'logout' ? 'item-menu-active' : 'item-menu' }}"><a href="{{ route('admin.logout') }}"><i class="material-icons">exit_to_app</i>Logout</a></li>
		    @endif
	    </ul>
    </div>
  </div>
</nav>