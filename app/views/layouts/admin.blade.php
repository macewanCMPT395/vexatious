@extends('layouts.header')

@section('adminItems')
<li @yield('editkitsli')> 
    {{ HTML::linkRoute('kits.edit', 'Edit Kits') }} </li>
<li @yield('editusersli')> 
    {{ HTML::linkRoute('users.edit', 'Edit Users') }} </li>
@stop