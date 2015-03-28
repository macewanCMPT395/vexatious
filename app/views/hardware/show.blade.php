@extends('layouts.header')
@section('headerScript')
{{ HTML::script('fullcalendar/lib/jquery.min.js') }}
{{ HTML::style('css/hardware.css') }}
@stop

@section('content')

<div class="hw-Title">
	<p>{{$hardware->name}} - {{$hardware->assetTag}}</p>
	{{Form::open(['route' => ['hardware.destroy', $hardware->id], 'method'=>'delete']) }}
	{{Form::submit('Remove Device From System') }}
	{{Form::close() }}
</div>

<div class="hw-box" id="hw-description">
	<h2 id="hw-box-title">Description</h2>
	<p id="hw-box-text">{{$hardware->description}}</p>
</div>

<div class="hw-contentBox" id="hw-damage">
	<h2 id="hw-box-title">Damaged Status</h2>
	
	@if (!$hardware->damaged)
	<p id="hw-box-text">
		No damage to report for device
	</p>
	@else
		<ul>
			@foreach(explode("\n", $hardware->damaged) as $status)
				<li>{{$status}}</li>
			@endforeach
	
		</ul>
		

	@endif
	
	<!--create form to report damage-->
   {{ Form::open([ 'route' => ['hardware.update', $hardware->id],
					'id' => 'form-booking', 'method' => 'put']
	)}}
	
	{{Form::label('damaged', 'Report Damage') }}
	{{Form::text('damaged') }}
	{{Form::submit('Add damage report') }}
	
	{{ Form::close() }}
	
	
</div>

<div class="hw-box" id="hw-kitinfo">
	<h2 id="hw-box-title">Kit Information</h2>
	<div id="hw-box-text">
		@if (!$hardware->kitID)
			<p>
				This device is not associated with a kit.
			</p>
		@else
			<a href="/kits/{{$hardware->kitID}}">Device is associated with kit - {{$hardware->barcode}}
			</a>
		@endif
	</div>
</div>




@stop