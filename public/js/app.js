var server = "/";

/**
 * [exists description]
 * @return {[type]} [description]
 */
jQuery.fn.exists = function() {
	return this.length>0;
}

/**
 * @param  {[string]} selector [id table]
 * @param  {[string]} list [comment the table]
 * @return {[dataTable]}   [table with options dataTable]
 */
var dataTable = function(selector, list){
	var options = {
		"order": [
            [0, "asc"]
        ],
        "bLengthChange": true,
        //'iDisplayLength': 7,
        "oLanguage": {
        	"sLengthMenu": "_MENU_ registros por página",
        	"sInfoFiltered": " - filtrada de _MAX_ registros",
            "sSearch": "Buscar: ",
            "sZeroRecords": "No existen, " + list,
            "sInfoEmpty": " ",
            "sInfo": 'Mostrando _END_ de _TOTAL_',
            "oPaginate": {
                "sPrevious": "Anterior",
                "sNext": "Siguiente"
            }
        }
	};
	$(selector).DataTable(options);
};

/**
 * [messageAjax - Response message after request ]
 * @param  {[json]} data [description messages error after request]
 * @return {[alert]}     [errors in alert]
 */
var box;
var messageAjax = function(data, href) {
	//console.log(data.errors);
	$.unblockUI();
	if(data.success){
		if(href){
			//console.log(href);
			box = bootbox.alert('<p>Para mostrar el reporte presione <a class="reportShow" href="'+href+'"" target="_blank">aquí.</a></p>');
			setTimeout(function() {
				box.modal('hide');
				window.location.href = href;
			}, 5000);
			return false;
		}
		bootbox.alert('<p class="success-ajax">'+data.message+'</p>', function(){
			location.reload();
		});
	}
	else{
		messageErrorAjax(data);
	}
};

/**
 * [messageErrorAjax description]
 * @param  {[type]} error [description]
 * @return {[type]}       [description]
 */
var messageErrorAjax = function(data){
	$.unblockUI();
	var errors = data.errors;
	var error  = "";
	if($.type(errors) === 'string'){
		error = data.errors;
	}else{
		for (var element in errors){
			if(errors.hasOwnProperty(element)){
				error += errors[element] + '<br>';
			}
		}
	}
	bootbox.alert('<p class="error-ajax">'+error+'</p>');
};

/**
 * [addActive - Add class for submenu active]
 * @param {[string]} element [submenu]
 */
var addActive = function (element) {
	element.find('.icon-menu').removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-down');
	element.addClass('active');
	element.find('.nav').show('slide');
};

/**
 * [removeActive - Remove class for submenu active]
 * @param {[string]} element [submenu]
 */
var removeActive = function (element) {
	$('.active').find('.icon-menu').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-right');
	$('.active').find('.nav').hide('slide');
	$('.active').removeClass('active');
};

/**
 * [loadingUI - Message before ajax for request]
 * @param  {[string]} message [message for before ajax]
 * @return {[message]}        [blockUI response with message]
 */
var loadingUI = function (message, img){
	if(img){
		var msg = '<h2><img style="margin-right: 30px" src="' + server + 'images/spiffygif.gif" >' + message + '</h2>';
	}else{
		var msg = '<h2>' + message + '</h2>';
	}
    $.blockUI({ css: {
        border: 'none',
        padding: '15px',
        backgroundColor: '#000',
        '-webkit-border-radius': '10px',
        '-moz-border-radius': '10px',
        opacity: 0.5,
        color: '#fff'
    }, message: msg});
};

/**
 * [addInputText description]
 * @param {[type]} data     [description]
 * @param {[type]} selector [description]
 */
var addInputText = function(data, selector){
	var div = '<div class="input-group">';
		div+= '<span class="input-group-addon"><i class="fa fa-tag"></i></span>';
		div+= '<input id="typeAuxiliarySeat" class="form-control" type="text" value="'+ data.textTypeAuxiliarySeat +'" data-type="text" data-token="'+ data.typeAuxiliarySeat +'" disabled>';
		div+= '</div>';
	selector.append(div);
};

/**
 * [ajaxForm - setup ajax for request]
 * @param  {[string]} url  [description]
 * @param  {[string]} type [description]
 * @param  {[json]} data [description]
 * @return {[type]}      [description]
 */
var ajaxForm = function (url, type, data, msg, school){
	var message;
	var path = server + url;
	if(msg){
		message = msg
	}else{
		if(type == 'post'){
		message = 'Registrando Datos';
		}else{
			message = 'Actualizando Registros';
		}
	}
	if(school){
		path = server + window.location.pathname.split('/')[1] + '/' + window.location.pathname.split('/')[2] + ('/') +url;
	}
	return $.ajax({
				url: path,
			    type: type,
			    data: {data: JSON.stringify(data)},
			    datatype: 'json',
			    beforeSend: function(){
		    		loadingUI(message, 'img');
			    },
			    error:function(xhr, status, error){
			    	$.unblockUI();
			    	if(xhr.status == 401){
			    		bootbox.alert("<p class='red'>No estas registrado en la aplicación.</p>", function(response){
			    				location.reload();
			    		});
			    	}else{
		    			bootbox.alert("<p class='red'>No se pueden grabar los datos.</p>");
			    	}
				}
	});
};

/**
 * [addItemRow description]
 * @param {[type]} data     [description]
 * @param {[type]} response [description]
 * @param {[type]} receipt  [description]
 */
var addItemRow = function (data, response, receipt){
	var codeArray = data.codeStudent.split(' ');
	var tr = '<tr class="Table-content">';
			tr+= '<td>'+ codeArray[0] + '</td>';
			tr+= '<td>'+ codeArray[2] + ' ' + codeArray[3] + codeArray[4] + ' ' +codeArray[5] +  '</td>';
			if(receipt){
				tr+= '<td>'+ data.detailAuxiliaryReceipt + '</td>';
				tr+= '<td class="text-center">'+ data.amountAuxiliaryReceipt +'</td>';
				tr+= '<td class="text-center"><a id="deleteReceiptRow" data-url="recibos-auxiliares" href="#" data-id="'+ response.message.id +'"><i class="fa fa-trash-o"></i></a></td>';
			}else{
				tr+= '<td>'+ data.detailAuxiliarySeat + '</td>';
				tr+= '<td>'+ data.textTypeAuxiliarySeat + '</td>';
				tr+= '<td class="text-center">'+ data.amountAuxiliarySeat +'</td>';
				tr+= '<td class="text-center"><a id="deleteDetailRow" data-url="asientos-auxiliares" href="#" data-id="'+ response.message.id +'"><i class="fa fa-trash-o"></i></a></td>';
			}
		tr+= '</tr>';
	return tr;
};

/**
 * [addItemSeat description]
 * @param {[type]} data     [description]
 * @param {[type]} response [description]
 */
var addItemSeat = function (data, response){
	var textAccountSeating     = data.textAccountSeating.split(' ');
	var textTypeSeating        = data.textTypeSeating;
	var textAccountPartSeating = data.textAccountPartSeating;
	var amountSeating          = data.amountSeating;
	var totalSeating           = amountSeating.reduce(function(previousValue, currentValue){
									return parseFloat(previousValue) + parseFloat(currentValue);
								});
	var tr = '<tr class="Table-content">';
	var textAccount = '';
			tr+= '<td>'+ textAccountSeating[0] + '</td>';
			for (var i = 1; i < textAccountSeating.length; i++) {
				textAccount += ' '+textAccountSeating[i];
			}
			tr+= '<td>'+ textAccount +'</td>';
			if(textTypeSeating.toLowerCase() == 'debito'){
				tr+= '<td class="text-center">'+ totalSeating + '</td>';
				tr+= '<td class="text-center">'+ '-' + '</td>';
			}else{
				tr+= '<td class="text-center">'+ '-' + '</td>';
				tr+= '<td class="text-center">'+ totalSeating + '</td>';
			}
			tr+= '<td class="text-center"><a id="deleteDetailSeating" data-url="asientos" href="#" data-id="'+ response.message.id +'"><i class="fa fa-trash-o"></i></a></td>';
		tr+= '</tr>';
		tr+= '<tr class="Table-description">';
			tr+= '<td>'+ data.detailSeating + '</td>';
		tr+= '</tr>';
		/* Childs */
		for (var i = 0; i < amountSeating.length; i++) {
			var amountPart = amountSeating[i];
			var textPart   = textAccountPartSeating[i].split(' ');
			var textAccountPart = '';
			for (var j = 1; j < textPart.length; j++) {
				textAccountPart += ' '+textPart[j];
			}
			tr+= '<tr class="Table-description">';
				tr+= '<td>'+ textPart[0] + '</td>';
				tr+= '<td>'+ textAccountPart + '</td>';
				if(textTypeSeating.toLowerCase() == 'debito'){
					tr+= '<td class="text-center">'+ '-' + '</td>';
					tr+= '<td class="text-center">'+ amountPart + '</td>';
				}else{
					tr+= '<td class="text-center">'+ amountPart + '</td>';
					tr+= '<td class="text-center">'+ '-' + '</td>';
				}
			tr+= '</tr>';
		};
	return tr;
};

