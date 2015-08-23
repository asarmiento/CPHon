<table style="margin: 1em 0">
	<tr style="">
		<td style=" font-size:11px;margin-bottom: 1em;border-bottom: 1px solid black; padding: .5em;">Año</td>
		@foreach(months() as $month)
			<td style=" font-size:11px;margin-bottom: 1em;border-bottom: 1px solid black; padding: .5em;">{{$month}}</td>
		@endforeach
	</tr>
	@foreach($data as $year)
		<tr>
		@foreach($year as $key => $month)
			@if($key == 0)
			<td style="font-size:11px;">{{ $month }}</td>
			@else
			<td style="text-align: right;font-size:11px;">
				@if( $month/(recordPercentage()->percentage/100) == 0 )
					{{ "" }}
				@else
					{{ $month/(recordPercentage()->percentage/100) }}
				@endif
			</td>
			@endif
		@endforeach
		</tr>
	@endforeach
</table>