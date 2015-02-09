@extends('layouts.main')

@section('items')
        
        <li>
        <div id="form">
            <ul>
                <li>
                    <div id="item">All Llamas</div>
                </li>
                <li>
                    <div id="textareasOut">
                    <div id="textareasIn">
                    
                    @foreach ($users as $user)
                        {{ $user->username }} <br>
                    @endforeach
                    </div>
                    </div>
                </li>
            </ul>
        </div>
        
        </li>

@stop