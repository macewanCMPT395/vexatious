@extends('layouts.main')

@section('items')
        
        <li>
        {{ Form::open(['route' => 'users.store']) }}
        <div id="form">
            <ul>
                <li>
                    <div id="item">New</div>
                </li>
                <li>
                    <div id="textareasOut">
                    <div id="textareasIn">
                        {{ Form::label('Username', 'Username: ') }}
                        {{ Form::text('Username',$errors->first('username'),array('class' => $errors->has('username' ? 'error' : ''))) }}
                        <br>
                        {{ Form::label('Password', 'Password: ') }}
                        {{ Form::password('Password') }}
                        <br>
                        {{ Form::label('Gender', 'Gender: ') }}
                        {{ Form::select('Gender',['Male', 'Female', 'TransLlama', 'NonGendered']) }}
                    </div>
                    </div>
                </li>
                <li>
                    <div id="textareasOut">
                    <div id="textareasIn">
                        {{ Form::label('LookingFor', 'Looking For: ') }}
                        {{ Form::select('LookingFor',['Male', 'Female', 'TransLlama', 'NonGendered']) }}
                        <br>
                        {{ Form::label('FurColor', 'Fur Color: ') }}
                        {{ Form::text('FurColor') }}
                        <br>
                        {{ Form::label('CommitmentLevel', 'Commitment Level: ') }}
                        {{ Form::select('CommitmentLevel',['Mild Eye Contact', 'Hoofing', 'Prancing', 'Elope to Peru']) }}
                        <br>
                    </div>
                    </div>
                </li>
                <li>
                    <div id="textareasOut">
                    <div id="textareasIn">
                        {{ Form::label('Interests', 'Interests: ') }}
                            {{ Form::text('Interests') }}
                            <br>
                            {{ Form::label('Email', 'Email: ') }}
                            {{ Form::text('Email') }}
                            <br>
                            {{ Form::submit('Create Profile') }}
                    </div>
                    </div>
                </li>
            </ul>
        </div>
        {{ Form::close() }}
        
        </li>

@stop