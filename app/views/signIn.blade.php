@extends('layouts.main')

@section('items')

        <li>
        {{ Form::open(['route' => 'sessions.store']) }}
        <div id="form">
            <ul>
                <li>
                    <div id="item">Login</div>
                </li>
                <li>
                    <div id="textareasOut">
                    <div id="textareasIn">
                        {{ Form::label('email', 'Email: ') }}
                        {{ Form::email('email') }}
                        <br>
                        {{ Form::label('password', 'Password: ') }}
                        {{ Form::password('password') }}
                        <br>
                        {{ Form::submit('Sign In') }}
                    </div>
                    </div>
                </li>
            </ul>
        </div>
        {{ Form::close() }}
        
        </li>
        
@stop