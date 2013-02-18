<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.lightbox_me.js"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.autocomplete.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>resources/css/autopartes.css" rel="stylesheet" type="text/css" />
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

        $(".vehiculos").autocomplete({
            source: vehiculos,
            change: function(e, ui){
                if(!ui.item){
                    $('.hidden_carro_selected').val('na');
                }   
            },select: function(e, ui) {
                $('.hidden_carro_selected').remove();
                var vehiculo_actual = ui.item.value;
                input = $("<input>").attr("type", "hidden").attr('value',ui.item.id_vehiculo).attr('name','vehiculo_id').attr("class", "hidden_carro_selected");
                span = $("<span>").html(vehiculo_actual);
                span.insertAfter(input);
                input.insertBefore(".vehiculos");
                
                //evento de google
                _gaq.push(['_trackEvent', 'Promocion', 'vehiculo', vehiculo_actual]);
                
                //cambia la url
                var url = window.location.pathname;
                var urlArray =  url.split("/");
                var encontro = false;
                var pocision = 0;
                $.each(urlArray, function(i, e){
                    if (e == 'vehiculo') {
                        encontro = true;
                        pocision = i+1;
                    }
                    if(e == 'pagina') {
                        urlArray[i+1] = '1';
                    }
                });
                    
                if(encontro){
                    urlArray[pocision] = vehiculo_actual;
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
                    vehiculo_actual = specialCharacters(vehiculo_actual);
                    var nuevaUrl = '';
                    $.each(urlArray, function(i, e){
                        if(i==1){
                            nuevaUrl = nuevaUrl+ e;   
                        }else if(i>=2){
                            nuevaUrl = nuevaUrl+'/'+ e;   
                        }
                    });
                    if(url.search('buscar') != -1 )
                        window.location = 'http://'+window.location.host+'/'+nuevaUrl +'/vehiculo/' + vehiculo_actual;
                    else
                        window.location = 'http://'+window.location.host+'/'+nuevaUrl +'/buscar/vehiculo/' + vehiculo_actual;
                }
                //----
                
            }
        });

                
    });
    
    
    //le hace autocomplete a la marca del carro, cuando se selecciona una marca,
    // por ajax se cargan las líneas correspondientes
    $(function(){
        var vehiculosMarca = <?php echo json_encode($allmarcas); ?>;

        $(".marca-vehiculo").autocomplete({
            source: vehiculosMarca,
            change: function(e, ui){
                $('.linea-vehiculo').val('');
            },select: function(e, ui) {
                $('.linea-vehiculo').val('');
                var marca_actual = ui.item.value;
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>usuario/dar_linea_vehiculos_marca_ajax",
                    async: false,
                    data: "marca=" + marca_actual,
                    success: function(data){
                        var lineas = $.parseJSON(data);
                        $(".linea-vehiculo").autocomplete({
                            source: lineas
                        });
                    }
                });    
            }
        });         
    });
