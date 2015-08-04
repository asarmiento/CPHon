<option value="">- - Seleccione - -</option>
@if(count($levels) > 0)
	@foreach($levels as $level)
		<option value="{{$level->token}}">{{ convertTitle($level->name) }}</option>
	@endforeach
@endif