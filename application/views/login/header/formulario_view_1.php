<link href="<?php echo base_url() ?>resources/css/autopartes.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>resources/css/registro.css" rel="stylesheet" type="text/css" />
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

        $("#input-registrate-vehiculo").autocomplete({
            source: vehiculos,
            change: function(e, ui){
                if(!ui.item){
                    $('#input-registrate-vehiculo-hidden').val('na');
                }   
            },select: function(e, ui) {
                $('#input-registrate-vehiculo-hidden').remove();
                var vehiculo_actual = ui.item.value,
                input = $("<input>").attr("type", "hidden").attr('value',ui.item.id_vehiculo).attr('name','vehiculo_id').attr("id", "input-registrate-vehiculo-hidden");
                span = $("<span>").html(vehiculo_actual);
                span.insertAfter(input);
                input.insertAfter("#input-registrate-vehiculo");
            }
        });

                
    });
    
    var validator = $('form#form_registro').validate({
            rules:{
                input_registrate_nombre:{
                    required: true
                },input_registrate_apellidos:{
                    required: true
                },input_registrate_usuario:{
                    required: true,
                    maxlength: 35,
                    minlength: 4,
                    remote: {
                        url: "<?php echo base_url(); ?>usuario/no_existe_usuario_ajax",
                        type: "post",
                        data: {
                                usuario: function() {
                                        return $("#input-registrate-usuario").val();
                                }
                        }
                }
                },input_registrate_email:{
                    required: true,
                    email: true,
                    remote: {
                        url: "<?php echo base_url(); ?>usuario/no_existe_email_ajax",
                        type: "post",
                        data: {
                                email: function() {
                                        return $("#input-registrate-email").val();
                                }
                        }
                }
                },input_registrate_contrasena:{
                    required: true,
                    maxlength: 35,
                    minlength: 4
                },input_registrate_contrasena_repite:{
                    required: true,
                    maxlength: 35,
                    minlength: 4,
                    equalTo: '#input-registrate-contrasena'
                },ckbox_registrate_chkbox:{
                    required: true
                },vehiculo_id:{
                    required: true
                },
                captcha_registrarse: {
                        required: true
                },select_registrate_kilometraje:{
                     number: true
                }
            },
            
            messages: {
                input_registrate_nombre: "*Debes ingresar tus nombres",
                input_registrate_apellidos: "*Debes ingresar tus apellidos",
                input_registrate_usuario: {
                    required: "*Debes escribir un nombre de usuario",
                    remote: "*Este es un nombre de usuario ya registrado",
                    maxlength: "*El número máximo de caracteres permitidos es de 35",
                    minlength: "*Debes ingresar más de 4 caracteres"
                },
                input_registrate_email: {
                    required: "*Debes ingresar una dirección de correo válida",
                    email: "*Debe ser un correo válido",
                    remote: "*Este correo ya está registrado"
                },
                input_registrate_contrasena: {
                    required: "*Debes ingresar tu contraseña",
                    maxlength: "*El número máximo de caracteres permitidos es de 35",
                    minlength: "*Debes ingresar más de 4 caracteres"
                },
                input_registrate_contrasena_repite: {
                    required: "*Debes ingresar tu contraseña",
                    equalTo: "*Debe ser el mismo valor de la contraseña anterior",
                    maxlength: "*El número máximo de caracteres permitidos es de 35",
                    minlength: "*Debes ingresar más de 4 caracteres"
                },
                ckbox_registrate_chkbox: "*Para poder ser parte debe aceptar los términos y condiciones",
                vehiculo_id:"*El vehículo que especificaste no se encuentra registrado en nuestra base de datos",
                captcha_registrarse: "*Debes ingresar el valor del captcha",
                select_registrate_kilometraje: "*El kilometraje debe ser un valor numérico"
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
               _gaq.push(['_trackEvent', 'Registros', 'Clic', 'usuario']);
                form.submit();
                return false;
            },
            errorPlacement: null
                   
        }); 
        
        //valida el formulario de login
        $("#form_login").validate({
                    rules: {
                        input_login_email: {
                            required: true,
                            email: true
                        },
                        input_login_contrasena: {
                            required: true
                        }
                    },
                    messages: {
                        input_login_email: {
                            required: "*Debes escribir tu correo electrónico",
                            email: "*Debes escribir un correo electrónico válido"
                        },
                        input_login_contrasena: {
                            required: "*Debes escribir tu contraseña"
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
                            url: "<?php echo base_url(); ?>usuario/validar_usuario_ajax",
                            type: "POST",
                            data: {
                                email: function(){ return $(".input_login_email", form).val(); },
                                contrasena: function(){ return $(".input_login_contrasena", form).val(); }
                            },
                            onsubmit: false,
                            success: function(data){
                                if(data == 'true'){
                                    window.location.replace('<?php echo base_url().'usuario';?>'); 
                                
                                }else if(data == 'false'){
                                    alert('Usuario o contraseña incorrectos');
                                }
                            }
                        });
                    }
                });
</script>

