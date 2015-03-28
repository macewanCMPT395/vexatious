@extends('layouts.header')
@section('headerScript')
{{ HTML::style('css/editkit.css') }}
<script src='fullcalendar/lib/jquery.min.js'></script>
@stop
@section('browsekitsli') class="" @stop
@section('content')
<div id="kitInfo">
     {{ Form::open(['method' => 'post', 'route' => 'kits.edit']) }}
     	<div class="inputs">
	<div>
		{{ Form::label('kitNumber', 'Bar Code:') }}
    		{{ Form::text('KitNumber', $kits->barcode) }}
	</div>
	<div>
		{{ Form::label('currentBranch', 'Current Branch:') }}
		{{ Form::select('CurrentBranch',Branch::lists("name","id"), $kits->currentBranchID, ['id'=>'CurrentBranch'] ) }}
	</div>
	<div>
		{{ Form::label('description', 'Description:') }}
		{{ Form::Input('string', 'description', $kits->description) }}
	</div>
	</div>
	<div>
	{{ Form::label('assetTable','Items within this kit') }}
	<table id="assetTable">
		<thead>
			<th>Type</th>
			<th>Damaged?</th>
		<thead>
		<tbody>
			@foreach($devices as $device)
					  <tr>
						<td>{{ $device->name }}</td>
						<td>{{ $device->damaged }}</td>
					</tr>
			@endforeach
		</tbody>
	</table>
	</div>
	<div>
	{{ Form::Submit('Apply Changes') }}
	</div>		       
{{ Form::close() }}
</div>
<div id="hardware">
@include('layouts.hardware')
</div>


@stop