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
		{{ Form::label('kitNumber', 'Kit Number:') }}
    		{{ Form::Input('string','KitNumber') }}
	</div>
	<div>
		{{ Form::label('currentBranch', 'Current Branch:') }}
		{{ Form::Input('string', 'CurrentBranch') }}
	</div>
	<div>
		{{ Form::label('description', 'Description:') }}
		{{ Form::Input('string', 'description') }}
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
		</tbody>
	</table>
	</div>
	<div>
	{{ Form::Submit('Apply Changes') }}
	</div>		       
{{ Form::close() }}
</div>
@stop