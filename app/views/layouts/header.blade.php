<!doctype html>
<html lang="en">
<head>
{{ HTML::style('css/header.css') }}
@yield('headerScript')
</head>
    
<body>
<<<<<<< HEAD
<div id="Image"><img src="http://www.epl.ca/sites/all/themes/epl/img/EPL_logo2.png" border="0" style="width:400px;"></div>
<div class="navMenu">
<ul>
<li @yield('homeli')> 
    {{ HTML::linkRoute('home', 'Overview') }} </li>
<li @yield('bookkitli')> 
    {{ HTML::linkRoute('bookkit', 'Book Kit') }} </li>
<li @yield('shippingli')> 
    {{ HTML::linkRoute('shipping', 'Shipping') }} </li>
<li @yield('browsekitsli')> 
    {{ HTML::linkRoute('browsekits', 'Browse Kits') }} </li>
@yield('adminItems')
</ul>
=======
<div class="menu">  
<div id="Image"><img src="http://www.epl.ca/sites/all/themes/epl/img/epl_logo.jpg" border="0"></div>
<div id="bar"></div>
<div class="button">{{ HTML::linkRoute('home','Overview') }}</div>
<div class="button">{{ HTML::linkRoute('kits.show', 'Book Kit') }}</div>
<div class="button">{{ HTML::linkRoute('home', 'Shipping') }}</div>
<div class="button">{{ HTML::linkRoute('kits.index', 'Browse Kits') }}</div>
@yield('adminButtons')
>>>>>>> Add route to username and fix logo position.
</div>
@yield('content')
</body>
</html>
