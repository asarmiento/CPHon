<form class='editModal'>
	<section class='row'>
		<div class='col-sm-6 col-md-6'>
			<div class='form-mep'>
				<label for='yearRecordPercentage'>Año</label>
				<div class='input-group'>
					<span class='input-group-addon'><i class='fa fa-calendar'></i></span>
			      	<input name='yearRecordPercentage' class='form-control' type='number' value='"+data.year+"'/>
				</div>
			</div>
		</div>
		<div class='col-sm-6 col-md-6'>
			<div class='form-mep'>
				<label for='monthRecordPercentage'>Mes</label>
				<div class='input-group'>
					<span class='input-group-addon'><i class='fa fa-calendar'></i></span>
			      	<input name='monthRecordPercentage' class='form-control' type='number' value='"+data.month+"'/>
				</div>
			</div>
		</div>
		<div class='col-sm-6 col-md-6'>
			<div class='form-mep'>
				<label for='percentage_affiliatesRecordPercentage'>Porcentaje del Afiliado</label>
				<div class='input-group'>
					<span class='input-group-addon'><i class='fa fa-bars'></i></span>
			      	<input name='percentage_affiliatesRecordPercentage' class='form-control' type='number' step='any' value='"+data.percentage_affiliates+"'/>
				</div>
			</div>
		</div>
		<div class='col-sm-6 col-md-6'>
			<div class='form-mep'>
				<label for='percentageRecordPercentage'>Porcentaje de la Empresa</label>
				<div class='input-group'>
					<span class='input-group-addon'><i class='fa fa-bars'></i></span>
			      	<input name='percentageRecordPercentage' class='form-control' type='number' step='any' value='"+data.percentage+"'/>
				</div>
			</div>
		</div>
	</section>
</form>