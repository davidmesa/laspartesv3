<style type="text/css">
    /** css del formulario de registro login*/
#loging-div{width:620px;}#login-div-top{width:600px;}#login-div-top-triangulo{background-image:url(../../resources/images/login/triangulo.png);background-repeat:no-repeat;height:7px;width:15px;position:relative;top:2px;left:560px;}#login-div-top-texto{font-family:open_sansregular;font-size:12px;position:relative;background-color:#404040;text-align:center;color:#FFF;width:100%;padding:10px;}#login-div-center{margin-top:1px;width:inherit;position:relative;background-color:#404040;height:100%;}#login-div-registrate{width:60%;background-color:#7b7b7b;float:left;color:#FFF;font-family:open_sansregular;}#login-div-sesion{width:40%;background-color:#404040;float:right;color:#FFF;font-family:open_sansregular;}#login-div-registrate-titulo{padding-top:15px;margin-left:10px;font-family:univers_condensedbold;font-size:25px;}#login-div-registrate-titulo span{margin-left:5px;position:relative;top:3px;}#form_registro label,#form_registro input,#form_login label,#form_login input{display:block;}#form_registro label,#form_login label{font-size:11px;margin-top:15px;}#form_registro input[type=text],#form_registro input[type=password]{background-color:transparent;border:none;border-bottom:2px solid #b5b5b5;width:300px;outline:none;color:#FFF;font-family:open_sansregular;}#form_login input[type=text],#form_login input[type=password]{background-color:transparent;border:none;border-bottom:2px solid #b5b5b5;width:195px;outline:none;color:#FFF;font-family:open_sansregular;}#form_registro input:focus{outline:none;}#form_registro select{width:190px;display:block;}#form_registro #ckbox-registrate-chkbox{margin-top:20px;display:inline;}#form_registro #label-registrate-condiciones{font-size:11px;margin-top:0;margin-left:10px;display:inline;position:relative;top:-3px;}#form_registro #label-registrate-condiciones span{text-decoration:underline;font-style:italic;cursor:pointer;color:#FFF;}#form_registro #label-registrate-condiciones a{cursor:pointer;color:#FFF;text-decoration:none;}#form_registro input[type=submit]{float:right;}#div-registrate-submit{margin-right:30px;margin-bottom:20px;margin-top:20px;}#form_registro #input-registrate-submit{font-family:open_sansregular;background-color:#404040;color:#FFF;border:none;cursor:pointer;padding:3px 10px;}#login-div-ingresarolvidar input{float:right;margin-right:20px;border:none;background-color:#777;color:#FFF;font-family:open_sansregular;font-size:11px;cursor:pointer;padding:3px 8px;}#login-div-olvide{float:left;width:50px;}#login-div-olvide a{text-decoration:underline;color:#FFF;font-size:11px;cursor:pointer;}#form_registro label.error,#form_login label.error{margin-top:0;}#form_registro,#form_login{margin-left:30px;}#form_registro #select-registrate-modelo,#login-div-ingresarolvidar{margin-top:20px;}

