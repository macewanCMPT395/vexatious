<div class="hw-exists">
	<div class="hw-Title">
		<h1 id="hw-title-text"></h1>
	</div>

	<div class="hw-box" id="hw-description">
		<h2 class="hw-box-title">Description</h2>
		<p class="hw-box-text"></p>
	</div>

	<div class="hw-contentBox" id="hw-damage">
		<h2 class="hw-box-title">Damaged Status</h2>
		<p class="hw-box-text"></p>
		<ul id="hw-damage-list"></ul>



		<!--create form to report damage-->
	   {{ Form::open([ 'route' => ['hardware.update', '#'],
						'id' => 'form-reportDamage', 'method' => 'put']
		)}}

		{{Form::label('damaged', 'Report Damage') }}
		{{Form::text('damaged') }}
		{{Form::submit('Add damage report') }}
		{{ Form::close() }}

		@if(Auth::user()->role == 1)
		<div class="hw-controls-container">
			{{Form::open(['route' => ['hardware.update', '#'], 
							'id' => 'form-clearDamage', 'method'=>'put'])
			}}
			{{Form::submit('Clear Damage', ['id'=>'clearDamageSubmit'])}}
			{{Form::close() }}
		{{Form::open(['route' => ['hardware.destroy', '#'],
						'method'=>'delete', 'id'=>'deleteForm']) }}
		{{Form::submit('Delete Device',['id'=>'removeBtn']) }}
		{{Form::close() }}

		{{ Form::open([ 'route' => 'removefromkit', 'method'=>'post', 'id'=>'form-removeFromKit']) }}
		{{ Form::submit('Take Out Of Kit', ['id'=>'removeFromKitButton']) }}
		{{ Form::close() }}


		</div>		
		@endif
	</div>

	<div class="hw-box" id="hw-kitinfo">
		<div class="hw-box-text">
		</div>
	</div>
</div>
<div class="hw-none"></div>
