<meta property="og:image" content="<?php if($tutorial->imagen_url!='') echo base_url().$tutorial->imagen_url; else echo base_url().'resources/images/template/logos/laspartes160x97.gif'; ?>">

<link rel="image_src" href="<?php if($tutorial->imagen_url!='') echo base_url().$tutorial->imagen_url; else echo base_url().'resources/images/template/logos/laspartes160x97.gif'; ?>">

<script src="<?php echo base_url(); ?>resources/js/jquery.scrollTo.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.counter.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function() {
        <?php if(isset($scrollTo)){ ?>
            $.scrollTo('#<?php echo $scrollTo; ?>', 1500);
        <?php } ?>

        $("#registro-comentario-id").fancybox({
            'transitionIn': 'none',
            'transitionOut': 'none'
        });

        $(".registro-me-gusta").fancybox({
            'transitionIn': 'none',
            'transitionOut': 'none'
        });

        $("#publicar-tutorial-link").fancybox({
            'transitionIn': 'none',
            'transitionOut': 'none'
        });

        $("#formulario_agregar_comentario").validate({
            rules: {
                comentario: {
                    required: true
                }
            },
            messages: {
                comentario: {
                    required: "Escriba un comentario"
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

        $("#formulario_agregar_comentario_ingresar").validate({
            rules: {
                comentario_ingresar: {
                    required: true
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
                comentario_ingresar: {
                    required: "Escriba un comentario"
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

        $("#formulario_agregar_comentario_registrarse").validate({
            rules: {
                comentario_registrarse: {
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
                terminos_condiciones_registrarse: {
                    required: true
                }
            },
            messages: {
                comentario_registrarse: {
                    required: "Escriba un comentario"
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

        $("#formulario_ingresar").validate({
            rules: {
                email_ingresar_reload: {
                    required: true,
                    email: true
                },
                contrasena_ingresar_reload: {
                    required:true
                }
            },
            messages: {
                email_ingresar_reload: {
                   required: "Escriba un correo electrónico",
                   email: "Escriba un correo electrónico válido"
                },
                contrasena_ingresar_reload: {
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
                        email: function(){ return $("#email_ingresar_reload").val(); },
                        contrasena: function(){ return $("#contrasena_ingresar_reload").val(); }
                    },
                    onsubmit: false,
                    success: function(data){
                        if(data=="true")
                            window.location.reload();
                        else
                            alert('Verifique su correo electrónico y contraseña.');
                    }
                });
            }
        });

        $("#formulario_registrarse").validate({
            rules: {
                usuario_registrarse_reload: {
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
                email_registrarse_reload: {
                    required: true,
                    email: true,
                    remote: {
                        url: "<?php echo base_url(); ?>usuario/no_existe_email_ajax/",
                        type: "POST",
                        data: {
                            email: function(){ return $("#email_registrarse_reload").val(); }
                        }
                    }
                },
                contrasena_registrarse_reload: {
                    required: true,
                    minlength: 4
                },
                contrasena2_registrarse_reload: {
                    equalTo: "#contrasena_registrarse_reload"
                },
                terminos_condiciones_registrarse_reload: {
                    required: true
                }
            },
            messages: {
                usuario_registrarse_reload: {
                   required: "Escriba un usuario",
                   noSpace: "No está permitido los espacios en el usuario",
                   maxlength: 50,
                   remote: "El usuario ya está registrado"
                },
                email_registrarse_reload: {
                   required: "Escriba un correo electrónico válido",
                   email: "Escriba un correo electrónico válido",
                   remote: "El correo electrónico ya está registrado"
                },
                contrasena_registrarse_reload: {
                   required: "Escriba una contraseña",
                   minlength: "Escriba una contraseña con al menos 4 caracteres"
                },
                contrasena2_registrarse_reload: {
                   equalTo: "Las contraseñas no son iguales"
                },
                terminos_condiciones_registrarse_reload: {
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
            },
            submitHandler: function(form){
                $.ajax({
                    url: "<?php echo base_url(); ?>usuario/registrar_usuario_ajax/",
                    type: "POST",
                    data: {
                        usuario: function(){ return $("#usuario_registrarse_reload").val(); },
                        email: function(){ return $("#email_registrarse_reload").val(); },
                        contrasena: function(){ return $("#contrasena_registrarse_reload").val(); }
                    },
                    onsubmit: false,
                    success: function(data){
                        $.ajax({
                            url: "<?php echo base_url(); ?>usuario/validar_usuario_ajax/",
                            type: "POST",
                            data: {
                                email: function(){ return $("#email_registrarse_reload").val(); },
                                contrasena: function(){ return $("#contrasena_registrarse_reload").val(); }
                            },
                            onsubmit: false,
                            success: function(data){
                                if(data=="true")
                                    window.location.reload();
                                else
                                    alert('Verifique su correo electrónico y contraseña.');
                            }
                        });
                    }
                });


            }
        });

        $("#formulario_publicar_tutorial").validate({
            rules: {
                email_publicar_tutorial: {
                    email: true,
                    required: true
                },
                tutorial_publicar_tutorial: {
                    required: true
                }
            },
            messages: {
                email_publicar_tutorial: {
                    email: "Escriba un correo electrónico válido",
                    required: "Escriba un correo electrónico"
                },
                tutorial_publicar_tutorial: {
                    required: "Escriba una propuesta de tutorial"
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
            submitHandler: function(form) {
                alert("¡Muchas gracias! Próximamente estaremos en contacto con usted.");
                form.submit();
           }
        });

        var configContador = {
            'maxCharacterSize': 50,
            'displayFormat' : ''
        };
        $('#usuario_registrarse').textareaCount(configContador, function(data){});
        $('#usuario_registrarse_reload').textareaCount(configContador, function(data){});
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

    function agregar_comentario_sin_sesion(){
        document.getElementById("comentario_ingresar").value = document.getElementById("comentario").value;
        document.getElementById("comentario_registrarse").value = document.getElementById("comentario").value;
    }

    function me_gusta(id_tutorial_p){
        $(".me-gusta-decidir").hide();
        $("#me-gusta-cantidad").text(parseInt($("#me-gusta-cantidad").text())+1);
        $(".me-gusta-decision").show();
        $.ajax({
            url: "<?php echo base_url(); ?>aprende/agregar_tutorial_me_gusta_ajax/",
            type: "POST",
            data: {
                id_tutorial: id_tutorial_p,
                me_gusta: 1
            },
            onsubmit: false
        });
    }

    function no_me_gusta(id_tutorial_p){
        $(".me-gusta-decidir").hide();
        $("#no-me-gusta-cantidad").text(parseInt($("#no-me-gusta-cantidad").text())+1);
        $(".no-me-gusta-decision").show();
        $.ajax({
            url: "<?php echo base_url(); ?>aprende/agregar_tutorial_me_gusta_ajax/",
            type: "POST",
            data: {
                id_tutorial: id_tutorial_p,
                me_gusta: 0
            },
            onsubmit: false
        });
    }
</script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
{lang: 'es'}
</script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) {return;}
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>