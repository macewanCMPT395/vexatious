<!doctype html>
<html lang="en">
<head>
{{ HTML::style('css/header.css') }}
@yield('headerScript')
</head>
    
<body>
  
<div id="Image"><img src="http://www.epl.ca/sites/all/themes/epl/img/epl_logo.jpg" border="0"></div>
<div id="bar"></div>
<div class="menu">
<div class="button">{{ HTML::linkRoute('home', 'Overview') }}</div>
<div class="button">{{ HTML::linkRoute('home', 'Book Kit') }}</div>
<div class="button">{{ HTML::linkRoute('kits.index', 'Browse Kits') }}</div>

@yield('adminButtons')
</div>
    
@yield('content')

</body>
</html>