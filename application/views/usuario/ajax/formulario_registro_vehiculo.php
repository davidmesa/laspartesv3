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
    #loging-div
    { width:605px; }

   #loging-div.login-div-historial
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

    #login-div-center.sesion-vehiculo, #login-div-center.sesion-historial{
        border-radius: 5px;
        padding:10px;
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

   #form_historial label
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

    .form_vehiculo_input, #form_vehiculo select
    { 

        padding: 10px 10px; 
        margin-top: 3px;}

    #form_vehiculo .form_vehiculo_input{
        width: 255px;	
    }

    #form_historial input[type=text]{
        width:70px;
        padding: 5px 5px;
        margin-top: 3px;
    }
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
                        errors += "<br/>" +  "\n\u25CF " + validator.errorList[x].message
                    }
                }
                confirm(message + errors, function () {
                                                        $.modal.close();
                                                    });
//                alert(message + errors)
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
                        confirm((data.split('|'))[1], function () {
                                                        $.modal.close();
                                                    });
//                        alert((data.split('|'))[1]);
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
<!--vista que contiene la información de registro del usuario-->

<input type="hidden" value="" id="input-registro-callback"/>

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
                    <div class="form_login_div_campo">
                        <label>Marca: ej. Renault</label>
                        <input type="text" name="input_vehiculo_marca" id="input_vehiculo_marca" class="input_vehiculo_marca form_vehiculo_input" maxlength="20"/><div for="input_vehiculo_marca"></div>
                    </div>
                    <div class="form_login_div_campo">
                        <label>Línea: ej. logan</label>
                        <input type="text" name="input_vehiculo_linea" id="input_vehiculo_linea" class="input_vehiculo_linea form_vehiculo_input" maxlength="30"/><div for="input_vehiculo_linea"></div>
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