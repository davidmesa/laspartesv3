<link href="<?php echo base_url() ?>resources/css/autopartes.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>resources/css/jquery.stars.css" rel="stylesheet" type="text/css"  media="screen" />
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.stars.js" type="text/javascript"></script>
<script>
    
    $('.talleres-detalle-opinar-calificacion-estrella').live('click',function(e){
        $('.estrella-elegida').removeClass('estrella-elegida');
        $(this).addClass('estrella-elegida');
        $('img', this).attr('src','<?php echo base_url(); ?>resources/images/autopartes/estrella-roja.png');
        $('.talleres-detalle-opinar-calificacion-estrella-tag',this).css('color','#c60200');

    });
    
    //pone las estrellas del color que tienen que ser
    $(function(){
        var $caption, $cap = $("<h4 style=\"color: black; padding-top: 35px; \" />").addClass("caption");
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
    
    //valída el formulario de contacto en línea
        $('form#formulario_califica_experiencia').validate({
            rules: {
                mensaje: {
                    required: true
                },
                calificacion: {
                    required: true
                }
            },
            messages: {
                mensaje: {
                    required: "Escriba un comentario"
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
            },submitHandler: function(form){
                alert('Gracias por comentar tu experiencia');
                form.submit();
            }
                   
        }); 
</script>