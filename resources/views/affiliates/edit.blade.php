<form class='editModal'>
	<section class='row'>
		<div class='col-sm-4 col-md-4'>
			<div class='form-mep'>
				<label for='codeAffiliates'>Código</label>
				<div class='input-group'>
					<span class='input-group-addon'><i class='fa fa-barcode'></i></span>
			      	<input name='codeAffiliates' class='form-control' type='text' value='"+data.code+"' />
				</div>
			</div>
		</div>
		<div class='col-sm-4 col-md-4'>
			<div class='form-mep'>
				<label for='charterAffiliates'>Cédula</label>
				<div class='input-group'>
					<span class='input-group-addon'><i class='fa fa-barcode'></i></span>
			      	<input name='charterAffiliates' class='form-control' type='text' value='"+data.charter+"' />
				</div>
			</div>
		</div>
		<div class='col-sm-4 col-md-4'>
			<div class='form-mep'>
				<label for='fnameAffiliates'>Primer Nombre</label>
				<div class='input-group'>
					<span class='input-group-addon'><i class='fa fa-user'></i></span>
			      	<input name='fnameAffiliates' class='form-control' type='text' value='"+data.fname+"' />
				</div>
			</div>
		</div>
		<div class='col-sm-4 col-md-4'>
			<div class='form-mep'>
				<label for='snameAffiliates'>Segundo Nombre</label>
				<div class='input-group'>
					<span class='input-group-addon'><i class='fa fa-user'></i></span>
			      	<input name='snameAffiliates' class='form-control' type='text' value='"+data.sname+"' />
				</div>
			</div>
		</div>
		<div class='col-sm-4 col-md-4'>
			<div class='form-mep'>
				<label for='flastAffiliates'>Primer Apellido</label>
				<div class='input-group'>
					<span class='input-group-addon'><i class='fa fa-user'></i></span>
			      	<input name='flastAffiliates' class='form-control' type='text' value='"+data.flast+"' />
				</div>
			</div>
		</div>
		<div class='col-sm-4 col-md-4'>
			<div class='form-mep'>
				<label for='slastAffiliates'>Segundo Apellido</label>
				<div class='input-group'>
					<span class='input-group-addon'><i class='fa fa-user'></i></span>
			      	<input name='slastAffiliates' class='form-control' type='text' value='"+data.slast+"' />
				</div>
			</div>
		</div>
		<div class='col-sm-4 col-md-4'>
			<div class='form-mep'>
				<label for='addressAffiliates'>Dirección</label>
				<div class='input-group'>
					<span class='input-group-addon'><i class='fa fa-map-marker'></i></span>
			      	<input name='addressAffiliates' class='form-control' type='text' value='"+data.address+"' />
				</div>
			</div>
		</div>
		<div class='col-sm-4 col-md-4'>
			<div class='form-mep'>
				<label for='homePhoneAffiliates'>Teléfono</label>
				<div class='input-group'>
					<span class='input-group-addon'><i class='fa fa-phone'></i></span>
			      	<input name='homePhone' class='form-control' type='text' value='"+data.homePhone+"' />
				</div>
			</div>
		</div>
		<div class='col-sm-4 col-md-4'>
			<div class='form-mep'>
				<label for='birthdateAffiliates'>Fecha de Nacimiento</label>
				<div class='input-group'>
					<span class='input-group-addon'><i class='fa fa-calendar'></i></span>
			      	<input name='birthdateAffiliates' class='form-control' type='date' value='"+data.birthdate+"' />
				</div>
			</div>
		</div>
		<div class='col-sm-4 col-md-4'>
			<div class='form-mep'>
				<label for='maritalStatusAffiliates'>Estado Civil</label>
				<select class='form-control' name='maritalStatusAffiliates'>"+
					if(data.maritalStatus == 'Casado'){+"
						<option value='Casado' selected>Casado</option>
						<option value='Soltero'>Soltero</option>"+
					}else{+"
						<option value='Casado'>Casado</option>
						<option value='Soltero' selected>Soltero</option>
					"+}+"
				</select>
			</div>
		</div>
	</section>
</form>