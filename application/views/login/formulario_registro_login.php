<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<script src="<?php echo base_url(); ?>resources/js/ajaxfileupload.js" type="text/javascript"></script>
<style type="text/css">
    #loging-div div.form-valid{
        position: absolute;
        right: -20px;
        top: 30px;
        background-image: url('../../resources/admin/images/checkmark.gif');
        background-repeat: no-repeat;
        width: 12px;
        height: 9px;
    }

    #loging-div div.form-invalid{
        position: absolute;
        right: -20px;
        top: 30px;
        background-image: url('../../resources/admin/images/x-red.gif');
        background-repeat: no-repeat;
        width: 9px;
        height: 9px;
    }

    #loging-div label.form-valid{
        margin-top: 0px;
    }

    #loging-div label.form-invalid{
        margin-top: 0px;
    }  
    
    #form_historial label.form-invalid{
        width: 150px;
    }  

    .form_login_div_campo{
        position: relative;
    }

    #loging-div
    { width:605px; }

   #loging-div.login-div-vehiculo, #loging-div.login-div-historial
    { width:600px; 
      display: none;
    }

    #login-div-top
    { width:605px; }


    #login-div-top-texto
    { font:12px open_sansregular;
      position:relative;
      background-color: #ef0600;
      text-align:center;
      color: white;
      border: 1px solid #c60200;
      border-top-right-radius: 5px;
      border-top-left-radius: 5px;
      padding:10px; }

    #login-div-center
    { margin-top:2px;
      position:relative;
      background-color: #f5f5f5;
      border: 1px solid #ccc;
      padding-bottom: 10px;
    }

    #login-div-center.sesion-login{
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px; 
    }

    #login-div-center.sesion-vehiculo, #login-div-center.sesion-historial{
        border-radius: 5px;
        padding:10px;
    }

    #login-div-registrate
    { background-color: #f5f5f5;
      float:right;
      width: 250px;
      color: #404040;
      font-family:open_sansregular; 
      background-image:url(../../resources/images/login/separador.png);
      background-position:left;
      background-repeat:repeat-y;
      padding-left: 20px;
      padding-right: 50px;
    }

    .sesion-login #login-div-sesion
    { background-color: #f5f5f5;
      float:left;
      width: 210px;
      color: #404040;
      font-family:open_sansregular;
      padding-left: 20px;
      padding-right: 50px; }

    #login-div-titulo
    { padding-top:15px;
      margin-left:10px;
      font:25px univers_condensedbold; }

    .sesion-vehiculo #login-div-titulo, .sesion-historial #login-div-titulo{
        font:20px univers_condensedbold;
    }


    #login-div-titulo span
    { margin-left:5px;
      position:relative;
      top:3px; }



    #form_login label, #form_login input, #form_registro label, #form_registro input
    { display:block; }

    #form_registro label,#form_login label, #form_historial label
    { 
        margin-top: 10px;
    }

    #loging-div input[type=text], #loging-div input[type=password], #loging-div select{
        background-color: #f9f9f9;
        border: 2px solid #b5b5b5;
        moz-border-radius: 5px;
        webkit-border-radius: 5px; 
        border-radius: 5px;
        outline:none;
        color: black;
        font-family:open_sansregular; 
    }

    #loging-div label{
        color: #404040;
        font-size:11px;
        display: block;

    }

    .form_registro_input , #form_registro select, #form_login input[type=text], #form_login input[type=password], .form_vehiculo_input, #form_vehiculo select
    { 

        padding: 10px 10px; 
        margin-top: 3px;}

    #form_registro .form_registro_input, #form_registro select{
        width: 196px;
    }
    #form_registro .form_registro_ie_select{
        width: 220px;  
    }
    #form_vehiculo .form_vehiculo_input{
        width: 255px;	
    }

    .form_login_input
    { width:156px;}

    #form_historial input[type=text]{
        width:70px;
        padding: 5px 5px;
        margin-top: 3px;
    }

    #loging-div input[type=text]:focus, #loging-div input[type=password]:focus
    { outline:none;
      border: 2px solid #c60200;
      background-color: #fbfbfb;
      -webkit-box-shadow: 0px 0px 5px #c60200;
      -moz-box-shadow:    0px 0px 5px #c60200;
      box-shadow:         0px 0px 5px #c60200;
    }


    #form_registro #ckbox-registrate-chkbox
    { display:inline; }

    #form_registro #label-registrate-condiciones
    { font-size:11px;
      margin-top:0;
      margin-left:10px;
      position:absolute;
      top:4px; 
      right: 20px;}

    #form_registro #label-registrate-condiciones span
    { text-decoration:underline;
      font-style:italic;
      cursor:pointer;
      color: #404040; }

    #form_registro #label-registrate-condiciones a
    { cursor:pointer;
      color:#FFF;
      text-decoration:none; }

    #loging-div input[type=submit] {
        float:right;
        margin-top:20px;
        cursor: pointer;
        background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ebe8eb), color-stop(1, #a8a5a8) );
        background:-moz-linear-gradient( center top, #ebe8eb 5%, #a8a5a8 100% );
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ebe8eb', endColorstr='#a8a5a8');
        background-color:#ebe8eb;
        -moz-border-radius:5px;
        -webkit-border-radius:5px;
        border-radius:5px;
        border:1px solid #8f8f8f;
        display:inline-block;
        color:#4a4a4a;
        font-family:arial;
        font-size:15px;
        font-weight:bold;
        padding:6px 24px;
        text-decoration:none;
        text-shadow:1px 1px 0px #c7c7c7;
    }

    #form_login input[type=submit]{
        margin-top: 0px;	
    }

    #loging-div input[type=submit]:hover {
        background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #a8a5a8), color-stop(1, #ebe8eb) );
        background:-moz-linear-gradient( center top, #a8a5a8 5%, #ebe8eb 100% );
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#a8a5a8', endColorstr='#ebe8eb');
        background-color:#a8a5a8;
    }
    #loging-div input[type=submit]:active {
        position:relative;
        top:1px;
    }
    /* This imageless css button was generated by CSSButtonGenerator.com */

    #login-div-ingresarolvidar input
    { float:right;}

    #login-div-olvide
    { float:left;
      width:50px; }

    #login-div-olvide a
    { text-decoration:underline;
      color:#404040;
      font-size:11px;
      cursor:pointer; }

    #form_registro label.error,#form_login label.error
    { margin-top:0; }

    #form_registro,#form_login
    { margin-left:30px; }

    #form_registro #select-registrate-modelo,#login-div-ingresarolvidar
    { margin-top:20px; position: relative;}

    #home-div-facebook-button{
        display: block;
        width: 100%;	
        cursor: pointer;
    }

    .div_campo_chkbox{
        margin-top: 5px;
    }

    #form_vehiculo select{
        width: 110px;	
    }

    #vehiculo_form_div_kilo{
        float: left;
    }

    #vehiculo_form_div_model{
        float: right;
    }

    #vehiculo_div_form{
        margin-top: 10px;
        font-family:open_sansregular;
        padding-left: 30px; 
        float: left; 
        margin-left: 50px;	
    }

    #form_vehiculo input 
    { display:block; }

    #form_vehiculo label
    { font-size:11px;
      margin-top: 10px;
    }
    
    #form_vehiculo_file label{
        font-size:11px;
        margin-bottom: 5px;
        font-family:open_sansregular;
    }

    #foto_div_form{
        float: left;
        margin-top: 30px;
        max-width:188px;
        color: transparent;
    }

    #foto_form_marco{
        padding: 2px;
        background-color: white;
        border: 1px solid #ccc;	
        border-radius: 5px;
        margin-bottom: 5px;
    }

    #foto_form_marco img{	
        border-radius: 5px;
        max-width:182px;
    }

    #login-div-progreso{
        text-align: center;	
    }

    #login-div-progreso div{
        float:left;
        color: white;
        padding: 10 13px;
        font:25px univers_condensedbold;
    }

    #login-div-progreso-vehiculo{
        background-color:#ccc;
        border:1px solid #ccc;
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        -moz-border-radius-bottomleft: 5px;
        -moz-border-radius-topleft: 5px;
        -webkit-border-bottom-left-radius: 5px;
        -webkit-border-top-left-radius: 5px;
        float: left;
        color:#4a4a4a;
        font-family:arial;
        font-size:15px;
        font-weight:bold;
        padding:6px 14px;
        text-decoration:none;
    }

    #login-div-progreso-historial{
        background-color:#ccc;
        border:1px solid #ccc;
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
        -moz-border-radius-bottomright: 5px;
        -moz-border-radius-topright: 5px;
        -webkit-border-bottom-right-radius: 5px;
        -webkit-border-top-right-radius: 5px;
        float: left;
        color:#4a4a4a;
        font-family:arial;
        font-size:15px;
        font-weight:bold;
        padding:6px 12px;
        text-decoration:none;
    }

    #login-div-progreso .login-div-progreso-selected{
        background-color:#ef0600;
        border:1px solid #c60200;
    }
    #form_historial{
        margin-top: 10px;
        font-family:open_sansregular;
        margin-left: 50px;	
    }

    #slider{
        width: 300px;	
        display: block;
    }

    .historial_div_slider div{
        float: left;	
    }

    .historial_div_slider{
        color: #404040;		
    }

    .historial_div_slider_kms{
        position: relative;
        margin-left: 20px;	
    }
    
    .historial_div_slider_kms span{
        position: absolute;
        top: 31px;
        left: 88px;
    }

    .historial_div_slider_tarea{
        position:relative;
        padding-bottom: 20px;
        padding-right: 30px;
        margin-bottom: 20px;
    }
    .historial_div_slider_tarea label{
        margin-bottom: 5px;	
    }

    .historial_div_slider_tarea_dotted{
        position: absolute;
        right: 30px;
        bottom: 13px;
        width: 300px;
        height: 3px;
        border-bottom: 1px dashed #ccc;
        border-right: 1px solid #ccc; 	
        border-left: 1px solid #ccc; 
    }

    .historial_div_slider_tarea_rango{
        position: absolute;
        bottom: 0px;
        font:10px open_sansregular;
    }

    .historial_div_slider_tarea_rango.meses_6{
        left: 130px;
    }

    .historial_div_slider_tarea_rango.meses_12{
        right: 10px;	
    }

    .historial_div_slider_tarea_msj{
        position: absolute;
        padding: 4px;
        left: -18px;
        bottom: -13px;
        border: 1px solid #c60200;
        background-color: #FF0000;
        border-radius: 5px;
        color:white;	
        font-size: 12px;
        z-index: 100;
    }

    .historial_div_slider_tarea_apuntador{
        position: absolute;
        top: 47px;
        left: -4px;
        background-image:url(../../resources/images/login/triangulo-rojo.fw.png);
        background-repeat:no-repeat;
        width: 13px;
        height: 7px;
        z-index: 101;
    }
    
    .ajax_img_loader{
        position: absolute;
        bottom: 10px;
        right: -20px;
        display: none;
    }
    
    .div-registrate-submit{
        position: relative;
    }

    .div_quisiste_decir{
    display: none;
    }

    #quisiste_decir{
        text-decoration: underline;
        font-size: 18px;
        color: #ef0600;
        cursor: pointer;
        font-style: italic;
        font-weight: bold;
        width: 270px;
    }
