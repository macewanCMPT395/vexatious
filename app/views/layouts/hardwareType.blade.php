<div class="hardware-create-type">
		{{ Form::label('title','Create New Kit Type') }}
	<div class="hardware-create-type-form">
		{{ Form::open(['method' => 'post','route' => 'hardwaretype.store']) }}
		<div class="hardware-create-type-input">
			{{ Form::label('name','Hardware Type:') }}
		 	{{ Form::input('string','name','Name of the hardware ex. iPad') }}
	 	</div>
	 	<div class="hardware-create-type-input">
			{{ Form::label('description','Description:') }}
			{{ Form::textarea('description','Please write a description of the hardware') }}
	 	</div>
	 	<div class="hardware-create-type-input" id="hardware-create-type-submit">
			{{ Form::Submit('Create kit Type') }}
	 	</div>
	 	{{ Form::close() }}
	</div>
</div>
