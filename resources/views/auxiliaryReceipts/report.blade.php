<div class="Report" style="font-size: 18px;">
	<section class="Report-header">
		<p style="text-align: center;">{{ userSchool()->name }}</p>
		<p style="text-align: center;">Recibo de Caja</p>
		<aside class="Report-header-receipt">
			<div style="display:inline-block; width:48%;">Recibimos de: {{ convertTitle($dataReceipt[0]->received_from) }}</div>
			<div style="display:inline-block; width:48%; text-align:right;">Número: {{ $dataReceipt[0]->receipt_number }}</div>
		</aside>
	</section>
	<section class="Report-content">
		<br>
		<table class="table table-bordered Table" cellpadding="0" cellspacing="0" border="1" width="100%">
            <tr class="Table-header" style="background-color:gray;">
                <th style="text-align: center;">Código</th>
                <th style="text-align: center;">Nombre</th>
                <th style="text-align: center;">Descripción</th>
                <th style="text-align: center;">Monto</th>
            </tr>
            <?php $aux = 0; ?>
            @foreach($dataReceipt as $data)
				<tr class="Table-content">
					<td style="text-align: center;">{{ $data->financialRecords->students->book }}</td>
	                <td style="text-align: center;">{{ convertTitle($data->financialRecords->students->nameComplete()) }}</td>
	                <td style="text-align: center;">{{ convertTitle($data->detail) }}</td>
	                <td style="text-align: center;">{{ $data->amount }}</td>
				</tr>
				<?php $aux++; ?>
			@endforeach
			@if(count($dataReceipt) < 5 )
				<?php $tr = 5 - $aux; ?>
				@for($i = 0; $i < $tr ; $i++)
					<tr class="Table-content">
						<td height="15"></td>
		                <td height="15"></td>
		                <td height="15"></td>
		                <td height="15"></td>
					</tr>
				@endfor
			@endif
			<tr style="background-color:gray;">
				<td style="padding-left: 0.5em;">N° de Depósitos:</td>
				<td style="padding-left: 0.5em;">{{ $deposits_numbers }}</td>
				<td style="text-align: center;">Total:</td>
				<td style="text-align: center;">{{ $totalReceipt }}</td>
			</tr>
			<tr style="background-color:gray;">
				<td style="padding-left: 0.5em;">Elaborado por:</td>
				<td style="padding-left: 0.5em;">{{ currentUser()->nameComplete() }}</td>
				<td></td>
				<td></td>
			</tr>
        </table>
	</section>
</div>
