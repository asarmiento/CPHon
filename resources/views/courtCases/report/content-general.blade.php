<section class="Report-content">
	<br>
	@if( !$receipts->isEmpty() || !$auxiliaryReceipts->isEmpty() )
	<table class="table table-bordered Table" cellpadding="0" cellspacing="0" border="1" width="100%">
        <tr class="Table-header" style="background-color:gray;">
            <th style="text-align: center;">Código</th>
            <th style="text-align: center;">Cuenta</th>
            <th style="text-align: center;">Crédito</th>
        </tr>
        <?php $aux = 0; ?>
        @if( !$receipts->isEmpty() )
        	@foreach($receipts as $receipt)
			<tr class="Table-content">
				<td style="text-align: center;">{{ $receipt->catalogs->code }}</td>
                <td style="text-align: center;">{{ convertTitle($receipt->catalogs->name) }}</td>
                <td style="text-align: center;">{{ $receipt->amount }}</td>
			</tr>
			<?php $aux += floatval($receipt->amount); ?>
			@endforeach
		@endif
		@if( !$auxiliaryReceipts->isEmpty() )
			@foreach($auxiliaryReceipts as $auxiliaryReceipt)
			<tr class="Table-content">
				<td style="text-align: center;">{{ $auxiliaryReceipt->financialRecords->students->book }}</td>
                <td style="text-align: center;">{{ convertTitle($auxiliaryReceipt->financialRecords->students->nameComplete()) }}</td>
                <td style="text-align: center;">{{ $auxiliaryReceipt->amount }}</td>
			</tr>
			<?php $aux += floatval($auxiliaryReceipt->amount); ?>
			@endforeach
		@endif
		@if( !$receipts->isEmpty() || !$auxiliaryReceipts->isEmpty() )
			<tr style="background-color:gray;">
				<td style="text-align: right; padding-right: 0.5em;">Depositos:</td>
				<td style="text-align: center;">
					@if($sumDepositsRC > 0 && $sumDepositsRCA > 0)
						{{ $sumDepositsRC + $sumDepositsRCA }}
					@elseif($sumDepositsRC == 0)
						{{ $sumDepositsRCA }}
					@elseif($sumDepositsRCA == 0)
						{{ $sumDepositsRC }}
					@endif
				</td>
				<td style=""></td>
			</tr>
			<tr style="background-color:gray;">
				<td style="text-align: right; padding-right: 0.5em;">Efectivo:</td>
				<td style="text-align: center;">
					@if($sumCashesRC > 0 && $sumCashesRCA > 0)
						{{ $sumCashesRC + $sumCashesRCA }}
					@elseif($sumCashesRC == 0)
						{{ $sumCashesRCA }}
					@elseif($sumCashesRCA == 0)
						{{ $sumCashesRC }}
					@endif
				</td>
				<td style=""></td>
			</tr>
			<tr style="background-color:gray;">
				<td style="text-align: right; padding-right: 0.5em;">Total:</td>
				<td style="text-align: center;">{{ ($sumDepositsRC + $sumDepositsRCA + $sumCashesRC + $sumCashesRCA) }}</td>
				<td style="text-align: center;">{{ $aux }}</td>
			</tr>
		@endif
    </table>
    @endif
</section>