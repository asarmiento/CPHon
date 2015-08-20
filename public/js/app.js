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

//Function SubmitAjax
var ajaxSubmit = function (url, type, data){
	var message;
	var path = url;
	if(type == 'post'){
		message = 'Registrando';
	}else{
		message = 'Actualizando';
	}
	return	$.ajax( {
		      	url: path,
		      	type: type,
		      	data: data,
				beforeSend: function(){
		    		loadingUI(message, 'img');
			    },
		      	error: function(jqXHR, textStatus, errorThrown){
					console.log('ERROR: ' + textStatus);
					$.unblockUI();
			    	bootbox.alert("<p class='red'>No se pueden grabar los datos.</p>")
				}
		    });
};

/**
 * [bootboxEdit description]
 * @param  {[type]} html    [description]
 * @param  {[type]} title   [description]
 * @param  {[type]} pathPut [description]
 * @return {[type]}         [description]
 */
var bootboxEdit = function(html, title, pathPut){
	bootbox.dialog({
	  	message: html,
	  	size: "large",
	  	title: "Editar " + title,
	  	animate: true,
	  	className: "my-modal-edit",
	  	buttons: {
		    success: {
				label: "Actualizar",
				className: "btn-success",
				callback: function() {
					ajaxSubmit(pathPut, 'put', $('.editModal').serialize())
				    .done(function(response){
				    	messageAjax(response);
				    });
				}
		    },
		    danger: {
		    	label: "Cancelar",
				className: "btn-default",
		    }
	  	}
	});
};

/**
 * [bootboxNew description]
 * @param  {[type]} html  [description]
 * @param  {[type]} title [description]
 * @param  {[type]} url   [description]
 * @return {[type]}       [description]
 */
var bootboxNew = function(html, title, url){
	if(url == "cuotas"){
		title = "Nueva " + title;
	}else{
		title = "Nuevo " + title;
	}
	bootbox.dialog({
	  	message: html,
	  	size: "large",
	  	title: title,
	  	animate: true,
	  	className: "my-modal-new",
	  	buttons: {
		    success: {
				label: "Grabar",
				className: "btn-success",
				callback: function() {
					ajaxSubmit(url, 'post', $('.newModal').serialize())
				    .done(function(response){
				    	messageAjax(response);
				    });
				}
		    },
		    danger: {
		    	label: "Cancelar",
				className: "btn-default",
		    }
	  	}
	});
};

/**
 * [getTpl description]
 * @param  {[type]} view [description]
 * @param  {[type]} type [description]
 * @return {[type]}      [description]
 */
var getTpl = function(view, type){
	return "../templates/" + view + "/" + type +".html";
};

/**
 * [helperHandlebars description]
 * @return {[type]} [description]
 */
var helpersHandlebars = function(){
	Handlebars.registerHelper('if_eq', function(a, b, opts) {
    if(a == b) // Or === depending on your needs
	        return opts.fn(this);
	    else
	        return opts.inverse(this);
	});

	Handlebars.registerHelper('ifCond', function (v1, operator, v2, options) {
	    switch (operator) {
	        case '==':
	            return (v1 == v2) ? options.fn(this) : options.inverse(this);
	        case '===':
	            return (v1 === v2) ? options.fn(this) : options.inverse(this);
	        case '<':
	            return (v1 < v2) ? options.fn(this) : options.inverse(this);
	        case '<=':
	            return (v1 <= v2) ? options.fn(this) : options.inverse(this);
	        case '>':
	            return (v1 > v2) ? options.fn(this) : options.inverse(this);
	        case '>=':
	            return (v1 >= v2) ? options.fn(this) : options.inverse(this);
	        case '&&':
	            return (v1 && v2) ? options.fn(this) : options.inverse(this);
	        case '||':
	            return (v1 || v2) ? options.fn(this) : options.inverse(this);
	        default:
	            return options.inverse(this);
	    }
	});
};

/**
 * [compileTpl description]
 * @param  {[type]} html [description]
 * @param  {[type]} data [description]
 * @return {[type]}      [description]
 */
var compileTpl = function(html, data){
	helpersHandlebars();
	var tpl = Handlebars.compile(html);
	var html = tpl(data);
	return html;
};

/**
 * [datepickerAdult description]
 * @return {[type]} [description]
 */
var datepickerAdult = function(){
	var current = new Date();
	var adult   = String(current.getDate()) + "/" + String(current.getMonth()) + "/" + String(current.getFullYear() - 18);
	$(".date").datepicker({
		autoclose: true,
		endDate: adult,
		format: "dd/mm/yyyy",
		language: "es",
		orientation: "top auto"
	});
};

/**
 * [datepickerMonth description]
 * @return {[type]} [description]
 */
var datepickerMonth = function(){
	$(".date").datepicker({
		autoclose: true,
		format: "mm/yyyy",
		language: "es",
		orientation: "top auto",
		minViewMode: 1
	});
};

/**
 * [editModal description]
 * @param  {[type]} url     [description]
 * @param  {[type]} data    [description]
 * @param  {[type]} title   [description]
 * @param  {[type]} pathPut [description]
 * @return {[type]}         [description]
 */
var editModal = function(url, data, title, pathPut){
	switch(url){
		case 'porcentajes': 
			var urlTpl = getTpl('recordPercentages', 'edit');
			$.get(urlTpl)
			.done( function(html){
				var modal = compileTpl(html, data)
				bootboxEdit(modal, title, pathPut);
			});
			break;
		case 'afiliados': 
			var urlTpl = getTpl('affiliates', 'edit');
			$.get(urlTpl)
			.done( function(html){
				var modal = compileTpl(html, data)
				bootboxEdit(modal, title, pathPut);
				datepickerAdult();
			});
			break;
	}
};

