<div class="formatting">
{{ Form::label('title','Create New Kit Type') }}
<div class="hardwareType">
     {{ Form::open(['method' => 'post','route' => 'hardwaretype.store']) }}
     <ul>
     <li>
     {{ Form::label('name','Hardware Type:') }}
     {{ Form::input('string','name','Please enter the name of the hardware ex. IPAD') }}
     </li>
     <li>
     {{ Form::label('description','Description:') }}
     {{ Form::input('string','description','Please write a description of the hardware') }}
     </li>
     <li>
     {{ Form::Submit('Create kit Type') }}
     </li>
     </ul>
     {{ Form::close() }}
</div>
</div>
