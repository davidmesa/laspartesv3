<script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery.lightbox_me.js"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.autocomplete.js" type="text/javascript"></script>
<link href="<?php echo base_url() ?>resources/css/autopartes.css" rel="stylesheet" type="text/css" />
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
    var pagActual = parseInt($('#input_paginacion_pagina').val());
    var limite = $('span:last', '#autopart-div-pagination').text();
    if(pagActual<= 1){
        $('.paginacion-atras').css('display', 'none');
    }
    if ( limite <= pagActual){
        $('.paginacion-adelante').css('display', 'none');
    }
    $(function(){
        var ciudades = ["Aguachica", "Apartadó", "Arauca", "Arjona", "Armenia", "Barrancabermeja", "Barranquilla", "Bello", "Bogotá", "Bucaramanga", "Buenaventura", "Calarcá", "Caldas", "Cali", "Candelaria", "Carmen de Bolívar", "Cartagena de indias", "Cartago", "Caucasia", "Cereté", "Chía", "Chigorodó", "Chiquinquirá", "Ciénaga", "Copacabana", "Cúcuta", "Dosquebradas", "Duitama", "Envigado", "Espinal", "Facatativa", "Florencia", "Floridablanca", "Fundación", "Funza", "Fusagasugá", "Garzón", "Girardot", "Guadalajara de Buga", "Ibagué", "Ipiales", "Itagüi", "Jamundí", "La Dorada", "Los Patios", "Madrid", "Magangué", "Maicao", "Malambo", "Manizales", "Medellín", "Montelíbano", "Monteria", "Mosquera", "Neiva", "Ocaña", "Palmira", "Pamplona", "Pasto", "Pereira", "Piedecuesta", "Pitalito", "Planeta Rica", "Popayán", "Quibdó", "Riohacha", "Rionegro", "Sabanalarga", "Sahagun", "San Andrés", "San Andrés de Sotavento", "San Andrés de Tumaco", "San José de Cúcuta", "San Juan de Girón", "Santa Cruz de Lorica", "Santa Marta", "Santa Rosa de Cabal", "Santander de Quilichao", "Sincelejo", "Soacha", "Sogamoso", "Soledad", "Tierralta", "Tuluá", "Tunja", "Turbaco", "Valledupar", "Villa del Rosario", "Villavicencio", "Yopal", "Yumbo", "Zipaquirá"];

        $(".vehiculos").autocomplete({
            source: ciudades
            ,select: function(e, ui) {
                $('.hidden_carro_selected').remove();
                var ciudad_actual = ui.item.value;
                
                
                //cambia la url
                var url = window.location.pathname;
                var urlArray =  url.split("/");
                var encontro = false;
                var pocision = 0;
                $.each(urlArray, function(i, e){
                    if (e == 'ciudad') {
                        encontro = true;
                        pocision = i+1;
                    }
                    if(e == 'pagina') {
                        urlArray[i+1] = '1';
                    }
                });
                    
                if(encontro){
                    urlArray[pocision] = ciudad_actual;
                    var nuevaUrl = '';
                    $.each(urlArray, function(i, e){
                        e = specialCharacters(e);
                        if(i==1){
                            nuevaUrl = nuevaUrl+ e;   
                        }else if(i>=2){
                            nuevaUrl = nuevaUrl+'/'+ e;   
                        }
                    });
                    window.location.replace('http://'+window.location.host+'/'+nuevaUrl);
                }else{
                    ciudad_actual = specialCharacters(ciudad_actual);
                    var nuevaUrl = '';
                    $.each(urlArray, function(i, e){
                        if(i==1){
                            nuevaUrl = nuevaUrl+ e;   
                        }else if(i>=2){
                            nuevaUrl = nuevaUrl+'/'+ e;   
                        }
                    });
                    if(url.search('buscar') != -1 )
                        window.location.replace('http://'+window.location.host+'/'+nuevaUrl +'/ciudad/' + ciudad_actual);
                    else
                        window.location.replace('http://'+window.location.host+'/'+nuevaUrl +'/buscar/ciudad/' + ciudad_actual);
                }
                    
                //----
                
            }
        });

                
    });
