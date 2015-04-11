@extends('layouts.header')
@section('headerScript')
{{ HTML::script('fullcalendar/lib/jquery.min.js') }}
{{ HTML::style('css/bookingview.css') }}
@stop

@section('content')
<div class="AddHardwareDiv">

	@include('layouts.hardwareType')

	{{ Form::open(['method' => 'post',
	               'id' => 'form-add_new_hardware',
	               'route' => ['hardware.store']
	])}}

	<div class="AddNewHardwareDiv">
		<div class="HardwareTypeSelectLabelDiv">
		<center>
		{{ Form::Label('_Addhardwarelbl', 'Add New Hardware') }}
		</center>
		</div>

		<div class="HardwareTypeSelectBox">
		<center>

		{{ Form::select('type', HardwareType::lists('name', 'id')) }}
		</center>
		</div>
		<div class="HardwareAssetTagDiv">
		<center>
		{{ Form::label('_AssetTagBoxlbl', 'Asset Tag:') }}
			<div>
			{{ Form::text('assetTag') }}
			</div>
		</center>
		</div>

		<div class="SubmitNewHardwareDiv">
		<center>
		{{ Form::submit('submit') }}
		</center>
		</div>

	</center>
	</div>

	{{ Form::close() }}

</div>

<script type="text/javascript">
$(document).ready(function() {

	$("#TypeSelect").selectedIndex = 0;
	
});
</script>

@stop