/** final del css formulario registro login*/
</style>
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
    $(function(){var vehiculos=<?php echo json_encode($allvehiculos);?>;$("#input-registrate-vehiculo").autocomplete({source:vehiculos,change:function(e,ui){if(!ui.item){$('#input-registrate-vehiculo-hidden').val('na')}},select:function(e,ui){$('#input-registrate-vehiculo-hidden').remove();var vehiculo_actual=ui.item.value,input=$("<input>").attr("type","hidden").attr('value',ui.item.id_vehiculo).attr('name','vehiculo_id').attr("id","input-registrate-vehiculo-hidden");span=$("<span>").html(vehiculo_actual);span.insertAfter(input);input.insertAfter("#input-registrate-vehiculo")}})});var validator=$('form#form_registro').validate({rules:{input_registrate_nombre:{required:true},input_registrate_apellidos:{required:true},input_registrate_usuario:{required:true,maxlength:35,minlength:4,remote:{url:"<?php echo base_url(); ?>usuario/no_existe_usuario_ajax",type:"post",data:{usuario:function(){return $("#input-registrate-usuario").val()}}}},input_registrate_email:{required:true,email:true,remote:{url:"<?php echo base_url(); ?>usuario/no_existe_email_ajax",type:"post",data:{email:function(){return $("#input-registrate-email").val()}}}},input_registrate_contrasena:{required:true,maxlength:35,minlength:4},input_registrate_contrasena_repite:{required:true,maxlength:35,minlength:4,equalTo:'#input-registrate-contrasena'},ckbox_registrate_chkbox:{required:true},vehiculo_id:{required:true},id_vehiculos:{required:true}},messages:{input_registrate_nombre:"*Debes escribir tu nombre",input_registrate_apellidos:"*Debes escribir tu apellido",input_registrate_usuario:{required:"*Debes escribir un nombre de usuario",remote:"*Es un nombre de usuario ya registrado",maxlength:"*El número máximo de caracteres permitidos es de 35",minlength:"*Debes ingresar más de 4 caracteres"},input_registrate_email:{required:"*Debes ingresar una dirección de correo válida",email:"*Debe ser un correo válido",remote:"*Este correo ya está registrado"},input_registrate_contrasena:{required:"*Debes ingresar tu contraseña",maxlength:"*El número máximo de caracteres permitidos es de 35",minlength:"*Debes ingresar más de 4 caracteres"},input_registrate_contrasena_repite:{required:"*Debes ingresar tu contraseña",equalTo:"*Debe ser el mismo valor de la contraseña anterior",maxlength:"*El número máximo de caracteres permitidos es de 35",minlength:"*Debes ingresar más de 4 caracteres"},ckbox_registrate_chkbox:"*Para poder ser parte debes aceptar los términos y condiciones",vehiculo_id:"*Debes ingresar tu vehículo",id_vehiculos:"*Debes ingresar tu vehículo"},invalidHandler:function(form,validator){var errors=validator.numberOfInvalids();if(errors){var message=errors==1?'Se encontró el siguiente error:\n':'Se encontraron los siguientes '+errors+' errores:\n';var errors="";if(validator.errorList.length>0){for(x=0;x<validator.errorList.length;x++){errors+="\n\u25CF "+validator.errorList[x].message}}alert(message+errors)}validator.focusInvalid()},submitHandler:function(form){_gaq.push(['_trackEvent','Registros','Clic','usuario']);$.ajax({url:"<?php echo base_url(); ?>usuario/registrar_usuario_ajax",type:"POST",data:{input_registrate_nombre:function(){return $("#input-registrate-nombre",form).val()},input_registrate_apellidos:function(){return $("#input-registrate-apellidos",form).val()},ciudad_registrarse:function(){return $("#input-registrate-ciudad",form).val()},input_registrate_usuario:function(){return $("#input-registrate-usuario",form).val()},input_registrate_email:function(){return $("#input-registrate-email",form).val()},input_registrate_contrasena:function(){return $("#input-registrate-contrasena",form).val()},input_registrate_contrasena_repite:function(){return $("#input-registrate-contrasena-repite",form).val()},ckbox_registrate_chkbox:function(){return $("#ckbox-registrate-chkbox",form).val()},vehiculo_id:function(){return $("#input-registrate-vehiculo-hidden",form).val()},vehiculo:function(){return $("#input-registrate-vehiculo",form).val()}},onsubmit:false,success:function(data){var callback=$('#input-registro-callback').val();if(data=='true'&&callback.length>0){cambiarHeaderSesion();try{window[callback]()}catch(e){alert(e)}}else{alert(data)}}})},errorPlacement:null});$("#form_login").validate({rules:{input_login_email:{required:true,email:true},input_login_contrasena:{required:true}},messages:{input_login_email:{required:"*Debes escribir tu correo electrónico",email:"*Debes escribir un correo electrónico válido"},input_login_contrasena:{required:"*Debes escribir tu contraseña"}},invalidHandler:function(form,validator){var errors=validator.numberOfInvalids();if(errors){var message=errors==1?'Se encontró el siguiente error:\n':'Se encontraron los siguientes '+errors+' errores:\n';var errors="";if(validator.errorList.length>0){for(x=0;x<validator.errorList.length;x++){errors+="\n\u25CF "+validator.errorList[x].message}}alert(message+errors)}validator.focusInvalid()},submitHandler:function(form){$.ajax({url:"<?php echo base_url(); ?>usuario/validar_usuario_ajax",type:"POST",data:{email:function(){return $(".input_login_email",form).val()},contrasena:function(){return $(".input_login_contrasena",form).val()}},onsubmit:false,success:function(data){var callback=$('#input-registro-callback').val();if(data=='true'&&callback.length>0){cambiarHeaderSesion();try{window[callback]()}catch(e){alert(e)}}else if(data=='false'){alert('Usuario o contraseña incorrectos')}}})}});
