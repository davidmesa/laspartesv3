<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/bootstrap-datepicker.js"></script>

<script>


$(document).ready(function() {
	$('#lugar').select2();

	$('.date-picker').datepicker();

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
$("form#generarFactura").validate({
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
		},fechapago: {
			required: true
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
		},fechapago: {
			required: "*Debes seleccionar la fecha de pago de la factura"
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
		generarFactura();
		return false;
	}
  });

});


//genera la factura
function generarFactura(){
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
	var observaciones = $('#observaciones').val();
	var fechapago = $('#fechapago').val();
	$.ajax({
		type: "POST",
	    url: "<?php echo base_url(); ?>operacion/facturacion/generar_factura",//cambiarlo por el controlador
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
	    	observaciones: observaciones,
	    	fechapago: fechapago
	    },success: function(data, status){
	    	var data = $.parseJSON(data);
	    	if(data.status){
	    		window.location = '<?php echo base_url()."operacion/facturacion/mostrar_facturacion/".$id_pipeline."/".$id_usuario."/facturaScs";?>'
	    	}else if(!data.status && !isEmpty(data.dbsesion)){
	    		$('body').prepend('<div class="alert alert-danger" style="display: block;"><button type="button" class="close" data-dismiss="alert">&times;</button>'+data.dbsesion+' <a href="'+data.dburl+'" target="_blank">'+data.dburl+'</a></div>');
	    		$('.modal').modal('hide');
	    		$("body").scrollTop(0);
	    	}else{
	    		$('.alert.alert-danger .alert-msg').html(data.msg).show();
	    		$('.alert.alert-danger').show();
	    		$("body").scrollTop(0);
	    		$('#guardar').val('GENERAR FACTURA');
	    		$('#guardar').removeAttr('disabled');
	    	}
	    	
	    },error: function(data, status, e){
	    	$('.alert.alert-danger .alert-msg').text('Ocurrió un error al generar la factura, favor intentar más tarde.');
	    	$('.alert.alert-danger').show();
	    	$("body").scrollTop(0);
	    	$('#guardar').val('GENERAR FACTURA');
	    	$('#guardar').removeAttr('disabled');
	    }
	});
}

//vista preliminar de la factura
function vista_preliminar(){
	var carro = $('#carros','#generarFactura').val();
	var lugar = $('#lugar','#generarFactura').val();
	var observaciones = $('#observaciones').val();
	var form = $('#generarFactura').clone();
	$('#carros',form).val(carro);
	$('#lugar',form).val(lugar);
	$('#observaciones',form).val(observaciones);
	$(form).attr("id", "previsualizarForm");
	$(form).attr("method", "post");
	$(form).css("display", "none");
	$(form).attr("action", '<?php echo base_url()?>operacion/facturacion/vista_preliminar/<?php echo $id_usuario?>/<?php echo $ids?>');

	// setting form target to a window named 'formresult'
	$(form).attr("target", "formresult");

	$('body').append(form);

	// creating the 'formresult' window with custom features prior to submitting the form
	window.open('<?php echo base_url()?>operacion/facturacion/vista_preliminar/<?php echo $id_usuario?>/<?php echo $ids?>', 'formresult', 'scrollbars=no,menubar=no,height=800,width=850,resizable=yes,toolbar=no,status=no');

	$(form).submit();
}

function valid(string) {
 string =  string.replace(/[^a-zA-Z0-9]/g,'_');
 return string
}

</script>
