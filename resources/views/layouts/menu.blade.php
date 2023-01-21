<!-- need to remove -->
<li class="nav-item">
	<a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
		<i class="nav-icon fas fa-home"></i>
		<p>Home</p>
	</a>
</li>
<li>
	<a href="{{ route('import') }}" class="nav-link {{ Request::is('import') ? 'active' : '' }}">
		<i class="nav-icon fas fa-download"></i>
		<p>Import CSV</p>
	</a>
</li>
<li>
	<a href="{{ route('customer') }}" class="nav-link {{ Request::is('customer') ? 'active' : '' }}">
		<i class="nav-icon fas fa-users"></i>
		<p>Customers</p>
	</a>
</li>
<li>
	<a href="{{ route('product') }}" class="nav-link {{ Request::is('product') ? 'active' : '' }}">
		<i class="nav-icon fas fa-cubes "></i>
		<p>Products</p>
	</a>
</li>
<li>
	<a href="{{ route('order') }}" class="nav-link {{ Request::is('order') ? 'active' : '' }}">
		<i class="nav-icon fas fa-money-check-alt"></i>
		<p>Orders</p>
	</a>
</li>
