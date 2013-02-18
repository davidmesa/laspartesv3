<meta property="og:image" content="<?php if($establecimiento->logo_url!='') echo base_url().$establecimiento->logo_url; else echo base_url().'resources/images/template/logos/laspartes160x97.gif'; ?>">

<link rel="image_src" href="<?php if($establecimiento->logo_url!='') echo base_url().$establecimiento->logo_url; else echo base_url().'resources/images/template/logos/laspartes160x97.gif'; ?>">

<meta name="viewport" content="initial-scale=1.0, user-scalable=yes" />

<link href="<?php echo base_url(); ?>resources/css/jquery.stars.css" rel="stylesheet" type="text/css"  media="screen" />

<script src="<?php echo base_url(); ?>resources/js/jquery.scrollTo.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.custom.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.stars.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.counter.js" type="text/javascript"></script>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">
    $(document).ready(function() {
        <?php if(isset($scrollTo)){ ?>
            $.scrollTo('#<?php echo $scrollTo; ?>', 1500);
        <?php } ?>

        pintarMapa();

        $("a[rel=galeria-imagenes]").fancybox({
            'transitionIn': 'none',
            'transitionOut': 'none',
            'titlePosition': 'over',
            'titleFormat': function(title, currentArray, currentIndex, currentOpts) {
                return '<span id="fancybox-title-over">Imagen ' + (currentIndex + 1) + ' de ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
            }
        });
        
        $("a.link-reportar-abuso").fancybox({
            'type'              :'iframe',
            'autoDimensions'	: false,
            'width'         	: 640,
            'height'        	: 470,
            'transitionIn'	: 'none',
            'transitionOut'	: 'none'
        });
        $("#registro-comentario-id").fancybox({
            'transitionIn': 'none',
            'transitionOut': 'none'
        });
        $("#contactar-establecimiento-id").fancybox({
            'transitionIn': 'none',
            'transitionOut': 'none'
        });

        $("#formulario_agregar_establecimiento_comentario").validate({
            rules: {
                comentario: {
                    required: true,
                    textoDiferente: true
                },
                calificacion: {
                    required: true
                }
            },
            messages: {
                comentario: {
                    required: "Escriba un comentario",
                    textoDiferente: "Escriba un comentario"
                },
                calificacion: {
                    required: "Califique al establecimiento"
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

        $("#formulario_agregar_establecimiento_comentario_ingresar").validate({
            rules: {
                comentario_ingresar: {
                    required: true,
                    textoDiferente: true
                },
                calificacion_ingresar: {
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
                    required: "Escriba un comentario",
                    textoDiferente: "Escriba un comentario"
                },
                calificacion_ingresar: {
                    required: "Califique al establecimiento"
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
                        console.log(data);
                        if(data=="true")
                            form.submit();
                        else
                            alert('Verifique su correo electrónico y contraseña.');
                    }
                });
            }
        });

        $("#formulario_agregar_establecimiento_comentario_registrarse").validate({
            rules: {
                comentario_registrarse: {
                    required: true,
                    textoDiferente: true
                },
                calificacion_registrarse: {
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
                    required: "Escriba un comentario",
                    textoDiferente: "Escriba un comentario"
                },
                calificacion_registrarse: {
                    required: "Califique al establecimiento"
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

        $("#formulario_contactar_establecimiento").validate({
            rules: {
                email_contactar: {
                    required: true,
                    email: true
                },
                asunto_contactar: {
                    required: true
                },
                mensaje_contactar: {
                    required: true
                }
            },
            messages: {
                email_contactar: {
                    required: "Escriba un correo electrónico",
                    email: "Escriba un correo electrónico válido"
                },
                asunto_contactar: {
                    required: "Escriba un asunto"
                },
                mensaje_contactar: {
                    required: "Escriba un mensaje para ser enviado"
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
        $('#usuario_registrarse').textareaCount(configContador, function(data){
             $('#usuario_registrarse_caracteres').text(data.left);
        });
    });

    $(function(){
        var $caption, $cap = $("<h4 style=\"color: #FFF; padding-top: 3px; \" />").addClass("caption");
        $(".multiField").children().hide();
        $caption = $cap.clone();
        $("#calificacion-comentario-div").stars({
                callback: function(ui, type, value){
                    document.getElementById("calificacion").value = value;
                },
                inputType: "select",
                cancelShow: false,
                captionEl: $caption
            })
        .append($caption);
    });

    $.validator.setDefaults({
        errorPlacement: function(error, element){
        }
    });
    
    $.validator.addMethod("textoDiferente",
        function(value, element){
            if(value!="Cuéntenos su experiencia con el establecimiento...")
                return true;
            else
                return false;
        },
        "Escriba un comentario"
    );

    $.validator.addMethod("noSpace",
        function(value, element){
            return value.indexOf(" ") < 0 && value != "";
        },
        "No está permitido los espacios en el usuario"
    );


    function agregar_establecimiento_comentario_sin_sesion(){
        document.getElementById("comentario_ingresar").value = document.getElementById("comentario").value;
        document.getElementById("comentario_registrarse").value = document.getElementById("comentario").value;
        document.getElementById("calificacion_ingresar").value = document.getElementById("calificacion").value;
        document.getElementById("calificacion_registrarse").value = document.getElementById("calificacion").value;
    }

    function pintarMapa() {
        var latlng = new google.maps.LatLng(<?php echo $establecimiento->lat; ?>,<?php echo $establecimiento->lng; ?>);
        var myOptions = {
            zoom: 15,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("googlemap"),myOptions);

        var markerOptions = {map: map, position: new google.maps.LatLng(<?php echo $establecimiento->lat; ?>, <?php echo $establecimiento->lng; ?>), title: '<?php echo $establecimiento->nombre; ?>'};
        var marker = new google.maps.Marker(markerOptions);
        
        var content = '<div align="center"><h4><center><b><?php echo $establecimiento->nombre; ?></b></center></h4><img src="<?php echo base_url().$establecimiento->logo_thumb_url;?>" /><div class="general_link"  align="center" valign="bottom" style="padding-top:5px;"><h4><img src="<?php echo base_url()?>resources/images/establecimientos/carrito.gif" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>establecimientos/ver_establecimiento/<?php echo $establecimiento->id_establecimiento; ?>" target="_blank">Ir al establecimiento.</a></h4></div></div>';
        var infowindow = new google.maps.InfoWindow({position: marker.getPosition(), map: map, content: content});
        
        google.maps.event.addListener(marker, 'click', function(e) {
            infowindow.open(map, marker);
        });

<?php 
    foreach($establecimientos as $e) {
?>

        var markerOptions_<?php echo $e->id_establecimiento; ?> = {map: map, position: new google.maps.LatLng(<?php echo $e->lat; ?>, <?php echo $e->lng; ?>), title: '<?php echo $e->nombre; ?>'};
        var marker_<?php echo $e->id_establecimiento; ?> = new google.maps.Marker(markerOptions_<?php echo $e->id_establecimiento; ?>);
        
        var content_<?php echo $e->id_establecimiento; ?> = '<div align="center"><h4><center><b><?php echo $e->nombre; ?></b></center></h4><img src="<?php echo base_url().$e->logo_thumb_url;?>" /><div class="general_link"  align="center" valign="bottom" style="padding-top:5px;"><h4><img src="<?php echo base_url()?>resources/images/establecimientos/carrito.gif" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>establecimientos/ver_establecimiento/<?php echo $e->id_establecimiento; ?>" target="_blank">Ir al establecimiento.</a></h4></div></div>';
        var infowindow_<?php echo $e->id_establecimiento; ?> = new google.maps.InfoWindow({position: marker_<?php echo $e->id_establecimiento; ?>.getPosition(), map: map, content: content_<?php echo $e->id_establecimiento; ?>});
        infowindow_<?php echo $e->id_establecimiento; ?>.close();
        
        google.maps.event.addListener(marker_<?php echo $e->id_establecimiento; ?>, 'click', function(e) {
            infowindow_<?php echo $e->id_establecimiento; ?>.open(map, marker_<?php echo $e->id_establecimiento; ?>);
        });
        
<?php
    }
?>

        map.panBy(50, -70);
    }
</script>