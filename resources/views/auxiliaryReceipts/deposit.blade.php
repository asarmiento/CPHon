<div class="row">
	<div class='col-sm-6 col-md-10'>
		<div class='form-mep'>
			<label>Depósitos - (Cuenta - Referencia - Fecha - Monto)</label>
			<div class='row totalDeposit'>
				<aside class='row' style='margin-bottom: .5em;'>
					<div class='col-sm-3' style='padding:0;'>
						<div class='input-group'>
							<span class='input-group-addon'><i class='fa fa-credit-card'></i></span>
							<input class='form-control accountDepositAuxiliaryReceipt' type='text'>
						</div>
					</div>
					<div class='col-sm-3' style='padding:0;'>
						<div class='input-group'>
							<span class='input-group-addon'><i class='fa fa-barcode'></i></span>
							<input class='form-control numberDepositAuxiliaryReceipt' type='text'>
						</div>
					</div>
					<div class='col-sm-3' style='padding:0;'>
						<div class='input-group'>
							<span class='input-group-addon'><i class='fa fa-calendar'></i></span>
							<input class='form-control dateDepositAuxiliaryReceipt' type='date' placeholder='01/01/2015'>
						</div>
					</div>
					<div class='col-sm-3'>
						<div class='input-group'>
							<span class='input-group-addon'><i class='fa fa-usd'></i></span>
							<input class='form-control amountDepositAuxiliaryReceipt' type='number'>
						</div>
					</div>
				</aside>
			</div>
			<button id='addDeposit' class='btn btn-default'>Agregar Depósito</button>
			<button id='removeDeposit' class='btn btn-danger hide' style="margin-left:0.5em;">Eliminar Depósito</button>
		</div>
	</div>
</div>