/**
 * [addItemReceipt description]
 * @param {[type]} data     [description]
 * @param {[type]} response [description]
 */
var addItemReceipt = function (data, response){
	var tr = '<tr class="Table-content">';
			tr+= '<td>'+ data.textCodeCatalogReceipt + '</td>';
			tr+= '<td>'+ data.textNameCatalogReceipt + '</td>';
			tr+= '<td class="text-center">'+ data.amountReceipt + '</td>';
			tr+= '<td class="text-center"><a id="deleteReceipt" data-url="recibos" href="#" data-id="'+ response.message.id +'"><i class="fa fa-trash-o"></i></a></td>';
		tr+= '</tr>';
		tr+= '<tr class="Table-description" colspan="4">';
			tr+= '<td>'+ data.detailReceipt +'</td>';
		tr+= '</tr>';
		return tr;
};

$(function(){
	//setup Ajax
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	var data = {};
	
	//Event menu expand
	$('.submenu').on('click', function(e){
		e.preventDefault();
		var element = $(this);
		var exp = false;
		if($(this).hasClass('active')){
			exp = true;
		}
		removeActive();
		if(!$(this).hasClass('active')){
			if(!exp){
				addActive(element);
			}
		}
	});

	$('.submenu li a').on('click', function(){
		window.location.href = $(this).attr('href');
	});

	//Switch Checkbox
	if( $("[name='status-checkbox']").exists() ){
		$("[name='status-checkbox']").bootstrapSwitch({size:'normal'});
	}

	if( $("[name='task-checkbox']").exists() ){
		$("[name='task-checkbox']").bootstrapSwitch({size:'normal'});
	}

	if( $(".role-checkbox").exists() ){
		$(".role-checkbox").bootstrapSwitch({size:'normal'});
	}

	//dateRangepicker
	if( $('#txtDate').exists() ){
		$("#txtDate").daterangepicker(
			{
				locale:{
					monthNames: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Set','Oct','Nov','Dic'],
					applyLabel: 'Aceptar',
					cancelLabel: 'Cancelar',
					fromLabel: 'Desde',
					toLabel: 'Hasta'
				},
				minViewMode: 'month',
			    format: 'MM/YYYY',
			    startDate: $('#startDate').val(),
			    endDate: $('#endDate').val(),
			    minDate: $('#startDate').val(),
			    maxDate: $('#endDate').val(),
			    hideFormInputs: false,
			    opens: 'right',
			    autoApplyClickedRange : true
			},
			function(start, end, label) {
			 	$('#txtDate').val(start.format('MM/YYYY')+'-'+end.format('MM/YYYY'));
			}
		);
	}

	//Events

	//txtDate Range Dates
	$(document).off('change', '#txtDate');
	$(document).on('change', '#txtDate', function(){
		var range = $('#txtDate').val();
		var rangeArray = range.split(' - ');
		var rangeIni = rangeArray[0].split('/');
		var rangeFin = rangeArray[1].split('/');
		range = rangeIni[1]+rangeIni[0]+'-'+rangeFin[1]+rangeFin[0];
		var path = 'balance-comprobacion/' + range;
		window.location.href = path;
	});
	
	//Events Roles
	$(document).off('click', '.form-role .checkAll');
	$(document).on('click', '.form-role .checkAll', function(e){
		e.preventDefault();
		$(this).parent().parent().find('.role-checkbox').bootstrapSwitch('state', true, true);
	});

	$(document).off('click', '.form-role .unCheckAll');
	$(document).on('click', '.form-role .unCheckAll', function(e){
		e.preventDefault();
		$(this).parent().parent().find('.role-checkbox').bootstrapSwitch('state', false, false);
	});

	$(document).off('click', '#checkAll');
	$(document).on('click', '#checkAll', function(e){
		e.preventDefault();
		$('.role-checkbox').bootstrapSwitch('state', true, true);
	});

	$(document).off('click', '#unCheckAll');
	$(document).on('click', '#unCheckAll', function(e){
		e.preventDefault();
		$('.role-checkbox').bootstrapSwitch('state', false, false);
	});

	if( $(".menu-role").exists() ){
		$(".menu-role").each(function(index){
		  	if($(this).find('div.row').length == 0){
		    	$(this).remove();
		  	}
		  	$('.form-role .col-sm-6 fieldset').matchHeight();
		});
	}
	
	//Redirect School
	$(document).off("click", ".routeSchool");
	$(document).on("click", ".routeSchool", function(e){
		e.preventDefault();
		var token  = $(this).data('token');
		var url    = 'route-institucion';
		data.token = token;
		ajaxForm(url, 'post', data, 'Redirigiendo...')
		.done(function (data) {
			$.unblockUI();
			if(data.success){
				window.location.href = server + 'institucion/inst/';
			}else{
				bootbox.alert(data.errores);
			}
		});
	});

	//Add Deposit
	$(document).off('click', '#addDeposit');
	$(document).on('click', '#addDeposit', function(e){
		e.preventDefault();
		if($('.totalDeposit').length == 1){
			$('#removeDeposit').removeClass('hide');
		}
		var account = $('.totalDeposit aside:first').clone(true,true);
		account.appendTo('.totalDeposit');
	});
	//Delete Deposit
	$(document).on('click', '#removeDeposit', function(e){
		e.preventDefault();
		var element = $(this);
		var account = $('.totalDeposit aside:first');
		account.remove();
		if($('.totalDeposit aside').length == 1){
			element.addClass('hide');
		}
	});

	//Report CourtCase
	$(document).off('click', '#reportCourtCase');
	$(document).on('click', '#reportCourtCase', function(e){ 
		e.preventDefault();
		var href = $(this).attr('href');
		for (var i = 1; i <= 3; i++) {
			window.open(href+'/'+i);
		}
	});

	/**
	 * School
	 */
	
	//Save School
	$(document).off('click', '#saveSchool');
	$(document).on('click', '#saveSchool', function(e){ 
		e.preventDefault();
		var url = $(this).data('url');
		url =  'save-' + url;
		data.nameSchool     = $('#nameSchool').val();
		data.charterSchool  = $('#charterSchool').val();
		data.routeSchool    = $('#routeSchool').val();
		data.phoneOneSchool = $('#phoneOneSchool').val();
		data.phoneTwoSchool = $('#phoneTwoSchool').val();
		data.faxSchool      = $('#faxSchool').val();
		data.addressSchool  = $('#addressSchool').val();
		data.townSchool     = $('#townSchool').val();
		data.statusSchool   = $('#statusSchool').bootstrapSwitch('state');
		ajaxForm(url,'post',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Update School
	$(document).off('click', '#updateSchool');
	$(document).on('click', '#updateSchool', function(e){
		e.preventDefault();
		var url;
		var idSchool;
		idSchool = $('#idSchool').val();
		url = $(this).data('url');
		url = 'update-' + url + '/' + idSchool;
		data.idSchool       = idSchool;
		data.nameSchool     = $('#nameSchool').val();
		data.charterSchool  = $('#charterSchool').val();
		data.routeSchool    = $('#routeSchool').val();
		data.phoneOneSchool = $('#phoneOneSchool').val();
		data.phoneTwoSchool = $('#phoneTwoSchool').val();
		data.faxSchool      = $('#faxSchool').val();
		data.addressSchool  = $('#addressSchool').val();
		data.townSchool     = $('#townSchool').val();
		data.statusSchool   = $('#statusSchool').bootstrapSwitch('state');
		ajaxForm(url,'put',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Active School
	$(document).off('click', '#activeSchool');
	$(document).on('click', '#activeSchool', function(e){
		e.preventDefault();
		var url;
		var idSchool  = $(this).parent().parent().find('.school_number').text();
		url           = $(this).data('url');
		url           = 'active-' + url + '/' + idSchool;
		data.idSchool = idSchool;
		ajaxForm(url, 'patch', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete School
	$(document).off('click', '#deleteSchool');
	$(document).on('click', '#deleteSchool', function(e){
		e.preventDefault();
		var url;
		var idSchool  = $(this).parent().parent().find('.school_number').text();
		url           = $(this).data('url');
		url           = 'delete-' + url + '/' + idSchool;
		data.idSchool = idSchool;
		ajaxForm(url, 'delete', data)
		.done( function (data) {
			messageAjax(data);
		});
	});
	
	dataTable('#table_school', 'instituciones');
	
	/**
	 * End School
	 */
	
	/**
	 * Type User
	 */
	//Save Type User
	$(document).off('click', '#saveTypeUser');
	$(document).on('click', '#saveTypeUser', function(e){
		e.preventDefault();
		url = $(this).data('url');
		url = url + '/save';
		data.nameTypeUser   = $('#nameTypeUser').val();
		data.statusTypeUser = $('#statusTypeUser').bootstrapSwitch('state');
		ajaxForm(url,'post',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Update Type User
	$(document).off('click', '#updateTypeUser');
	$(document).on('click', '#updateTypeUser', function(e){
		e.preventDefault();
		var url;
		var idTypeUser;
		idTypeUser = $('#idTypeUser').val();
		url = $(this).data('url');
		url = url + '/update/' + idTypeUser;
		data.idTypeUser     = idTypeUser;
		data.nameTypeUser   = $('#nameTypeUser').val();
		data.statusTypeUser = $('#statusTypeUser').bootstrapSwitch('state');
		ajaxForm(url,'put',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Active Type User
	$(document).off('click', '#activeTypeUser');
	$(document).on('click', '#activeTypeUser', function(e){
		e.preventDefault();
		var url;
		var id_type_user = $(this).parent().parent().find('.type_user_number').text();
		url              = $(this).data('url');
		url              = url + '/active/' + id_type_user;
		data.idTypeUser = id_type_user;
		ajaxForm(url, 'patch', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete Type User
	$(document).off('click', '#deleteTypeUser');
	$(document).on('click', '#deleteTypeUser', function(e){
		e.preventDefault();
		var url;
		var id_type_user = $(this).parent().parent().find('.type_user_number').text();
		url              = $(this).data('url');
		url              = url + '/delete/' + id_type_user;
		data.idTypeUser  = id_type_user;
		ajaxForm(url, 'delete', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	dataTable('#table_type_user', 'tipos de usuarios');

	/**
	 * End Type User
	 */
	
	/**
	 * Tasks
	 */
	//Save Task
	$(document).off('click', '#saveTask');
	$(document).on('click', '#saveTask', function(e){
		e.preventDefault();
		url = $(this).data('url');
		url = url + '/save';
		data.nameTask   = $('#nameTask').val();
		data.statusTask = $('#statusTask').bootstrapSwitch('state');
		ajaxForm(url,'post',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Update Task
	$(document).off('click', '#updateTask');
	$(document).on('click', '#updateTask', function(e){
		e.preventDefault();
		var url;
		var idTask;
		idTask = $('#idTask').val();
		url    = $(this).data('url');
		url    = url + '/update/' + idTask;
		data.idTask     = idTask;
		data.nameTask   = $('#nameTask').val();
		data.statusTask = $('#statusTask').bootstrapSwitch('state');
		ajaxForm(url,'put',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Active Task
	$(document).off('click', '#activeTask');
	$(document).on('click', '#activeTask', function(e){
		e.preventDefault();
		var url;
		var id_task = $(this).parent().parent().find('.task_number').text();
		url         = $(this).data('url');
		url         = url + '/active/' + id_task;
		data.idTask = id_task;
		ajaxForm(url, 'patch', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete Task
	$(document).off('click', '#deleteTask');
	$(document).on('click', '#deleteTask', function(e){
		e.preventDefault();
		var url;
		var id_task = $(this).parent().parent().find('.task_number').text();
		url         = $(this).data('url');
		url         = url + '/delete/' + id_task;
		data.idTask = id_task;
		ajaxForm(url, 'delete', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	dataTable('#table_task', 'tareas');

	/**
	 * End Tasks
	 */

	/**
	 * Menu
	 */
	
	//Save Menu
	$(document).off('click', '#saveMenu');
	$(document).on('click', '#saveMenu', function(e){
		e.preventDefault();
		var url;
		var stateTasks = [];
		var idTasks = [];
		url = $(this).data('url');
		url = url + '/save';
		$('.task_menu').each(function(index){
			stateTasks[index] = $(this).bootstrapSwitch('state');
			idTasks[index]    = $(this).data('id');
		});
		data.nameMenu   = $('#nameMenu').val();
		data.urlMenu    = $('#urlMenu').val();
		data.iconMenu   = $('#iconMenu').val();
		data.idTasks    = idTasks;
		data.stateTasks = stateTasks;
		ajaxForm(url,'post',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Update Menu
	$(document).off('click', '#updateMenu');
	$(document).on('click', '#updateMenu', function(e){
		e.preventDefault();
		var url;
		var idMenu;
		var statusMenu;
		var stateTasks = [];
		var idTasks = [];
		url        = $(this).data('url');
		idMenu     = $('#idMenu').val();
		statusMenu = $('#statusMenu').bootstrapSwitch('state');
		url        = url + '/update/' + idMenu;
		$('.task_menu').each(function(index){
			stateTasks[index] = $(this).bootstrapSwitch('state');
			idTasks[index]    = $(this).data('id');
		});
		data.idMenu     = idMenu;
		data.statusMenu = statusMenu;
		data.nameMenu   = $('#nameMenu').val();
		data.urlMenu    = $('#urlMenu').val();
		data.iconMenu   = $('#iconMenu').val();
		data.idTasks    = idTasks;
		data.stateTasks = stateTasks;
		ajaxForm(url,'put',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Active Menu
	$(document).off('click', '#activeMenu');
	$(document).on('click', '#activeMenu', function(e){
		e.preventDefault();
		var url;
		var idMenu  = $(this).parent().parent().find('.menu_number').text();
		url         = $(this).data('url');
		url         = url + '/active/' + idMenu;
		data.idMenu = idMenu;
		ajaxForm(url, 'patch', data)
		.done( function (data) {
			messageAjax(data);
			location.reload();
		});
	});

	//Delete Menu
	$(document).off('click', '#deleteMenu');
	$(document).on('click', '#deleteMenu', function(e){
		e.preventDefault();
		var url;
		var idMenu  = $(this).parent().parent().find('.menu_number').text();
		url         = $(this).data('url');
		url         = url + '/delete/' + idMenu;
		data.idMenu = idMenu;
		ajaxForm(url, 'delete', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	dataTable('#table_menu', 'menús');

	/**
	 * End Menu
	 */

	/**
	 * Users
	 */
	var routeAction = document.location.pathname.split('/')[1]+'/'+document.location.pathname.split('/')[2];
	if(routeAction === 'usuarios/crear' || routeAction === 'usuarios/editar'){
		localStorage.clear();
		if(localStorage === 'usuarios/crear'){
			var prefetch = '../json/schools.json';
		}else {
			var prefetch = '../../json/schools.json';
		}
		
		var schools = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: prefetch
	    });
	    schools.initialize();

	    var elt = $('#schools');
	    elt.tagsinput({
			itemValue: 'value',
			itemText: 'text',
			typeaheadjs: {
				name: 'schools',
				displayKey: 'text',
				source: schools.ttAdapter()
			}
	    });

	    if(routeAction === 'usuarios/editar'){
			if($("#hdnSchools").attr('data-id').length === 1){
				var value = $("#hdnSchools").attr('data-id');
				var text  = $("#hdnSchools").attr('data-name');
		    	elt.tagsinput('add', {"value": value, "text": ''+ text})
			}else if($("#hdnSchools").attr('data-id').length > 1){
				var value = $("#hdnSchools").attr('data-id').split(',');
				var text  = $("#hdnSchools").attr('data-name').split(',');
				for(var i = 0; i<value.length; i++){
		    		elt.tagsinput('add', {"value": value[i], "text": '' + text[i]})
		    	}
			}
	    }
	}

	//Save User
	$(document).off('click', '#saveUser');
	$(document).on('click', '#saveUser', function(e){
		e.preventDefault();
		url = $(this).data('url');
		url = url + '/save';
		var schools    = $("#schools").val();
		var arrSchools = schools.split(',');
		data.nameUser       = $('#nameUser').val();
		data.lastUser       = $('#lastUser').val();
		data.emailUser      = $('#emailUser').val();
		data.passwordUser   = $('#passwordUser').val();
		data.typeUserIdUser = $('#typeUser').val();
		data.tokenSupplier  = $('#supplier').val();
		data.schoolsUser    = arrSchools;
		data.statusUser     = $('#statusUser').bootstrapSwitch('state');
		ajaxForm(url,'post',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Update User
	$(document).off('click', '#updateUser');
	$(document).on('click', '#updateUser', function(e){
		e.preventDefault();
		var url;
		var idUser;
		idUser = $('#idUser').val();
		url    = $(this).data('url');
		url    = url + '/update/' + idUser;
		data.idUser        = idUser;
		var schools        = $("#schools").val();
		var arrSchools     = schools.split(',');
		data.nameUser      = $('#nameUser').val();
		data.lastNameUser  = $('#lastNameUser').val();
		data.emailUser     = $('#emailUser').val();
		data.passwordUser  = null;
		data.idTypeUser    = $('#typeUser').val();
		data.tokenSupplier = $('#supplier').val();
		data.schoolsUser   = arrSchools;
		data.statusUser    = $('#statusUser').bootstrapSwitch('state');
		ajaxForm(url,'put',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Active User
	$(document).off('click', '#activeUser');
	$(document).on('click', '#activeUser', function(e){
		e.preventDefault();
		var url;
		var idUser  = $(this).parent().parent().find('.user_number').text();
		url         = $(this).data('url');
		url         = url + '/active/' + idUser;
		data.idUser = idUser;
		ajaxForm(url, 'patch', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete User
	$(document).off('click', '#deleteUser');
	$(document).on('click', '#deleteUser', function(e){
		e.preventDefault();
		var url;
		var idUser  = $(this).parent().parent().find('.user_number').text();
		url         = $(this).data('url');
		url         = url + '/delete/' + idUser;
		data.idUser = idUser;
		ajaxForm(url, 'delete', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	dataTable('#table_user', 'usuarios');

	/**
	 * End User
	 */
	
	/**
	 * Type Form
	 */
	//Save Type Form
	$(document).off('click', '#saveTypeForm');
	$(document).on('click', '#saveTypeForm', function(e){
		e.preventDefault();
		url = $(this).data('url');
		url = url + '/save';
		data.nameTypeForm   = $('#nameTypeForm').val();
		data.statusTypeForm = $('#statusTypeForm').bootstrapSwitch('state');
		ajaxForm(url,'post',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Update Type Form
	$(document).off('click', '#updateTypeForm');
	$(document).on('click', '#updateTypeForm', function(e){
		e.preventDefault();
		var url;
		var idTypeForm;
		idTypeForm = $('#idTypeForm').val();
		url = $(this).data('url');
		url = url + '/update/' + idTypeForm;
		data.idTypeForm     = idTypeForm;
		data.nameTypeForm   = $('#nameTypeForm').val();
		data.statusTypeForm = $('#statusTypeForm').bootstrapSwitch('state');
		ajaxForm(url,'put',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Active Type Form
	$(document).off('click', '#activeTypeForm');
	$(document).on('click', '#activeTypeForm', function(e){
		e.preventDefault();
		var url;
		var id_type_form = $(this).parent().parent().find('.type_form_number').text();
		url              = $(this).data('url');
		url              = url + '/active/' + id_type_form;
		data.idTypeForm  = id_type_form;
		ajaxForm(url, 'patch', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete Type Form
	$(document).off('click', '#deleteTypeForm');
	$(document).on('click', '#deleteTypeForm', function(e){
		e.preventDefault();
		var url;
		var id_type_form = $(this).parent().parent().find('.type_form_number').text();
		url              = $(this).data('url');
		url              = url + '/delete/' + id_type_form;
		data.idTypeForm  = id_type_form;
		ajaxForm(url, 'delete', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	dataTable('#table_type', 'tipos');

	/**
	 * Fin Tipos
	 */
	
	/**
	 * Bancos
	 */
	//Save Bank
	$(document).off('click', '#saveBank');
	$(document).on('click', '#saveBank', function(e){
		e.preventDefault();
		url = $(this).data('url');
		url = url + '/save';
		data.nameBank    = $('#nameBank').val();
		data.accountBank = $('#accountBank').val();
		data.statusBank  = $('#statusBank').bootstrapSwitch('state');
		ajaxForm(url,'post',data, null,'true')
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Update Bank
	$(document).off('click', '#updateBank');
	$(document).on('click', '#updateBank', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/update';
		data.token       = $('#nameBank').data('token');
		data.nameBank    = $('#nameBank').val();
		data.accountBank = $('#accountBank').val();
		data.statusBank  = $('#statusBank').bootstrapSwitch('state');
		ajaxForm(url,'put',data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Active Bank
	$(document).off('click', '#activeBank');
	$(document).on('click', '#activeBank', function(e){
		e.preventDefault();
		var url;
		var token  = $(this).parent().parent().find('.bank_name').data('token');
		url        = $(this).data('url');
		url        = url + '/active/' + token;
		data.token = token;
		ajaxForm(url, 'patch', data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete Bank
	$(document).off('click', '#deleteBank');
	$(document).on('click', '#deleteBank', function(e){
		e.preventDefault();
		var url;
		var token  = $(this).parent().parent().find('.bank_name').data('token');
		url        = $(this).data('url');
		url        = url + '/delete/' + token;
		data.token = token;
		ajaxForm(url, 'delete', data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});

	dataTable('#table_bank', 'cuentas bancarias');

	/**
	 * Fin Bancos
	 */
	
	/**
	 * Grados
	 */
	//Save Degree
	$(document).off('click', '#saveDegree');
	$(document).on('click', '#saveDegree', function(e){
		e.preventDefault();
		url = $(this).data('url');
		url = url + '/save';
		data.codeDegree   = $('#codeDegree').val();
		data.nameDegree   = $('#nameDegree').val();
		data.statusDegree = $('#statusDegree').bootstrapSwitch('state');
		ajaxForm(url,'post',data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Update Degree
	$(document).off('click', '#updateDegree');
	$(document).on('click', '#updateDegree', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/update';
		data.token        = $('#codeDegree').data('token');
		data.codeDegree   = $('#codeDegree').val();
		data.nameDegree   = $('#nameDegree').val();
		data.statusDegree = $('#statusDegree').bootstrapSwitch('state');
		ajaxForm(url,'put',data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});
/*
	//Active Degree
	$(document).off('click', '#activeDegree');
	$(document).on('click', '#activeDegree', function(e){
		e.preventDefault();
		var url;
		var token  = $(this).parent().parent().find('.degree_code').data('token');
		url        = $(this).data('url');
		url        = url + '/active/' + token;
		data.token = token;
		ajaxForm(url, 'patch', data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete Degree
	$(document).off('click', '#deleteDegree');
	$(document).on('click', '#deleteDegree', function(e){
		e.preventDefault();
		var url;
		var token  = $(this).parent().parent().find('.degree_code').data('token');
		url        = $(this).data('url');
		url        = url + '/delete/' + token;
		data.token = token;
		ajaxForm(url, 'delete', data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});*/

	dataTable('#table_degree', 'grados académicos');

	/**
	 * Fin Bancos
	 */
	
	/**
	 * Notas
	 */
	//Update Degree
	$(document).off('click', '#updateNote');
	$(document).on('click', '#updateNote', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/update';
		data.token        = $('#descriptionNote').data('token');
		data.descriptionNote   = $('#descriptionNote').val();
		ajaxForm(url,'put',data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});

	dataTable('#table_note', 'notas');

	/**
	 * Fin Bancos
	 */
	
	/**
	 * Periodos Contables
	 */
	dataTable('#table_accounting_period', 'notas');

	/**
	 * Fin Periodos Contables
	 */

	/**
	 * Costos
	 */
	//Save Cost
	$(document).off('click', '#saveCost');
	$(document).on('click', '#saveCost', function(e){
		e.preventDefault();
		url = $(this).data('url');
		url = url + '/save';
		data.yearCost           = $('#yearCost').val();
		data.monthlyPaymentCost = $('#monthlyPaymentCost').val();
		data.tuitionCost        = $('#tuitionCost').val();
		data.degreeSchoolCost   = $('#degreeSchoolCost').val();
		ajaxForm(url,'post',data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Update Cost
	$(document).off('click', '#updateCost');
	$(document).on('click', '#updateCost', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/update';
		data.token              = $('#yearCost').data('token');
		data.yearCost           = $('#yearCost').val();
		data.monthlyPaymentCost = $('#monthlyPaymentCost').val();
		data.tuitionCost        = $('#tuitionCost').val();
		data.degreeSchoolCost   = $('#degreeSchoolCost').val();
		ajaxForm(url,'put',data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});

	dataTable('#table_cost', 'costos de mensualidad');
	/**
	 * Fin Rutas Costos
	 */

	/**
	 * Estudiantes
	 */
	//Save Student
	$(document).off('click', '#saveStudent');
	$(document).on('click', '#saveStudent', function(e){
		e.preventDefault();
		url = $(this).data('url');
		url = url + '/save';
		data.fnameStudent           = $('#fnameStudent').val();
		data.snameStudent           = $('#snameStudent').val();
		data.flastStudent           = $('#flastStudent').val();
		data.slastStudent           = $('#slastStudent').val();
		data.sexStudent             = $('#sexStudent').val();
		data.phoneStudent           = $('#phoneStudent').val();
		data.addressStudent         = $('#addressStudent').val();
		data.degreeStudent          = $('#degreeStudent').val();
		data.discountTuitionStudent = $('#discountTuitionStudent').val();
		data.discountStudent        = $('#discountStudent').val();
		ajaxForm(url,'post',data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Update Student
	$(document).off('click', '#updateStudent');
	$(document).on('click', '#updateStudent', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/update';
		data.token                  = $('#fnameStudent').data('token');
		data.fnameStudent           = $('#fnameStudent').val();
		data.snameStudent           = $('#snameStudent').val();
		data.flastStudent           = $('#flastStudent').val();
		data.slastStudent           = $('#slastStudent').val();
		data.sexStudent             = $('#sexStudent').val();
		data.phoneStudent           = $('#phoneStudent').val();
		data.addressStudent         = $('#addressStudent').val();
		data.degreeStudent          = $('#degreeStudent').val();
		data.discountTuitionStudent = $('#discountTuitionStudent').val();
		data.statusStudent          = $('#statusStudent').val();
		data.discountStudent        = $('#discountStudent').val();
		ajaxForm(url,'put',data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Save Enrolled
	$(document).off('click', '#saveEnrolled');
	$(document).on('click', '#saveEnrolled', function(e){
		e.preventDefault();
		var url = $(this).data('url');
		url = url + '/enrolled';
		ajaxForm(url, 'post', data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});

/*
	//Active Student
	$(document).off('click', '#activeStudent');
	$(document).on('click', '#activeStudent', function(e){
		e.preventDefault();
		var url;
		var token  = $(this).parent().parent().find('.Student_code').data('token');
		url        = $(this).data('url');
		url        = url + '/active/' + token;
		data.token = token;
		ajaxForm(url, 'patch', data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete Student
	$(document).off('click', '#deleteStudent');
	$(document).on('click', '#deleteStudent', function(e){
		e.preventDefault();
		var url;
		var token  = $(this).parent().parent().find('.Student_code').data('token');
		url        = $(this).data('url');
		url        = url + '/delete/' + token;
		data.token = token;
		ajaxForm(url, 'delete', data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});*/

	dataTable('#table_student', 'estudiantes');

	dataTable('#table_student_enrolled', 'estudiantes matriculados');

	/**
	 * Fin Estudiantes
	 */
	
	/**
	 * Asientos Auxiliares
	 */
	
	/**
	 * Save Detail Auxiliar Seat
	 */
	$(document).off('click', '#saveDetailAuxiliarySeat');
	$(document).on('click', '#saveDetailAuxiliarySeat', function(e){
		e.preventDefault();
		var url = $(this).data('url');
		url = url + '/save';
		var data = {};
		data.dateAuxiliarySeat            = $('#dateAuxiliarySeat').val();
		data.typeSeatAuxiliarySeat        = $('#codeAuxiliarySeat').data('token');
		data.codeAuxiliarySeat            = $('#codeAuxiliarySeat').val();
		data.detailAuxiliarySeat          = $('#detailAuxiliarySeat').val();
		data.amountAuxiliarySeat          = $('#amountAuxiliarySeat').val();
		data.financialRecordAuxiliarySeat = $('#financialRecordAuxiliarySeat').val();
		data.accoutingPeriodAuxiliarySeat = $('#accoutingPeriodAuxiliarySeat').val();
		data.codeStudent				  = $("#financialRecordAuxiliarySeat option:selected").text();

		var type = $("#typeAuxiliarySeat").data('type')

		if( type == 'select') {
			data.textTypeAuxiliarySeat = $("#typeAuxiliarySeat option:selected").text();
			data.typeAuxiliarySeat     = $('#typeAuxiliarySeat').val();
		}else{
			data.textTypeAuxiliarySeat = $("#typeAuxiliarySeat").val();
			data.typeAuxiliarySeat     = $('#typeAuxiliarySeat').data('token');
		}

		ajaxForm(url,'post',data, null, 'true')
		.done( function (response) {
			if(response.success){
				$.unblockUI();
				var tr = addItemRow(data, response);
				if($('#table_auxiliar_seat_temp tbody tr:first').exists()){
					$('#table_auxiliar_seat_temp tbody tr:first').before(tr);
					$('#totalAuxiliarySeat').val(response.message.total);
				}else{
					$('#table_auxiliar_seat_temp').removeClass('hide');
					$('#table_auxiliar_seat_temp tbody').append(tr);
					var parent = $('#typeAuxiliarySeat').parent();
					$('#typeAuxiliarySeat').remove();
					addInputText(data, parent);
					$('#saveAuxiliarySeat').removeClass('hide');
					if(!$("#tokenAuxiliarySeat").exists()){
						var token = '<input id="tokenAuxiliarySeat" type="hidden" value="'+ response.message.token +'">';
						$("#table_auxiliar_seat_temp tbody").prepend(token);
					}
					$('#totalAuxiliarySeat').val(response.message.total);
				}
			}else{
				messageErrorAjax(response);
			}
		});
	});

	//Save Auxiliary Seat
	$(document).off('click', '#saveAuxiliarySeat');
	$(document).on('click', '#saveAuxiliarySeat', function(e){
		e.preventDefault();
		url = $(this).data('url');
		url = url + '/status';
		data.token = $('#tokenAuxiliarySeat').val();
		ajaxForm(url, 'post', data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete Auxiliary Set
	$(document).off('click', '#deleteDetailRow');
	$(document).on('click', '#deleteDetailRow', function(e){
		e.preventDefault();
		var row = $(this).parent().parent();
		var totalRows = $('#table_auxiliar_seat_temp tbody tr').length;
		idAuxiliarySeat  = $(this).data('id')
		url = $(this).data('url');
		url = url + '/deleteDetail/' + idAuxiliarySeat;
		data.idAuxiliarySeat = idAuxiliarySeat;
		ajaxForm(url, 'delete', data, null, 'true')
		.done( function (response) {
			if(response.success){
				$.unblockUI();
				if(totalRows == 1){
					bootbox.alert('<p class="success-ajax">'+response.message.message+'</p>', function(){
						location.reload();
					});
				}else{
					row.remove();
					bootbox.alert('<p class="success-ajax">'+response.message.message+'</p>');
					$('#totalAuxiliarySeat').val(response.message.total);
				}
			}else{
				messageErrorAjax(response);
			}
		});
	});

	//Update Auxiliary Seat
	$(document).off('click', '#updateAuxiliarySeat');
	$(document).on('click', '#updateAuxiliarySeat', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/update';
		data.token                        = $('#dateAuxiliarySeat').data('token');
		data.dateAuxiliarySeat            = $('#dateAuxiliarySeat').val();
		data.codeAuxiliarySeat            = $('#codeAuxiliarySeat').val();
		data.detailAuxiliarySeat          = $('#detailAuxiliarySeat').val();
		data.amountAuxiliarySeat          = $('#amountAuxiliarySeat').val();
		data.financialRecordAuxiliarySeat = $('#financialRecordAuxiliarySeat').val();
		data.accoutingPeriodAuxiliarySeat = $('#accoutingPeriodAuxiliarySeat').val();
		data.typeSeatAuxiliarySeat        = $('#typeSeatAuxiliarySeat').val();
		ajaxForm(url,'put',data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});

	$(document).off('click', '#otherPeriods');
	$(document).on('click', '#otherPeriods', function(e){
		e.preventDefault();
		var url = $(this).data('url');
		url = url + '/other';
		bootbox.confirm('¿Se apolicara un asiento a los estudiantes que no tenga el cobro del mes selecionado?', function (result) {
			if(result){
				var modal = '<div class="row"><div class="col-sm-4"><span class="pull-right" style="line-height:2.25em;">Seleccionar Mes:</span></div><div class="col-sm-6"><div class="input-group"><span class="input-group-addon"><i class="fa fa-calendar"></i></span> <input id="dateOther" class="form-control" type="text"></div></div></div>';
				bootbox.dialog({
				  	message: modal,
				  	title: "Cobros a Estudiantes",
				  	animate: true,
				  	className: "my-modal-other",
				  	buttons: {
					    success: {
							label: "Grabar",
							className: "btn-success",
							callback: function() {
								var dateOther = $('#dateOther').val();
								data.dateOther = dateOther;
								ajaxForm(url,'post',data, null, 'true')
								.done( function (data) {
									messageAjax(data);
								});
							}
					    },
					    danger: {
					    	label: "Cancelar",
							className: "btn-default",
					    }
				  	}
				});
			}
		});
	});
	
	$(document).off('click', '#dateOther');
	$(document).on('click', '#dateOther', function(e){
		e.preventDefault();
		var today = new Date();
		var yyyy = today.getFullYear();
		var start = '01/'+ yyyy;
		var end = '12/'+ yyyy;
		var options = {
			language: 'es',
			startDate: start,
			endDate: end,
			orientation: 'top',
			format: 'mm/yyyy',
			minViewMode: 1,
			autoclose: true
		}
		$(this).datepicker(options).datepicker('show');
	});

/*
	//Active Student
	$(document).off('click', '#activeStudent');
	$(document).on('click', '#activeStudent', function(e){
		e.preventDefault();
		var url;
		var token  = $(this).parent().parent().find('.Student_code').data('token');
		url        = $(this).data('url');
		url        = url + '/active/' + token;
		data.token = token;
		ajaxForm(url, 'patch', data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete Student
	$(document).off('click', '#deleteStudent');
	$(document).on('click', '#deleteStudent', function(e){
		e.preventDefault();
		var url;
		var token  = $(this).parent().parent().find('.Student_code').data('token');
		url        = $(this).data('url');
		url        = url + '/delete/' + token;
		data.token = token;
		ajaxForm(url, 'delete', data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});*/
	
	dataTable('#table_auxiliary_seat', 'asientos auxiliares');

	/**
	 * Fin Asientos Auxiliares
	 */
	
	/**
	 * Tipos de Asientos
	 */

	//Save TypeSeat
	$(document).off('click', '#saveTypeSeat');
	$(document).on('click', '#saveTypeSeat', function(e){
		e.preventDefault();
		url = $(this).data('url');
		url = url + '/save';
		data.abbreviationTypeSeat = $('#abbreviationTypeSeat').val();
		data.nameTypeSeat         = $('#nameTypeSeat').val();
		data.quatityTypeSeat      = $('#quatityTypeSeat').val();
		data.yearTypeSeat         = $('#yearTypeSeat').val();
		ajaxForm(url,'post',data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});
	dataTable('#table_type_seat','tipos de asientos');

	/**
	 * Fin tipos de Asientos
	 */
	

	/**
	 * Auxiliary Receipt
	 */
	// Save Detail Auxiliary Receipt
	$(document).off('click', '#saveDetailAuxiliaryReceipt');
	$(document).on('click', '#saveDetailAuxiliaryReceipt', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/save';
		data.accoutingPeriodAuxiliaryReceipt = $('#accoutingPeriodAuxiliaryReceipt').val();
		data.dateAuxiliaryReceipt            = $('#dateAuxiliaryReceipt').val();
		data.receiptNumberAuxiliaryReceipt   = $('#receiptNumberAuxiliaryReceipt').val();
		data.receivedFromAuxiliaryReceipt    = $('#receivedFromAuxiliaryReceipt').val();
		data.detailAuxiliaryReceipt          = $('#detailAuxiliaryReceipt').val();
		data.amountAuxiliaryReceipt          = $('#amountAuxiliaryReceipt').val();
		data.financialRecordAuxiliaryReceipt = $('#financialRecordAuxiliaryReceipt').val();
		data.codeStudent                     = $("#financialRecordAuxiliaryReceipt option:selected").text();
		ajaxForm(url,'post',data, null, 'true')
		.done( function (response) {
			if(response.success){
				$.unblockUI();
				var tr = addItemRow(data, response, 'receipt');
				if($('#table_auxiliar_receipt_temp tbody tr:first').exists()){
					$('#table_auxiliar_receipt_temp tbody tr:first').before(tr);
					$('#totalAuxiliaryReceipt').val(response.message.total);
				}else{
					$('#table_auxiliar_receipt_temp').removeClass('hide');
					$('#table_auxiliar_receipt_temp tbody').append(tr);
					$('#saveAuxiliaryReceipt').removeClass('hide');
					if(!$("#tokenAuxiliaryReceipt").exists()){
						var token = '<input id="tokenAuxiliaryReceipt" type="hidden" value="'+ response.message.token +'">';
						$("#table_auxiliar_receipt_temp tbody").prepend(token);
					}
					$('#totalAuxiliaryReceipt').val(response.message.total);
				}
			}else{
				messageErrorAjax(response);
			}
		});
	});

	// Save AuxiliaryReceipt
	$(document).off('click', '#saveAuxiliaryReceipt');
	$(document).on('click', '#saveAuxiliaryReceipt', function(e){
		var modal = "<div class='row'><div class='col-sm-6 col-md-12'><div class='form-mep'><label>Depósitos - (Cuenta - Referencia - Fecha - Monto)</label><div class='row totalDeposit'><aside class='row' style='margin-bottom: .5em;'><div class='col-sm-3' style='padding:0;'><div class='input-group'><span class='input-group-addon'><i class='fa fa-credit-card'></i></span><input class='form-control accountDepositAuxiliaryReceipt' type='text'></div></div><div class='col-sm-3' style='padding:0;'><div class='input-group'><span class='input-group-addon'><i class='fa fa-barcode'></i></span><input class='form-control numberDepositAuxiliaryReceipt' type='text'></div></div><div class='col-sm-3' style='padding:0;'><div class='input-group'><span class='input-group-addon'><i class='fa fa-calendar'></i></span><input class='form-control dateDepositAuxiliaryReceipt' type='date' placeholder='01/01/2015'></div></div><div class='col-sm-3'><div class='input-group'><span class='input-group-addon'><i class='fa fa-usd'></i></span><input class='form-control amountDepositAuxiliaryReceipt' type='number'></div></div></aside></div><button id='addDeposit' class='btn btn-default'>Agregar Depósito</button><button id='removeDeposit' class='btn btn-danger hide' style='margin-left:0.5em;'>Eliminar Depósito</button></div></div></div>";
		var url;
		url = $(this).data('url');
		url = url + '/status';

		var token = $('#tokenAuxiliaryReceipt').val();


		bootbox.dialog({
		  	message: modal,
		  	title: "Depósitos del Recibo",
		  	size: "large",
		  	animate: true,
		  	className: "my-modal",
		  	buttons: {
			    success: {
					label: "Grabar",
					className: "btn-success",
					callback: function() {
						var accountDepositAuxiliaryReceipt = [];
						var dateDepositAuxiliaryReceipt    = [];
						var amountDepositAuxiliaryReceipt  = [];
						var numberDepositAuxiliaryReceipt  = [];
						$(".accountDepositAuxiliaryReceipt").each(function(index,value){
						    accountDepositAuxiliaryReceipt[index] = $(this).val();
						});
						$(".numberDepositAuxiliaryReceipt").each(function(index,value){
						    numberDepositAuxiliaryReceipt[index] = $(this).val();
						});
						$(".dateDepositAuxiliaryReceipt").each(function(index,value){
						    dateDepositAuxiliaryReceipt[index] = $(this).val();
						});
						$(".amountDepositAuxiliaryReceipt").each(function(index,value){
						    amountDepositAuxiliaryReceipt[index] = $(this).val();
						});
						data.token                           = $('#tokenAuxiliaryReceipt').val();
						data.accountDepositAuxiliaryReceipt  = accountDepositAuxiliaryReceipt;
						data.numberDepositAuxiliaryReceipt   = numberDepositAuxiliaryReceipt;
						data.dateDepositAuxiliaryReceipt     = dateDepositAuxiliaryReceipt;
						data.amountDepositAuxiliaryReceipt   = amountDepositAuxiliaryReceipt;
						ajaxForm(url,'post',data, null, 'true')
						.done( function (data) {
							if(data.success){
								$.unblockUI();
								bootbox.alert('<p class="success-ajax">'+data.message+'</p>', function(){
									window.open('/institucion/inst/recibos-auxiliares/impresion/'+token);
									location.reload();
								});
							}else{
								messageErrorAjax(data);
							}
						});
					}
			    },
			    danger: {
			    	label: "Cancelar",
					className: "btn-default",
			    }
		  	}
		});
	});

	//Delete Auxiliary Receipt
	$(document).off('click', '#deleteReceiptRow');
	$(document).on('click', '#deleteReceiptRow', function(e){
		e.preventDefault();
		var row = $(this).parent().parent();
		var totalRows = $('#table_auxiliar_receipt_temp tbody tr').length;
		idAuxiliarySeat  = $(this).data('id');
		url = $(this).data('url');
		url = url + '/deleteDetail/' + idAuxiliarySeat;
		data.idAuxiliarySeat = idAuxiliarySeat;
		ajaxForm(url, 'delete', data, null, 'true')
		.done( function (response) {
			if(response.success){
				$.unblockUI();
				if(totalRows == 1){
					bootbox.alert('<p class="success-ajax">'+response.message.message+'</p>', function(){
						location.reload();
					});
				}else{
					row.remove();
					bootbox.alert('<p class="success-ajax">'+response.message.message+'</p>');
					$('#totalAuxiliaryReceipt').val(response.message.total);
				}
			}else{
				messageErrorAjax(response);
			}
		});
	});



	/**
	 * Catalogs
	 */

	//Search level
	$(document).off('change', '#levelCatalog');
	$(document).on('change', '#levelCatalog', function(){
		var level = $(this).val();
		data.level = level;
		$.ajax({
			url: '/' + 'institucion/inst/catalogos/level',
		    type: 'post',
		    data: {data: JSON.stringify(data)},
		    datatype: 'json',
		    beforeSend: function(){
	    		$('#groupCatalog').prop('disabled', true);
		    },
		    error:function(){
		    	bootbox.alert("<p class='red'>No se pueden cargar los grupos de catalogos.</p>")
		    }
		}).done( function (response){
			$('#groupCatalog').empty();
			$('#groupCatalog').html(response);
			$('#groupCatalog').prop('disabled', false);
		});
	});

	//Save Catalogs
	$(document).off('click', '#saveCatalog');
	$(document).on('click', '#saveCatalog', function(e){
		e.preventDefault();
		url = $(this).data('url');
		url = url + '/save';
		data.nameCatalog  = $('#nameCatalog').val();
		data.styleCatalog = $('#styleCatalog').val();
		data.noteCatalog  = $('#noteCatalog').bootstrapSwitch('state');
		data.typeCatalog  = $('#typeCatalog').val();
		data.levelCatalog = $('#levelCatalog').val();
		data.groupCatalog = $('#groupCatalog').val();
		ajaxForm(url,'post',data, null, 'true')
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Update Catalogs
	$(document).off('click', '#updateCatalog');
	$(document).on('click', '#updateCatalog', function(e){
		e.preventDefault();
		var url = $(this).data('url');
		url = url + '/update';
		data.token = $('#codeCatalog').data('token');
		data.nameCatalog  = $('#nameCatalog').val();
		data.noteCatalog  = $('#noteCatalog').bootstrapSwitch('state');
		ajaxForm(url, 'put', data, null, 'true')
		.done(function(response){
			messageAjax(response);
		});
	});

	dataTable('#table_catalogs', 'catálogos');

	/**
	 * Seatings
	 */
	
	//Save Seating
	$(document).off('click', '#saveDetailSeating');
	$(document).on('click', '#saveDetailSeating', function(e){
		e.preventDefault();
		var url = $(this).data('url');
		url = url + '/save';
		var accountPartSeating  = [];
		var amountSeating  = [];
		var textAccountPartSeating = [];
		$(".accountPartSeating").each(function(index,value){
			accountPartSeating[index]     = $(this).val();
			textAccountPartSeating[index] = $("option:selected", this).text();
		});
		$(".amountSeating").each(function(index,value){
		    amountSeating[index] = $(this).val();
		});
		data.accoutingPeriodSeating = $('#accoutingPeriodSeating').data('token');
		data.dateSeating            = $('#dateSeating').val();
		data.codeSeating            = $('#typeSeatSeating').val();
        data.typeSeatSeating        = $('#typeSeatSeating').data('token');
        data.accountSeating         = $('#accountSeating').val();
		data.detailSeating          = $('#detailSeating').val();
		data.amountSeating          = amountSeating;
		data.typeSeating            = $('#typeSeating').val();
		data.accountPartSeating     = accountPartSeating;
		data.tokenSeating           = $('#tokenSeating').val();
		data.textAccountSeating     = $("#accountSeating option:selected").text();
		data.textTypeSeating        = $('#typeSeating option:selected').text();
		data.textAccountPartSeating = textAccountPartSeating;
		ajaxForm(url, 'post', data, null, 'true')
		.done(function (response){
			if(response.success){
				$.unblockUI();
				var tr = addItemSeat(data, response);
				if($('#table_seating_temp tbody tr:first').exists()){
					$('#table_seating_temp tbody tr:first').before(tr);
					$('#totalSeating').val(response.message.total);
				}else{
					$('#table_seating_temp').removeClass('hide');
					$('#table_seating_temp tbody').append(tr);
					$('#saveSeating').removeClass('hide');
					if(!$("#tokenSeating").exists()){
						var token = '<input id="tokenSeating" type="hidden" value="'+ response.message.token +'">';
						$("#table_seating_temp tbody").prepend(token);
					}
					$('#totalSeating').val(response.message.total);
				}
			}else{
				messageErrorAjax(response);
			}
		});
	});

	dataTable('#table_seatings', 'asientos');

    //Save Seating
    $(document).off('click', '#saveSeating');
    $(document).on('click', '#saveSeating', function(e){
        e.preventDefault();
        url = $(this).data('url');
        url = url + '/status';
        data.token = $('#tokenSeating').val();
        ajaxForm(url, 'post', data, null, 'true')
        .done( function (data) {
            messageAjax(data);
        });
    });

    //Delete Seating
    $(document).off('click', '#deleteDetailSeating');
    $(document).on('click', '#deleteDetailSeating', function(e){
        e.preventDefault();
		var row       = $(this).parent().parent();
		var totalRows = $('#table_seating_temp tbody tr').length;
		var idSeating = $(this).data('id')
		var url       = $(this).data('url');
		var dataClass = $(this).data('class');
        url = url + '/deleteDetail/' + idSeating;
        data.idSeating = idSeating;
        ajaxForm(url, 'delete', data, null, 'true')
        .done( function (response) {
            if(response.success){
                $.unblockUI();
                if(totalRows == 1){
                    bootbox.alert('<p class="success-ajax">'+response.message.message+'</p>', function(){
                        location.reload();
                    });
                }else{
                	$('.'+dataClass).remove();
                    row.remove();
                    bootbox.alert('<p class="success-ajax">'+response.message.message+'</p>');
                    $('#totalSeating').val(response.message.total);
                }
            }else{
                messageErrorAjax(response);
            }
        });
    });

	/**
	 * 
	 */
	
	/**
	 * Receipts
	 */
	// Save Detail Receipt
	$(document).off('click', '#saveDetailReceipt');
	$(document).on('click', '#saveDetailReceipt', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/save';
		data.accoutingPeriodReceipt = $('#accoutingPeriodReceipt').data('token');
		data.dateReceipt            = $('#dateReceipt').val();
		data.receiptNumberReceipt   = $('#receiptNumberReceipt').val();
		data.receivedFromReceipt    = $('#receivedFromReceipt').val();
		data.detailReceipt          = $('#detailReceipt').val();
		data.amountReceipt          = $('#amountReceipt').val();
		data.catalogReceipt         = $("#catalogReceipt").find('option:selected').val();
		data.textCodeCatalogReceipt = $("#catalogReceipt").find('option:selected').data('code');
		data.textNameCatalogReceipt = $("#catalogReceipt").find('option:selected').data('name');
		ajaxForm(url,'post',data, null, 'true')
		.done( function (response) {
			if(response.success){
				$.unblockUI();
				var tr = addItemReceipt(data, response);
				if($('#table_receipt_temp tbody tr:first').exists()){
					$('#table_receipt_temp tbody tr:first').before(tr);
					$('#totalReceipt').val(response.message.total);
				}else{
					$('#table_receipt_temp').removeClass('hide');
					$('#table_receipt_temp tbody').append(tr);
					$('#saveReceipt').removeClass('hide');
					if(!$("#tokenReceipt").exists()){
						var token = '<input id="tokenReceipt" type="hidden" value="'+ response.message.token +'">';
						$("#table_receipt_temp tbody").prepend(token);
					}
					$('#totalReceipt').val(response.message.total);
				}
			}else{
				messageErrorAjax(response);
			}
		});
	});

	//Delete Receipt
    $(document).off('click', '#deleteReceipt');
    $(document).on('click', '#deleteReceipt', function(e){
        e.preventDefault();
		var row       = $(this).parent().parent();
		var totalRows = $('#table_receipt_temp tbody tr').length;
		var idSeating = $(this).data('id')
		var url       = $(this).data('url');
        url = url + '/deleteDetail/' + idSeating;
        data.idSeating = idSeating;
        ajaxForm(url, 'delete', data, null, 'true')
        .done( function (response) {
            if(response.success){
                $.unblockUI();
                if(totalRows == 1){
                    bootbox.alert('<p class="success-ajax">'+response.message.message+'</p>', function(){
                        location.reload();
                    });
                }else{
                    row.next('tr').remove();
                    row.remove();
                    bootbox.alert('<p class="success-ajax">'+response.message.message+'</p>');
                    $('#totalReceipt').val(response.message.total);
                }
            }else{
                messageErrorAjax(response);
            }
        });
    });

	// Save Receipt
	$(document).off('click', '#saveReceipt');
	$(document).on('click', '#saveReceipt', function(e){
		e.preventDefault();
		var modal = "<div class='row'><div class='col-sm-6 col-md-12'><div class='form-mep'><label>Depósitos - (Cuenta - Referencia - Fecha - Monto)</label><div class='row totalDeposit'><aside class='row' style='margin-bottom: .5em;'><div class='col-sm-3' style='padding:0;'><div class='input-group'><span class='input-group-addon'><i class='fa fa-credit-card'></i></span><input class='form-control accountDepositAuxiliaryReceipt' type='text'></div></div><div class='col-sm-3' style='padding:0;'><div class='input-group'><span class='input-group-addon'><i class='fa fa-barcode'></i></span><input class='form-control numberDepositAuxiliaryReceipt' type='text'></div></div><div class='col-sm-3' style='padding:0;'><div class='input-group'><span class='input-group-addon'><i class='fa fa-calendar'></i></span><input class='form-control dateDepositAuxiliaryReceipt' type='date' placeholder='01/01/2015'></div></div><div class='col-sm-3'><div class='input-group'><span class='input-group-addon'><i class='fa fa-usd'></i></span><input class='form-control amountDepositAuxiliaryReceipt' type='number'></div></div></aside></div><button id='addDeposit' class='btn btn-default'>Agregar Depósito</button><button id='removeDeposit' class='btn btn-danger hide' style='margin-left:0.5em;'>Eliminar Depósito</button></div></div></div>";
		var url;
		url = $(this).data('url');
		url = url + '/status';
		var token = $('#tokenReceipt').val();

		bootbox.dialog({
		  	message: modal,
		  	title: "Depósitos del Recibo",
		  	size: "large",
		  	animate: true,
		  	className: "my-modal",
		  	buttons: {
			    success: {
					label: "Grabar",
					className: "btn-success",
					callback: function() {
						var accountDepositAuxiliaryReceipt = [];
						var dateDepositAuxiliaryReceipt    = [];
						var amountDepositAuxiliaryReceipt  = [];
						var numberDepositAuxiliaryReceipt  = [];
						$(".accountDepositAuxiliaryReceipt").each(function(index,value){
						    accountDepositAuxiliaryReceipt[index] = $(this).val();
						});
						$(".numberDepositAuxiliaryReceipt").each(function(index,value){
						    numberDepositAuxiliaryReceipt[index] = $(this).val();
						});
						$(".dateDepositAuxiliaryReceipt").each(function(index,value){
						    dateDepositAuxiliaryReceipt[index] = $(this).val();
						});
						$(".amountDepositAuxiliaryReceipt").each(function(index,value){
						    amountDepositAuxiliaryReceipt[index] = $(this).val();
						});
						data.token                           = token;
						data.accountDepositAuxiliaryReceipt  = accountDepositAuxiliaryReceipt;
						data.numberDepositAuxiliaryReceipt   = numberDepositAuxiliaryReceipt;
						data.dateDepositAuxiliaryReceipt     = dateDepositAuxiliaryReceipt;
						data.amountDepositAuxiliaryReceipt   = amountDepositAuxiliaryReceipt;
						ajaxForm(url,'post',data, null, 'true')
						.done( function (data) {
							if(data.success){
								$.unblockUI();
								bootbox.alert('<p class="success-ajax">'+data.message+'</p>', function(){
									window.open('/institucion/inst/recibos/impresion/'+token);
									location.reload();
								});
							}else{
								messageErrorAjax(data);
							}
						});
					}
			    },
			    danger: {
			    	label: "Cancelar",
					className: "btn-default",
			    }
		  	}
		});
	});

	dataTable('#table_receipts', 'recibos');

	/**
	 * Roles
	 */
	/**
	 * Roles
	 */
	
	$(document).off('click', '#updateRole');
	$(document).on('click', '#updateRole', function(e){
		e.preventDefault();
		var url;
		var idMenu;
		var roles = [];
		url = $(this).data('url');
		url = url + '/update';
		
		$('.menu-role').each(function (index) {
			idMenu = $(this).attr('data-menu');
			var idTasks     = [];
			var statusTasks = [];
			$('.menu-role:eq('+index+') .role-checkbox').each(function (i){
				idTasks[i]     = $(this).data('id');
				statusTasks[i] = $(this).bootstrapSwitch('state');
			});
			roles[idMenu] = {'idTasks': idTasks, 'statusTasks': statusTasks};
		});
		data.idUser = $("#idUser").val();
		data.roles  = roles;
		ajaxForm(url,'put',data)
		.done( function (response) {
			messageAjax(response);
		});
	});
	
	dataTable('#table_role', 'roles');
	
	/**
	 * End Roles
	 */
	
	/**
	 * Periodos Accounting
	 */

	$(document).off('click', '#saveAccountingPeriod');
	$(document).on('click', '#saveAccountingPeriod', function(e){
		var that = $(this);
		bootbox.confirm("¿Esta seguro de generar el nuevo Periodo Contable?, recuerde que no se puede regresar a un periodo anterior, verifique que tenga los saldos correctos.", function(result) {
		 	if(result){
		 		bootbox.prompt({
			        title: "Ingrese su clave", 
			        inputType: "password",
			        callback: function(result) {
			            if(result) {                                             
							var url = that.data('url');
					 		url = url + '/save';
					 		data.clave = result;
					 		ajaxForm(url, 'post', data, null, 'true')
					 		.done( function (response){
					 			messageAjax(response);
					 		});
						} else {
							bootbox.alert('No ha ingresado su Clave');
						}
			        }
			    });
		 	}
		});
	});

	/**
	 * Cortes de Caja
	 */
	$(document).off('click', '#saveCourtCase');
	$(document).on('click', '#saveCourtCase', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/save';
		ajaxForm(url, 'post', data, null, 'true')
		.done(function (response) {
			if(response.success){
				var tokenCourtCase = response.message;
				$.unblockUI();
				bootbox.alert('<p class="success-ajax">Se registro el corte de caja con éxito.</p>', function(){
					window.open('/institucion/inst/cortes-de-caja/impresion/'+tokenCourtCase+'/'+1, 'one');
					window.open('/institucion/inst/cortes-de-caja/impresion/'+tokenCourtCase+'/'+2, 'two');
					window.open('/institucion/inst/cortes-de-caja/impresion/'+tokenCourtCase+'/'+3, 'tree');
					location.reload();
				});
			}else{
				messageErrorAjax(response);
			}
		});
	});

	dataTable('#table_courtCase', 'cortes de caja');

	/**
	 * Configuracion
	 */
	$(document).off('click', '#saveSetting');
	$(document).on('click', '#saveSetting', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/save';
		data.typeSeatSetting = $('#typeSeatSetting').data('token');
		data.catalogSetting  = $('#catalogSetting').val();
		ajaxForm(url, 'post', data, null, 'true')
		.done(function (response) {
			messageAjax(response);
		});
	});

	// Update
	$(document).off('click', '#updateSetting');
	$(document).on('click', '#updateSetting', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/update';
		data.token           = $('#catalogSetting').data('token');
		data.typeSeatSetting = $('#typeSeatSetting').data('token');
		data.catalogSetting  = $('#catalogSetting').val();
		ajaxForm(url, 'post', data, null, 'true')
		.done(function (response) {
			messageAjax(response);
		});
	});

	dataTable('#table_settings','configuraciones');

	//Add partSeting
	$(document).off('click', '#addPartSeating');
	$(document).on('click', '#addPartSeating', function(e){
		e.preventDefault();
		if($('.accountPart aside').length == 1){
			$('#removePartSeating').removeClass('hide');
		}
		var partSeating = $('.accountPart aside:first').clone(true,true);
		partSeating.appendTo('.accountPart');
	});

	//Delete partSeting
	$(document).on('click', '#removePartSeating', function(e){
		e.preventDefault();
		var element = $(this);
		var partSeating = $('.accountPart aside:first');
		partSeating.remove();
		if($('.accountPart aside').length == 1){
			element.addClass('hide');
		}
	});

});