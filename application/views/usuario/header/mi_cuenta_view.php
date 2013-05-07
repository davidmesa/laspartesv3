<link href="<?php echo base_url() ?>resources/css/usuario.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>resources/css/jquery.ui.all.css" rel="stylesheet" type="text/css"  media="screen" />

<script src="<?php echo base_url(); ?>resources/js/jquery.ui.core.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.widget.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.button.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.position.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.autocomplete.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/ajaxupload.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery.lightbox_me.js"></script>
<script src="<?php echo base_url(); ?>resources/js/ajaxfileupload.js" type="text/javascript"></script>

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

        $(".vehiculos").autocomplete({
            source: vehiculos,
            change: function(e, ui){
                if(!ui.item){
                    $('.hidden_carro_selected').val('na');
                }   
            },select: function(e, ui) {
                $('.hidden_carro_selected').remove();
                var vehiculo_actual = ui.item.value,
                input = $("<input>").attr("type", "hidden").attr('value',ui.item.id_vehiculo).attr('name','vehiculo_id').attr("class", "hidden_carro_selected");
                span = $("<span>").html(vehiculo_actual);
                span.insertAfter(input);
                input.insertBefore(".vehiculos");
            }
        });

                
    });
</script>


<script>  
    $(document).ready(function() {
        var carroSeleccionado;
        var mouse_is_inside = false;
        
        //si el número de vehículos que tiene el usuario es 0
        //se le muestra al usuario un lightbox para que registre un carro
        var numeroVehiculos = parseInt('<?php echo $numVehiculos; ?>');
        if(numeroVehiculos == 0){
            //            alert('ent');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>usuario/mostrar_registro_vehiculo_ajax", 
                success: function(data){
                    $('#registro-login-div').empty();
                    $('#registro-login-div').html(data);
                    $('#registro-login-div').lightbox_me({
                        fixedNavigation:true,
                        centered: true
                    }); 
                }
            }); //ajax
        }
	 
        //Al momento de hacer un click sobre una clase inactiva, ésta cambia a activa. La clase que estaba activa antes
        //se vuelve inactiva
        $('.usuario-div-perfil-tarea').click(function(){
            var activo = $(this).hasClass('activo');
            if(!activo){
                $(this).removeClass('inactivo');
		
		
		  
                $('.activo').each(function(i, e) {
                    $(e).removeClass('activo'); 
                    $(e).addClass('inactivo');  
                });  
                $(this).addClass('activo');
            }
	   
	   
            //mueve el scroll de la página a la sesión correspondiente
            var sesion = $('.usuario-span-perfil-titulosesion', this).text();
            if(sesion == 'Mis vehículos'){
                //get the top offset of the target anchor
                var target_offset = $('#usuario-div-mis-vehiculos').offset();
                var target_top = target_offset.top-180;
	 
                //goto that anchor by setting the body scroll top to anchor top
                $('html, body').animate({scrollTop:target_top}, 500);
            }else if(sesion == 'Sobre mi vehículo'){
                var target_offset = $('#usuario-div-smv').offset();
                var target_top = target_offset.top -150;
                $('html, body').animate({scrollTop:target_top}, 500);
            }else if(sesion == 'Ofertas'){
                var target_offset = $('#usuario-div-ofertas').offset();
                var target_top = target_offset.top -150;
                $('html, body').animate({scrollTop:target_top}, 500);
                //            }else if(sesion == 'Compras'){
                //                var target_offset = $('#usuario-div-compras').offset();
                //                var target_top = target_offset.top-150;
                //                $('html, body').animate({scrollTop:target_top}, 500);
            }else if(sesion == 'Comunidad'){
                var target_offset = $('#usuario-div-comunidad').offset();
                var target_top = target_offset.top-150;
                $('html, body').animate({scrollTop:target_top}, 500);
            }
		
        });
	
	
        //posiciona el div de información en una posicion fija mientras se hace
        //scroll hacia abajo
        var msie6 = $.browser == 'msie' && $.browser.version < 7;
  
        if (!msie6) {
            var top = $('#usuario-div-mi-perfil').offset().top - parseFloat($('#usuario-div-mi-perfil').css('margin-top').replace(/auto/, 0));
            var misVehiculos = $('#usuario-div-mis-vehiculos').offset().top - parseFloat($('#usuario-div-mis-vehiculos').css('margin-top').replace(/auto/, 0)) -150;
            var smv = $('#usuario-div-smv').offset().top - parseFloat($('#usuario-div-smv').css('margin-top').replace(/auto/, 0))-150;
            var ofertas = $('#usuario-div-ofertas').offset().top - parseFloat($('#usuario-div-ofertas').css('margin-top').replace(/auto/, 0))-150;
            //            var compras = $('#usuario-div-compras').offset().top - parseFloat($('#usuario-div-compras').css('margin-top').replace(/auto/, 0))-150;
            var comunidad = $('#usuario-div-comunidad').offset().top - parseFloat($('#usuario-div-comunidad').css('margin-top').replace(/auto/, 0))-150;
            $(window).scroll(function (event) {
                // what the y position of the scroll is
                var y = $(this).scrollTop();
		  
                // whether that's below the form
                if (y >= top) {
                    // if so, ad the fixed class
                    $('#usuario-div-mi-perfil').addClass('fixed');
                } else {
                    // otherwise remove it
                    $('#usuario-div-mi-perfil').removeClass('fixed');
                }
                
                if(y >= misVehiculos && y < smv){
                    $('.usuario-div-perfil-tarea').css('color', '#564B47')
                    $('.usuario-div-perfil-misvehiculos').css('color', '#C60200');
                    $('.activo').addClass('inactivo');
                    $('.activo').removeClass('activo');
                    $('.usuario-div-perfil-misvehiculos').removeClass('inactivo');
                    if($('.usuario-div-perfil-misvehiculos').hasClass('activo') == false){
                        var src = $('.usuario-div-perfil-misvehiculos').find('img').attr('src');
                        var subsrc = src.replace('-inactivo', '');
                        $('.usuario-div-perfil-misvehiculos').find('img').attr('src', subsrc);

                    }
                    $('.usuario-div-perfil-misvehiculos').addClass('activo');
                    if($('.usuario-div-perfil-misvehiculos').hasClass('activo')){
                        var inactivo =  $('.inactivo');
                        inactivo.each(function(i, e){
                            var scr1= $(e).find('img').attr('src');
                            if(scr1.indexOf('-inactivo.png') == -1){
                                var substr1 = scr1.replace('.png', '-inactivo.png');
                                $(e).find('img').attr('src', substr1);
                            }
                        });
                        
                    }
                }
                else if(y >= smv && y < ofertas){
                    $('.usuario-div-perfil-tarea').css('color', '#564B47')
                    $('.usuario-div-perfil-sobrevehiculo').css('color', '#C60200');
                    $('.activo').addClass('inactivo');
                    $('.activo').removeClass('activo');
                    $('.usuario-div-perfil-sobrevehiculo').removeClass('inactivo');
                    if($('.usuario-div-perfil-sobrevehiculo').hasClass('activo') == false){
                        var src = $('.usuario-div-perfil-sobrevehiculo').find('img').attr('src');
                        var subsrc = src.replace('-inactivo', '');
                        $('.usuario-div-perfil-sobrevehiculo').find('img').attr('src', subsrc);

                    }
                    $('.usuario-div-perfil-sobrevehiculo').addClass('activo');
                    if($('.usuario-div-perfil-sobrevehiculo').hasClass('activo')){
                        var inactivo =  $('.inactivo');
                        inactivo.each(function(i, e){
                            var scr1= $(e).find('img').attr('src');
                            if(scr1.indexOf('-inactivo.png') == -1){
                                var substr1 = scr1.replace('.png', '-inactivo.png');
                                $(e).find('img').attr('src', substr1);
                            }
                        });
                        
                    }
                }else if(y >= ofertas && y <comunidad){
                    $('.usuario-div-perfil-tarea').css('color', '#564B47')
                    $('.usuario-div-perfil-ofertas').css('color', '#C60200');
                    $('.activo').addClass('inactivo');
                    $('.activo').removeClass('activo');
                    $('.usuario-div-perfil-ofertas').removeClass('inactivo');
                    if($('.usuario-div-perfil-ofertas').hasClass('activo') == false){
                        var src = $('.usuario-div-perfil-ofertas').find('img').attr('src');
                        var subsrc = src.replace('-inactivo', '');
                        $('.usuario-div-perfil-ofertas').find('img').attr('src', subsrc);

                    }
                    $('.usuario-div-perfil-ofertas').addClass('activo');
                    if($('.usuario-div-perfil-ofertas').hasClass('activo')){
                        var inactivo =  $('.inactivo');
                        inactivo.each(function(i, e){
                            var scr1= $(e).find('img').attr('src');
                            if(scr1.indexOf('-inactivo.png') == -1){
                                var substr1 = scr1.replace('.png', '-inactivo.png');
                                $(e).find('img').attr('src', substr1);
                            }
                        });
                        
                    }
                    //                }else if(y >= ofertas && y <comunidad){
                    //                    $('.usuario-div-perfil-tarea').css('color', '#564B47')
                    //                    $('.usuario-div-perfil-compras').css('color', '#C60200');
                    //                    $('.activo').addClass('inactivo');
                    //                    $('.activo').removeClass('activo');
                    //                    $('.usuario-div-perfil-compras').removeClass('inactivo');
                    //                    if( $('.usuario-div-perfil-compras').hasClass('activo') == false){
                    //                        var src =  $('.usuario-div-perfil-compras').find('img').attr('src');
                    //                        var subsrc = src.replace('-inactivo', '');
                    //                        $('.usuario-div-perfil-compras').find('img').attr('src', subsrc);
                    //
                    //                    }
                    //                    $('.usuario-div-perfil-compras').addClass('activo');
                    //                    if($('.usuario-div-perfil-compras').hasClass('activo')){
                    //                        var inactivo =  $('.inactivo');
                    //                        inactivo.each(function(i, e){
                    //                            var scr1= $(e).find('img').attr('src');
                    //                            if(scr1.indexOf('-inactivo.png') == -1){
                    //                                var substr1 = scr1.replace('.png', '-inactivo.png');
                    //                                $(e).find('img').attr('src', substr1);
                    //                            }
                    //                        });
                    //                        
                    //                    }
                }else if(y >= comunidad){
                    $('.usuario-div-perfil-tarea').css('color', '#564B47')
                    $('.usuario-div-perfil-comunidad').css('color', '#C60200');
                    $('.activo').addClass('inactivo');
                    $('.activo').removeClass('activo');
                    $('.usuario-div-perfil-comunidad').removeClass('inactivo');
                    if($('.usuario-div-perfil-comunidad').hasClass('activo') == false){
                        var src = $('.usuario-div-perfil-comunidad').find('img').attr('src');
                        var subsrc = src.replace('-inactivo', '');
                        $('.usuario-div-perfil-comunidad').find('img').attr('src', subsrc);
                        
                    }
                    $('.usuario-div-perfil-comunidad').addClass('activo');
                    if($('.usuario-div-perfil-comunidad').hasClass('activo')){
                        var inactivo =  $('.inactivo');
                        inactivo.each(function(i, e){
                            var scr1= $(e).find('img').attr('src');
                            if(scr1.indexOf('-inactivo.png') == -1){
                                var substr1 = scr1.replace('.png', '-inactivo.png');
                                $(e).find('img').attr('src', substr1);
                            }
                        });
                        
                    }
                }
            });
        } 
	  
	  
        //muestra el mensaje si la imagen de la interogación le han dado click
	  
        $('.imagen-interogacion').click(function(){
            var imagen = $('img', this);
            var src = imagen.attr('src');
            var mensajeDiv = $('.usuario-div-mensaje', this);
            var mensaje = mensajeDiv.css('display');
            if(mensaje == 'none'){
                mensajeDiv.css('display', 'block');
            }else{
                mensajeDiv.css('display', 'none');
            }
		
            if(src.indexOf('interogacion.png') != -1){
                var nuevo = src.replace('interogacion.png' ,'interogacion-2.png');
                imagen.attr('src' , nuevo);
            }
        });	
	 
        //Despliega el formulario de creación de un vehículo
        $('#usuario-div-mv-anadir').click(function(){
            var target_offset = $('.adicionar').offset();
            var target_top = target_offset.top -150;
            $('html, body').animate({scrollTop:target_top}, 500);
            var padre = $('.adicionar');	
            padre.addClass('carroseleccionado');
            $('.usuario-div-editar' ,padre).text('Guardar');
            $('.editar-vehiculo-hidden', padre).show('fast'); 
            $('#usuario_formulario_agregar_vehiculo', padre).css('display', 'block');
        });
	
        //cuando le pasa por encima el mouse a la imagen del carro se vuelve activo
        $('.usuario-div-mv-vehiculo-marco').live({
            mouseenter:
                function(){
                var activo = $('.carroactivo:not(.carroseleccionado)');
                activo.addClass('carroinactivo');
                activo.removeClass('carroactivo');
		
                $('.usuario-div-mv-vehiculo').has(this).addClass('carroactivo');
                $('.usuario-div-mv-vehiculo').has(this).removeClass('carroinactivo');
            
            },
            mouseleave:
                function(){
                var activo1 = $('.carroactivo:not(.carroseleccionado)');
                activo1.addClass('carroinactivo');
                activo1.removeClass('carroactivo');
		
                $('.carroseleccionado').removeClass('carroinactivo');
                $('.carroseleccionado').addClass('carroactivo');
            
            }
        });
	
        //cuando se hace click sobre un carro se carga la información del automóvil por ajax
        $('.usuario-div-mv-vehiculo-marco').live("click",function(){
            $('.carroseleccionado.adicionar .editar-vehiculo-hidden').hide();
            $('#usuario_formulario_agregar_vehiculo').hide();
            $('.carroseleccionado:not(".adicionar") .editar-vehiculo-hidden').hide();
            $('.carroseleccionado:not(".adicionar") .editar-vehiculo-show').not('.usuario-div-editar').show();
            $('.carroseleccionado:not(".adicionar") .usuario-div-editar').hide();

            $('.carroseleccionado').removeClass('carroactivo');
            $('.carroseleccionado').addClass('carroinactivo');
            var padre = $('.usuario-div-mv-vehiculo').has(this);
            var id_usuario_vehiculo = $('.usuario_div_id_usuario_vehiculo', padre).text();
            var id_vehiculo = $('.usuario_div_id_vehiculo', padre).text();

            var adicionar = $('.adicionar').has(this);
            $('.usuario-div-editar' ,adicionar).text('Guardar');
            $('.usuario-div-editar' ,adicionar).hide();
            $('.editar-vehiculo-hidden', adicionar).show('fast'); 
            $('#usuario_formulario_agregar_vehiculo', adicionar).css('display', 'block');


            var auto = $('.usuario-span-marca-carro', padre).text();
            $('.carroseleccionado').removeClass('carroseleccionado');
            $('.usuario-div-mv-vehiculo').has(this).addClass('carroseleccionado');
            $('.usuario-div-mv-vehiculo').has(this).removeClass('carroinactivo');
            $('.usuario-div-mv-vehiculo').has(this).addClass('carroactivo');
            carroSeleccionado = $('.usuario-div-mv-vehiculo').has(this);

            $('.carroseleccionado:not(".adicionar") .usuario-div-editar').text('Editar');
            $('.carroseleccionado:not(".adicionar") .usuario-div-editar').show();
            
            var mostar_secciones = $(padre).hasClass(".adicionar");
            //carga la información de las tareas por ajax
            if(mostar_secciones == false){
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>usuario/mostrar_vehiculo_tareas_ajax",
                    async: false,
                    data: "id_usuario_vehiculo=" + id_usuario_vehiculo + "&id_usuario=" + <?php echo $usuario->id_usuario; ?>,
                    success: function(data){
                        $('#usuario-div-smv-content').empty();
                        $('#usuario-div-smv-content').html(data);
                    }
                });  

                //carga la información de las ofertas por ajax
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>usuario/mostrar_mas_ofertas_perfil_ajax",
                    async: false,
                    data: "id_vehiculo=" + id_vehiculo + "&offset=0"+ "&id_usuario=" + <?php echo $usuario->id_usuario; ?>,
                    success: function(data){
                        $('#usuario-div-ofertas-all').empty();
                        $('#usuario-div-ofertas-all').html(data);
                    }
                });    

                //cambia el titulo de la sesión smv por color rojo
                $('.tituloseleccionado').removeClass('tituloseleccionado');
                $('.usuario-span-titulo-carro').each(function(index, element) {
                    var textoTitulo = $(element).text();

                    if(textoTitulo == auto){
                        $('#usuario-div-smv-content-carro').text(textoTitulo);
                        $(element).addClass('tituloseleccionado');	
                    }
                });

            }

        });
        
        //cambia los datos al hacer click sobre el titulo del carro
        $('.usuario-span-titulo-carro').live('click',function(){
            var texto = $(this).text();
            var tituloCarro = $('.usuario-span-marca-carro');
            tituloCarro.each(function(i,e){
                if($(e).text().match(texto)){
                    var padre = $('.usuario-div-mv-vehiculo').has(e);
                    $('.usuario-div-mv-vehiculo-marco', padre).trigger('click');
                    return false;
                }
            });
            //            var carroSeleccionado = $('.carroseleccionado');
            //            $('.usuario-div-mv-vehiculo-marco', carroSeleccionado).trigger('click');
        });
	
        //activa el lightbox cuando se hace click sobre la imagen, boton o nombre de oferta
        //Capturando el valor del id de la oferta se debe cargar por ajax los datos correspondientes a la oferta
        $('.lightboxme').live("click", function(){
            var padre = $('.usuario-div-oferta').has(this);
            var id_oferta = $('.usuario-div-id_oferta', padre).text();
            //carga la información de la oferta por ajax
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>usuario/mostrar_oferta_lightbox_ajax",
                async: false,
                data: "id_oferta=" + id_oferta + "&id_usuario=" + <?php echo $usuario->id_usuario; ?>,
                success: function(data){
                    $('.usuario-div-oferta-lightbox').remove();
                    $('#usuario-div-ofertas').append(data);
                }
            });    
            
            $('.usuario-div-oferta-lightbox').lightbox_me({
                fixedNavigation:true,
                closeSelector: '.usuario-div-oferta-lightbox-cerrar'
            });
        });
        
        
        //al hacer click sobre el input de realizado, 
        $('.usuario-div-smv-tarea-chkbox > :input[type=checkbox]:checked').live("click",function(){
            var id_tarea = $(this).val();
            var padre = $('.smv_tarea_realizar').has(this);
            $('.tarea_realizar_selected').removeClass('tarea_realizar_selected');
            $(padre).addClass('tarea_realizar_selected');
            //            var nombre = $('.usuario-div-tarea-nombre', padre).text();
            var id_usuario_vehiculo = $('.usuario_div_id_usuario_vehiculo','.carroseleccionado').text();
            //            padre.hide('slow', function(){ padre.remove(); });
  
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>usuario/mostrar_ya_hice_lightbox_ajax",
                async: false,
                data: 'id_tarea='+id_tarea +'&id_usuario_vehiculo='+id_usuario_vehiculo,
                success: function(data){
                    $('#usuario-div-smv-lightbox-realizar').empty();
                    $('#usuario-div-smv-lightbox-realizar').html(data);
                    $('#usuario-lightbox-ya-hise').lightbox_me({
                        centered: true,
                        closeSelector:".tarea_realizada_cancelar"
                    });
                }
            });
        });
        
        //al hacer click en deshacer, la tarea pasa de estar realizada a debe hacer o tengo pendiente
        $('.usuario-span-tareas-deshacer').live('click',function(){
            var padre = $('.usario-li-tarea-realizada').has(this);
            var id_tarea_realizada = $('.usuario-div-smv-hecho-tareas-id-tarea', padre).text();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>usuario/tarea_no_realizada_ajax",
                async: false,
                data: "id_tarea_realizada=" + id_tarea_realizada,
                success: function(data){
                    $('.usuario-div-mv-vehiculo-marco', '.carroseleccionado').trigger('click');

                }
            });
        });
        
        
        //imprime 5 preguntas, respuestas o talleres nuevos según sea el caso
        var ver_mas_preguntas = 5;
        var ver_mas_respuestas = 5;
        var ver_mas_talleres = 5;
        var ver_mas_compras = 6;
        var ver_mas_ofertas = 6;
        $('.div-ver-mas').click(function(){
            var este = $(this);
            var span = $('span', this);
            var div = $('div', this);
            if(span.hasClass('usuario-span-comunidad-vermas-preguntas') ){
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>usuario/mostrar_mas_preguntas_perfil_ajax",
                    async: false,
                    data: "offset=" + ver_mas_preguntas + "&id_usuario=" + <?php echo $usuario->id_usuario; ?>,
                    success: function(data){
                        ver_mas_preguntas += 5;
                        $('.usuario-div-comunidad-contenedor', '#usuario-div-comunidad-preguntas').append(data);
                        if(ver_mas_preguntas >= parseInt(<?php echo $numPreguntas; ?>) ){
                            este.css('display', 'none');
                        }
                        
                    }
                }); 
                    
            }else if(span.hasClass('usuario-span-comunidad-vermas-respuestas') ){
            
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>usuario/mostrar_mas_respuestas_perfil_ajax",
                    async: false,
                    data: "offset=" + ver_mas_respuestas + "&id_usuario=" + <?php echo $usuario->id_usuario; ?>,
                    success: function(data){
                        ver_mas_respuestas += 5;
                        if(parseInt(ver_mas_respuestas) >= parseInt(<?php echo $numRespuestas; ?>) ){
                            este.css('display', 'none');
                        }
                        $('.usuario-div-comunidad-contenedor', '#usuario-div-comunidad-respuestas').append(data);
                    }
                }); 
                
            }else if( span.hasClass('usuario-span-comunidad-vermas-talleres') ){
                
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>usuario/mostrar_mas_talleres_perfil_ajax",
                    async: false,
                    data: "offset=" + ver_mas_talleres + "&id_usuario=" + <?php echo $usuario->id_usuario; ?>,
                    success: function(data){
                        ver_mas_talleres += 5;
                        if(ver_mas_talleres > parseInt( <?php echo $numEstablecimientos; ?> )){
                            este.css('display', 'none');
                        }                        
                        $('.usuario-div-comunidad-contenedor', '#usuario-div-comunidad-talleres').append(data);
                    }
                }); 
                
