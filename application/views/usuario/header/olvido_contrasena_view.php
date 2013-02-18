<link href="<?php echo base_url() ?>resources/css/autopartes.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    $(document).ready(function() {
        $("#formulario_olvido_contrasena").validate({
            rules: {
                email_registrarse: {
                    required: true,
                    email: true,
                    remote: {
                        url: "<?php echo base_url(); ?>usuario/existe_email_ajax/",
                        type: "POST",
                        data: {
                            email: function(){ return $("#email_registrarse").val(); }
                        }
                    }
                }
            },
            messages: {
                email_registrarse: {
                   required: "Escriba un correo electrónico válido",
                   email: "Escriba un correo electrónico válido",
                   remote: "El correo electrónico no está registrado"
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
    });
</script>