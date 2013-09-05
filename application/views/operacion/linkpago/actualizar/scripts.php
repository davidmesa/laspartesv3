<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/numeral.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/wysihtml5-0.3.0_rc2.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/bootstrap-wysihtml5.js"></script> 
<script>
$(document).ready(function() {
	numeral.language('es', {
		delimiters: {
			thousands: '.',
			decimal: ','
		},
		abbreviations: {
			thousand: 'k',
			million: 'mm',
			billion: 'b',
			trillion: 't'
		},
		ordinal : function (number) {
			var b = number % 10;
			return (b === 1 || b === 3) ? 'er' :
			(b === 2) ? 'do' :
			(b === 7 || b === 0) ? 'mo' : 
			(b === 8) ? 'vo' :
			(b === 9) ? 'no' : 'to';
		},
		currency: {
			symbol: '$'
		}
	});

  // switch between languages
  numeral.language('es');

  //setea el campo .date-picker como un datepicker
  $('.date-picker').datepicker();

  $('textarea').wysihtml5({
	"font-styles": false, //Font styling, e.g. h1, h2, etc. Default true
	"emphasis": false, //Italics, bold, etc. Default true
	"lists": false, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
	"html": false, //Button which allows you to edit the generated HTML. Default false
	"link": false, //Button to insert a link. Default true
	"image": false, //Button to insert an image. Default true,
	"color": false //Button to change color of font  
});

  //pone el campo de categorias con select2
  $("#categoria").select2({
	    placeholder: "Selecciona una categoría"
	});

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
  	// $('form#actualizarLink').submit(function(e){
  	// 	e.preventDefault();
  	// 	actualizarLink();
  	// });
  	$("form#actualizarLink").validate({
        rules: {
            titulo: {
                required: true
            },precio: {
                required: true
            },iva: {
                required: true
            },margen: {
                required: true
            },descuento: {
                required: true
            },plazo: {
                required: true,
                number: true
            },vigencia: {
                required: true
            },categoria: {
                required: true
            },carros: {
                required: true
            }
        },messages: {
            titulo: "*Debes escribir el título de la oferta"
            ,precio: {
                required: "*Debes escribir el precio de la oferta"
            },iva: {
                required: "*Debes escribir el iva de la oferta"
            },margen: {
                required: "*Debes escribir el margen de la oferta"
            },descuento: {
                required: "*Debes escribir el descuento de la oferta"
            },plazo: {
                required: "*Debes escribir el plazo de uso de la oferta",
                number: "*El campo plazo de uso debe ser un número"
            },categoria: "*Debes escribir las categorías de la oferta"
            ,carros: "*Debes escribir los carros asociados a la oferta"
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
            actualizarLink();
            return false;
        }
    });
});

//formatea los números
function format_number(elem){
	if($(elem).val() !== ""){
		var numero = numeral().unformat($(elem).val());
		$(elem).val(numeral(numero).format('0,0.00'));	
	}
}

//actualiza el link de pago
function actualizarLink(){
	$('#guardar').attr('disabled', 'disabled');
	$('#guardar').val('Actualizando...');
	var id_oferta  = $('#id_oferta').val();
	var titulo  = $('#titulo').val();
	if($('#precio').val() !== '')
		var precio = numeral().unformat($('#precio').val());
	if($('#iva').val() !== '')
		var iva = numeral().unformat($('#iva').val());
	if($('#margen').val() !== '')
		var margen = numeral().unformat($('#margen').val());
	var vigencia = $('#vigencia').val();
	var plazo = $('#plazo').val();
	var iconDescuento = $('#descuento').next('.input-group-addon').text();
	if(iconDescuento === '$')
		fix_descuento($('#descuento').next('.input-group-addon'));
	var descuento = $('#descuento').val();
	var condiciones = $('#condiciones').val();
	var incluye = $('#incluye').val();
	var categoria_otra = $('#otro').val();
	var motivo = $('#motivo').val();
	var mySelections = [];
    $('#categoria option').each(function(i) {
        if (this.selected == true) {
                mySelections.push(this.value);
        }
    });
	var categoria = mySelections;
	var mySelections2 = [];
    $('#carros option').each(function(i) {
            if (this.selected == true) {
                    mySelections2.push(this.value);
            }
    });

    <?php $ids_pc = '';
    	foreach ($proveedores_cotizacion as $pc) {
    		$ids_pc .= $pc->id.',';
    	}
    	$ids_pc = substr($ids_pc, 0, -1);?>
	var carros = mySelections2;
	$.ajaxFileUpload({
	    type: "POST",
	    url: "<?php echo base_url(); ?>operacion/linkPago/actualizar_link_pago/85",//cambiarlo por el controlador
	    secureuri      :false,
	    dataType    : 'json',
        fileElementId  :'imagen',
	    data: { 
	    	'id_usuario': '<?php echo $link_pago->id_usuario;?>',
	    	'id_link_pago': '<?php echo $link_pago->id;?>',
	    	'id_oferta': id_oferta,
	    	'titulo': titulo,
	    	'precio': precio,
	    	'iva': iva,
	    	'margen': margen,
	    	'descuento': descuento,
	    	'motivo': motivo,
	    	'vigencia': vigencia,
	    	'plazo': plazo,
	    	'condiciones': condiciones,
	    	'incluye': incluye,
	    	'categoria_otra': categoria_otra,
	    	'categoria': categoria,
	    	'vehiculo_id': carros,
	    },success: function(data, status){
	    	if(data.status){
	    		window.location = '<?php echo base_url()."operacion/linkPago/mostrar_links/".$link_pago->id_pipeline."/".$link_pago->id_usuario."/ofertaActScs";?>'
	    	}else{
	    		$('.alert.alert-danger .alert-msg').html(data.msg).show();
	    		$('.alert.alert-danger').show();
	    		$("body").scrollTop(0);
		    	$('#guardar').val('ACTUALIZAR OFERTA');
		    	$('#guardar').removeAttr('disabled');
	    	}
	    	//hay que asociar la oferta con el link de pago
	    	
	    },error: function(data, status, e){
	    	alert('no functiona esta shit');
	    	$('.alert.alert-danger .alert-msg').text('Ocurrió un error al guardar la cotización, favor intentar más tarde.');
	    	$('.alert.alert-danger').show();
	    	$("body").scrollTop(0);
	    	$('#guardar').val('ACTUALIZAR OFERTA');
	    	$('#guardar').removeAttr('disabled');
	    }
	});
}

//cancela el formulario
function cancelar(){
	if(confirm('¿Está seguro de que desea cancelar el formulario?'))
		window.location = '<?php echo base_url()."operacion/linkPago/mostrar_links/".$id_pipeline."/".$id_usuario;?>'
}

//cambia el descuento de % a valor y viceversa
function fix_descuento(elem){
	if($(elem).text() === '%'){
		$(elem).text('$');
		var precio = parseFloat($('#precio').val());
		var iva = parseFloat($('#iva').val());
		var base = parseFloat(precio - iva);
		var dcto = numeral().unformat($('#descuento').val());
		var valorDcto = base*(dcto/100);
		$('#descuento').val(numeral(valorDcto).format('0,0.00'));
	}else if($(elem).text() === '$'){
		$(elem).text('%');
		var precio = parseFloat($('#precio').val());
		var iva = parseFloat($('#iva').val());
		var base = parseFloat(precio - iva);
		var valorDcto = numeral().unformat($('#descuento').val());
		var dcto = (valorDcto/base)*100;
		$('#descuento').val(numeral(dcto).format('0,0.00'));
	}
}
</script>