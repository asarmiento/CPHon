<section class="Report-content">
	<br>
	@if( count($arrReceipt) > 0 || count($arrAuxilaryReceipt) > 0 )
	<table class="table table-bordered Table" cellpadding="0" cellspacing="0" border="1" width="100%">
        <tr class="Table-header" style="background-color:gray;">
            <th style="text-align: center;">Código</th>
            <th style="text-align: center;">Cuenta</th>
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
	                <td style="text-align: center;">{{ $sum }}</td>
				</tr>
				@foreach($receipts as $receipt)
					@if($codeReceipt == $receipt->receipt_number)
					<tr class="Table-content">
						<td style="text-align: center;">{{ $receipt->catalogs->code }}</td>
		                <td style="text-align: center;">{{ convertTitle($receipt->catalogs->name) }}</td>
		                <td style="text-align: center;">{{ $receipt->amount }}</td>
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
	                <td style="text-align: center;">{{ $sum }}</td>
				</tr>
				@foreach($auxiliaryReceipts as $auxiliaryReceipt)
					@if($codeReceipt == $auxiliaryReceipt->receipt_number)
					<tr class="Table-content">
						<td style="text-align: center;">{{ $auxiliaryReceipt->financialRecords->students->book }}</td>
		                <td style="text-align: center;">{{ convertTitle($auxiliaryReceipt->financialRecords->students->nameComplete()) }}</td>
		                <td style="text-align: center;">{{ $auxiliaryReceipt->amount }}</td>
		                <td style="text-align: center;"></td>
					</tr>
					@endif
				@endforeach
			<?php $aux += floatval($sum); ?>
			@endforeach
		@endif
		<tr style="background-color:gray;">
			<td></td>
			<td style="text-align: right; padding-right: 0.5em;">Total:</td>
			<td style="text-align: center;">{{ $aux }}</td>
			<td style="text-align: center;">{{ $aux }}</td>
		</tr>
    </table>
    @endif
</section>