</script>
<input type="hidden" value="" id="input-registro-callback"/>
<div id="loging-div">
    <div id="login-div-top">
        <div id="login-div-top-triangulo"></div>
        <div id="login-div-top-texto" >Este servicio es para usuarios registrados, para compartir con nosotros regístrate o inicia tu sesión.</div>
    </div>
    <div id="login-div-center">
        <div id="login-div-registrate">
            <div id="login-div-registrate-titulo">
                <img src="<?php echo base_url(); ?>resources/images/login/mayor-que.png" alt="flechas de registro"/><span>REGÍSTRATE</span>
            </div>

            <form id="form_registro">
                <label>Nombres:</label>
                <input type="text" name="input_registrate_nombre" id="input-registrate-nombre" />
                <label>Apellidos:</label>
                <input type="text" name="input_registrate_apellidos" id="input-registrate-apellidos" />
                <label>¿En qué ciudad vives?:</label>
                <div class="ui-widget">
                <?php
                $option_ciudades = array();
                $selected = false;
                $ciudades = array("Aguachica", "Apartadó", "Arauca", "Arjona", "Armenia", "Barrancabermeja", "Barranquilla", "Bello", "Bogotá", "Bucaramanga", "Buenaventura", "Calarcá", "Caldas", "Cali", "Candelaria", "Carmen de Bolívar", "Cartagena de indias", "Cartago", "Caucasia", "Cereté", "Chía", "Chigorodó", "Chiquinquirá", "Ciénaga", "Copacabana", "Cúcuta", "Dosquebradas", "Duitama", "Envigado", "Espinal", "Facatativa", "Florencia", "Floridablanca", "Fundación", "Funza", "Fusagasugá", "Garzón", "Girardot", "Guadalajara de Buga", "Ibagué", "Ipiales", "Itagüi", "Jamundí", "La Dorada", "Los Patios", "Madrid", "Magangué", "Maicao", "Malambo", "Manizales", "Medellín", "Montelíbano", "Monteria", "Mosquera", "Neiva", "Ocaña", "Palmira", "Pamplona", "Pasto", "Pereira", "Piedecuesta", "Pitalito", "Planeta Rica", "Popayán", "Quibdó", "Riohacha", "Rionegro", "Sabanalarga", "Sahagun", "San Andrés", "San Andrés de Sotavento", "San Andrés de Tumaco", "San José de Cúcuta", "San Juan de Girón", "Santa Cruz de Lorica", "Santa Marta", "Santa Rosa de Cabal", "Santander de Quilichao", "Sincelejo", "Soacha", "Sogamoso", "Soledad", "Tierralta", "Tuluá", "Tunja", "Turbaco", "Valledupar", "Villa del Rosario", "Villavicencio", "Yopal", "Yumbo", "Zipaquirá");
                foreach($ciudades as $ciudad){
                        if( $ciudad != 'default'){
                                $option_ciudades[$ciudad] = $ciudad;
                                if(!$selected){
                                        $selected = $ciudad;
                                }
                        }
                }
                echo form_dropdown('ciudad_registrarse', $option_ciudades, 'Bogotá', 'id="input-registrate-ciudad"');//, 'id="marca_registrarse"');
                ?>
                </div>
                <label>Escribe tu nombre de usuario: (4 caracteres)</label>
                <input type="text" name="input_registrate_usuario" id="input-registrate-usuario" />
                <label>Escribe tu correo electrónico: </label>
                <input type="text" name="input_registrate_email" id="input-registrate-email" />
                <label>Escribe tu contraseña:</label>
                <input type="password" name="input_registrate_contrasena" id="input-registrate-contrasena" />
                <label>Repite tu contraseña:</label>
                <input type="password" name="input_registrate_contrasena_repite" id="input-registrate-contrasena-repite" />
                <label>Marca y línea de tu vehículo: ej. Renault Twingo</label>
                <input type="text" id="input-registrate-vehiculo" class="vehiculos" id="input-registrate-vehiculo"  name="id_vehiculos"  value="" /> 
                <input type="hidden" value="na" name="vehiculo_id"  id="input-registrate-vehiculo-hidden">
<!--                <select type="text" name="select_registrate_vehiculo" id="select-registrate-vehiculo"><option value="1" selected="selected">Escoge tu vehiculo</option></select>-->
<!--                <select name="select_registrate_modelo" id="select-registrate-modelo"><option value="1" selected="selected">Escoge tu modelo</option></select>-->
                <input type="checkbox" name="ckbox_registrate_chkbox" id="ckbox-registrate-chkbox"/><label id="label-registrate-condiciones">Acepto los <a href="<?php echo base_url();?>acerca/terminos_condiciones"><span>términos y condiciones</span></a></label>
                <div id="div-registrate-submit">
                    <input type="submit" name="input_registrate_submit" id="input-registrate-submit" value="Registrame"/>
                    <div class="clear"></div>
                </div>

            </form>
        </div>

        <div id="login-div-sesion">
            <div id="login-div-registrate-titulo">
                <img src="<?php echo base_url(); ?>resources/images/login/mayor-que.png" alt="flechas de registro"/><span>INICIA TU SESIÓN</span>
            </div>
            <form id="form_login">
                <label>Email:</label>
                <input type="text" name="input_login_email" id="input_login_email" class="input_login_email"/>
                <label>Contraseña:</label>
                <input type="password" name="input_login_contrasena" id="input_login_contrasena" class="input_login_contrasena"/>
                <div id="login-div-ingresarolvidar">
                    <div id="login-div-olvide">
                        <a href="<?php echo base_url();?>usuario/formulario_olvido_contrasena">Olvidé mi contraseña</a>
                    </div>
                    <input type="submit" name="input_login_contrasena" id="input-login-contrasena" value="Ingresar"/>
                </div><br/><br/>

                <img id="home-div-facebook-button" class="home-div-facebook-button" width="90%" src="<?php echo base_url();?>resources/images/login/facebook-conectar-boton.png"/>
            </form>
        </div>

        <div class="clear"></div>
    </div>
</div>