{{ Form::open(['route' => 'sessions.store']) }}
<div>Login</div>
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
