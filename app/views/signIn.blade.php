
<!doctype html>
<html lang="en">
<head>
{{ HTML::style('css/header.css') }}
{{ HTML::style('css/signin.css') }}
</head>

<body>
<div class="outer">

<div id="Image"><img src="http://www.epl.ca/sites/all/themes/epl/img/EPL_logo2.png" border="0" style="width:400px;"></div>
    
<div id="bar"></div>
<div class="middle">
<div class="login">
    {{ Form::open(['route' => 'sessions.store']) }}
    <div class="title"></div>
    <div>
    {{ Form::label('email', 'Email: ') }}
    {{ Form::email('email') }}
    </div>
    <div>
    {{ Form::label('password', 'Password: ') }}
    {{ Form::password('password') }}
    </div>
    <div>{{ Form::submit('Sign In') }}</div>
    {{ Form::close() }}
</div>
</div>
</div>
</body>
</html>