@extends('layouts.header')

@section('adminButtons')
	<div class="button"><a href={{URL::route('editkits')}}>EDIT KITS</div>
	<div class="button><a href={{URL::route('editusers')}}>EDIT USERS</div>
@stop