</script>
<script>
    
    $(document).ready(function(){
        //cuando carga la página obliga al usuario a escoger un vehículo 
        var url = window.location.pathname;
        var urlArray =  url.split("/");
        var encontro = false;
        var pocision = 0;
        $.each(urlArray, function(i, e){
            if (e == 'buscar') {
                encontro = true;
                pocision = i+1;
            }
            if(e == 'pagina') {
                urlArray[i+1] = '1';
            }
        });
        if(!encontro){ 
            $('#escoger-carro-lightbox').lightbox_me({
                fixedNavigation:true,
                centered: true,
                closeSelector: "#escoger-carro-lightbox-cancelar"
            }); 
        }
        
        var pagActual = parseInt($('#input_paginacion_pagina').val());
        var limite = $('span:last', '#autopart-div-pagination').text();
        if(pagActual<= 1){
            $('.paginacion-atras').css('display', 'none');
        }
        if ( limite <= pagActual){
            $('.paginacion-adelante').css('display', 'none');
        }
        
        //muestra hover el titulo seleccionado
        var titulovehiculo = $('span', '#filtro-vehiculo').text();
        var titulocategoria = $('span', '#filtro-categoria').text();
        var titulomarca = $('span', '#filtro-marca').text();
        var encontroTituloCategoria = false;
        var encontroTituloMarca = false;
        $('.autopart-h4-categoria-titulo').each( function(index, element){
            if($('span:first', element).text() == titulomarca){
                $(element).addClass('titulo-servicio-seleccionado');
                $(element).css('background-color', 'black');
                $(element).css('color', 'white');
                $('span',element).css('color', 'white');
                encontroTituloMarca = true;
                
            }else if( $('span:first', element).text() == titulocategoria){
                $(element).addClass('titulo-servicio-seleccionado');
                $(element).css('background-color', 'black');
                $(element).css('color', 'white');
                $('span',element).css('color', 'white');
                encontroTituloCategoria = true;
            }

        });
        
        
        if(encontroTituloCategoria == false){
            $('#categoria-filtro-todos-categorias').addClass('titulo-servicio-seleccionado');
            $('#categoria-filtro-todos-categorias').css('background-color', 'black');
            $('#categoria-filtro-todos-categorias').css('color', 'white');
            $('span','#categoria-filtro-todos-categorias').css('color', 'white');
        }
        if(encontroTituloMarca == false){
            $('#categoria-filtro-todos-marcas').addClass('titulo-servicio-seleccionado');
            $('#categoria-filtro-todos-marcas').css('background-color', 'black');
            $('#categoria-filtro-todos-marcas').css('color', 'white');
            $('span','#categoria-filtro-todos-marcas').css('color', 'white');
        }
            
        //esconde y muestra la subcategoria de busqueda al hacer click
        $('.autopart-h4-categoria-titulo').live('click', function(){
            var padre = $('.autopart-div-categoria').has(this);
            var busqueda = $('span:first',this).text();
            var url = window.location.pathname;
            var urlArray =  url.split("/");
            var encontro = false;
            var pocision = 0;
            
            //evento de google
            _gaq.push(['_trackEvent', 'Autoparte', 'categoria', busqueda]);
            
            if(padre.hasClass('filtro-marca')){
                $.each(urlArray, function(i, e){
                    if (e == 'marca') {
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
                        window.location = 'http://'+window.location.host+'/'+nuevaUrl +'/marca/' + busqueda;
                    else
                        window.location = 'http://'+window.location.host+'/'+nuevaUrl +'/buscar/marca/' + busqueda;
                }
                   
            }
            else if(padre.hasClass('filtro-categoria')){
                $.each(urlArray, function(i, e){
                    if (e == 'categoria') {
                        encontro = true;
                        pocision = i+1;
                    }
                    else if(e == 'pagina') {
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
        $('.autopart-div-filtro-x, .categorias-div-filtro-x').live('click',function(){
            var padre= $('.autopart-div-filtro').has(this);
            var id = $(padre).attr('id');
            var url = window.location.pathname;
            var urlArray =  url.split("/");
            var nuevaUrl = '';
            var next = false;
            $.each(urlArray, function(i, e){
                if (e == 'marca' && (id == 'filtro-marca' || id =='categoria-filtro-todos-marcas')) {
                    next = true;
                }else if(e == 'categoria' && (id == 'filtro-categoria' || id =='categoria-filtro-todos-categorias')) {
                    next = true;
                }else if(e == 'vehiculo' && (id == 'filtro-vehiculo')) {
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
        
    });
    
    //al dar click a el boton envíar en el lighbox de escoger carro
    //el sistema seleccciona el carro dado
    $('#escoger-carro-lightbox-submit').click(function(){
        var marca = $('#marca-vehiculo').val();
        var linea = $('#linea-vehiculo').val();
        var vehiculo_actual = marca+'-'+linea;
        //cambia la url
        var url = window.location.pathname;
        var urlArray =  url.split("/");
        var encontro = false;
        var pocision = 0;
        $.each(urlArray, function(i, e){
            if (e == 'vehiculo') {
                encontro = true;
                pocision = i+1;
            }
            if(e == 'pagina') {
                urlArray[i+1] = '1';
            }
        });

        if(encontro){
            urlArray[pocision] = vehiculo_actual;
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
            vehiculo_actual = specialCharacters(vehiculo_actual);
            var nuevaUrl = '';
            $.each(urlArray, function(i, e){
                if(i==1){
                    nuevaUrl = nuevaUrl+ e;   
                }else if(i>=2){
                    nuevaUrl = nuevaUrl+'/'+ e;   
                }
            });
            if(url.search('buscar') != -1 )
                window.location = 'http://'+window.location.host+'/'+nuevaUrl +'/vehiculo/' + vehiculo_actual;
            else
                window.location = 'http://'+window.location.host+'/'+nuevaUrl +'/buscar/vehiculo/' + vehiculo_actual;
        }
        //----
    });
    
    //se registra el evento de click al entrar a la página
    _gaq.push(['_trackEvent', 'Autopartes', 'Clic']);
</script>