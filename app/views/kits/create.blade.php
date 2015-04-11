@extends('layouts.header')

@section('headerScript')
	{{ HTML::Style('css/editkit.css') }}
@stop

@section('content')
   {{ Form::label('title','Please enter all information to create kit') }}
<div id="kitInfo">
{{ Form::open(['method' => 'post', 'route' => 'kits.store']) }}
   <ul>
   <li>
   {{ Form::label('barcode','Barcode:') }}
   {{ Form::input('string','barcode','31221') }}
   </li>
   <li>
   {{ Form::label('type', 'Type:') }}
   {{ Form::select('type', HardwareType::lists('name','id')) }}
   </li>
   <li>
   {{ Form::label('currentBranchID',"Current Branch:") }}
   {{ Form::select('currentBranchID', Branch::lists('name','id')) }}
   </li>
   <li>
   {{ Form::label('description', 'Description:') }}
   {{ Form::input('string','description') }}
   </li>
   <li>
   {{ Form::Submit('Create Kit') }}
   </li>
   </ul>
{{ Form::close() }}
</div>
@include('layouts.hardwareType')
@stop