@extends('layouts.header')

@section('headerScript')
	{{ HTML::Style('css/editkit.css') }}
	{{ HTML::Style('css/createkit.css') }}
@stop

@section('content')

	
	<div id="createKitType">
		@include('layouts.hardwareType')
	</div>

	<div id="createKitLayout">
	   {{ Form::label('title','Create A New Kit') }}
		<div id="createKitForm">
		{{ Form::open(['method' => 'post', 'route' => 'kits.store']) }}
		   <div class="create-new-kit-form">
		   {{ Form::label('barcode','Barcode:') }}
		   {{ Form::input('string','barcode','31221') }}
		   </div>
		   <div class="create-new-kit-form">
		   {{ Form::label('type', 'Type:') }}
		   {{ Form::select('type', HardwareType::lists('name','id')) }}
		   </div>
		   <div class="create-new-kit-form">
		   {{ Form::label('currentBranchID',"Current Branch:") }}
		   {{ Form::select('currentBranchID', Branch::lists('name','id')) }}
		   </div>
		   <div class="create-new-kit-form">
		   {{ Form::label('description', 'Description:') }}
		   {{ Form::input('string','description', 'Describe the contents of the kit here.') }}
		   </div>
		   <div class="create-new-kit-form" id="create-new-kit-submit">
		   {{ Form::Submit('Create Kit') }}
		   </div>
		{{ Form::close() }}
		</div>
	</div>

@stop