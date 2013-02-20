<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $titulo; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
            <?php if ($metaKeywords != "" || sizeof($metaKeywords) > 1): ?>
                <meta name="keywords" content="<?php echo $metaKeywords; ?>">
                <?php else: ?>
                    <meta name="keywords" content="autopartes,talleres,mecanica,automotriz,laspartes,carro,mantenimiento,repuestos">
                    <?php endif; ?>
                    <?php if ($metaDescripcion != "" || sizeof($metaDescripcion) > 1): ?>
                        <meta property="description" content="<?php echo $metaDescripcion; ?>"/>
                        <meta property="og:description" content="<?php echo $metaDescripcion; ?>"/>
                    <?php else: ?>
                        <meta name="og:description" content="Registra la información de tu carro y te avisamos qué debes tener en cuenta, cuándo tienes que hacerlo, y quiénes pueden ayudarte con el adecuado mantenimiento. Información sobre autopartes, talleres, mecánica automotriz, ofertas y promociones en Laspartes.com.">
                            <meta name="description" content="Registra la información de tu carro y te avisamos qué debes tener en cuenta, cuándo tienes que hacerlo, y quiénes pueden ayudarte con el adecuado mantenimiento. Información sobre autopartes, talleres, mecánica automotriz, ofertas y promociones en Laspartes.com." >
                            <?php endif; ?>
                            <meta property="og:title" content="<?php echo $titulo; ?>"/>
                            <meta property="og:site_name" content="Laspartes.com: Todo para tu vehículo"/>
                            <?php if ($metaImagen != "" || sizeof($metaImagen) > 1): ?>
                                <meta property="og:image" content="<?php echo base_url() . $metaImagen; ?>"/>
                            <?php else: ?>
                                <meta property="og:image" content="<?php echo base_url(); ?>resources/template/header/laspartes.png"/>
                            <?php endif; ?>
                            <link href="<?php echo base_url(); ?>resources/css/style.css" rel="stylesheet" type="text/css" />
                            <link href="<?php echo base_url(); ?>resources/css/header.css" rel="stylesheet" type="text/css" />
                            <link href="<?php echo base_url(); ?>resources/css/footer.css" rel="stylesheet" type="text/css" />
                            <link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/fonts.css" type="text/css" charset="utf-8" />
                            <link href="<?php echo base_url(); ?>resources/css/confirm.css" rel="stylesheet" type="text/css" />

                            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script> 
                            <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery-ui-1.8.23.custom.min.js"></script>
                            <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.validate.js"></script>
                            <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.simplemodal.js"></script>

                            <html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">



                                </head>

                                <body>
                                    <div id="contenido">
                                        <div id="home-div-degrade"></div>
                                        <div style="min-width: 980px; margin-left: auto; margin-right: auto;">
                                            <?php
                                            $header_viewdata = array();
                                            if (isset($show_login)) {
                                                $data['show_login'] = true;
                                            }


                                            $this->load->view('template/header_view', $data);
                                            ?>
                                        </div>    
                                        <div id="home-div-wrapper">

                                            <?php // if(isset($breadcrumb)){$this->load->view('template/breadcrumbs_view');} ?>
                                            <?php $this->load->view($contenido_view); ?> 
                                        </div>

                                        <?php $this->load->view('template/footer_view'); ?>
                                    </div>
                                    <!-- modal content -->
                                    <div id='confirm'>
                                        <div class='header'><span>Mensaje de http://www.laspartes.com/</span></div>
                                        <div class='message'></div>
                                        <div class='buttons'>
                                            <div class='yes'>Aceptar</div>
                                        </div>
                                    </div>
                                    <div id="ajax_loadingDiv"></div> 



                                    <script type="text/javascript"> 

                                        var _gaq = _gaq || [];
                                    _gaq.push(['_setAccount', 'UA-23173661-1']);
                                    _gaq.push(['_trackPageview']);

                                    (function() {
                                        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                                        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                                    })();

                                    </script>

                                    <script type="text/javascript">

                                    //muestra el triangulo negro al hacer hover sobre novedades
                                    $('#barra_novedades').hover( function () {
                                        $('#home-img-header-triangulo').show();
                                    } , function(){
                                        $('#home-img-header-triangulo').hide();
                                    });
                                    $('#ajax_loadingDiv').hide();
                                    //            $('#ajax_loadingDiv').ajaxStart(function(){$('#contenido').css('opacity', '0.4'); $(this).show(); });
                                    //            $('#ajax_loadingDiv').ajaxStop(function(){$('#contenido').css('opacity', '1'); $(this).hide();});
                                    $('#ajax_loadingDiv').ajaxStart(function(){ $(this).show(); });
                                    $('#ajax_loadingDiv').ajaxStop(function(){ $(this).hide();}); 
                                    
                                    
                                    busqueda();
                                    show_login();
                                    validar_usuario();
                                    cerrar_sesion();
                                    mostarDropdownSesion();
                                    cerrarMensajes();
                                    preload([
                                        '../../resources/template/header/gplus-icon-hover.png',
                                        '../../resources/template/header/fb-icon-hover.png',
                                        '../../resources/template/header/twitter-icon-hover.png'

                                    ]);
            
                                    function busqueda(){
                                        $('form#form_buscar').submit(function(e){
                                            var busqueda = $('#input-busqueda-palabra', this).val();
                                            window.location = "<?php echo base_url(); ?>buscar/"+busqueda;
                                            e.preventDefault();
                                            return false;
                                        });
                                    }
            
                                    function cerrarMensajes(){
                                        $('.mensaje-error, .mensaje-ok, .mensaje-alerta, .mensaje-informativo').click(function(){
                                            $(this).slideUp();
                                        });
                                    }
                                    function mostarDropdownSesion(){
                                        $('#sesion-div-header-perfil').live('click',function(){
                                            var dd = $('.hidden-header-perfil');
                                            if($(dd).is(':hidden')){
                                                $(dd).show();
                                            }else{
                                                $(dd).hide();	
                                            }
                                        });
                                    }

                                    //funcion que arregla caracteres especiales
                                    function specialCharacters(r){
                                        r = r.replace(new RegExp(/\s/g),"-");
                                        r = r.replace(new RegExp(/[àáâãäå]/g),"a");
                                        r = r.replace(new RegExp(/æ/g),"ae");
                                        r = r.replace(new RegExp(/ç/g),"c");
                                        r = r.replace(new RegExp(/[èéêë]/g),"e");
                                        r = r.replace(new RegExp(/[ìíîï]/g),"i");
                                        r = r.replace(new RegExp(/ñ/g),"n");                
                                        r = r.replace(new RegExp(/[òóôõö]/g),"o");
                                        r = r.replace(new RegExp(/œ/g),"oe");
                                        r = r.replace(new RegExp(/[ùúûü]/g),"u");
                                        r = r.replace(new RegExp(/[ýÿ]/g),"y");
                                        return r;
                                    };    

                                    //preload images
                                    function preload(arrayOfImages) {
                                        $(arrayOfImages).each(function(){
                                            $('<img/>')[0].src = this;
                                            // Alternatively you could use:
                                            (new Image()).src = this;
                                        });
                                    }



                                    //ciera la sesión del usuario y lo redirecciona al home
                                    function cerrar_sesion(){
                                        $('#sesion-div-header-cerrar').live('click',function(){

                                            $.ajax({
                                                url: "<?php echo base_url(); ?>usuario/cerrar_sesion_ajax",
                                                success: function(data){
                                                    if(data == 'true'){
                                                        window.location.reload();
                                                    }else{
                                                        alert('Ocurrió un error al cerrar su sesión.');
                                                    }  
                                                }
                                            }); 
                                        });
                                    }

                                    //cambia el header de la sesion
                                    function cambiarHeaderSesion(){
                                        $('#home-div-header-top-sesion').remove();
                                        $('<a href="<?php echo base_url() . 'usuario' ?>"><div class="helvetica-regular" id="home-div-header-top-sesion-activo"><span>MI TALLER</span></div></a>').insertBefore("#home-div-header-login-box");
                                        $('#sesion-div-header-sin-sesion').remove();
                                        //                $('<div id="sesion-div-header-cerrar">Cerrar sesión</div><div id="sesion-div-header-perfil"><span id="sesion-span-header-perfil-nombre">cabarique</span><img id="sesion-span-header-perfil-flechita" src="<?php echo base_url(); ?>resources/template/header/flechita-usuario.png" alt="" /></div><div class="clear"></div><img id="sesion-span-header-perfil-triangulo" class="hidden-header-perfil" src="<?php echo base_url(); ?>resources/template/header/triangulo-header.png" /><div id="sesion-div-header-dropdown"  class="hidden-header-perfil"><div id="sesion-div-header-dd-opcion"><span id="sesion-span-header-dd-vehiculos"><a href="<?php echo base_url(); ?>usuario#usuario-div-mis-vehiculos">Mis vehículos</a></span><span></span></div><div id="sesion-div-header-dd-opcion"><span id="sesion-span-header-dd-ofertas"><a href="<?php echo base_url(); ?>usuario#usuario-div-ofertas">Ofertas de mantenimiento</a></span><span></span></div><div id="sesion-div-header-dd-opcion"><span id="sesion-span-header-dd-compras"><a href="<?php echo base_url(); ?>usuario#usuario-div-compras">Mis compras</a></span><span></span></div><div id="sesion-div-header-dd-opcion"><span id="sesion-span-header-dd-preguntas"><a href="<?php echo base_url(); ?>usuario#usuario-div-comunidad">Mis preguntas</a></span><span></span></div><div id="sesion-div-header-dd-opcion"><span id="sesion-span-header-dd-respuestas"><a href="<?php echo base_url(); ?>usuario#usuario-div-comunidad">Mis respuestas</a></span><span></span></div></div>').insertAfter('#sesion-div-header-contactenos');
                                        $.ajax({
                                            url: "<?php echo base_url(); ?>usuario/cargar_header_ajax",
                                            type: "POST",
                                            success: function(data){
                                                $('#sesion-div-header-contactenos').after(data); 
                                            }
                                        });
                                    }

                                    //valida que el usuario este registrado y la contraseña coincida (por AJAX)
                                    //en caso de que la validación sea exitosa, se redirecciona a su perfil
                                    function validar_usuario(){
                                        $("#formulario_login").validate({
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
                                                    required: "*Escribe tu correo electrónico",
                                                    email: "*Escribe un correo electrónico válido"
                                                },
                                                input_login_contrasena: "*Escribe tu contraseña"
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
                                                    //                                                        alert(message + errors);
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
                                                    success: function(data, status){
                                                        data = JSON.parse(data); 
                                                        if(data.status==true){
                                                            _gaq.push(['_setCustomVar', '1' ,'login', 'user_'+data.msg, '1']);
                                                            _gaq.push(['_trackEvent', 'login', 'NLogin']);
                                                            _gaq.push(['_deleteCustomVar', 1]);
                                                            window.location = "<?php echo base_url() . 'usuario'; ?>";
                                                        }else
                                                            confirm('Usuario o contraseña incorrectos', function () {
                                                                $.modal.close();
                                                            });
                                                        //                                                                alert();
                                                    }
                                                });
                                            }
                                        });

                                    }

                                    //funcion que despliega la forma de login
                                    function show_login(){
                                        $('#home-div-header-top-sesion span').click(function(){
                                            var show= $('#home-div-header-login-box').hasClass('hide');
                                            if(show){
                                                $('#home-div-header-login-box').css('display','block');
                                                $('#home-div-header-login-box').removeClass('hide');
                                                $('#home-div-header-login-box').addClass('show');
                                            }else{
                                                $('#home-div-header-login-box').hide();
                                                $('#home-div-header-login-box').removeClass('show');
                                                $('#home-div-header-login-box').addClass('hide');
                                            }
                                            return false;
                                        });

                                        function dar_estrellas_calificadas(){
                                            var texto = $('.estrellas-clasificadas span');

                                            texto.each(function(i, e){
                                                var padre = $('.estrellas-clasificadas').has(this);
                                                var porcentaje = $(e).text();
                                                $(padre).css('width', porcentaje);
                                            }); 
                                        }

                                        function dar_estrellas_calificadas_grandes(){
                                            var textogrande = $('.estrellas-clasificadas-grandes span');

                                            textogrande.each(function(i, e){
                                                var padre = $('.estrellas-clasificadas-grandes').has(this);
                                                var porcentaje = $(e).text();
                                                $(padre).css('width', porcentaje);
                                            });
                                        }

                                        dar_estrellas_calificadas_grandes();
                                        dar_estrellas_calificadas();


                                    }
            
                                    function confirm(message, callback) {
                                        $('#confirm').modal({
                                            closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
                                            position: ["20%",],
                                            overlayId: 'confirm-overlay',
                                            containerId: 'confirm-container', 
                                            onShow: function (dialog) {
                                                var modal = this;

                                                $('.message', dialog.data[0]).append(message);

                                                // if the user clicks "yes"
                                                $('.yes', dialog.data[0]).click(function () {
                                                    // call the callback
                                                    if ($.isFunction(callback)) {
                                                        callback.apply();
                                                    }
                                                    // close the dialog
                                                    modal.close(); // or $.modal.close();
                                                });
                                            }
                                        });
                                        $('.simplemodal-container').css('height', 'auto');
                                    }
                                    </script>

                                    <script type="text/javascript">
                                    window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
                                            d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
                                                _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
                                        $.src='//cdn.zopim.com/?KS85wRTFYa1hkV6j5Dcg1dzTxTfvAwIX';z.t=+new Date;$.
                                            type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
                                    </script>

                                    <script type="text/javascript">$zopim(function() {
                                    // Insert API calls below this line
                                    $zopim.livechat.setLanguage('es');
                                    //             <a href="javascript:void($zopim.livechat.setLanguage('es'))">Spanish</a>
                                    // Insert API calls above this line
                                })
                                    </script>

                                    <div id="fb-root"></div>

                                    <script type="text/javascript">
                                window.fbAsyncInit = function() {
                                    //Initiallize the facebook using the facebook javascript sdk
                                    FB.init({ 
                                        appId:'382292381857467', // App ID 
                                        cookie:true, // enable cookies to allow the server to access the session
                                        status:true, // check login status
                                        xfbml:true, // parse XFBML
                                        oauth : true //enable Oauth 
                                    });
                                };
                                //Read the baseurl from the config.php file
                                (function(d){
                                    var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
                                    if (d.getElementById(id)) {return;}
                                    js = d.createElement('script'); js.id = id; js.async = true;
                                    js.src = "//connect.facebook.net/en_US/all.js";
                                    ref.parentNode.insertBefore(js, ref);
                                }(document));
            
                                //Onclick for fb login
                                $('.home-div-facebook-button').live('click',function(e) {
                                    FB.getLoginStatus(function(response) {
                                        //                    if (response.status === 'connected') { 
                                        //                        FB.login(function(response) {
                                        //                            if(response.authResponse) {
                                        //                                parent.location ='<?php echo base_url(); ?>usuario/FBlogin'; //redirect uri after closing the facebook popup
                                        //                            }
                                        //                        },{scope: 'email,user_birthday,publish_stream,user_hometown'}); //permissions for facebook
                                        //                    } else{
                                        FB.login(function(response) {
                                            if(response.authResponse) {
                                                parent.location ='<?php echo base_url(); ?>usuario/FBlogin'; //redirect uri after closing the facebook popup
                                            }
                                        },{scope: 'email,user_birthday,publish_stream,user_hometown'}); //permissions for facebook

                                        //                    }
                                    });
                
                                });
                                    </script>



                                    <?php $this->load->view($header_view); ?>  
                                </body>
                            </html>