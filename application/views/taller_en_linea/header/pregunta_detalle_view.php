<link href="<?php echo base_url() ?>resources/css/autopartes.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>resources/css/jquery.ui.all.css" rel="stylesheet" type="text/css"  media="screen" />
<script src="<?php echo base_url(); ?>resources/js/jquery.scrollTo.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.counter.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.lightbox_me.js"></script>


<script>
    //activa el lightbox cuando se hace click sobre el div de hacer contacto
        $('.lightbox-reportar').click(function(){
            $('.lightboxme-reportar').lightbox_me();  
        });
        
        $('.lightbox-reportar-respuesta').click(function(){
            var padre = $('.tallerlinea-detalle-div-respuesta').has(this);
            var val = $('.tallerlinea-detalle-input-respuesta-id', padre).val();
            $('#id_respuesta-resportar').val(val);
            $('.lightboxme-reportar-respuesta').lightbox_me();  
        });
        
        //valída el formulario de reportar respuesta
        $('form#form_reportar_respuesta').validate({
            rules: {
                comentarios_reporte: {
                    required: true
                },
                motivo_reporte: {
                    required: true
                },
                id_respuesta_resportar:{
                    required: true
                }
            },
            messages: {
                comentarios_reporte: {
                    required: "Escriba un comentario"
                },
                motivo_reporte: {
                    required: "Seleccione un motivo"
                },
                id_respuesta_resportar: "error"
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
            },submitHandler: function(form){
                var motivo_reporte = $('#motivo_reporte', form).val();
                var comentarios_reporte = $('#textarea_reportar_comentario', form).val();
                var id = $('#id_respuesta-resportar', form).val();
                var captcha = $('#captcha_registrarse', form).val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>usuario/reportar_abuso",
                    data: "id=" + id + "&motivo_reporte=" + motivo_reporte+  "&comentarios_reporte=" + comentarios_reporte+ '&tipo=respuesta'+ '&captcha_registrarse=' +captcha,
                    async: false,
                    success: function(data){
                            $('.lightbox-reportar-respuesta').trigger('close'); 
                            alert(data);
                    }
                }); 
            }
                   
        }); 
        
        //valída el formulario de reportar abuso de la pregunta
        $('form#form_reportar_pregunta').validate({
            rules: {
                comentarios_reporte: {
                    required: true
                },
                motivo_reporte: {
                    required: true
                }
            },
            messages: {
                comentarios_reporte: {
                    required: "Escriba un comentario"
                },
                motivo_reporte: {
                    required: "Seleccione un motivo"
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
            },submitHandler: function(form){
                var id = ((window.location.pathname.split('/'))[2].split('-'))[0];
                var motivo_reporte = $('#motivo_reporte', form).val();
                var comentarios_reporte = $('#textarea_reportar_comentario', form).val();
                var captcha = $('#captcha_registrarse', form).val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>usuario/reportar_abuso",
                    data: "id=" + id + "&motivo_reporte=" + motivo_reporte+  "&comentarios_reporte=" + comentarios_reporte+ '&tipo=pregunta' + '&captcha_registrarse=' +captcha,
                    async: false,
                    success: function(data){
                            $('.lightboxme-reportar').trigger('close'); 
                            alert(data); 
                    }
                }); 
            }
                   
        }); 
 
    $('#tallerlinea-input-submit-link').click(function(){
        $('html, body').animate({
            scrollTop: $("#tallerlinea-detalle-div-responder").offset().top
        }, 800);
    });
 

    $("form#forma-responder").validate({
        rules: {
            respuesta: {
                required: true
            }
        },
        messages: {
            respuesta: {
                required: "Escriba una respuesta"
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
        },submitHandler: function(form){
            $.ajax({
                url: '<?php echo base_url(); ?>usuario/dar_sesion_activa_ajax',
                type: "POST",
                success: function(data) {
                    var sesion = data;
                    if(sesion){
                        var respuesta = $('#tallerlinea-textarea-respuesta').val();
                        var id_pregunta = ((window.location.pathname.split('/'))[2].split('-'))[0];
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>taller_en_linea/agregar_respuesta",
                            data: "respuesta=" + respuesta + "&id_pregunta=" + id_pregunta,
                            async: false,
                            success: function(data){
                                var corrio = data.split('|');
                                if(corrio[0] == 'false')
                                    alert('No se pudo agregar su respuesta, favor intentar denuevo más tarde\n'. corrio[1]);
                                else{
                                    $('#tallerlinea-detalle-div-respuestas').append(data);
                                    $('#tallerlinea-textarea-respuesta').val('');
                                }
                        
                            }
                        }); 
                    }else{
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>usuario/mostrar_registro_ajax",
                            async: false,
                            success: function(data){
                                $('#registro-login-div').empty();
                                $('#registro-login-div').html(data);
                                $('#input-registro-callback').val('registarPregunta');
                                $('#registro-login-div').lightbox_me(); 
                            }
                        });
                        return false; 
                    }
                }
            });
            return false;               
        }
    }); 
    
    function registarPregunta(){
        $('#registro-login-div').trigger('close');
        var respuesta = $('#tallerlinea-textarea-respuesta').val();
        var id_pregunta = ((window.location.pathname.split('/'))[2].split('-'))[0];
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>taller_en_linea/agregar_respuesta",
            data: "respuesta=" + respuesta + "&id_pregunta=" + id_pregunta,
            async: false,
            success: function(data){
                var corrio = data.split('|');
                if(corrio[0] == 'false')
                    alert('No se pudo agregar su respuesta, favor intentar denuevo más tarde\n'. corrio[1]);
                else{
                    $('#tallerlinea-detalle-div-respuestas').append(data);
                    $('#tallerlinea-textarea-respuesta').val('');
                    alert('Tu respuesta ha sido agregada');
                }
                        
            }
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