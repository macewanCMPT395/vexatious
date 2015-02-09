@extends('layouts.profile')

@section('menu')
        
        <li>
            {{ link_to("/users/{$user->username}", "Peruse Llamas") }}
        </li>
        
        <li>
            {{ link_to("/", "Sign Out") }}
        </li>
@stop

@section('content')
{{ Form::open(['method' =>'put', 'route' => "users.update"]) }}
<div class="profile">
        <ul>
            <li>
                {{ HTML::image('images/bhipster.jpg', 'profile pic',array('class' => 'pic')) }}
            </li>
            <li>
                <div class="user-name">{{$user->username}}</div>
                <div class="edit-info">
                    <ul>
                        <li>
                    <div id="textareasOut">
                    <div id="textareasIn">
                        {{ Form::label('username', 'Username: ') }}
                        {{ Form::text('username', $user->username) }}
                        <br>
                        {{ Form::label('password', 'Password: ') }}
                        {{ Form::text('password', '') }}
                        <br>
                        {{ Form::label('password', 'Gender: ') }}
                        {{ Form::select('Gender',['Male', 'Female', 'TransLlama', 'NonGendered'], $user->Gender) }}
                        <br>
                        {{ Form::label('LookingFor', 'Looking For: ') }}
                        {{ Form::select('LookingFor',['Male', 'Female', 'TransLlama', 'NonGendered'], $user->SexualOrientation) }}
                        <br>
                        
                    </div>
                    </div>
                </li>
                <li>
                    <div id="textareasOut">
                    <div id="textareasIn">
                        
                        {{ Form::label('FurColor', 'Fur Color: ') }}
                        {{ Form::text('FurColor', $user->FurColor) }}
                        <br>
                        {{ Form::label('CommitmentLevel', 'Commitment Level: ') }}
                        {{ Form::select('CommitmentLevel',['Mild Eye Contact', 'Hoofing', 'Prancing', 'Elope to Peru'], $user->Type) }}
                        <br>
                    </div>
                    </div>
                </li>
                <li>
                    <div id="textareasOut">
                    <div id="textareasIn">
                        {{ Form::label('Interests', 'Interests: ') }}
                        {{ Form::text('Interests', $user->Interests) }}
                        <br>
                        {{ Form::label('Email', 'Email: ') }}
                        {{ Form::text('Email', $user->Email) }}
                        <br>
                        {{ Form::submit('Update Profile') }}
                        <br>
                    </div>
                    </div>
                </li>
                        
                    </ul>
                </div>
            </li>
        </ul>
    </div>
        
{{ Form::close() }}
@stop
