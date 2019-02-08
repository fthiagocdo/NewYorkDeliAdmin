<footer class="page-footer hide-on-small-only">
  <div class="container">
    <div class="row">
      <div class="col l6 s12">
        <h5 class="white-text">New York Deli</h5>
        <ul>
          <li class="address">New York Deli Aylesbury - Friars Square Shopping Centre, Aylesbury</li>
          <li class="address">New York Deli Maidenhead - Nicholsons Shopping Centre, Maidenhead</li>
        </ul>
      </div>
      <div class="col l4 offset-l2 s12">
        <h5 class="white-text">Links</h5>
        <div class="row">
          <div class="col m6">
            <ul>
              <li class="link"><a href="{{ route('site.home') }}">Home</a></li>
              <li class="link"><a href="{{ route('site.contactus') }}">Contact us</a></li>
              @if(Auth::guest())
              <li class="link"><a href="{{ route('site.login') }}">Login</a></li>
              @else
              <li class="link"><a href="{{ route('admin.user.edit', Auth::user()->id) }}">Profile</a></li>
              <li class="link"><a href="{{ route('site.checkout.shoppingcart') }}">Checkout</a></li>
              <li class="link"><a href="{{ route('admin.orderhistory') }}">Order History</a></li>
              <li class="link"><a href="{{ route('admin.logout') }}">Logout</a></li>
              @endif
            </ul>
          </div>
          <div class="col m6">
            <ul>
              @can('users_list')
              <li class="link"><a href="{{ route('admin.user') }}">Users</a></li>
              @endcan
              @can('roles_list')
              <li class="link"><a href="{{ route('admin.role') }}">Roles</a></li>
              @endcan
              @can('shops_list')
              <li class="link"><a href="{{ route('admin.shop') }}">Shops</a></li>
              @endcan
              @can('users_list')
              <li class="link"><a href="{{ route('admin.menutype') }}">Menu</a></li>
              @endcan
              @can('orders_list')
              <li class="link"><a href="{{ route('admin.order') }}">Orders</a></li>
              @endcan
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
    	<div class="col copyright">
    		<a href="http://www.ftcsolutions.com" target="_blank">© 2018 Copyright - FTC Solutions</a>
    	</div>
    </div>
  </div>
</footer>