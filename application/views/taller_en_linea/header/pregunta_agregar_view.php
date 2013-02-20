<script src="<?php echo base_url(); ?>resources/js/jquery.counter.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.core.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.widget.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.button.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.position.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.autocomplete.js" type="text/javascript"></script>

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
				//selectLinea.combobox("destroy");
				//selectLinea.combobox();
			}
		});
	}
    
    
    $(document).ready(function() {
    	//$('select[name="ciudad_registrarse"]').combobox();
		$('select[name="marca_registrarse"]').change(function(){
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
    
    
        $("#registro-pregunta-id").fancybox({
            'transitionIn': 'none',
            'transitionOut': 'none'
        });

        $("#formulario_agregar_pregunta").validate({
            rules: {
                titulo_pregunta: {
                    required: true,
                    textoDiferenteTitulo: true,
                    maxlength: 150
                },
                cuerpo_pregunta: {
                    required: true,
                    textoDiferenteCuerpo: true
                }
            },
            messages: {
                titulo_pregunta: {
                    required: "Escriba una pregunta",
                    textoDiferenteTitulo: "Escriba una pregunta"
                },
                cuerpo_pregunta: {
                    required: "Escriba una descripción de la pregunta",
                    textoDiferenteCuerpo: "Escriba una descripción de la pregunta"
                }
            },
            invalidHandler: function(form, validator){
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = errors == 1
                      ? 'Se encontró el siguiente error:\n'
                      : 'Se encontraron los siguientes ' + errors + ' errores:\n';
                    var errors = "";
                    if (validator.errorList.length > 0) {
                        for (x=0;x<validator.errorList.length;x++) {
                            errors += "<br/>" +  "\n\u25CF " + validator.errorList[x].message;
                        }
                    }
                    confirm(message + errors, function () {
                                                        $.modal.close();
                                                    });
//                    alert(message + errors);
                }
                validator.focusInvalid();
            }
        });

        $("#formulario_agregar_pregunta_ingresar").validate({
            rules: {
                titulo_pregunta_ingresar: {
                    required: true,
                    textoDiferenteTitulo: true
                },
                cuerpo_pregunta_ingresar: {
                    required: true,
                    textoDiferenteCuerpo: true
                },
                email_ingresar: {
                    required: true,
                    email: true
                },
                contrasena_ingresar: {
                    required:true
                }
            },
            messages: {
                titulo_pregunta_ingresar: {
                    required: "Escriba una pregunta",
                    textoDiferenteTitulo: "Escriba una pregunta"
                },
                cuerpo_pregunta_ingresar: {
                    required: "Escriba una descripción de la pregunta",
                    textoDiferenteCuerpo: "Escriba una descripción de la pregunta"
                },
                email_ingresar: {
                   required: "Escriba un correo electrónico",
                   email: "Escriba un correo electrónico válido"
                },
                contrasena_ingresar: {
                   required: "Escriba su contraseña"
                }
            },
            invalidHandler: function(form, validator){
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = errors == 1
                      ? 'Se encontró el siguiente error:\n'
                      : 'Se encontraron los siguientes ' + errors + ' errores:\n';
                    var errors = "";
                    if (validator.errorList.length > 0) {
                        for (x=0;x<validator.errorList.length;x++) {
                            errors += "<br/>" +  "\n\u25CF " + validator.errorList[x].message;
                        }
                    }
                    alert(message + errors);
                }
                validator.focusInvalid();
            },
            submitHandler: function(form){
                $.ajax({
                    url: "<?php echo base_url(); ?>usuario/validar_usuario_ajax/",
                    type: "POST",
                    data: {
                        email: function(){ return $("#email_ingresar").val(); },
                        contrasena: function(){ return $("#contrasena_ingresar").val(); }
                    },
                    onsubmit: false,
                    success: function(data){
                        if(data=="true")
                            form.submit();
                        else
                            alert('Verifique su correo electrónico y contraseña.');
                    }
                });
            }
        });

        $("#formulario_agregar_pregunta_registrarse").validate({
            rules: {
                titulo_pregunta_registrarse: {
                    required: true,
                    textoDiferenteTitulo: true
                },
                cuerpo_pregunta_registrarse: {
                    required: true,
                    textoDiferenteCuerpo: true
                },
                nombre_registrarse:{
                	required: true
                },
                apellidos_registrarse:{
                	required: true
                },
                usuario_registrarse: {
                    required: true,
                    noSpace: true,
                    minlength: 4,
                    maxlength: 50,
                    remote: {
                        url: "<?php echo base_url(); ?>usuario/no_existe_usuario_ajax/",
                        type: "POST",
                        data: {
                            usuario: function(){ return $("#usuario_registrarse").val(); }
                        }
                    }
                },
                email_registrarse: {
                    required: true,
                    email: true,
                    remote: {
                        url: "<?php echo base_url(); ?>usuario/no_existe_email_ajax/",
                        type: "POST",
                        data: {
                            email: function(){ return $("#email_registrarse").val(); }
                        }
                    }
                },
                contrasena_registrarse: {
                    required: true,
                    minlength: 4
                },
                contrasena2_registrarse: {
                    equalTo: "#contrasena_registrarse"
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
                terminos_condiciones_registrarse: {
                    required: true
                }
            },
            messages: {
                titulo_pregunta_registrarse: {
                    required: "Escriba una pregunta",
                    textoDiferenteTitulo: "Escriba una pregunta"
                },
                cuerpo_pregunta_registrarse: {
                    required: "Escriba una descripción de la pregunta",
                    textoDiferenteCuerpo: "Escriba una descripción de la pregunta"
                },
                nombre_registrarse: {
                   required: "Escriba su nombre"
                },
                apellidos_registrarse: {
                   required: "Escriba sus apellidos"
                },
                usuario_registrarse: {
                   required: "Escriba un usuario",
                   noSpace: "No está permitido los espacios en el usuario",
                   maxlength: 50,
                   remote: "El usuario ya está registrado"
                },
                email_registrarse: {
                   required: "Escriba un correo electrónico válido",
                   email: "Escriba un correo electrónico válido",
                   remote: "El correo electrónico ya está registrado"
                },
                contrasena_registrarse: {
                   required: "Escriba una contraseña",
                   minlength: "Escriba una contraseña con al menos 4 caracteres"
                },
                contrasena2_registrarse: {
                   equalTo: "Las contraseñas no son iguales"
                },
                marca_registrarse: "Debe seleccionar una marca válida",
				linea_registrarse: "Debe seleccionar una Línea de vehículos válidos",
				modelo_registrarse: {
					required: "El modelo del vehículo debe se escrito",
					number: "Es un número válido"
				},
                terminos_condiciones_registrarse: {
                    required: "Debe aceptar los términos y condiciones"
                }
            },
            invalidHandler: function(form, validator){
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = errors == 1
                      ? 'Se encontró el siguiente error:\n'
                      : 'Se encontraron los siguientes ' + errors + ' errores:\n';
                    var errors = "";
                    if (validator.errorList.length > 0) {
                        for (x=0;x<validator.errorList.length;x++) {
                            errors += "<br/>" +  "\n\u25CF " + validator.errorList[x].message;
                        }
                    }
                    alert(message + errors);
                }
                validator.focusInvalid();
            }
        });

        var configContadorUsuario = {
            'maxCharacterSize': 50,
            'displayFormat' : ''
        };
        $('#usuario_registrarse').textareaCount(configContadorUsuario, function(data){
        });

        var configContadorTituloPregunta = {
            'maxCharacterSize': 150,
            'displayFormat' : '#left caracteres restantes'
        };
        $('#titulo_pregunta').textareaCount(configContadorTituloPregunta, function(data){
        });
    });

    $.validator.setDefaults({
        errorPlacement: function(error, element){
        }
    });

    $.validator.addMethod("textoDiferenteTitulo",
        function(value, element){
            if(value!="Escribe aquí tu pregunta...")
                return true;
            else
                return false;
        },
        "Escriba una pregunta"
    );
    $.validator.addMethod("textoDiferenteCuerpo",
        function(value, element){
            if(value!="Escribe aquí los detalles de tu pregunta...")
                return true;
            else
                return false;
        },
        "Escriba detalles de la pregunta"
    );

    $.validator.addMethod("noSpace",
        function(value, element){
            return value.indexOf(" ") < 0 && value != "";
        },
        "No está permitido los espacios en el usuario"
    );

    function agregar_pregunta_sin_sesion(){
        document.getElementById("titulo_pregunta_ingresar").value = document.getElementById("titulo_pregunta").value;
        document.getElementById("titulo_pregunta_registrarse").value = document.getElementById("titulo_pregunta").value;
        document.getElementById("cuerpo_pregunta_ingresar").value = document.getElementById("cuerpo_pregunta").value;
        document.getElementById("cuerpo_pregunta_registrarse").value = document.getElementById("cuerpo_pregunta").value;
        document.getElementById("id_pregunta_categoria_ingresar").value = document.getElementById("id_pregunta_categoria").value;
        document.getElementById("id_pregunta_categoria_registrarse").value = document.getElementById("id_pregunta_categoria").value;
        document.getElementById("palabras_clave_ingresar").value = document.getElementById("palabras_clave").value;
        document.getElementById("palabras_clave_registrarse").value = document.getElementById("palabras_clave").value;
    }
</script>