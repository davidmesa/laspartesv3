<script src="<?php echo base_url(); ?>resources/js/jquery.bgiframe.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.dimensions.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.tooltip.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.numeric.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/jquery.tooltip.css" />





<script type="text/javascript">
	var descripciones = {
		"#preguntas"		: 'Estas son las preguntas que has hecho en el taller en línea…',
		"#respuestas"		: 'Estas son las preguntas que has respondido en el taller en línea.',
		"#comentarios"		: 'Estos son las noticias, tips y tutoriales en los que ud ha comentado.',
		"#carritos-compras"	: 'Estas son las compras que has hecho.',
		"#vehiculos"		: 'En esta sección encontrará sus vehículos con toda la información y una detallada descripción de las actividades realizadas en éste, desde el día de la inscripción y consejos para su mantenimiento.',
                "#ofertas"		: 'Estas son las ofertas ofrecidas por los talleres suscriptos en Laspartes.com.'
	};
	var vehiculos = [<?php
$i = 0;
foreach($vehiculos as $vehiculo){
	echo $vehiculo->id_usuario_vehiculo;
	if($i < count($vehiculos) - 1 ){
		echo ', ';
	}
	$i++;
}
?>];

	function mostrarSeccion(source, seccion){
		$(".tab-selected").removeClass("tab-selected");
		$(source).parent().addClass("tab-selected");
		$(".tabs").hide();
		$(seccion).show();
		$('#descripcion').html(descripciones[seccion]);
	}

	$(document).ready(function() {  
                
            
		$("#preguntas-seleccionar").click(function(event){
			event.preventDefault();
			mostrarSeccion(this, "#preguntas");
		});

		$("#respuestas-seleccionar").click(function(event){
			event.preventDefault();
			mostrarSeccion(this, "#respuestas");
		});

		$("#comentarios-seleccionar").click(function(event){
			event.preventDefault();
			mostrarSeccion(this, "#comentarios");
		});

		$("#carritos-compras-seleccionar").click(function(event){
			event.preventDefault();
			mostrarSeccion(this, "#carritos-compras");
		});

		$("#vehiculos-seleccionar").click(function(event){
			event.preventDefault();
			mostrarSeccion(this, "#vehiculos");
                        
		});
                $("#ofertas-seleccionar").click(function(event){
			event.preventDefault();
			mostrarSeccion(this, "#ofertas");
                        
		});
                

<?php //if($tab=='carritos-compras'){ ?>
		mostrarSeccion("#<?php echo $tab;?>-seleccionar", "#<?php echo $tab;?>");
		$('.timeline').hide();
                $(".texto_kilometraje").numeric({
			decimal: false,
			negative: false
		}, function() {
			this.value = "";
			this.focus();
		});
                
               
		
		$(".texto_kilometraje").blur(function(){
			var parts = $(this).attr("id").split("_");
			var id = parts[parts.length - 1];
			var hideid = $("#id_vehiculo_" + id);
			var idVehiculo = hideid.val();
			
			var url = "<?php echo base_url(); ?>usuario/modificar_kilometraje_ajax";
			$.ajax({
				type: "POST",
				url: url,
				async: false,
				data: "id_usuario_vehiculo=" + idVehiculo + "&kilometraje=" + $(this).val(),
				success: function(contenido){
					$("#tooltip_kilometraje_" + id ).find("p").toggle();
					
					//Actualiza el timeline
					mostrarTareas(id, idVehiculo);
                                        window.location.reload();
				}
			});
		});
		
		$(".texto_placa").blur(function(){
			var parts = $(this).attr("id").split("_");
			var id = parts[parts.length - 1];
			var hideid = $("#id_vehiculo_" + id);
			var idVehiculo = hideid.val();
			
			var url = "<?php echo base_url(); ?>usuario/modificar_placa_ajax";
			$.ajax({
				type: "POST",
				url: url,
				async: false,
				data: "id_usuario_vehiculo=" + idVehiculo + "&placa=" + $(this).val(),
				success: function(contenido){
					$("#tooltip_placa_" + id ).find("p").toggle();
                                        mostrarTareas(id, idVehiculo);
                                        window.location.reload();
				}
			});
		});
		if(vehiculos.length > 0){
			actualizarTimeline(0, vehiculos[0]);
		}
                $('.titulo_categoria').click(function() {
                    var hide = $(this).nextUntil('.titulo_categoria').hasClass('hide_wrapper_tarea');
                    if(hide){
                       $(this).nextUntil('.titulo_categoria').fadeOut('slow', function() {
                            $(this).removeClass('hide_wrapper_tarea');
                            $(this).addClass('show_wrapper_tarea');
                        }); 
                        return false;
                    }
                    var show = $(this).nextUntil('.titulo_categoria').hasClass('show_wrapper_tarea');
                    if(show){
                        $(this).nextUntil('.titulo_categoria').fadeIn('fast', function() {
                                $(this).addClass('hide_wrapper_tarea');
                                $(this).removeClass('show_wrapper_tarea');
                        }); 
                    }
                });
	});
        
        	
	
	


