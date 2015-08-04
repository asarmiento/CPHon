<section class="Report-content">
	<br>
	@if( count($arrReceipt) > 0 || count($arrAuxilaryReceipt) > 0 )
	<table class="table table-bordered Table" cellpadding="0" cellspacing="0" border="1" width="100%">
        <tr class="Table-header" style="background-color:gray;">
            <th style="text-align: center;">Cuenta Bancaria</th>
            <th style="text-align: center;">N° Referencia</th>
            <th style="text-align: center;">Fecha</th>
            <th style="text-align: center;">Crédito</th>
            <th style="text-align: center;">Total</th>
        </tr>
        <?php $aux = 0; ?>
        @if( count($arrReceipt) > 0 )
        	@foreach($arrReceipt as $codeReceipt => $sum)
				<tr class="Table-content">
					<td style="text-align: center;">{{ $codeReceipt }}</td>
	                <td style="text-align: center;"></td>
	                <td style="text-align: center;"></td>
	                <td style="text-align: center;"></td>
	                <td style="text-align: center;">{{ $sum }}</td>
				</tr>
				@foreach($depositsRC as $depositRC)
					@if($codeReceipt == $depositRC->codeReceipt)
					<tr class="Table-content">
						<td style="text-align: center;">{{ $depositRC->account }}</td>
						<td style="text-align: center;">{{ $depositRC->number }}</td>
		                <td style="text-align: center;">{{ $depositRC->date }}</td>
		                <td style="text-align: center;">{{ $depositRC->amount }}</td>
		                <td style="text-align: center;"></td>
					</tr>
					@endif
				@endforeach
				@foreach($cashesRC as $cashRC)
					@if($codeReceipt == $cashRC->receipt)
					<tr class="Table-content">
						<td style="text-align: center;">Efectivo</td>
						<td style="text-align: center;"></td>
                                                <?php $fecha = explode(' ', $cashRC->updated_at) ?>
		                <td style="text-align: center;">{{ $fecha[0] }}</td>
		                <td style="text-align: center;">{{ $cashRC->amount }}</td>
		                <td style="text-align: center;"></td>
					</tr>
					@endif
				@endforeach
			<?php $aux += floatval($sum); ?>
			@endforeach
		@endif
		@if( count($arrAuxilaryReceipt) > 0 )
        	@foreach($arrAuxilaryReceipt as $codeReceipt => $sum)
				<tr class="Table-content">
					<td style="text-align: center;">{{ $codeReceipt }}</td>
	                <td style="text-align: center;"></td>
	                <td style="text-align: center;"></td>
	                <td style="text-align: center;"></td>
	                <td style="text-align: center;">{{ $sum }}</td>
				</tr>
				@foreach($depositsRCA as $depositRCA) 
					@if($codeReceipt == $depositRCA->codeReceipt)
					<tr class="Table-content">
						<td style="text-align: center;">{{ $depositRCA->account }}</td>
						<td style="text-align: center;">{{ $depositRCA->number }}</td>
		                <td style="text-align: center;">{{ $depositRCA->date }}</td>
		                <td style="text-align: center;">{{ $depositRCA->amount }}</td>
		                <td style="text-align: center;"></td>
					</tr>
					@endif
				@endforeach
				@foreach($cashesRCA as $cashRCA)
					@if($codeReceipt == $cashRCA->receipt)
					<tr class="Table-content">
						<td style="text-align: center;">Efectivo</td>
						<td style="text-align: center;"></td>
                                                <?php $fecha = explode(' ', $cashRCA->updated_at) ?>
		                <td style="text-align: center;">{{ $fecha[0] }}</td>
		                <td style="text-align: center;">{{ $cashRCA->amount }}</td>
		                <td style="text-align: center;"></td>
					</tr>
					@endif
				@endforeach
			<?php $aux += floatval($sum); ?>
			@endforeach
		@endif
		<tr style="background-color:gray;">
			<td></td>
			<td></td>
			<td style="text-align: right; padding-right: 0.5em;">Total:</td>
			<td style="text-align: center;">{{ $aux }}</td>
			<td style="text-align: center;">{{ $aux }}</td>
		</tr>
    </table>
    @endif
</section>