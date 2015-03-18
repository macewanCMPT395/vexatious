@extends('layouts.header')

@section('adminButtons')
	<div class="button"><a href= {{URL::route('kits.edit')}}>EDIT KITS</div>
	<div class="button"><a href= {{URL::route('users.edit')}}>EDIT USERS</div>
@stop