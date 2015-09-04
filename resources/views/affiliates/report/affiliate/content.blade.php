<table style="margin: 1em 0">
	<tr>
		<td style="font-size:11px;margin-bottom: 1em;border-bottom: 1px solid black; padding: .5em;">Año</td>
		@foreach(months() as $month)
			<td style="font-size:11px;margin-bottom: 1em;border-bottom: 1px solid black; padding: .5em;">{{$month}}</td>
		@endforeach
	</tr>
	@foreach($dataAffiliate as $keyYear => $year)
		@if($keyYear < 20)
			<tr>
			@foreach($year as $key => $month)
				@if( $key == 0 && $keyYear != (count($dataAffiliate)-1) )
					<td style="font-size:11px;">{{ $month }}</td>
				@else
					<td style="text-align: right; font-size:11px;">
					@if( is_array($month) )
						{{ number_format($month[0],2,'.',',') }}
					@endif
					</td>
				@endif
			@endforeach
			</tr>
			<tr>
			@foreach($year as $key => $month)
				@if( $key == 0 && $keyYear != (count($dataAffiliate)-1) )
					<td style="font-size:11px;"></td>
				@else
					<td style="text-align: right; font-size:11px;">
					@if( is_array($month) )
						{{ $month[1] }}
					@endif
					</td>
				@endif
			@endforeach
			</tr>
		@endif
	@endforeach
</table>
@if(count($dataAffiliate) >= 20 && count($dataAffiliate) < 40)
	{{ addPage(1) }}
	<div class="page-break"></div>
	<img src="{{ asset('images/logo.jpg') }}" style="float: right; height: 85px; position: absolute; right: 5em; top: -1em;">
	<p style="margin:0; font-size: 14px;">Página: {{ Session::get('page') }} impreso el: {{ $arrDateNow[0] }} Hora: {{ $arrDateNow[1] }}</p>
	<p style="margin:0; font-size: 14px;">INSTITUTO DE PREVISION SOCIAL DEL PERIODISTA</p>
	<p style="margin:0; font-size: 14px;">{{ strtoupper($affiliate->fullname()) }}</p>
	<table>
		<tr>
			<td style="font-size:11px;margin-bottom: 1em;border-bottom: 1px solid black; padding: .5em;">Año</td>
			@foreach(months() as $month)
				<td style="font-size:11px;margin-bottom: 1em;border-bottom: 1px solid black; padding: .5em;">{{$month}}</td>
			@endforeach
		</tr>
		@foreach($dataAffiliate as $keyYear => $year)
			@if($keyYear >= 20 && $keyYear <40)
				<tr>
				@foreach($year as $key => $month)
					@if( $key == 0 && $keyYear != (count($dataAffiliate)-1) )
						<td style="font-size:11px;">{{ $month }}</td>
					@else
						<td style="text-align: right; font-size:11px;">
						@if( is_array($month) )
							{{ number_format($month[0],2,'.',',') }}
						@endif
						</td>
					@endif
				@endforeach
				</tr>
				<tr>
				@foreach($year as $key => $month)
					@if( $key == 0 && $keyYear != (count($dataAffiliate)-1) )
						<td style="font-size:11px;"></td>
					@else
						<td style="text-align: right; font-size:11px;">
						@if( is_array($month) )
							{{ $month[1] }}
						@endif
						</td>
					@endif
				@endforeach
				</tr>
			@endif
		@endforeach
	</table>
@endif
@if(count($dataAffiliate) >= 40)
	{{ addPage(1) }}
	<div class="page-break"></div>
	<img src="{{ asset('images/logo.jpg') }}" style="float: right; height: 85px; position: absolute; right: 5em; top: -1em;">
	<p style="margin:0; font-size: 14px;">Página: {{ Session::get('page') }} impreso el: {{ $arrDateNow[0] }} Hora: {{ $arrDateNow[1] }}</p>
	<p style="margin:0; font-size: 14px;">INSTITUTO DE PREVISION SOCIAL DEL PERIODISTA</p>
	<p style="margin:0; font-size: 14px;">{{ strtoupper($affiliate->fullname()) }}</p>
	<table>
		<tr>
			<td style="font-size:11px;margin-bottom: 1em;border-bottom: 1px solid black; padding: .5em;">Año</td>
			@foreach(months() as $month)
				<td style="font-size:11px;margin-bottom: 1em;border-bottom: 1px solid black; padding: .5em;">{{$month}}</td>
			@endforeach
		</tr>
		@foreach($dataAffiliate as $keyYear => $year)
			@if($keyYear >= 40)
				<tr>
				@foreach($year as $key => $month)
					@if( $key == 0 && $keyYear != (count($dataAffiliate)-1) )
						<td style="font-size:11px;">{{ $month }}</td>
					@else
						<td style="text-align: right; font-size:11px;">
						@if( is_array($month) )
							{{ number_format($month[0],2,'.',',') }}
						@endif
						</td>
					@endif
				@endforeach
				</tr>
				<tr>
				@foreach($year as $key => $month)
					@if( $key == 0 && $keyYear != (count($dataAffiliate)-1) )
						<td style="font-size:11px;"></td>
					@else
						<td style="text-align: right; font-size:11px;">
						@if( is_array($month) )
							{{ $month[1] }}
						@endif
						</td>
					@endif
				@endforeach
				</tr>
			@endif
		@endforeach
	</table>
@endif