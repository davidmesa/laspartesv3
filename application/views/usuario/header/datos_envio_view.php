<link href="<?php echo base_url(); ?>resources/css/autopartes.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>resources/js/jquery.formatCurrency-1.4.0.js" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        $("#datos-envio-form").validate({
                    rules: {
                        emailComprador: {
                            required: true,
                            email: true
                        },
                        nombreComprador: {
                            required: true
                        },
                        ciudadEnvio: {
                            required: true
                        },
                        direccionEnvio: {
                            required: true
                        },
                        telefonoMovil: {
                            required: true
                        }
                    },
                    messages: {
                        emailComprador: {
                            required: "*Debes escribir tu correo electrónico",
                            email: "*Debes escribir un correo electrónico válido"
                        },
                        nombreComprador: {
                            required: "*Debes escribir tus nombres"
                        },
                        ciudadEnvio: {
                            required: "*Debes escribir una ciudad"
                        },
                        direccionEnvio: {
                            required: "*Debes escribir tu dirección de envío"
                        },
                        telefonoMovil: {
                            required: "*Debes escribir tu telefono de contacto"
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
                        var nombreComprador = $('#nombreComprador').val();
                        var ciudadEnvio =$('#ciudadEnvio').val();
                        var direccionEnvio = $('#direccionEnvio').val();
                        var telefonoMovil = $('#telefonoMovil').val();
                        var emailComprador = $('#emailComprador').val();
                        var di = $('#di').val();
                        var carro = $('#carro').val();
                        var placa = $('#placa').val();
                        var refVenta = $('#refVenta').val();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>usuario/registrar_datos_envio_ajax",
                            data: "nombreComprador=" + nombreComprador + "&ciudadEnvio=" + ciudadEnvio+  "&direccionEnvio=" + direccionEnvio+  "&telefonoMovil=" + telefonoMovil+  "&emailComprador=" + emailComprador+  "&refVenta=" + refVenta+  "&di=" + di+  "&carro=" + carro+  "&placa=" + placa,
                            async: false,
                            success: function(data){ 
                                if(data == 'true'){
                                  form.submit();
                                }else{
                                    alert(data);
                                }

                                return false;
                            }
                        }); 
                        return false;
                    }
                });
    });
</script>