</script>
<script>
    
    $(document).ready(function(){
	
        //muestra hover el titulo seleccionado
        var titulozona = $('span', '#filtro-zona').text();
        var tituloServicio = $('span', '#filtro-servicio').text();
        var encontroTituloServicio = false;
        var encontroTituloZona = false;
        $('.autopart-h4-categoria-titulo').each( function(index, element){
            if($('span:first', element).text() == tituloServicio){
                $(element).addClass('titulo-servicio-seleccionado');
                $(element).css('background-color', 'black');
                $(element).css('color', 'white');
                $('span',element).css('color', 'white');
                encontroTituloServicio = true;
            }else if($('span:first', element).text() == titulozona){
                $(element).addClass('titulo-servicio-seleccionado');
                $(element).css('background-color', 'black');
                $(element).css('color', 'white');
                $('span',element).css('color', 'white');
                encontroTituloZona = true;
            }

        });
            
        if(encontroTituloServicio == false){
            $('#categoria-filtro-todos-servicio').addClass('titulo-servicio-seleccionado');
            $('#categoria-filtro-todos-servicio').css('background-color', 'black');
            $('#categoria-filtro-todos-servicio').css('color', 'white');
            $('span','#categoria-filtro-todos-servicio').css('color', 'white');
        }
        if(encontroTituloZona == false){
            $('#categoria-filtro-todos-zonas').addClass('titulo-servicio-seleccionado');
            $('#categoria-filtro-todos-zonas').css('background-color', 'black');
            $('#categoria-filtro-todos-zonas').css('color', 'white');
            $('span','#categoria-filtro-todos-zonas').css('color', 'white');
        }

        
        //esconde y muestra la subcategoria de busqueda al hacer click
        $('.autopart-h4-categoria-titulo').live('click', function(){
            $(this).addClass('categoria-titulo-seleccionado');
            var padre = $('.autopart-div-categoria').has(this);
            var busqueda = $('span:first',this).text();
            var url = window.location.pathname;
            var urlArray =  url.split("/");
            var encontro = false;
            var pocision = 0;
            if(padre.hasClass('filtro-servicio')){
                $.each(urlArray, function(i, e){
                    if (e == 'servicio') {
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
                    window.location= 'http://'+window.location.host+'/'+nuevaUrl ;
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
                        window.location = 'http://'+window.location.host+'/'+nuevaUrl +'/servicio/' + busqueda;
                    else
                        window.location = 'http://'+window.location.host+'/'+nuevaUrl +'/buscar/servicio/' + busqueda;
                }
                   
            }
            else if(padre.hasClass('filtro-zona')){
                $.each(urlArray, function(i, e){
                    if (e == 'zona') {
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
                        window.location = 'http://'+window.location.host+'/'+nuevaUrl +'/zona/' + busqueda;
                    else
                        window.location = 'http://'+window.location.host+'/'+nuevaUrl +'/buscar/zona/' + busqueda;
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
        $('.autopart-div-filtro-x, .categorias-div-filtro-x').live('click',function(){
            var padre= $('.autopart-div-filtro').has(this);
            var id = $(padre).attr('id');
            var url = window.location.pathname;
            var urlArray =  url.split("/");
            var nuevaUrl = '';
            var next = false;
            $.each(urlArray, function(i, e){
                if (e == 'servicio' && (id == 'filtro-servicio' || id =='categoria-filtro-todos-servicio')) {
                    next = true;
                }else if(e == 'ciudad' && (id == 'filtro-ciudad')) { 
                    next = true;
                }else if(  (e == 'zona' && (id == 'filtro-zona' || id == 'filtro-ciudad' || id =='categoria-filtro-todos-zonas'))) {
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
        
        
        var pathname  = window.location.pathname;
         var urlArray =  pathname.split("/");
         var nuevaUrl = '';
            var ordenar = false;
            var next = false;
            $.each(urlArray, function(i, e){
                    if (e == 'ordenarpor') {
                        next = true;
                        ordenar = true;
                    }
                    else{
                        if(next == true ){
                            if(e == 'calificacion'){
                                 $('#talleres-div-ordenar-calificacion img').show();
                            }else if(e == 'nombre'){
                                $('#talleres-div-ordenar-nombre img').show();
                            }   
                        }
                       
                    }
                });
//        if(pathname.search('calificacion') == -1 && pathname.search('ordenarpor') != -1){
           
//        }
        //cuando se da click sobre ordenar por calificación, los talleres se organizar
        //por calificación
        $('.talleres-div-ordenar').live('click',function(){
            var imagen = $('img', this);
            var id = $(this).attr('id');
            var url = window.location.pathname;
            var urlArray =  url.split("/");
            var nuevaUrl = '';
            var ordenar = false;
            var next = false;
            if($(imagen).is(':hidden')){
                var buscar = false;
                $.each(urlArray, function(i, e){
                    if (e == 'ordenarpor') {
                        next = true;
                        ordenar = true;
                    }else if(e == 'pagina') {
                        next = true;
                    }else if(e=='buscar'){
                        buscar = true;
                        nuevaUrl = nuevaUrl+'/'+ e;    
                    }
                    else{
                        if(next == false && i>=1){
                            nuevaUrl = nuevaUrl+'/'+ e;      
                        }else{ 
                            next = false;
                        } 
                       
                    }
                });
                if( buscar == true){
                    if(id== 'talleres-div-ordenar-nombre')
                        window.location = 'http://'+window.location.host+nuevaUrl+'/ordenarpor/nombre';
                    else if(id== 'talleres-div-ordenar-calificacion')
                        window.location = 'http://'+window.location.host+nuevaUrl+'/ordenarpor/calificacion';
                }else if(buscar == false){
                    if(id== 'talleres-div-ordenar-nombre')
                        window.location = 'http://'+window.location.host+nuevaUrl+'/buscar/ordenarpor/nombre';
                    else if(id== 'talleres-div-ordenar-calificacion')
                        window.location = 'http://'+window.location.host+nuevaUrl+'/buscar/ordenarpor/calificacion';
                }
                else
                    window.location = 'http://'+window.location.host+nuevaUrl;
                
            }else{
                $.each(urlArray, function(i, e){
                    if (e == 'ordenarpor') {
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
                window.location= 'http://'+window.location.host+nuevaUrl;
            }
        });
        
    }); 
</script>