/**
 * [newModal description]
 * @param  {[type]} url   [description]
 * @param  {[type]} title [description]
 * @return {[type]}       [description]
 */
var newModal = function(url, title){
	var urlTpl;
	var modal;
	switch(url){
		case 'porcentajes': 
			urlTpl = getTpl('recordPercentages', 'create');
			$.get(urlTpl)
			.done( function(html){
				modal = compileTpl(html)
				bootboxNew( modal, title, url);
			});
			break;
		case 'afiliados': 
			urlTpl = getTpl('affiliates', 'create');
			$.get(urlTpl)
			.done( function(html){
				modal = compileTpl(html)
				bootboxNew(modal, title, url);
				datepickerAdult();
			});
			break;
		case 'cuotas':
			urlTpl = getTpl('dues', 'create');
			$.get(urlTpl)
			.done( function(html){
				modal = compileTpl(html)
				bootboxNew( modal, title, url);
				datepickerMonth();
				var rec_affi = $('#rec_affi').val();
				var rec_priv = $('#rec_priv').val();
				$('#lbl_priv').append(" "+rec_priv+"%");
				$('#lbl_aff').append(" "+rec_affi+"%");
			});
			break;
	}
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

	//datePicker
	if( $(".date").exists() ){
		$('.date').datepicker({
			autoclose: true,
			format: "mm/yyyy",
			language: "es",
			orientation: 'top auto'
		});
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

    //Select row affilliate
    $(document).off('click', '.radioAffiliate');
    $(document).on('click', '.radioAffiliate', function(e){
    	var self = $(this);
    	$('#codeAffiliate').val(self.parent().parent().find('.code').text());
    	$('#hdnCode').val(self.parent().parent().find('.code').text());
    	$('#datePaymentLastAffiliate').val(self.parent().parent().find('.lastPayment').val());
    	$('#charterAffiliate').val(self.parent().parent().find('.charter').text());
    	$('#nameAffiliate').val(self.parent().parent().find('.name').text());
    	$('#lastAffiliate').val(self.parent().parent().find('.last').text());
    	$('#birthdateAffiliate').val(self.parent().parent().find('.birthdate').val());
    	$('.my-modal-search').modal('hide');
    });

    //Search Affiliate - typeahead
	$(document).off('click', '.search');
	$(document).on('click', '.search', function(e) {
		e.preventDefault();
		var self = $('#searchAffiliate');
		// Act on the event
		if( self.val().length > 0 ){
			$.getJSON('searchAffiliate', { code: self.val() } )
			.done( function(response){
				if(response.length > 0){
					var urlTpl = getTpl('dues', 'listAffiliates');
					$.get(urlTpl)
					.done( function(html){
						helpersHandlebars();
						var tpl = Handlebars.compile(html);
						var html = tpl({ListData: response});
						bootbox.dialog({
						  	message: html,
						  	size: "large",
						  	title: "Escoger Afiliado",
						  	animate: true,
						  	className: "my-modal-search",
						  	buttons: {
							    danger: {
							    	label: "Cancelar",
									className: "btn-default",
							    }
						  	}
						});
					});
				}else{
					console.log("Sin respuesta");
				}
			});
		}else{
			console.log("sin respuesta");
		}
	});
	

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
		data.nameMenu     = $('#nameMenu').val();
		data.urlMenu      = $('#urlMenu').val();
		data.icon_fontMenu     = $('#icon_fontMenu').val();
		data.priorityMenu = $('#priorityMenu').val();
		data.resourceMenu = $('#resourceMenu').bootstrapSwitch('state');
		data.idTasks      = idTasks;
		data.stateTasks   = stateTasks;
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
		data.icon_fontMenu   = $('#icon_fontMenu').val();
		data.priorityMenu = $('#priorityMenu').val();
		data.resourceMenu = $('#resourceMenu').bootstrapSwitch('state');
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
	 * Resources:
	 * Porcentajes, Afiliados
	 */
	
	$(document).off('click', '.new');
	$(document).on('click', '.new', function(e){
		e.preventDefault();
		var url = $(this).data('url');
		$.getJSON('../json/modal.json', function(views){
			$.each(views, function(index,value){
				if(value.view == url){
					//get view tpl and modal
					newModal(url, value.title);
					return false;
				}
			});
		});
	});

	$(document).off('click', '.edit');
	$(document).on('click', '.edit', function(e){
		e.preventDefault();
		var url     = $(this).data('url');
		var token   = $(this).data('token');
		var path    = url+'/'+token+'/edit';
		var pathPut = url+'/'+token;
		$.get(path)
		.done(function(response){
			//get pages json
			$.getJSON('../json/modal.json', function(views){
				$.each(views, function(index,value){
					if(value.view == url){
						//get view tpl and modal
						editModal(url, response, value.title, pathPut);
						return false;
					}
				});
			});
		});
	});

	dataTable('#table_percentage', 'porcentajes.');
	dataTable('#table_affiliates', 'afiliados');
	dataTable('#table_dues', 'cuotas');
	/**
	 * End Porcentajes
	 */

	$(document).off('click', '#otherPeriods');
	$(document).on('click', '#otherPeriods', function(e){
		e.preventDefault();
		var url = $(this).data('url');
		url = url + '/other';
		bootbox.confirm('¿Se aplicara un asiento a los estudiantes que no tenga el cobro del mes selecionado?', function (result) {
			if(result){
				var modal = '<div class="row"><div class="col-sm-4"><span class="pull-right" style="line-height:2.25em;">Seleccionar Mes:</span></div><div class="col-sm-6"><div class="input-group"><span class="input-group-addon"><i class="fa fa-calendar"></i></span> <input id="dateOther" class="form-control" type="text"></div></div></div>';
				bootbox.dialog({
				  	message: modal,
				  	size: "large",
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

	

});