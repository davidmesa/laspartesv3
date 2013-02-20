<link href="<?php echo base_url(); ?>resources/css/autopartes.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>resources/css/registro.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>resources/css/ayuda.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.autocomplete.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>resources/css/jquery.ui.all.css" rel="stylesheet" type="text/css"  media="screen" />
<style>
    .ui-autocomplete-input
    {
        margin: 0; 
        padding: 0.30em 0 0.30em 0.45em;
        max-height: 30px;
        font-size: 13px;
    }

    .ui-menu .ui-menu-item a{
        font-family:"Lucida Sans Unicode", "Lucida Grande", sans-serif;
        font-size:13px;
        font-style:normal;
        font-weight:normal;
        padding:2px;
        margin:0;
    }

    .ui-autocomplete {
        max-height: 200px;
        overflow-y: auto;
        /* prevent horizontal scrollbar */
        overflow-x: hidden;
        /* add padding to account for vertical scrollbar */
        padding-right: 20px;
    }

    /* IE 6 doesn't support max-height
     * we use height instead, but this forces the menu to always be this tall
    */
    * html .ui-autocomplete {
        height: 200px;
    }
</style>
<script>
    $(function(){
        var vehiculos = <?php echo json_encode($allvehiculos); ?>;

        $("#solicitud-input-vehiculo").autocomplete({
            source: vehiculos,
            change: function(e, ui){
                if(!ui.item){
                    $('#solicitud-input-vehiculo-hidden').val('');
                }   
            },select: function(e, ui) {
                $('#solicitud-input-vehiculo-hidden').remove();
                var vehiculo_actual = ui.item.value,
                input = $("<input>").attr("type", "hidden").attr('value',ui.item.id_vehiculo).attr('name','vehiculo_id').attr("id", "solicitud-input-vehiculo-hidden");
                span = $("<span>").html(vehiculo_actual);
                span.insertAfter(input);
                input.insertAfter("#solicitud-input-vehiculo");
            }
        });

                
    });
    
    $("#form_solicitud").validate({
                    rules: {
                        solicitud_email: {
                            required: true,
                            email: true
                        },
                        solicitud_nombres: {
                            required: true
                        },
                        ciudad_registrarse: {
                            required: true
                        },
                        modelo: {
                            required: true
                        },
                        kilometraje: {
                            required: true
                        },
                        telefono: {
                            required: true
                        },
                        solicitud_mensaje: {
                            required: true
                        },ckbox_registrate_chkbox:{
                        required: true
                        },id_vehiculos:{
                            required: true
                        }
                    },
                    messages: {
                        solicitud_email: {
                            required: "Debes escribir tu correo electrónico",
                            email: "*Debes escribir un correo electrónico válido"
                        },
                        solicitud_nombres: {
                            required: "Debes escribir tus nombres"
                        },
                        ciudad_registrarse: {
                            required: "Debes escribir una ciudad"
                        },
                        modelo: {
                            required: "Debes escribir el modelo de tu vehículo"
                        },
                        kilometraje: {
                            required: "Debes escribir el kilometraje de tu vehículo"
                        },
                        telefono: {
                            required: "Necesitamos un teléfono de contacto"
                        },
                        solicitud_mensaje: {
                            required: "Debes escribir tu mensaje"
                        },
                        ckbox_registrate_chkbox: "Para poder ser parte debe aceptar los términos y condiciones",
                        vehiculo_id:"*Debes escribir la marca y línea de tu vehículo"
                        
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
//                            alert(message + errors);
                        }
                        validator.focusInvalid();
                    },
                    submitHandler: function(form){
                        _gaq.push(['_trackEvent', 'Registros', 'Clic', 'usuario']);
                        form.submit();
                        return false;
                    }
                });
</script>