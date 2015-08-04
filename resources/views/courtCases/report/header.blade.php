<section class="Report-header">
	<p style="text-align: center; margin: .25em;">{{ userSchool()->name }}</p>
	<p style="text-align: center; margin: .25em;">Corte de Caja # {{ $courtCase->abbreviation }} </p>
	@if( !$receipts->isEmpty() )
	<p style="text-align: center; margin: .25em;">Recibos: {{ $receipts[0]->receipt_number }} a {{ $receipts[count($receipts)-1]->receipt_number }} </p>
	@endif
	@if( !$auxiliaryReceipts->isEmpty() )
	<p style="text-align: center; margin: .25em;">Recibos Auxiliares: {{ $auxiliaryReceipts[0]->receipt_number }} a {{ $auxiliaryReceipts[count($auxiliaryReceipts)-1]->receipt_number }} </p>
	@endif
	<p style="text-align: center;">Fecha de Asiento {{ dateShort() }} - Periodo: {{ period() }}</p>
</section>