</style>
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
    _gaq.push(['_trackEvent', 'registro', 'LRegistro']);
    cargarHojaMto();
    //le hace autocomplete a la marca del carro, cuando se selecciona una marca,
    // por ajax se cargan las líneas correspondientes
    $(function(){
        var vehiculosMarca = <?php echo json_encode($allmarcas); ?>;

        $("#input_vehiculo_marca").autocomplete({
            source: vehiculosMarca,
            change: function(e, ui){
                $('#input_vehiculo_linea').val('');
                $('#nuevo_carro').val(1);
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
                            source: lineas,
                            select: function(){
                                $('#nuevo_carro').val(0);
                            }
                        });

                    }
                });    
            }
        });         
    });
    
    //Valida el formulario de registro
    var validator = $('form#form_registro').validate({
        rules: {
            input_registrate_nombre: {
                required: true
            },
            input_registrate_apellidos: {
                required: true
            },
            input_registrate_usuario: {
                required: true,
                maxlength: 35,
                minlength: 4,
                remote: {
                    url: "<?php echo base_url(); ?>usuario/no_existe_usuario_ajax",
                    type: "post",
                    data: {
                        usuario: function () {
                            return $("#input-registrate-usuario").val()
                        }
                    }
                }
            },
            input_registrate_email: {
                required: true,
                email: true,
                remote: {
                    url: "<?php echo base_url(); ?>usuario/no_existe_email_CRM_ajax",
                    type: "post",
                    data: {
                        email: function () {
                            return $("#input-registrate-email").val()
                        }
                    }
                }
            },
            input_registrate_contrasena: {
                required: true,
                maxlength: 35,
                minlength: 4
            },
            input_registrate_contrasena_repite: {
                required: true,
                maxlength: 35,
                minlength: 4,
                equalTo: '#input-registrate-contrasena'
            },
            ckbox_registrate_chkbox: {
                required: true
            },
            captcha_registrarse: {
                required: true
            }
        },
        messages: {
            input_registrate_nombre: "*Debes escribir tu nombre",
            input_registrate_apellidos: "*Debes escribir tu apellido",
            input_registrate_usuario: {
                required: "*Debes escribir un nombre de usuario",
                remote: "*Es un nombre de usuario ya registrado",
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
            ckbox_registrate_chkbox: "*Para poder ser parte debes aceptar los términos y condiciones",
            captcha_registrarse: "*Debes ingresar el valor del captcha"
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
        submitHandler: function (form) {
            _gaq.push(['_trackEvent', 'Registros', 'Clic', 'usuario']);
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
                    var callback = $('#input-registro-callback').val();
                    if (data.status==true && callback.length > 0) {
                        
                        _gaq.push(['_setCustomVar', '1' ,'login', 'user_'+data.msg, '1']);
                        _gaq.push(['_trackEvent', 'login', 'LBRegistro']);
                        _gaq.push(['_deleteCustomVar', 1]);
                        cambiarHeaderSesion(); 
                        try {
                            $('.login-div-registro').hide();
                            $('.login-div-vehiculo').show();
                            //                            window[callback]()
                        } catch (e) {
                            alert(e)
                        }
                    } else {
                        alert(data.msg);
                    }
                }
            });
            $('.ajax_img_loader', form).hide();
            $(form).unbind('click');
        },
        errorPlacement: null
    });
    
    //Valida el formulario de login
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
                url: "<?php echo base_url(); ?>usuario/validar_usuario_ajax",
                type: "POST",
                data: {
                    email: function () {
                        return $(".input_login_email", form).val()
                    },
                    contrasena: function () {
                        return $(".input_login_contrasena", form).val()
                    }
                },
                onsubmit: false,
                success: function (data) {
                    data = JSON.parse(data);
                    var callback = $('#input-registro-callback').val();
                    if (data.status == true && callback.length > 0) {
                        _gaq.push(['_setCustomVar', '1' ,'login', 'user_'+data.msg, '1']);
                        _gaq.push(['_trackEvent', 'login', 'LBLogin']);
                        _gaq.push(['_deleteCustomVar', 1]);
                        cambiarHeaderSesion();
                        try {
                            window[callback]()
                        } catch (e) {
                            alert(e)
                        }
                    } else {
                        alert('Usuario o contraseña incorrectos')
                    }
                }
            });
            $('.ajax_img_loader', form).hide();
            $(form).unbind('click');
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
            var marca = $("#input_vehiculo_marca", form).val();
            var linea = $("#input_vehiculo_linea", form).val(); 
            var nuevo_carro = $('#nuevo_carro').val();
            if(nuevo_carro == 1){
                confirmNO('El carro <strong>'+ marca+' '+linea+'</strong> no aparece en el sistema, está seguro que desea registrar este carro', function () {
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
                    $.modal.close();
                });
            }else{
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
        }
    });

