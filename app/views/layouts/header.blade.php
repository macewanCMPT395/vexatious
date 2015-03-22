<!doctype html>
<html lang="en">
<head>
{{ HTML::style('css/header.css') }}
@yield('headerScript')
</head>
    
<body>
  
<div id="Image"><img src="http://www.epl.ca/sites/all/themes/epl/img/EPL_logo2.png" border="0" style="width:400px;"></div>
    
<div id="bar"></div>

<div class="menu">
<div class="button">{{ HTML::linkRoute('home', 'Overview') }}</div>
<div class="button">{{ HTML::linkRoute('bookkit', 'Book Kit') }}</div>
<div class="button">{{ HTML::linkRoute('browsekits', 'Browse Kits') }}</div>

@yield('adminButtons')
</div>
    
@yield('content')

</body>
</html>