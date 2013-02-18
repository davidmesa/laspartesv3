<script src="<?php echo base_url(); ?>resources/js/jquery.counter.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#registro-carrito-compras-id").fancybox({
            'transitionIn': 'none',
            'transitionOut': 'none'
        });

        $("#formulario_checkout_carrito_compras_ingresar").validate({
            rules: {
                email_ingresar: {
                    required: true,
                    email: true
                },
                contrasena_ingresar: {
                    required:true
                }
            },
            messages: {
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
                            errors += "\n\u25CF " + validator.errorList[x].message;
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

        $("#formulario_checkout_carrito_compras_registrarse").validate({
            rules: {
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
                terminos_condiciones_registrarse: {
                    required: true
                }
            },
            messages: {
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
                            errors += "\n\u25CF " + validator.errorList[x].message;
                        }
                    }
                    alert(message + errors);
                }
                validator.focusInvalid();
            }
        });

        var configContador = {
            'maxCharacterSize': 50,
            'displayFormat' : ''
        };
        $('#usuario_registrarse').textareaCount(configContador, function(data){});
        
        //forma de pagosOnline.com      
        $("#forma_pagosonline").validate({
            
            submitHandler: function(form){
                $.ajax({
                    url: "<?php echo base_url(); ?>usuario/checkout_carrito_compras/",
                    type: "POST",
                    data: {
                        usuarioId: function(){ return $("#usuarioId").val(); },
                        descripcion: function(){ return $("#descripcion").val(); },
                        refVenta: function(){ return $("#refVenta").val(); },
                        valor: function(){ return $("#valor").val(); },
                        iva: function(){ return $("#iva").val(); },
                        baseDevolucionIva: function(){ return $("#baseDevolucionIva").val(); },
                        firma: function(){ return $("#firma").val(); },
                        emailComprador: function(){ return $("#emailComprador").val(); },
                        prueba: function(){ return $("#prueba").val(); },
                        url_respuesta: function(){ return $("#url_respuesta").val(); }
                    },
                    onsubmit: false,
                    success: function(data){
                        if(data=="true")
                            form.submit();
                        else
                            alert(data);
                    }
                });
            }
        });
        
        
        
        
        
    });

    $.validator.setDefaults({
        errorPlacement: function(error, element){
        }
    });

    $.validator.addMethod("noSpace",
        function(value, element){
            return value.indexOf(" ") < 0 && value != "";
        },
        "No está permitido los espacios en el usuario"
    );
</script>