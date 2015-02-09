<!doctype html>
<html lang="en">
<head>
    {{ HTML::style('css/profile.css') }}
   
</head>

<body> 
<div class="header-fixed">
    
<div class="bar"></div>
<div class="title"> &nbsp&nbsp{{ link_to("/", "A Fever of Llamas") }} </div>
<div class="bar"></div>
<div class="header-menu">
    <ul>
        @yield('menu')
    </ul>
</div>
    
</div>
    
<div class="content">
    @yield('content')
</div>

</body>

</html>