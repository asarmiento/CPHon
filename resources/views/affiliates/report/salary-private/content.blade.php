<table style="margin: 1em 0">
	<tr style="">
		<td style=" font-size:11px;margin-bottom: 1em;border-bottom: 1px solid black; padding: .5em;">Año</td>
		@foreach(months() as $month)
			<td style=" font-size:11px;margin-bottom: 1em;border-bottom: 1px solid black; padding: .5em;">{{$month}}</td>
		@endforeach
	</tr>
	@foreach($dataPrivate as $year)
		<tr>
		@foreach($year as $key => $month)
			@if($key == 0)
				<td style="font-size:11px;">{{ $month }}</td>
			@else
				<td style="text-align: right; font-size:11px;">
				@if( is_array($month) )
					{{ $month[2] }}
				@endif
				</td>
			@endif
		@endforeach
		</tr>
	@endforeach
</table>