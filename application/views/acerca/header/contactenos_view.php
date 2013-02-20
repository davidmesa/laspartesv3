<link href="<?php echo base_url() ?>resources/css/autopartes.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    $(document).ready(function() {
        $("#formulario_contactenos").validate({
            rules: {
                email_contactenos: {
                    required: true,
                    email: true
                },
                nombre_contactenos: {
                    required: true
                },
                comentarios_contactenos: {
                    required: true
                },
                captcha_contactenos: {
                    required: true
                }
            },
            messages: {
                email_contactenos: {
                   required: "*Escribe un correo electrónico válido",
                   email: "*Escribe un correo electrónico válido" 
                },
                nombre_contactenos: {
                   required: "*Escribe tu nombre"
                },
                comentarios_contactenos: {
                   required: "*Escribe tu comentario"
                },
                captcha_contactenos: {
                   required: "*Es necesario que escribas los 4 dígitos correspondientes"
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