function actualizarTimeline(i, id){
	mostrarTareas(i, id);
	
	$('ul.indice.vehiculos').find(".tab-selected").removeClass("tab-selected");
	$('#vehiculo_' + i).parent().addClass("tab-selected");
}

function mostrarTareas(i, id){
    
        $('.oferta').hide();
	for(var j = 0; j < <?php echo sizeof($vehiculos); ?>; j++){
		if(i != j){
			$('#info-vehiculo-' + j).hide();
		}
		$("#loading-vehiculo_" + i).hide();
	}
	$('#info-vehiculo-' + i).show("fast");
        $('#timeline_'+i).show();
        
        $(".progress-bar").each(function(i,value){
            var val = parseInt( $('.numero', value).text());
            var texto_val = $('.mensaje', value).text();
            if(val < 15 && texto_val =="Faltan: "){
                $(".numero", value).css("background","red" );
            }else if(val >= 15 && val <30 && texto_val =="Faltan: "){
                $(".numero", value).css("background","orange" );
            }else if( val >=30 && texto_val =="Faltan: "){
                $(".numero", value).css("background","green" );
            }else{
                $(".numero", value).css("background","red" );
            }
            
        });
        
        $("input:checkbox").click(function() { 

            var val = $(this).val();   
               var url = "<?php echo base_url(); ?>usuario/tarea_realizada_ajax";
                        $.ajax({
				type: "POST",
				url: url,
				async: true,
				data: "checkbox=" + val,
				success: function(contenido){
                                   window.location.reload();
				}
			});
            
        });
        
        
        $("input:button").click(function(event, value){
//                alert($('#forma_pagosonline').attr("method"));
            var forma = $(this).closest("form");
            var id_oferta = $('.id_oferta', forma).val();
            var url = "<?php echo base_url(); ?>usuario/generar_firmaPol_ajax";
                        $.ajax({
				type: "POST",
				url: url,
				async: true,
				data: "id_oferta=" + id_oferta,
				success: function(contenido){
                                    obj = jQuery.parseJSON(contenido);
                                        var valor = obj.valor;
                                        var iva = obj.iva;
                                        var baseDevolucionIva = obj.baseDevolucionIva;
                                        var usuarioId = obj.usuarioId;
                                        var refVenta = obj.refVenta;
                                        var firma = obj.firma;
                                        var descripcion = obj.descripcion;
                                        var var_valor = $("<input>").attr("type", "hidden").attr('value',valor).attr('name','valor');
                                        $('.forma_pagosonline').append(var_valor);
                                        var var_iva = $("<input>").attr("type", "hidden").attr('value',iva).attr('name','iva');
                                        $('.forma_pagosonline').append(var_iva);
                                        var var_base = $("<input>").attr("type", "hidden").attr('value',baseDevolucionIva).attr('name','baseDevolucionIva');
                                        $('.forma_pagosonline').append(var_base);
                                        var var_usua = $("<input>").attr("type", "hidden").attr('value',usuarioId).attr('name','usuarioId');
                                        $('.forma_pagosonline').append(var_usua);
                                        var var_ref = $("<input>").attr("type", "hidden").attr('value',refVenta).attr('name','refVenta');
                                        $('.forma_pagosonline').append(var_ref);
                                        var var_firma = $("<input>").attr("type", "hidden").attr('value',firma).attr('name','firma');
                                        $('.forma_pagosonline').append(var_firma);
                                        var var_descripcion = $("<input>").attr("type", "hidden").attr('value',descripcion).attr('name','descripcion');
                                        $('.forma_pagosonline').append(var_descripcion);
                                        
                                         $('#forma_pagosonline', value).submit();
				}
			});
        });
        
        desplegar_oferta();
        progress_bar_calificacion();

	$('#timeline_'+i).show();
}

function progress_bar_calificacion(){
    $('.calificacion_taller').each(function(index, domEle) {
        var valor = $(domEle).children('span').text();
        valor = ((valor/5)*100);
        valor = valor + '%';
        $(domEle).next('.progress_bar').children('.progress_level').css('width', valor);
    });
}

function desplegar_oferta(){
    $('.contenido_oferta').hover(
    function(){
        $('>.oferta', this).fadeIn(1000);
    },
    function(){ 
        return false;
    }
    );
    
    $('.titulo').click(function(){
        var hidden = $('~.oferta', this).is(':not(:hidden)');
        if(hidden){  
            $('~.oferta', this).fadeOut(500); 
        } 
    });
}



	
</script>