//            }else if( span.hasClass('usuario-span-compras-vermas') ){
//                
//                $.ajax({
//                    type: "POST",
//                    url: "<?php echo base_url(); ?>usuario/mostrar_mas_compras_perfil_ajax",
//                    async: false,
//                    data: "offset=" + ver_mas_compras + "&id_usuario=" + <?php echo $usuario->id_usuario; ?>,
//                    success: function(data){
//                        ver_mas_compras += 6;
//                        if(ver_mas_compras > parseInt( <?php echo $numCarrito; ?> )){
//                            este.css('display', 'none');
//                        }
//                        $('#usuario-div-tareas-all').append(data);
//                    }
//                }); 
                
            }else if( div.hasClass('usuario-span-ofertas-vermas') ){
                
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>usuario/mostrar_mas_ofertas_perfil_ajax",
                    async: false,
                    data: "offset=" + ver_mas_ofertas + "&id_usuario=" + <?php echo $usuario->id_usuario; ?>,
                    success: function(data){
                        ver_mas_ofertas += 4;
                        if((parseInt(ver_mas_ofertas)) > parseInt( <?php echo $numOfertas; ?> )){
                            este.css('display', 'none');
                        }
                        $('#usuario-div-ofertas-all').append(data);
                    }
                }); 
                
            }
        });
        
        
        //esconde el span de ver más para los casos de que el offset sea mayor
        //al número de preguntas, respuestas o talleres
        if(parseInt(ver_mas_respuestas) >= parseInt(<?php echo $numRespuestas; ?>) ){
            $('.usuario-div-respuestas-vermas').css('display', 'none');
        }
        if(ver_mas_preguntas >= parseInt(<?php echo $numPreguntas; ?>) ){
            $('.usuario-div-preguntas-vermas').css('display', 'none');
        }
        if(ver_mas_talleres > parseInt( <?php echo $numEstablecimientos; ?> )){
            $('.usuario-div-talleres-vermas').css('display', 'none');
        }
        //        if(ver_mas_compras > parseInt( <?php echo $numCarrito; ?> )){
        //            $('.usuario-div-compra-vermas').css('display', 'none');
        //        }
        if(ver_mas_ofertas > parseInt( <?php echo $numOfertas; ?> )){
            $('.usuario-div-ofertas-vermas').css('display', 'none');
        }
        
        
        //cuando se hace click en editar se hace visible el formulario
        $('#usuario-div-mv-all .usuario-div-editar').live("click",function(){
            var padre = $('.usuario-div-mv-vehiculo').has(this);
            $(this).text('Guardar');
            $('.editar-vehiculo-show', padre).hide('fast');
            $('.editar-vehiculo-hidden', padre).show('fast'); 
        });
        
        //cuando se hace click en editar perfil se edita la información del perfil
        $('#usuario-div-perfil-info .usuario-div-editar').live("click",function(){
            var padre = $('#usuario-div-perfil-info').has(this);
            $(this).text('Guardar');
            $('.editar-perfil-show', padre).hide('fast');
            $('.editar-perfil-hidden', padre).show('fast');
            $(this).hide();
            
        });
        
        //Valida el formulario de editar vehiculo
        $('.usuario_formulario_editar_vehiculo').each(function(i, e){
            $(e).validate({
                rules:{
                    vehiculo_id:{
                        required: true
                    },
                    kilometraje:{
                        required: true,
                        number: true
                    },
                    placa:{
                        maxlength: 7
                    },id_vehiculos:{
                        required: true
                    }
                },
                messages: {
                    kilometraje:{
                        required: "El kilometraje no puede estar vacío",
                        number: "El kilometraje debe ser un número mayor a 0"
                    },
                    placa:{
                        maxlength: "Se encontró un error en los datos suministrados"
                    },vehiculo_id:{
                        required: "El vehículo que especificaste no se encuentra registrado en nuestra base de datos" 
                    },id_vehiculos:{
                        required: "*Ingresa la marca y línea de tu vehículo" 
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
                                errors += "<br/>" +  "\n\u25CF " + validator.errorList[x].message;
                            }
                        }
                        confirm(message + errors, function () {
                                                        $.modal.close();
                                                    });
//                        alert(message + errors);
                    }
                    validator.focusInvalid();
                }
                ,submitHandler: function(form){
                    var padre = $('.usuario-div-mv-vehiculo').has(form);
                    var elem = $('.usuario-div-editar', padre);

                    var lineamodelo = $('.vehiculos', padre).val();
                    var modelo_elem = $('.input_modelo', padre);
                    var id_vehiculo_elem = $('.hidden_carro_selected', padre);
                    var kilometraje_elem = $('.usuario-div-mv-vehiculo-kilometraje-editar input', padre);
                    var placa_elem = $('.usuario-div-mv-vehiculo-placa-editar input', padre);
                    var id_usuario_vehiculo_elem = $('.usuario_div_id_usuario_vehiculo', padre);

                    var modelo = modelo_elem.val();
                    var id_vehiculo = id_vehiculo_elem.val();
                    var kilometraje = kilometraje_elem.val();
                    var placa;
                    if(!placa_elem.val()){
                        placa = ''; 
                    }else{
                        placa = placa_elem.val();
                    }
                    var id_usuario_vehiculo = id_usuario_vehiculo_elem.text();

                    $.ajax({
                        type: "POST",
                        url: "usuario/editar_vehiculo_ajax",
                        async: false,
                        data: "id_vehiculo=" + id_vehiculo + "&id_usuario_vehiculo=" + id_usuario_vehiculo + "&modelo=" + modelo 
                            + "&kilometraje=" + kilometraje + "&placa=" + placa+ "&vehiculo=" + lineamodelo,
                        success: function(data){
                            var corrio = data.split('|');
                            if(corrio[0] == 'true'){
                                //                                window.location.reload();
                                elem.text('Editar');
                                $('.usuario-span-marca-carro', padre).text(lineamodelo);
                                $('.usuario-div-mv-vehiculo-modelo', padre).text(modelo);
                                $('.usuario-div-mv-vehiculo-kilometraje', padre).text(kilometraje);
                                $('.usuario-div-mv-vehiculo-placa', padre).text(placa);
                                $('.editar-vehiculo-show', padre).show('fast');
                                $('.editar-vehiculo-hidden', padre).hide('fast'); 
                                
                                //carga la información de las tareas por ajax
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo base_url(); ?>usuario/mostrar_vehiculo_tareas_ajax",
                                    async: false,
                                    data: "id_usuario_vehiculo=" + id_usuario_vehiculo + "&id_usuario=" + <?php echo $usuario->id_usuario; ?>,
                                    success: function(data){
                                        $('#usuario-div-smv-content').empty();
                                        $('#usuario-div-smv-content').html(data);
                                    }
                                }); 
                            }else{
                                try{
                                    var respuesta = $.parseJSON(corrio[1]);
                                    var error;
                                    $.each(respuesta, function(k,v){
                                        if(v.length>0){
                                            error = v+'\n';
                                        }
                                    
                                    });
                                }
                                catch(b)
                                {
                                    var respuesta = corrio[1];
                                    var error;
                                
                                    error = respuesta;
                                  
                                }
                               confirm(error, function () {
                                                        $.modal.close();
                                                    });
//                                alert(error);
                            }
                        }
                    });

                }

            });
        });
        
        
        
        // Valida el formulario de agregar un vehiculo
        $('#usuario_formulario_agregar_vehiculo').validate({
            rules:{
                vehiculo_id:{
                    required: true
                },
                kilometraje:{
                    required: true,
                    number: true
                },
                placa:{
                    maxlength: 7
                },id_vehiculos:{
                    required: true
                }
            },
            messages: {
                kilometraje:{
                    required: "*Debes Ingresar tu kilometraje",
                    number: "*Debes ingresar un kilometraje que sea un número mayor a 0" 
                },
                placa:{
                    maxlength: "*Se encontró un error en los datos suministrados"
                },
                vehiculo_id:{
                    required: "*Ingresa la marca y línea de tu vehículo" 
                },
                id_vehiculos:{
                    required: "*Ingresa la marca y línea de tu vehículo" 
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
                            errors += "<br/>" +  "\n\u25CF " + validator.errorList[x].message;
                        }
                    }
                    confirm(message + errors, function () {
                                                        $.modal.close();
                                                    });
//                    alert(message + errors);
                }
                validator.focusInvalid();
            },submitHandler: function(form){
                var padre = $('.usuario-div-mv-vehiculo').has(form);
                var elem = $('.usuario-div-editar', padre);
                var lineamodelo = $('.vehiculos', padre).val();
                var modelo_elem = $('#modelo', padre);
                var id_vehiculo_elem = $('.hidden_carro_selected', padre);
                var kilometraje_elem = $('.usuario-div-mv-vehiculo-kilometraje-editar input', padre);
                var placa_elem = $('.usuario-div-mv-vehiculo-placa-editar input', padre);
                var modelo = modelo_elem.val();
                var id_vehiculo = id_vehiculo_elem.val();
                var kilometraje = kilometraje_elem.val();
                var placa;
                if(!placa_elem.val()){
                    placa = ''; 
                }else{
                    placa = placa_elem.val();
                }
                var id_usuario = '<?php echo $usuario->id_usuario; ?>';
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>usuario/agregar_vehiculo_ajax",
                    async: false,
                    data: "id_vehiculo=" + id_vehiculo + "&modelo=" + modelo 
                        + "&kilometraje=" + kilometraje + "&placa=" + placa + "&id_usuario=" + id_usuario+ "&vehiculo=" + lineamodelo,
                    success: function(data){
                        var corrio = data.split('|');
                        if(corrio[0] == 'true'){
                            window.location.reload();
                        }else{
                            try{
                                var respuesta = $.parseJSON(corrio[1]);
                                var error;
                                $.each(respuesta, function(k,v){
                                    if(v.length>0){
                                        error = v+'\n';
                                    }
                                    
                                });
                            }
                            catch(b)
                            {
                                var respuesta = corrio[1];
                                var error;
                                
                                error = respuesta;
                                  
                            }
                            confirm(error, function () {
                                                        $.modal.close();
                                                    });   
//                            alert(error);
                        }
                    }
                }); 
                
            }
                   
        });
        
        //valida el formulario de editar perfil
        $("#usuario_formulario_perfil").validate({
            rules: {
                nombres: {
                    required: true
                    ,maxlength: 20
                },
                apellidos: {
                    required: true
                    ,maxlength: 20
                },
                usuario: {
                    required: true
                    ,minlength: 5
                    ,maxlength: 25
                    ,remote: {
                        url: "usuario/validar_usuario_existente_ajax",
                        type: "POST",
                        async:false,
                        data: {
                            usuario: function(){
                                return $("#usuario_input_perfil_usuario").val();
                            }
                                    
                        }
                    }
                },
                email:{
                    required: true,
                    email: true
                    ,remote: {
                        url: "usuario/validar_email_existente_ajax",
                        type: "POST",
                        async:false,
                        data: {
                            email: function(){
                                return $("#usuario_input_perfil_email").val();
                            }
                                    
                        }
                    }
                },
                lugar:{
                    required: true
                }
            },
            messages: {
                email: {
                    required: "*Escriba su correo electrónico",
                    email: "*Escriba un correo electrónico válido"
                    ,remote: "Ya existe alguien registrado con el mail que especificaste"
                },
                nombres: {
                    required: "*Escriba sus nombres"
                    ,maxlength: "Porfavor no ingresar más de 20 caracteres"
                },
                apellidos: {
                    required: "*Escriba sus apellidos"
                    ,maxlength: "Porfavor no ingresar más de 20 caracteres"
                },
                lugar: {
                    required: "*Escriba el lugar donde vive"
                },
                usuario: {
                    required: "*Escriba un usuario"
                    ,remote: "Ya existe alguien registrado con el usuario que especificaste"
                    ,minlength: "El usuario debe contener al menos 5 caracteres"
                    ,maxlength: "Porfavor no ingresar más de 20 caracteres"
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
                            errors += "<br/>" +  "\n\u25CF " + validator.errorList[x].message;
                        }
                    }
                    confirm(message + errors, function () {
                                                        $.modal.close();
                                                    });
//                    alert(message + errors);
                }
                validator.focusInvalid();
            }
            ,submitHandler: function(form){
                var nombres = $('#usuario_input_perfil_nombres').val();
                var apellidos = $('#usuario_input_perfil_apellidos').val();
                var usuario = $('#usuario_input_perfil_usuario').val();
                var email = $('#usuario_input_perfil_email').val();
                var lugar = $('#usuario_input_perfil_lugar').val();

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>usuario/editar_perfil_ajax",
                    async: false,
                    data: "id_usuario=" + <?php echo $usuario->id_usuario; ?> +
                        "&nombres=" + nombres + 
                        "&apellidos=" + apellidos + 
                        "&usuario=" + usuario +
                        "&email=" + email + 
                        "&lugar=" + lugar,
                    success: function(data){
                        var corrio = data.split('|');
                        if(corrio[0] == 'true' || corrio[0]== true){
                            $('#usuario-div-perfil-info .usuario-div-editar').text("Editar Perfil");
                            $('#usuario-div-perfil-info .usuario-div-editar').show();
                            $('#usuario-div-perfil-info-usuario').text(usuario);
                            $('#usuario-div-perfil-info-email').text(email);
                            $('#usuario-div-perfil-info-lugar').text(lugar);
                            $('#usuario-div-perfil-info-nombresapellidos').text(nombres+" "+apellidos);
                            $('#usuario-div-perfil-info .editar-perfil-show').show('fast');
                            $('#usuario-div-perfil-info .editar-perfil-hidden').hide('fast'); 
                        }else{
                            try{
                                var respuesta = $.parseJSON(corrio[1]);
                                var error;
                                $.each(respuesta, function(k,v){
                                    if(v.length>0){
                                        error = v+'\n';
                                    }
                                    
                                });
                            }
                            catch(b)
                            {
                                var respuesta = corrio[1];
                                var error;
                                
                                error = respuesta;
                                  
                            }
                            confirm(error, function () {
                                                        $.modal.close();
                                                    });   
//                            alert(error);
                        }
                    }
                }); 
                return false;
            }
            
        });
        
        
        
        //Edita la foto de los automoviles
        $('.input_imageUpload_automovil').each(function(i, e){
            var padre = $('.usuario-div-mv-vehiculo').has(e);
            var thumb = $('.usuario-div-mv-vehiculo-marco-contenedor img', padre);	
            var id = e.id;
            new AjaxUpload(id, {
                action: $('form.subir_imagen_automovil', padre).attr('action'),
                name: 'image',
                onSubmit: function(file, extension) {

                    $('.usuario-div-mv-vehiculo-marco-contenedor', padre).addClass('loading_subir_imagen_automovil');
                    $('img', padre).css('display', 'none');
                    this.setData({id_usuario: <?php echo $usuario->id_usuario; ?>, id_usuario_vehiculo: $('.usuario_div_id_usuario_vehiculo', padre).text() });
                },
                onComplete: function(file, response) {
                    thumb.load(function(){
                        $('.usuario-div-mv-vehiculo-marco-contenedor', padre).removeClass('loading_subir_imagen_automovil');
                        $('img', padre).css('display', 'block');
                        thumb.unbind();
                    });
                    thumb.attr('src', response);

                }
            });
        });
      
        //Edita la foto de usuario del perfil
        var thumb_perfil = $('#usuario-div-foto-marco img');
        new AjaxUpload('#imagen_perfil', {
            action: $('form#subir_imagen_perfil').attr('action'),
            name: 'image',
            onSubmit: function(file, extension) {

                $('#usuario-div-foto-marco').addClass('loading_subir_imagen_automovil_perfil');
                $('#usuario-div-foto-marco img').css('display', 'none');
                this.setData({id_usuario: <?php echo $usuario->id_usuario; ?> });
            },
            onComplete: function(file, response) {
                thumb_perfil.load(function(){
                    $('#usuario-div-foto-marco').removeClass('loading_subir_imagen_automovil_perfil');
                    $('#usuario-div-foto-marco img').css('display', 'block');
                    thumb_perfil.unbind();
                });
                thumb_perfil.attr('src', response);

            }
        });
        
        
        //al hacer click sobre cancelar, se esconde el formulario de editar 
        //y muestra la información que había antes
        $('.cancelar-formulario').live("click",function(){
            var padre_perfil = $('#usuario-div-perfil-info').has(this);
            var padre_vehiculos = $('.usuario-div-mv-vehiculo-center').has(this);
            //            var padre_vehiculos_no_adicionar = $('.usuario-div-mv-vehiculo-center:not(.adicionar)').has(this);
            var no_adicionar = $('.usuario-div-mv-vehiculo').has(this).hasClass('adicionar');
            if(padre_perfil){
                $('.editar-perfil-hidden', padre_perfil).hide();
                $('.editar-perfil-show', padre_perfil).show();
                $('.usuario-div-editar', padre_perfil).text('Editar Perfil');
            }
            if(padre_vehiculos){
                $('.editar-vehiculo-hidden', padre_vehiculos).hide();
                if(no_adicionar){
                    $('#usuario_formulario_agregar_vehiculo').hide();
                }  
                else{
                    $('.editar-vehiculo-show', padre_vehiculos).show();
                }
                   
                $('.usuario-div-editar', padre_vehiculos).text('Editar');
            }
        });
        
        //al hacer click sobre los iconos de las tarjetas se hace submit al formulario de POL
        $('.usuario-div-oferta-tarjetas').live('click',function(){
            $('#forma_pagosonline').submit();
        });
        
        
        //muestra el cronograma de tareas al dar click en "ver lo que tengo que hacer durante el año"
        $('.usuario-div-smv-cronograma').live('click',function(){
            var padre = $('.carroseleccionado');
            var id_usuario_vehiculo = $('.usuario_div_id_usuario_vehiculo', padre).text();
            //carga la información de la oferta por ajax
            window.location = '<?php echo base_url(); ?>usuario/cronograma/'+id_usuario_vehiculo;
            //            $.ajax({
            //                type: "POST",
            //                url: "<?php // echo base_url();   ?>usuario/mostrar_cronograma_lightbox_ajax",
            //                async: false,
            //                data: "id_usuario_vehiculo=" + id_usuario_vehiculo ,
            //                success: function(data){
            //                    $('#usuario-div-lightbox-cronograma').remove();
            //                    $('#usuario-div-smv').append(data);
            //                }
            //            });    
            //            
            //            $('#usuario-div-lightbox-cronograma').lightbox_me({
            //                centered: true
            //            });
        });
        
        
        //al hacer click en el formulario de enviar soat, se envía el número telefonico
        $('.usuario-input-smv-soat').live('click', function(){
            var padre = $('.carroseleccionado');
            var padreTel = $('.usuario-div-smv-soat-telefono').has(this);
            var id_usuario_vehiculo = $('.usuario_div_id_usuario_vehiculo', padre).text();
            var modelo = $('.usuario-div-mv-vehiculo-modelo', padre).text();
            var telefono = $('.usuario-input-smv-telefono', padreTel).val();
            if((modelo.length >0 && modelo != 0) ){
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>usuario/cotizar_SOAT_ajax",
                    async: false,
                    data: "id_usuario_vehiculo=" + id_usuario_vehiculo+"&telefono=" +telefono,
                    success: function(data){
                        confirm('Tu solicitud ha sido enviada, en breve vas a recibir respuesta de uno de nuestros agentes.', function () {
                                                        $.modal.close();
                                                    });
//                        alert('Tu solicitud ha sido enviada, en breve vas a recibir respuesta de uno de nuestros agentes.');
                    }
                });    
            }else{
                confirm('Debes ingresar el modelo de tu carro para poder cotizar el valor de tu SOAT', function () {
                                                        $.modal.close();
                                                    });
//                alert('Debes ingresar el modelo de tu carro para poder cotizar el valor de tu SOAT');
            }
        });
        
        
        //muestra la tarea seleccionada al dar click a qué pasa si no lo hago
        $('.usuario-div-smv-db-content-t3').live('click',function(){
            var padreVehiculo = $('.carroseleccionado');
            var id_vehiculo = $('.usuario_div_id_vehiculo', padreVehiculo).text();
            var padre = $('.smv_tarea_realizar').has(this);
            var tarea = $('.usuario-input-smv-tarea-chkbox', padre).val();
            //carga la información de la oferta por ajax
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>usuario/mostrar_tarea_lightbox_ajax",
                async: false,
                data: "tarea=" + tarea+"&id_vehiculo=" +id_vehiculo,
                success: function(data){
                    $('#usuario-div-lightbox-tarea').empty();
                    $('#usuario-div-lightbox-tarea').append(data);
                }
            });    
            
            $('#usuario-div-lightbox-tarea').lightbox_me({fixedNavigation:true});
        });
        
        //al hacer click en el ver más de la tarea, le despliega las otras tareas
        $('.usuario-div-smv-vermas').live('click',function(){
            $('.usuario-div-smv-vermas').bind('click');
            var mostrar = false;
            $('.smv_div_tareas').each(function(i, padre){
                $('.tarea_hidden', padre).each(function(index, element){
                    if(index <8 && i == 2)
                        $(element).removeClass('tarea_hidden');
                    else if(index <2 && (i == 1 || i == 0))
                        $(element).removeClass('tarea_hidden');
                });
                if($('.tarea_hidden', padre).length > 0)
                    mostrar = true;
            });
            if(!mostrar){
                $('.usuario-div-smv-vermas').css('display', 'none');
                mostrar = false;
            }
            $('.usuario-div-smv-vermas').unbind('click');
        });
        
    });
</script>