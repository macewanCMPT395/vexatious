<!doctype html>
<html lang="en">
<head>
{{ HTML::style('css/header.css') }}
@yield('headerScript')
</head>

<body>
<div id="Image"><img src="http://www.epl.ca/sites/all/themes/epl/img/EPL_logo2.png" border="0" style="width:400px;"></div>
<div class="navMenu">
<ul>
<li @yield('bookkitli')> 
    {{ HTML::linkRoute('bookings.index', 'Booking') }} </li>
<li @yield('shippingli')> 
    {{ HTML::linkRoute('shipping', 'Shipping') }} </li>
<li @yield('browsekitsli')> 
    {{ HTML::linkRoute('kits.index', 'Browse Kits') }} </li>
@if(Auth::user()->role == 1)
<!--li @yield('editkitsli')> 
    {{ HTML::linkRoute('kits.edit', 'Edit Kits') }}</li-->
<li @yield('editusersli')> 
    {{ HTML::linkRoute('users.edit', 'Edit Users') }} </li>
@endif
<li>
  <!--{{HTML::linkRoute('sessions.destroy', 'Logout') }}-->
	<a href="logout">Logout</a>
	
	</li>
</ul>
</div>
@yield('content')
</body>
</html>
