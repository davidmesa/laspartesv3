<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/bootstrap-datepicker.js"></script>

<script>


$(document).ready(function() {
	$('#lugar').select2();


//pone el campo de carros con select2
$('#carros').select2({
	placeholder: "Selecciona un carro",
	minimumInputLength: 3,
	formatInputTooShort: function (input, min) {  
		if(min - input.length == 1)
			return "Favor ingresar " + (min - input.length) + " caracter más"; 
		else
			return "Favor ingresar " + (min - input.length) + " caracteres más"; 
	}, 	
});

  //forma de crear link
  // $('form#generarFactura').submit(function(e){
  // 	e.preventDefault();
  // 	generarFactura();
  // });
$("form#generarRecibo").validate({
	rules: {
		nombres: {
			required: true
		},correo: {
			email: true,
			required: true
		},lugar: {
			required: true
		},carro: {
			number: true
		}
	},messages: {
		nombres: "*Debes escribir el nombre a quien va radicada la factura"
		,correo: {
			required: "*Debes escribir el correo electrónico",
			email: "*Debes escribir el correo electrónico válido"
		},lugar: {
			required: "*Debes seleccionar el lugar"
		},carro: {
			number: "*Debes seleccionar un carro"
		}
	},highlight: function(element, errorClass) {
		var formGroup = $('.form-group').has(element);
		$(formGroup).addClass('has-error');
	},unhighlight: function(element, errorClass) {
		var formGroup = $('.form-group').has(element);
		$(formGroup).removeClass('has-error');
	},invalidHandler: function(form, validator){
		var errors = validator.numberOfInvalids();
		if (errors) {
			var message = errors == 1
			? 'Se encontró el siguiente error:\n'
			: 'Se encontraron los siguientes ' + errors + ' errores:\n';
			var errors = "";
			if (validator.errorList.length > 0) {
				for (x=0;x<validator.errorList.length;x++) {
					errors += "\n\u25CF " + validator.errorList[x].message;
				}
			}
			alert(errors);
		}
		validator.focusInvalid();
	},submitHandler: function (form) {
		generarRecibo();
		return false;
	}
  });

});


//genera la factura
function generarRecibo(){
	$('#guardar').attr('disabled', 'disabled');
	$('#guardar').val('Generando...');
	var nombres = $('#nombres').val();
	var documento = $('#documento').val();
	var correo = $('#correo').val();
	var lugar = $('#lugar').val();
	var direccion = $('#direccion').val();
	var telefono = $('#telefono').val();
	var carro = $('#carros').val();
	var placa = $('#placa').val();
	$.ajax({
		type: "POST",
	    url: "<?php echo base_url(); ?>operacion/facturacion/generar_recibo",//cambiarlo por el controlador
	    data: { 
	    	'id_pipeline': '<?php echo $id_pipeline;?>',
	    	'id_usuario': '<?php echo $id_usuario;?>',
	    	'ids': '<?php echo $ids;?>',
	    	nombres: nombres,
	    	documento: documento,
	    	correo: correo,
	    	lugar: lugar,
	    	direccion: direccion,
	    	telefono: telefono,
	    	carro: carro,
	    	placa: placa,
	    },success: function(data, status){
	    	var data = $.parseJSON(data);
	    	if(data.status){
	    		window.location = '<?php echo base_url()."operacion/facturacion/mostrar_facturacion/".$id_pipeline."/".$id_usuario."/reciboScs";?>'
	    	}else if(!data.status && !isEmpty(data.dbsesion)){
	    		$('body').prepend('<div class="alert alert-danger" style="display: block;"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.dbsesion+' <a href="'+data.dburl+'" target="_blank">'+data.dburl+'</a></div>');
	    		$('.modal').modal('hide');
	    		$("body").scrollTop(0);
	    	}else{
	    		$('.alert.alert-danger .alert-msg').html(data.msg).show();
	    		$('.alert.alert-danger').show();
	    		$("body").scrollTop(0);
	    		$('#guardar').val('GENERAR RECIBO');
	    		$('#guardar').removeAttr('disabled');
	    	}
	    	
	    },error: function(data, status, e){
	    	$('.alert.alert-danger .alert-msg').text('Ocurrió un error al generar el recibo, favor intentar más tarde.');
	    	$('.alert.alert-danger').show();
	    	$("body").scrollTop(0);
	    	$('#guardar').val('GENERAR RECIBO');
	    	$('#guardar').removeAttr('disabled');
	    }
	});
}

</script>
