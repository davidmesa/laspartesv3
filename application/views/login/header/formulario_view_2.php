<script src="<?php echo base_url(); ?>resources/js/jquery.ui.core.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.widget.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.button.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.position.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.autocomplete.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.datepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.datepicker-es.js" type="text/javascript"></script>

<link href="<?php echo base_url(); ?>resources/css/jquery.ui.all.css" rel="stylesheet" type="text/css"  media="screen" />
<!--link href="<?php echo base_url(); ?>resources/css/jquery-ui-1.8.17.custom.css" rel="stylesheet" type="text/css"  media="screen" /-->
<link href="<?php echo base_url(); ?>resources/css/jquery.ui.datepicker.css" rel="stylesheet" type="text/css"  media="screen" />

<style>
.ui-autocomplete-input
{
	margin: 0; padding: 0.48em 0 0.47em 0.45em;
	width: 100px;
	max-height: 30px;
}

.ui-menu .ui-menu-item a{
	font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
	font-size:13px;
	font-style:normal;
	font-weight:normal;
	padding:2px;
	margin:0;
}

.ui-autocomplete {
	max-height: 200px;
	overflow-y: auto;
	/* prevent horizontal scrollbar */
	overflow-x: hidden;
	/* add padding to account for vertical scrollbar */
	padding-right: 20px;
}

/* IE 6 doesn't support max-height
 * we use height instead, but this forces the menu to always be this tall
 */
* html .ui-autocomplete {
	height: 200px;
}
</style>
<script type="text/javascript">
	(function( $ ) {
		$.widget( "ui.combobox", {
			_create: function() {
				var self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "";
				var input = this.input = $( "<input>" )
					.attr("id", this.element.attr("name") + "-text")
					.insertAfter( select )
					.val( value )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>" ),
										value: text,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							self._trigger( "selected", event, {
								item: ui.item.option
							});
						},
						change: function( event, ui ) {
							if ( !ui.item ) {
								var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
									valid = false;
								select.children( "option" ).each(function() {
									if ( $( this ).text().match( matcher ) ) {
										this.selected = valid = true;
										self._trigger( "selected", event, {
											item: $( this ).text()
										});
										return false;
									}
								});
								if(!valid){
									if ( select.attr('name') != 'ciudad_registrarse' ) {
										// remove invalid value, as it didn't match anything
										$( this ).val( "" );
										select.val( "" );
										input.data( "autocomplete" ).term = "";
										return false;
									}else{
										$( this ).val( $(this).val() );
										select.val( $(this).val() );
										input.data( "autocomplete" ).term = $(this).val();
										return false;
									}
								}
							}
						}
					})
					.addClass( "ui-widget ui-widget-content ui-corner-left" );

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li></li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};

				this.button = $( "<button type='button'>&nbsp;</button>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Show All Items" )
					.insertAfter( input )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "ui-corner-right ui-button-icon" )
					.click(function() {
						// close if already visible
						if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
							input.autocomplete( "close" );
							return;
						}

						// work around a bug (likely same cause as #5265)
						$( this ).blur();

						// pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
						input.focus();
					});
			},

			destroy: function() {
				this.input.remove();
				this.button.remove();
				this.element.show();
				$.Widget.prototype.destroy.call( this );
			}
		});
	})( jQuery );


	jQuery.validator.setDefaults({
		success: "valid"
	});
		
	function solicitarLineas(marca){
		var url = "<?php echo base_url(); ?>usuario/dar_vehiculos_lineas_ajax";
		$.ajax({
			type: "POST",
			url: url,
			data: "marca=" + marca,
			success: function(contenido){
				var selectLinea = $('select[name="linea_registrarse"]');
				selectLinea.empty();

				var lineasObj = jQuery.parseJSON(contenido);
				$.each(lineasObj, function(key, lineaObj){
					selectLinea.append($("<option></option>")
						.attr("value", lineaObj.id_vehiculo )
						.text(lineaObj.linea));
				});
				selectLinea.combobox("destroy");
				selectLinea.combobox();
			}
		});
	}
		
	var fecha = $.datepicker.formatDate('yy-mm-dd', new Date());
	$(function() {
		$('select[name="ciudad_registrarse"]').combobox();
		$('select[name="marca_registrarse"]').combobox({
			selected: function( event, data ) {
				solicitarLineas(data.item.innerText);
			}});
		$('#marca_registrarse-text').keyup(function(){
			solicitarLineas($(this).val());
		});
		
		
		
		$('#tiene_carro_registrarse').change(function(){
			var thisCheck = $(this);
			if(thisCheck.is(':checked')){
				$('#tiene_carro_form_registro').show();
			}else{
				$('#tiene_carro_form_registro').hide();
			}
		}).change();
		
		
		
		$('select[name="marca_registrarse"]').change(function(){
			solicitarLineas($(this).val());
		}).change();
		
		
		var validator = $("#formulario_registrar_usuario").validate({
			rules: {
				nombre_usuario_registrarse: {
					required: true
				},
				apellidos_usuario_registrarse: {
					required: true
				},
				usuario_registrarse: {
					required: true,
					remote: {
						url: "<?php echo base_url(); ?>usuario/no_existe_usuario_ajax",
						type: "post",
						data: {
							usuario: function() {
								return $("#usuario_registrarse").val();
							}
						}
					}
				},
				email_registrarse: {
					required: true,
					email: true,
					remote: {
						url: "<?php echo base_url(); ?>usuario/no_existe_email_ajax",
						type: "post",
						data: {
							email: function() {
								return $("#email_registrarse").val();
							}
						}
					}
				},
				contrasena_registrarse: {
					required: true
				},
				contrasena2_registrarse: {
					required: true,
					equalTo: '#contrasena_registrarse'
				},
				marca_registrarse: {
					required: '#tiene_carro_registrarse:checked'
				},
				linea_registrarse: {
					required: '#tiene_carro_registrarse:checked'
				},
				kilometraje_registrarse: {
					required: '#tiene_carro_registrarse:checked',
					number: true
				},
				modelo_registrarse: {
					required: '#tiene_carro_registrarse:checked',
					number: true
				},
				captcha_registrarse: {
					required: true
				},
				terminos_condiciones_registrarse: {
					required: true
				}
			},
			messages: {
				nombre_usuario_registrarse: "El nombre es un campo requerido",
				apellidos_usuario_registrarse: "Los apellidos es un campo requerido",
				usuario_registrarse: {
										required: "Debe escribir un nombre de usuario",
										remote: "Es un nombre de usuario ya registrado"
									},
				email_registrarse: {
										required: "Ingresa una dirección de correo válida",
										email: "Debe ser un correo válido",
										remote: "Este correo ya está registrado"
									},
				contrasena_registrarse: "Debe ingresar una contraseña",
				contrasena2_registrarse: {
										required: "Debe ingresar el valor de la contraseña",
										equalTo: "Debe ser el mismo valor de la contraseña anterior"
									},
				marca_registrarse: "Debe seleccionar una marca válida",
				linea_registrarse: "Debe seleccionar una Línea de vehículos válidos",
				modelo_registrarse: {
										required: "El modelo del vehículo debe se escrito",
										number: "Es un número válido"
									},
				captcha_registrarse: " ",
				terminos_condiciones_registrarse: "Para poder ser parte debe aceptar los términos y condiciones"
			},
			submitHandler: function(form) {
				_gaq.push(['_trackEvent', 'Registros', 'Clic', 'usuario']);
                                form.submit();
			},
			errorPlacement: null
		});
		validator.resetForm();
	});
</script>