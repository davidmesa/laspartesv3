<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.validate.js"></script>

<script>
$(document).ready(function() {

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

  //les da el formato de selec2
  $('#taller, #lugar').select2();

	// $('form#agregarOR').submit(function(e){
	// 	e.preventDefault();
	// 	agregarOrdenRemision();
	// });

	$("form#agregarOR").validate({
        rules: {
            nombres: {
                required: true
            },correo: {
                required: true,
                email: true
            },lugar: {
                required: true
            },direccion: {
                required: true
            },telefono: {
                required: true
            },carros: {
                required: true,
                number: true
            },taller: {
                required: true
            },descripcion: {
                required: true
            }
        },messages: {
            nombres: "*Debes ingresar tus nombres",
            ciudadEnvio: "*Debes ingresar tu ciudad",
            correo: {
                required: "*Debes ingresar una dirección de correo válida",
                email: "*Debe ser un correo válido"
            },
            vehiculo_id:{
                required: "*El vehículo que especificaste no se encuentra registrado en nuestra base de datos",
                number: "*Debes ingresar un vehículo válido"
            },
            direccion:"*Debes ingresar tu dirección de envío",
            telefono:"*Deebes ingresar tu número telefónico",
            taller:"*Debes ingresar un taller",
            descripcion: "*Debes ingresar la descripción de la orden de remisión"
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
            agregarOrdenRemision();
            return false;
        }
    });
});

//envía el formulario para la orden de remisión
function agregarOrdenRemision(){
	$('#guardar').attr('disabled', 'disabled');
	$('#guardar').val('Generando...');
	var nombres = $('#nombres').val();
	var email = $('#correo').val();
	var ciudadEnvio = $('#lugar').val();
	var direccionEnvio = $('#direccion').val();
	var telefonoMovil = $('#telefono').val();
	var vehiculo_id = $('#carros').val();
	var id_talleres = $('#taller').val();
	var descripcion = $('#descripcion').val();
	$.ajax({
	    type: "POST",
	    url: "<?php echo base_url(); ?>operacion/ordenRemision/generar_orden_remision",//cambiarlo por el controlador
	    data: { 
	    	'id_pipeline': '<?php echo $id_pipeline;?>',
	    	'id_usuario': '<?php echo $id_usuario;?>',
	    	'nombres': nombres,
	    	'email': email,
	    	'ciudadEnvio': ciudadEnvio,
	    	'direccionEnvio': direccionEnvio,
	    	'telefonoMovil': telefonoMovil,
	    	'vehiculo_id': vehiculo_id,
	    	'id_talleres': id_talleres,
	    	'descripcion': descripcion
	    },success: function(data, status){
	    	var data = $.parseJSON(data);
	    	if(data.status){
	    		window.location = '<?php echo base_url()."operacion/ordenRemision/mostrar_ordedes/".$id_pipeline."/".$id_usuario."/remisionSucs";?>'
	    	}else{
	    		$('.alert.alert-danger .alert-msg').html(data.msg);
	    		$('.alert.alert-danger').show();
	    		$("body").scrollTop(0);
	    		$('#guardar').val('GENERAR ORDEN DE REMISIÓN');
	    		$('#guardar').removeAttr('disabled');
	    	}
	    },error: function(data, status, e){
	    	$('.alert.alert-danger .alert-msg').text('Ocurrió un error al guardar la orden de remisión, favor intentar más tarde.');
	    	$('.alert.alert-danger').show();
	    	$("body").scrollTop(0);
	    	$('#guardar').val('GENERAR ORDEN DE REMISIÓN');
	    	$('#guardar').removeAttr('disabled');
	    }
	});
}

//cancela el formulario
function cancelar(){
	if(confirm('¿Está seguro de que desea cancelar el formulario?'))
		window.location = '<?php echo base_url()."operacion/ordenRemision/mostrar_ordedes/".$id_pipeline."/".$id_usuario;?>'
}
</script>