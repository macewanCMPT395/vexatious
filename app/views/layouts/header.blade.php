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
    {{ HTML::linkRoute('bookings.index', 'Bookings') }} </li>
<li @yield('shippingli')> 
    {{ HTML::linkRoute('shipping', 'Shipping') }} </li>
<li @yield('browsekitsli')> 
    {{ HTML::linkRoute('kits.index', 'Browse Kits') }} </li>
@yield('adminItems')
</ul>
</div>
@yield('content')
</body>
</html>
