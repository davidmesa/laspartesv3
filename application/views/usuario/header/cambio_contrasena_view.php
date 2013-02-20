<link href="<?php echo base_url() ?>resources/css/autopartes.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    $(document).ready(function() {
        $("#formulario_cambio_contrasena").validate({
            rules: {
                contrasena_registrarse: {
                    required: true,
                    minlength: 4
                },
                contrasena2_registrarse: {
                    equalTo: "#contrasena_registrarse"
                }
            },
            messages: {
                contrasena_registrarse: {
                   required: "*Escribe una contraseña",
                   minlength: "*Escribe una contraseña con al menos 4 caracteres"
                },
                contrasena2_registrarse: {
                   equalTo: "*Las contraseñas no son iguales"
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
    });
</script>