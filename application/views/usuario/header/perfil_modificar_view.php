<script type="text/javascript">
    $(document).ready(function() {
        $("#formulario_modificar_perfil").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                email2: {
                    equalTo: "#email"
                },
                usuario: {
                    required: true,
                    noSpace: true,
                    minlength: 4,
                    maxlength: 50
                },
                contrasena: {
                    minlength: 4
                },
                contrasena2: {
                    equalTo: "#contrasena"
                }
            },
            messages: {
                email: {
                    required: "Escriba un correo electrónico",
                    email: "Escriba un correo electrónico válido"
                },
                email2: {
                    equalTo: "Los 2 correos electrónicos escritos no son iguales"
                },
                usuario: {
                    required: "Escriba un usuario",
                    noSpace: "Escriba un usuario sin espacios",
                    minlength: "Escriba un usuario con mínimo 4 caracteres",
                    maxlength: "Escriba un usuario con máximo 50 caracteres"
                },
                contrasena: {
                   minlength: "Escriba una contraseña con al menos 4 caracteres"
                },
                contrasena2: {
                    equalTo: "Las contraseñas no son iguales"
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