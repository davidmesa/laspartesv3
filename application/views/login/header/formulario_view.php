<link href="<?php echo base_url() ?>resources/css/autopartes.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>resources/css/registro.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.autocomplete.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>resources/css/jquery.ui.all.css" rel="stylesheet" type="text/css"  media="screen" />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<script src="<?php echo base_url(); ?>resources/js/ajaxfileupload.js" type="text/javascript"></script>
<style>

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
    _gaq.push(['_trackEvent', 'registro', 'RRegistro']);
    //le hace autocomplete a la marca del carro, cuando se selecciona una marca,
    // por ajax se cargan las líneas correspondientes
    $(function(){
        var vehiculosMarca = <?php echo json_encode($allmarcas); ?>;

        $("#input_vehiculo_marca").autocomplete({
            source: vehiculosMarca,
            change: function(e, ui){
                $('#input_vehiculo_linea').val('');
            },select: function(e, ui) {
                $('#input_vehiculo_linea').val('');
                var marca_actual = ui.item.value;
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>usuario/dar_linea_vehiculos_marca_ajax",
                    async: false,
                    data: "marca=" + marca_actual,
                    success: function(data){
                        var lineas = $.parseJSON(data);
                        $("#input_vehiculo_linea").autocomplete({
                            source: lineas
                        });
                    }
                });    
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
        errorClass: "form-invalid",
        validClass: "form-valid",
        highlight: function(element, errorClass, validClass) {
            $(element).addClass(errorClass);
            var divValid =  $(element.form).find("div[for=" + element.id + "]");
            divValid.addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass(errorClass);
            var divValid =  $(element.form).find("div[for=" + element.id + "]");
            divValid.addClass(validClass).removeClass(errorClass);
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
            $(form).bind('click');
            $('.ajax_img_loader', form).show();
            $.ajax({
                url: "<?php echo base_url(); ?>usuario/registrar_usuario_ajax",
                type: "POST",
                data: {
                    input_registrate_nombre: function () {
                        return $("#input-registrate-nombre", form).val()
                    },
                    input_registrate_apellidos: function () {
                        return $("#input-registrate-apellidos", form).val()
                    },
                    ciudad_registrarse: function () {
                        return $("#input-registrate-ciudad", form).val()
                    },
                    input_registrate_usuario: function () {
                        return $("#input-registrate-usuario", form).val()
                    },input_registrate_telefono: function () {
                        return $("#input-registrate-telefono", form).val()
                    },
                    input_registrate_email: function () {
                        return $("#input-registrate-email", form).val()
                    },
                    input_registrate_contrasena: function () {
                        return $("#input-registrate-contrasena", form).val()
                    },
                    input_registrate_contrasena_repite: function () {
                        return $("#input-registrate-contrasena-repite", form).val()
                    },
                    ckbox_registrate_chkbox: function () {
                        return $("#ckbox-registrate-chkbox", form).val()
                    },
                    vehiculo_id: function () {
                        return $("#input-registrate-vehiculo-hidden", form).val()
                    },
                    vehiculo: function () {
                        return $("#input-registrate-vehiculo", form).val()
                    },
                    captcha_registrarse: function () {
                        return $("#input_login_captcha", form).val()
                    }
                },
                onsubmit: false,
                success: function (data) {
                    data = JSON.parse(data); 
                    if (data.status==true) {
                        _gaq.push(['_setCustomVar', '1' ,'login', 'user_'+data.msg, '1']);
                        _gaq.push(['_trackEvent', 'login', 'RRegistro']);
                        _gaq.push(['_deleteCustomVar', 1]);
                        cambiarHeaderSesion();
                        $('.login-div-registro').hide();
                        $('.login-div-vehiculo').show();
                    } else {
                        alert(data.msj)
                    }
                }
            });
            $('.ajax_img_loader', form).hide();
            $(form).unbind('click');
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
        errorClass: "form-invalid",
        validClass: "form-valid",
        highlight: function(element, errorClass, validClass) {
            $(element).addClass(errorClass);
            var divValid =  $(element.form).find("div[for=" + element.id + "]");
            divValid.addClass(errorClass).removeClass(validClass);
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass(errorClass);
            var divValid =  $(element.form).find("div[for=" + element.id + "]");
            divValid.addClass(validClass).removeClass(errorClass);
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
                success: function(data, status){
                    data = JSON.parse(data); 
                    if(data.status==true){
                        _gaq.push(['_setCustomVar', '1' ,'login', 'user_'+data.msg, '1']);
                        _gaq.push(['_trackEvent', 'login', 'NLogin']);
                        _gaq.push(['_deleteCustomVar', 1]);
                        window.location = "<?php echo base_url() . 'usuario'; ?>";
                    }else
                        alert('Usuario o contraseña incorrectos');
                }
            });
        }
    });
    
    //Valida el formulario de login
    $("#form_vehiculo").validate({
        rules: {
            input_vehiculo_marca: {
                required: true,
                maxlength: 20
            },
            input_vehiculo_linea: {
                required: true,
                maxlength: 30
            },
            input_vehiculo_kilometraje: {
                required: true,
                number: true
            },
            input_vehiculo_modelo: {
                required: true,
                number: true
            },
            input_vehiculo_palca: {
                maxlength: 7
            }
        },
        messages: {
            input_vehiculo_marca: {
                required: "*Debes ingresar la marca de tu carro",
                maxlength: "*La marca del carro no puede contener más de 20 caracteres"
            },
            input_vehiculo_linea: {
                required: "*Debes ingresar la línea de tu carro",
                maxlength: "*La marca del carro no puede contener más de 30 caracteres"
            },
            input_vehiculo_kilometraje: {
                required: "*Debes ingresar el kilometraje de tu carro",
                number: "*El kilometraje debe ser un número"
            },
            input_vehiculo_modelo: {
                required: "*Debes ingresar el modelo de tu carro",
                number: "*El modelo de tu carro debe ser un número"
            },
            input_vehiculo_palca: {
                maxlength: "*La placa no puede tener más de 7 caracteres"
            }
        }, 
        errorClass: "form-invalid",
        validClass: "form-valid",
        highlight: function(element, errorClass, validClass) {
            $(element).addClass(errorClass);
            var divValid =  $(element.form).find("div[for=" + element.id + "]");
            divValid.addClass(errorClass);
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass(errorClass).removeClass(validClass);
            var divValid =  $(element.form).find("div[for=" + element.id + "]");
            divValid.addClass(validClass).removeClass(errorClass);
        },
        invalidHandler: function (form, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                var message = errors == 1 ? 'Se encontró el siguiente error:\n' : 'Se encontraron los siguientes ' + errors + ' errores:\n';
                var errors = "";
                if (validator.errorList.length > 0) {
                    for (x = 0; x < validator.errorList.length; x++) {
                        errors += "\n\u25CF " + validator.errorList[x].message
                    }
                }
                alert(message + errors)
            }
            validator.focusInvalid()
        },
        submitHandler: function (form) {
            $(form).bind('click');
            $('.ajax_img_loader', form).show();
            $.ajax({
                url: "<?php echo base_url(); ?>usuario/agregar_vehiculo_registro_ajax",
                type: "POST",
                data: {
                    input_vehiculo_marca: function () {
                        return $("#input_vehiculo_marca", form).val()
                    },input_vehiculo_linea: function () {
                        return $("#input_vehiculo_linea", form).val()
                    },input_vehiculo_kilometraje: function () {
                        return $("#input_vehiculo_kilometraje", form).val()
                    },input_vehiculo_modelo: function () {
                        return $("#input_vehiculo_modelo", form).val()
                    },input_vehiculo_placa: function () {
                        return $("#input_vehiculo_placa", form).val()
                    }
                },
                onsubmit: false,
                success: function (data) {
                    if (data == 'true') {
                        try{
                            var imagen = $("#input_vehiculo_imagen").val();
                            if( imagen != "" || imagen != null){
                                subirFotoVehiculo();
                            }
                            //según el carro registrado, se carga la hoja de mto
                            cargarHojaMto();
                            
                            //se muestra la vista de hoja de mto
                            $('.login-div-vehiculo').hide();
                            $('.login-div-historial').show();
                        }catch(e){
                            //según el carro registrado, se carga la hoja de mto
                            cargarHojaMto();
                            $('.login-div-vehiculo').hide();
                            $('.login-div-historial').show();
                        }
                        $('#ajax_loadingDiv').hide(); 
                    } else{
                        alert((data.split('|'))[1]);
                    }
                }
            });
            $('.ajax_img_loader', form).hide();
            $(form).unbind('click');
        }
    });
    
    //Sube la foto del vehiculo
    function subirFotoVehiculo(){
        $.ajaxFileUpload({
            url         :'/usuario/subir_imagen_vehiculo_ajax',
            secureuri      :false,
            fileElementId  :'input_vehiculo_imagen',
            dataType    : 'json'
        });
    }
    
    //Muestra un preview de la foto
    function fotoPreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#foto_form_marco img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    
    //Carga la hoja de mto del carro ingresado por el usuario
    function cargarHojaMto(){
        $.ajax({
            url: "<?php echo base_url(); ?>usuario/dar_hojamto_ajax",
            type: "POST",
            onsubmit: false,
            success: function (data) {
                $('#loging-div.login-div-historial').append(data);
            }
        });
    }
</script>