$('#input-vehiculo-submit').attr('disabled', 'disabled');
    $('#form_vehiculo').bind('submit',function(e){e.preventDefault();});
    var globalTimeout = null;  
    //Busca la referencia del carro más parecida
    $('#input_vehiculo_marca, #input_vehiculo_linea').change(function() {
        $('#input-vehiculo-submit', this).attr('disabled', 'disabled');
        $('#form_vehiculo').bind('submit',function(e){e.preventDefault();});

        var marca = $('#input_vehiculo_marca').val();
        var linea = $('#input_vehiculo_linea').val();
        if(marca.length > 0 && linea.length > 0){
            if (globalTimeout != null) {
                clearTimeout(globalTimeout);
              }
              globalTimeout = setTimeout(function() {
                globalTimeout = null;  

                $.ajax({
                    url: "<?php echo base_url(); ?>usuario/buscar_vehiculo_similar_ajax",
                    type: "POST",
                    data: {
                        vehiculo: marca+' '+linea
                    },
                    onsubmit: false,
                    success: function(data, status){
                        if(data !== 'true'){
                            data = JSON.parse(data); 
                            var carro = data.marca +' '+ data.linea;
                            $('#quisiste_decir').text(carro);
                            $('#quisiste_decir_marca').val(data.marca);
                            $('#quisiste_decir_linea').val(data.linea);
                            $('.div_quisiste_decir').css('display', 'block');
                            $('#nuevo_carro').val(1);
                        }else{
                            $('.div_quisiste_decir').css('display', 'none');
                            $('#nuevo_carro').val(0);
                        }

                        $('#input-vehiculo-submit').removeAttr('disabled', 'disabled');
                        // $('#form_vehiculo').unbind('submit');
                    }
                });

              }, 1000);  
        }else{
           clearTimeout(globalTimeout); 
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

    //al dar click en el carro sugerido se carga la información de ese carro
    function carro_sugerido(){
        var marca = $('#quisiste_decir_marca').val();
        var linea = $('#quisiste_decir_linea').val();
        $("#input_vehiculo_marca").val(marca);
        $("#input_vehiculo_linea").val(linea);
        $('#nuevo_carro').val(0);
    }

    //valida el correo alla sido precreado con el CRM y carga la información
    function validar_correo(campo){
        $.ajax({
                url: "<?php echo base_url(); ?>usuario/dar_usuario_CRM_ajax",
                type: "POST",
                data: {
                    email: function() {
                            return $("#input-registrate-email").val();
                        }
                },
                onsubmit: false,
                success: function(data) {
                        if(data!=='false' && data !== 'true'){
                            console.log(data);
                            var data = $.parseJSON(data);
                            $("#input-registrate-nombre").val(data.nombres);
                            $('#input-registrate-apellidos').val(data.apellidos);
                            $('#input-registrate-telefono').val(data.telefonos);
                            $('#input-registrate-ciudad').val(data.lugar);

                            //info del carro
                            $("#input_vehiculo_marca").val(data.marca);
                            $('#input_vehiculo_linea').val(data.linea);
                            $('#input_vehiculo_placa').val(data.placa);
                            $('#input_vehiculo_kilometraje').val(data.kilometraje);
                            $('#input_vehiculo_modelo').val(data.modelo);
                        }
                    }
            });
    }
    
</script>
<!--vista que contiene la información de registro del usuario-->

<input type="hidden" value="" id="input-registro-callback"/>
<div id="loging-div" class="login-div-registro">
    <div id="login-div-top">
        <div id="login-div-top-texto" >Este servicio es para usuarios registrados, para compartir con nosotros regístrate o inicia tu sesión.</div>
    </div>
    <div id="login-div-center"  class="sesion-login">


        <div id="login-div-sesion">
            <div id="login-div-titulo">
                <img src="<?php echo base_url(); ?>resources/images/login/mayor-que-404040.png" alt="flechas de registro"/><span>INICIA TU SESIÓN</span>
            </div>
            <form id="form_login">
                <div class="form_login_div_campo">
                    <label>Email:</label>
                    <input type="text" name="input_login_email" id="input_login_email" class="input_login_email form_login_input"/><div for="input_login_email"></div>
                </div>
                <div class="form_login_div_campo">
                    <label>Contraseña:</label>
                    <input type="password" name="input_login_contrasena" id="input_login_contrasena" class="input_login_contrasena form_login_input"/><div for="input_login_contrasena"></div>
                </div>
                <div id="login-div-ingresarolvidar">
                    <div id="login-div-olvide">
                        <a href="<?php echo base_url(); ?>usuario/formulario_olvido_contrasena">Olvidé mi contraseña</a>
                    </div>
                    <input type="submit" name="input_login_contrasena" id="input-login-contrasena" class="input-registrate-submit" value="Ingresar"/>
                    <img src="<?php echo base_url();?>resources/images/login/ajax-loader.gif" class="ajax_img_loader" />
                    <div class="clear"></div>
                </div>
                <br/>
                <img id="home-div-facebook-button" class="home-div-facebook-button" src="<?php echo base_url(); ?>resources/images/login/facebook-conectar-boton.png"/>
            </form>
        </div>
        <div id="login-div-registrate">
            <div id="login-div-titulo">
                <img src="<?php echo base_url(); ?>resources/images/login/mayor-que-404040.png" alt="flechas de registro"/><span>REGÍSTRATE</span>
            </div>

            <form id="form_registro">

                <div class="form_login_div_campo">
                    <label>Correo electrónico: </label>
                    <input class="form_registro_input" onblur="validar_correo(this)" type="text" name="input_registrate_email" id="input-registrate-email"  title="Ingresa tu correo electrónico"/><div for="input-registrate-email"></div>
                </div>
                <div class="form_login_div_campo">
                    <label>Contraseña:</label>
                    <input class="form_registro_input" type="password" name="input_registrate_contrasena" id="input-registrate-contrasena"  title="Ingresa tu contraseña"/><div for="input-registrate-contrasena"></div>
                </div>
                <div class="form_login_div_campo">
                    <label>Repite tu contraseña:</label>
                    <input class="form_registro_input" type="password" name="input_registrate_contrasena_repite" id="input-registrate-contrasena-repite"  title="Repite tu contraseña"/><div for="input-registrate-contrasena-repite"></div>
                </div>
                <div class="form_login_div_campo">
                    <label>Nombres:</label>
                    <input class="form_registro_input" type="text" name="input_registrate_nombre" id="input-registrate-nombre" title="Ingresa tus nombres"/><div for="input-registrate-nombre"></div>
                </div>
                <div class="form_login_div_campo">
                    <label>Apellidos:</label>
                    <input class="form_registro_input" type="text" name="input_registrate_apellidos" id="input-registrate-apellidos"  title="Ingresa tus apellidos"/><div for="input-registrate-apellidos"></div>
                </div>
                <div class="form_login_div_campo">
                    <label>Número telefónico: *opcional</label>
                    <input class="form_registro_input" type="text" name="input_registrate_telefono" id="input-registrate-telefono"  title="Ingresa tu número telefónico" /><div for="input-registrate-telefono"></div>
                </div>
                <div class="form_login_div_campo">
                    <label>¿En qué ciudad vives?:</label>
                    <?php
                    $option_ciudades = array();
                    $selected = false;
                    $ciudades = array("Aguachica", "Apartadó", "Arauca", "Arjona", "Armenia", "Barrancabermeja", "Barranquilla", "Bello", "Bogotá", "Bucaramanga", "Buenaventura", "Calarcá", "Caldas", "Cali", "Candelaria", "Carmen de Bolívar", "Cartagena de indias", "Cartago", "Caucasia", "Cereté", "Chía", "Chigorodó", "Chiquinquirá", "Ciénaga", "Copacabana", "Cúcuta", "Dosquebradas", "Duitama", "Envigado", "Espinal", "Facatativa", "Florencia", "Floridablanca", "Fundación", "Funza", "Fusagasugá", "Garzón", "Girardot", "Guadalajara de Buga", "Ibagué", "Ipiales", "Itagüi", "Jamundí", "La Dorada", "Los Patios", "Madrid", "Magangué", "Maicao", "Malambo", "Manizales", "Medellín", "Montelíbano", "Monteria", "Mosquera", "Neiva", "Ocaña", "Palmira", "Pamplona", "Pasto", "Pereira", "Piedecuesta", "Pitalito", "Planeta Rica", "Popayán", "Quibdó", "Riohacha", "Rionegro", "Sabanalarga", "Sahagun", "San Andrés", "San Andrés de Sotavento", "San Andrés de Tumaco", "San José de Cúcuta", "San Juan de Girón", "Santa Cruz de Lorica", "Santa Marta", "Santa Rosa de Cabal", "Santander de Quilichao", "Sincelejo", "Soacha", "Sogamoso", "Soledad", "Tierralta", "Tuluá", "Tunja", "Turbaco", "Valledupar", "Villa del Rosario", "Villavicencio", "Yopal", "Yumbo", "Zipaquirá");
                    foreach ($ciudades as $ciudad) {
                        if ($ciudad != 'default') {
                            $option_ciudades[$ciudad] = $ciudad;
                            if (!$selected) {
                                $selected = $ciudad;
                            }
                        }
                    }
                    echo form_dropdown('ciudad_registrarse', $option_ciudades, 'Bogotá', 'id="input-registrate-ciudad" title="En qué ciudad vives" class="form_registro_ie_select"'); //, 'id="marca_registrarse"');
                    ?>
                </div>
                
                <div class="form_login_div_campo">
                    <label>Escribe los 4 dígitos de la imagen:</label>
                    <div id="registrar-div-login-captcha"><?php echo $captcha['image']; ?></div>
                    <input type="text" name="captcha_registrarse" id="input_login_captcha" class="input_login_captcha form_registro_input"/>
                </div>
                <div class="form_login_div_campo div_campo_chkbox">
                    <input type="checkbox" name="ckbox_registrate_chkbox" id="ckbox-registrate-chkbox"/><label id="label-registrate-condiciones">Acepto los <a href="<?php echo base_url(); ?>acerca/terminos_condiciones"><span>términos y condiciones</span></a></label>
                </div>   
                <div id="div-registrate-submit" class="div-registrate-submit">
                    <input type="submit" name="input_registrate_submit" id="input-registrate-submit" class="input-registrate-submit" value="Enviar"/>
                    <img src="<?php echo base_url();?>resources/images/login/ajax-loader.gif" class="ajax_img_loader" />
                    <div class="clear"></div>
                </div>
            </form>
        </div>

        <div class="clear"></div>
    </div>
</div>

<!--vista que contiene la información del vehículo-->
<div id="loging-div" class="login-div-vehiculo">
    <div id="login-div-center" class="sesion-vehiculo">


        <div id="login-div-sesion">
            <div id="login-div-progreso">
                <div id="login-div-progreso-vehiculo" class="login-div-progreso-selected">DATOS DEL VEHÍCULO</div>
                <div id="login-div-progreso-historial">HISTORIAL DE MANTENIMIENTO</div>              
            </div>
            <div class="clear"></div> 


            <div id="login-div-titulo"> 
                <img src="<?php echo base_url(); ?>resources/images/login/mayor-que-404040.png" alt="flechas de registro"/><span>PASO 2: INGRESA LOS DATOS DE TU VEHÍCULO</span>
            </div>
            <form action="<?php echo base_url(); ?>usuario/subir_imagen_vehiculo_ajax" id="form_vehiculo_file">
                <div id="foto_div_form">
                    <label>Adjunta la imagen de tu carro: (*opcional)</label>
                    <div id="foto_form_marco">
                        <img src="http://www.laspartes.com/resources/images/micuenta/tmpl_img_micuenta_vehiculo_nd1.png"  />
                    </div>
                    <input type="file" id="input_vehiculo_imagen" name="input_vehiculo_imagen" onchange="fotoPreview(this);" />
                </div>
            </form>
            <form id="form_vehiculo">
                <div id="vehiculo_div_form">
                    <input type="hidden" id="nuevo_carro" value="1">                    
                    <input type="hidden" name="input_vehiculo_id_usuario_vehiculo" id="input_vehiculo_id_usuario_vehiculo" class="input_vehiculo_id_usuario_vehiculo form_vehiculo_input" maxlength="20"/>
                    <div class="form_login_div_campo">
                        <label>Marca: ej. Renault</label>
                        <input type="text" name="input_vehiculo_marca" id="input_vehiculo_marca" class="input_vehiculo_marca form_vehiculo_input" maxlength="20"/><div for="input_vehiculo_marca"></div>
                    </div>
                    <div class="form_login_div_campo">
                        <label>Línea: ej. logan</label>
                        <input type="text" name="input_vehiculo_linea" id="input_vehiculo_linea" class="input_vehiculo_linea form_vehiculo_input" maxlength="30"/><div for="input_vehiculo_linea"></div>
                    </div>
                    <div class="form_login_div_campo div_quisiste_decir">
                        <label style="font-size: 15px;">Quisiste decir: </label>
                        <input type="hidden" id="quisiste_decir_marca">
                        <input type="hidden" id="quisiste_decir_linea">
                        <div id="quisiste_decir" onclick="carro_sugerido()"></div>
                    </div>
                    <div class="form_login_div_campo">
                        <label>Placa: (*opcional)</label>
                        <input type="text" name="input_vehiculo_placa" id="input_vehiculo_placa" class="input_vehiculo_palca form_vehiculo_input" maxlength="7"/><div for="input_vehiculo_placa"></div>
                    </div>
                    <div id="vehiculo_form_div_kilo" class="form_login_div_campo">
                        <label>Kilometraje Aproximado:</label>
                        <?php
                        $option_kilometraje = array();
                        for ($i = 0; $i < 200000; $i += 5000) {
                            $option_kilometraje[$i] = $i . ' Km.';
                        }
                        echo form_dropdown('input_vehiculo_kilometraje', $option_kilometraje, '5000', 'id="input_vehiculo_kilometraje" class="input_vehiculo_kilometraje" title="Selecciona el kilometraje aproximado de tu carro"');
                        ?><div for="input_vehiculo_kilometraje"></div>
                    </div>
                    <div id="vehiculo_form_div_model" class="form_login_div_campo">
                        <label>Modelo:</label>
                        <?php
                        $this->load->helper('date');
                        $option_modelo = array();
                        $selected = '2010';
                        $año = intval(mdate('%Y')) + 1;
                        for ($i = $año; $i > 1950; $i--) {
                            $option_modelo[$i] = $i;
                            if ($vehiculo->modelo == $i) {
                                $selected = $i;
                            }
                        }
                        echo form_dropdown('input_vehiculo_modelo', $option_modelo, $selected, 'id="input_vehiculo_modelo" class="input_vehiculo_modelo" title="Selecciona el modelo de tu carro"');
                        ?><div for="input_vehiculo_modelo"></div>
                    </div>
                    <div class="clear"></div>
                    <div class="div-registrate-submit">
                        <input type="submit" name="input_vehiculo_submit" id="input-vehiculo-submit" class="input-vehiculo-submit" value="Siguente"/>
                        <img src="<?php echo base_url();?>resources/images/login/ajax-loader.gif" class="ajax_img_loader" />
                    </div>
                    <div class="clear"></div>
                </div>
            </form>
        </div>


        <div class="clear"></div>
    </div>
</div>

<!--Vista que contiene el historial del carro-->
<div id="loging-div" class="login-div-historial"></div>