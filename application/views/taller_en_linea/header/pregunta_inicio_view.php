<script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery.lightbox_me.js"></script>
<link href="<?php echo base_url() ?>resources/css/autopartes.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>resources/css/jquery.ui.all.css" rel="stylesheet" type="text/css"  media="screen" />



<script>
    var pagActual = parseInt($('#input_paginacion_pagina').val());
    var limite = $('span:last', '#autopart-div-pagination').text();
    if(pagActual<= 1){
        $('.paginacion-atras').css('display', 'none');
    }
    if ( limite <= pagActual){
        $('.paginacion-adelante').css('display', 'none');
    }
    
</script>
<script>
    
    $(document).ready(function(){


        //muestra hover el titulo seleccionado
        var titulocategoria = $('span', '#filtro-categoria').text();
        $('.autopart-h4-categoria-titulo').each( function(index, element){
            if($('span:first', element).text() == titulocategoria){
                $(element).addClass('titulo-servicio-seleccionado');
                $(element).css('background-color', 'black');
                $(element).css('color', 'white');
                $('span',element).css('color', 'white');
            }

        });
            
        //esconde y muestra la subcategoria de busqueda al hacer click
        $('.tallerlinea-span-pregunta-categoria').click(function(){
            var busqueda = $(this).text();
            var url = window.location.pathname;
            var urlArray =  url.split("/");
            var encontro = false;
            var pocision = 0;
            $.each(urlArray, function(i, e){
                if (e == 'categoria') {
                    encontro = true;
                    pocision = i+1;
                }
                if(e == 'pagina') {
                    urlArray[i+1] = '1';
                }
            });
                    
            if(encontro){
                urlArray[pocision] = busqueda;
                var nuevaUrl = '';
                $.each(urlArray, function(i, e){
                    e = specialCharacters(e);
                    if(i==1){
                        nuevaUrl = nuevaUrl+ e;   
                    }else if(i>=2){
                        nuevaUrl = nuevaUrl+'/'+ e;   
                    }
                });
                window.location = 'http://'+window.location.host+'/'+nuevaUrl;
            }else{
                busqueda = specialCharacters(busqueda);
                var nuevaUrl = '';
                $.each(urlArray, function(i, e){
                    e = specialCharacters(e);
                    if(i==1){
                        nuevaUrl = nuevaUrl+ e;   
                    }else if(i>=2){
                        nuevaUrl = nuevaUrl+'/'+ e;   
                    }
                });
                if(url.search('buscar') != -1 )
                    window.location = 'http://'+window.location.host+'/'+nuevaUrl +'/categoria/' + busqueda;
                else
                    window.location = 'http://'+window.location.host+'/'+nuevaUrl +'/buscar/categoria/' + busqueda;
            }
        });

        //esconde y muestra la subcategoria de busqueda al hacer click
        $('.autopart-h4-categoria-titulo').click(function(){
            var padre = $('.autopart-div-categoria').has(this);
            var busqueda = $('span:first',this).text();
            var url = window.location.pathname;
            var urlArray =  url.split("/");
            var encontro = false;
            var pocision = 0;
            if(padre.hasClass('filtro-categoria')){
                $.each(urlArray, function(i, e){
                    if (e == 'categoria') {
                        encontro = true;
                        pocision = i+1;
                    }
                    if(e == 'pagina') {
                        urlArray[i+1] = '1';
                    }
                });
                    
                if(encontro){
                    urlArray[pocision] = busqueda;
                    var nuevaUrl = '';
                    $.each(urlArray, function(i, e){
                        e = specialCharacters(e);
                        if(i==1){
                            nuevaUrl = nuevaUrl+ e;   
                        }else if(i>=2){
                            nuevaUrl = nuevaUrl+'/'+ e;   
                        }
                    });
                    window.location = 'http://'+window.location.host+'/'+nuevaUrl;
                }else{
                    busqueda = specialCharacters(busqueda);
                    var nuevaUrl = '';
                    $.each(urlArray, function(i, e){
                        e = specialCharacters(e);
                        if(i==1){
                            nuevaUrl = nuevaUrl+ e;   
                        }else if(i>=2){
                            nuevaUrl = nuevaUrl+'/'+ e;   
                        }
                    });
                    if(url.search('buscar') != -1 )
                        window.location = 'http://'+window.location.host+'/'+nuevaUrl +'/categoria/' + busqueda;
                    else
                        window.location = 'http://'+window.location.host+'/'+nuevaUrl +'/buscar/categoria/' + busqueda;
                }
                   
            }
        });
	
        //al estar hover sobre una categoria o subcategoria, el fondo cambia a negro
        $('.autopart-h4-categoria-titulo:not(.titulo-servicio-seleccionado)').live({
            mouseenter:
                function(){
                $(this).css('background-color', 'black');
                $(this).css('color', 'white');
                $('span',this).css('color', 'white');
            },
            mouseleave:
                function(){
                $(this).css('background-color', 'transparent');
                $('span:first',this).css('color', 'black');
                $('span:last',this).css('color', '#c60200');
            }
        });
        
        
        //encargada de hacer el submit de la paginacion
        $('form#form_paginacion').submit(function(){
            var pagina = $('#input_paginacion_pagina', this).val();
            var url = window.location.pathname;
            var urlArray =  url.split("/");
            var encontro = false;
            var pocision = 0;
            $.each(urlArray, function(i, e){
                if (e == 'pagina') {
                    encontro = true;
                    pocision = i+1;
                }
            });
            if(encontro){
                urlArray[pocision] = pagina;
                var nuevaUrl = '';
                $.each(urlArray, function(i, e){
                    e = specialCharacters(e);
                    if(i==1){
                        nuevaUrl = nuevaUrl+ e;   
                    }else if(i>=2){
                        nuevaUrl = nuevaUrl+'/'+ e;   
                    }
                });
                window.location = 'http://'+window.location.host+'/'+nuevaUrl;
            }else{
                pagina = specialCharacters(pagina);
                if(url.search('buscar') != -1 )
                    window.location = url +'/pagina/' + pagina;
                else
                    window.location = url +'/buscar/pagina/' + pagina;
            }
            return false;
        });
        
        
        //Al dar click sobre la X de un filtro, este filtro se cancela
        $('.autopart-div-filtro-x').live('click',function(){
            var padre= $('.autopart-div-filtro').has(this);
            var id = $(padre).attr('id');
            var url = window.location.pathname;
            var urlArray =  url.split("/");
            var nuevaUrl = '';
            var next = false;
            $.each(urlArray, function(i, e){
                if (e == 'categoria' && (id == 'filtro-categoria')) {
                    next = true;
                }else if(e == 'pagina') {
                    next = true;
                }else{
                    if(next == false && i>=1){
                        nuevaUrl = nuevaUrl+'/'+ e;      
                    }else{
                        next = false;
                    }
                       
                }
            });
            window.location = 'http://'+window.location.host+nuevaUrl;
        
        });
        
        
        
        //cuando se da click sobre las flechas adelante y atras en la pagínacion
        //esta lo lleva a la página correspondiente
        $('.paginacion-flecha').live('click',function(){
            var id= $(this).attr('id');
            var padre = $('.autopart-div-pagination').has(this);
            var limite = $('span:last', padre).text();
            var pagActual = parseInt($('#input_paginacion_pagina', padre).val());
            var formulario = $('form.form_paginacion', padre);
            if(id.match('paginacion-adelante') && limite > pagActual){
                $('#input_paginacion_pagina', padre).val(pagActual+1);
                $(formulario).submit();
            }else if(id.match('paginacion-atras')&& pagActual >1 ){
                $('#input_paginacion_pagina', padre).val(pagActual-1);
                $(formulario).submit();
            }
           
        });
        
        
        //activa el lightbox cuando se hace click sobre el div de hacer contacto
        $('.lightbox-pregunta').click(function(){
            $.ajax({
                url: '<?php echo base_url(); ?>usuario/dar_sesion_activa_ajax',
                type: "POST",
                success: function(data) {
                    var sesion = data;
                    if(sesion){
                        $('#pregunta-div-form').lightbox_me({
                            fixedNavigation:true,
                            centered: true
                        });  
                    }else{
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>usuario/mostrar_registro_ajax",
                            success: function(data){
                                $('#registro-login-div').empty();
                                $('#registro-login-div').html(data);
                                $('#input-registro-callback').val('lightboxmepregunta');
                                $('#registro-login-div').lightbox_me({
                                    fixedNavigation:true,
                                    centered: true
                                }); 
                            }
                        }); //ajax
                    }//else
                }//success
            });//ajax           
        });//click

        $.validator.addMethod("textoDiferenteTitulo",
        function(value, element){
            if(value!="Escribe aquí tu pregunta...")
                return true;
            else
                return false;
        },
        "Escriba una pregunta"
    );
        $.validator.addMethod("textoDiferenteCuerpo",
        function(value, element){
            if(value!="Escribe aquí los detalles de tu pregunta...")
                return true;
            else
                return false;
        },
        "Escriba detalles de la pregunta" 
    );
        
        $("form#form-preguntar").validate({
            rules: {
                titulo_pregunta: {
                    required: true,
                    textoDiferenteTitulo: true,
                    maxlength: 150
                },
                cuerpo_pregunta: {
                    required: true,
                    textoDiferenteCuerpo: true
                }
            },
            messages: {
                titulo_pregunta: {
                    required: "*Escribe tu pregunta",
                    textoDiferenteTitulo: "*Escribe tu pregunta"
                },
                cuerpo_pregunta: {
                    required: "*Escribe una descripción de tu pregunta",
                    textoDiferenteCuerpo: "*Escribe una descripción de tu pregunta"
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
        });
        

        
        
    });
    
    
    
    //agrega un comentario realizado dinámicamente
    function lightboxmepregunta(){
        $('#registro-login-div').trigger('close');
        $.ajax({
            url: '<?php echo base_url(); ?>usuario/dar_sesion_activa_ajax',
            type: "POST",
            success: function(data) {
                var sesion = data;
                if(sesion){
                    $('#pregunta-div-form').lightbox_me({
                        fixedNavigation:true,
                        centered: true
                    });  
                }else{
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>usuario/mostrar_registro_ajax",
                        async: false,
                        success: function(data){
                            $('#registro-login-div').empty();
                            $('#registro-login-div').html(data);
                            $('#input-registro-callback').val('lightboxmepregunta');
                            $('#registro-login-div').lightbox_me({fixedNavigation:true,
                                centered: true }); 
                        }
                    }); 
                }
            }
        }); 
    } 
</script>