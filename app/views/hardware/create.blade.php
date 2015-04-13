@extends('layouts.header')
@section('headerScript')
{{ HTML::script('fullcalendar/lib/jquery.min.js') }}
{{ HTML::Style('css/createkit.css') }}
{{ HTML::Style('css/editkit.css') }}
@stop

@section('content')
<div class="AddHardwareDiv">

	<div id="createKitType">
		@include('layouts.hardwareType')
	</div>
	
	<div id="createKitLayout">
	   {{ Form::label('title','Create A New Asset') }}
		<div id="createKitForm">
		{{ Form::open(['method' => 'post', 'route' => 'hardware.store']) }}
		   <div class="create-new-kit-form">
		   {{ Form::label('type', 'Type:') }}
		   {{ Form::select('type', HardwareType::lists('name','id')) }}
		   </div>
		   <div class="create-new-kit-form">
		   {{ Form::label('assetTag', 'Asset Tag:') }}
		   {{ Form::input('string','assetTag') }}
		   </div>
		   <div class="create-new-kit-form" id="create-new-kit-submit">
		   {{ Form::Submit('Create Asset') }}
		   </div>
		{{ Form::close() }}
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {

	$("#TypeSelect").selectedIndex = 0;
	
});
</script>

@stop

