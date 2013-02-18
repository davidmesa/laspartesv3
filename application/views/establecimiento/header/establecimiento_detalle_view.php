<link href="<?php echo base_url(); ?>resources/css/jquery.stars.css" rel="stylesheet" type="text/css"  media="screen" />
<link href="<?php echo base_url(); ?>resources/css/jquery.fancybox.css" rel="stylesheet" type="text/css" media="screen"/>

<script src="<?php echo base_url(); ?>resources/js/jquery.ui.autocomplete.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.stars.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.fancybox.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.lightbox_me.js"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.widget.js" type="text/javascript"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>

<script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery.lightbox_me.js"></script>
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
    $(function(){
        var ciudades = ["Aguachica", "Apartadó", "Arauca", "Arjona", "Armenia", "Barrancabermeja", "Barranquilla", "Bello", "Bogotá", "Bucaramanga", "Buenaventura", "Calarcá", "Caldas", "Cali", "Candelaria", "Carmen de Bolívar", "Cartagena de indias", "Cartago", "Caucasia", "Cereté", "Chía", "Chigorodó", "Chiquinquirá", "Ciénaga", "Copacabana", "Cúcuta", "Dosquebradas", "Duitama", "Envigado", "Espinal", "Facatativa", "Florencia", "Floridablanca", "Fundación", "Funza", "Fusagasugá", "Garzón", "Girardot", "Guadalajara de Buga", "Ibagué", "Ipiales", "Itagüi", "Jamundí", "La Dorada", "Los Patios", "Madrid", "Magangué", "Maicao", "Malambo", "Manizales", "Medellín", "Montelíbano", "Monteria", "Mosquera", "Neiva", "Ocaña", "Palmira", "Pamplona", "Pasto", "Pereira", "Piedecuesta", "Pitalito", "Planeta Rica", "Popayán", "Quibdó", "Riohacha", "Rionegro", "Sabanalarga", "Sahagun", "San Andrés", "San Andrés de Sotavento", "San Andrés de Tumaco", "San José de Cúcuta", "San Juan de Girón", "Santa Cruz de Lorica", "Santa Marta", "Santa Rosa de Cabal", "Santander de Quilichao", "Sincelejo", "Soacha", "Sogamoso", "Soledad", "Tierralta", "Tuluá", "Tunja", "Turbaco", "Valledupar", "Villa del Rosario", "Villavicencio", "Yopal", "Yumbo", "Zipaquirá"];
        $(".vehiculos").autocomplete({
            source: ciudades
            ,select: function(e, ui) {
                $('.hidden_carro_selected').remove();
                var ciudad_actual = ui.item.value;
                
                
                //cambia la url
                var url = arreglarURL();
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
                    window.location = 'http://'+window.location.host+'/'+nuevaUrl;
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
                        window.location= 'http://'+window.location.host+'/'+nuevaUrl +'/ciudad/' + ciudad_actual;
                    else
                        window.location = 'http://'+window.location.host+'/'+nuevaUrl +'/buscar/ciudad/' + ciudad_actual;
                }
                //----
                
            }
        });

                
    });
</script>
<script>
    
    $(document).ready(function(){
        preload([
            '../../resources/images/autopartes/contraer.png'
        ]);
        
        pintarMapa();
        
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
            var padre = $('.autopart-div-categoria').has(this);
            var busqueda = $('span:first',this).text();
            var url = arreglarURL();
            var urlArray =  url.split("/");
            var encontro = false;
            var pocision = 0;
            if(padre.hasClass('filtro-servicio')){
                $.each(urlArray, function(i, e){
                    if (e == 'servicio') {
                        encontro = true;
                        pocision = i+1;
                    }
                    else if(e == 'pagina') {
                        urlArray[i+1] = '0';
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
                        window.location = 'http://'+window.location.host+'/'+nuevaUrl +'/servicio/' + busqueda;
                    else
                        window.location = 'http://'+window.location.host+'/'+nuevaUrl +'/buscar/servicio/' + busqueda;
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
        $('.autopart-div-categoria-content h4').live({
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
            var url = arreglarURL();
            var urlArray =  url.split("/");
            var nuevaUrl = '';
            var next = false;
            $.each(urlArray, function(i, e){
                if (e == 'servicio' && (id == 'filtro-servicio' || id =='categoria-filtro-todos-servicio')) {
                    next = true;
                }else if(e == 'zona' && (id == 'filtro-zona' || id == 'filtro-ciudad' )) {
                    next = true;
                }else if(e == 'ciudad' && (id == 'filtro-ciudad')) { 
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
        
        
        
        
        var pathname  = window.location.pathname;
        if(pathname.search('calificacion') == -1 && pathname.search('ordenarpor') != -1){
            $('#talleres-div-ordenar img').hide();
        }
        
        
        //Al hacer click en una imagen, se despliega un fancybox
        $("a[rel=galeria-imagenes]").fancybox({
            'transitionIn': 'none',
            'transitionOut': 'none',
            'titlePosition': 'over',
            'titleFormat': function(title, currentArray, currentIndex, currentOpts) {
                return '<span id="fancybox-title-over">Imagen ' + (currentIndex + 1) + ' de ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
            }
        });
        
        
        //Pinga el mapa de Gmaps
        function pintarMapa() {
            var latlng = new google.maps.LatLng(<?php echo $establecimiento->lat; ?>,<?php echo $establecimiento->lng; ?>);
            var myOptions = {
                zoom: 15,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("googlemap"),myOptions);

            var markerOptions = {map: map, position: new google.maps.LatLng(<?php echo $establecimiento->lat; ?>, <?php echo $establecimiento->lng; ?>), title: '<?php echo $establecimiento->nombre; ?>'};
            var marker = new google.maps.Marker(markerOptions);
        
            var content = '<div align="center"><h4><center><b><?php echo $establecimiento->nombre; ?></b></center></h4><img src="<?php echo base_url() . $establecimiento->logo_thumb_url; ?>" /><div class="general_link"  align="center" valign="bottom" style="padding-top:5px;"><h4><img src="<?php echo base_url() ?>resources/images/establecimientos/carrito.gif" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>establecimientos/ver_establecimiento/<?php echo $establecimiento->id_establecimiento; ?>" target="_blank">Ir al establecimiento.</a></h4></div></div>';
            var infowindow = new google.maps.InfoWindow({position: marker.getPosition(), map: map, content: content});
        
            google.maps.event.addListener(marker, 'click', function(e) {
                infowindow.open(map, marker);
            });

<?php
foreach ($establecimientos as $e) {
    ?>

                    var markerOptions_<?php echo $e->id_establecimiento; ?> = {map: map, position: new google.maps.LatLng(<?php echo $e->lat; ?>, <?php echo $e->lng; ?>), title: '<?php echo $e->nombre; ?>'};
                    var marker_<?php echo $e->id_establecimiento; ?> = new google.maps.Marker(markerOptions_<?php echo $e->id_establecimiento; ?>);
                                        
                    var content_<?php echo $e->id_establecimiento; ?> = '<div align="center"><h4><center><b><?php echo $e->nombre; ?></b></center></h4><img src="<?php echo base_url() . $e->logo_thumb_url; ?>" /><div class="general_link"  align="center" valign="bottom" style="padding-top:5px;"><h4><img src="<?php echo base_url() ?>resources/images/establecimientos/carrito.gif" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>establecimientos/ver_establecimiento/<?php echo $e->id_establecimiento; ?>" target="_blank">Ir al establecimiento.</a></h4></div></div>';
                    var infowindow_<?php echo $e->id_establecimiento; ?> = new google.maps.InfoWindow({position: marker_<?php echo $e->id_establecimiento; ?>.getPosition(), map: map, content: content_<?php echo $e->id_establecimiento; ?>});
                    infowindow_<?php echo $e->id_establecimiento; ?>.close();
                                        
                    google.maps.event.addListener(marker_<?php echo $e->id_establecimiento; ?>, 'click', function(e) {
                        infowindow_<?php echo $e->id_establecimiento; ?>.open(map, marker_<?php echo $e->id_establecimiento; ?>);
                    });
                                        
    <?php
}
?>

            map.panBy(50, -70);
        }
    
    
       
		
        //activa el lightbox cuando se hace click sobre el div de opinar
        $('#lightbox-opinar').click(function(){
            sesion =  $.ajax({
                url: '<?php echo base_url(); ?>usuario/dar_sesion_activa_ajax',
                type: "POST",
                success: function(data) {
                    var sesion = data;
                    if(sesion){
                        $('#lightboxme-opinar').lightbox_me(); 
                    }else{
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>usuario/mostrar_registro_ajax",
                            async: false,
                            success: function(data){
                                $('#registro-login-div').empty();
                                $('#registro-login-div').html(data);
                                $('#input-registro-callback').val('lightboxmeopinar');
                                $('#registro-login-div').lightbox_me({ }); 
                            }
                        }); 
                    }//else
                }//sucess
            });//ajax
        });//click
        
        $.validator.addMethod("textoDiferente",
            function(value, element){
                if(value!="Cuéntanos tu experiencia con el establecimiento...")
                    return true;
                else
                    return false;
            },
            "Escriba un comentario"
        );
        
        //valída el formulario de contacto en línea
        $('form#form_calificar_taller').validate({
            rules: {
                comentario: {
                    required: true,
                    textoDiferente: true
                },
                calificacion: {
                    required: true
                }
            },
            messages: {
                comentario: {
                    required: "Escriba un comentario",
                    textoDiferente: "Escriba un comentario"
                },
                calificacion: {
                    required: "Califique al establecimiento"
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
            },submitHandler: function(form){
                var idestablecimiento = ((window.location.pathname.split('/'))[2].split('-'))[0];
                var calificacion = $('#calificacion').val();
                var comentario = $('#textarea_opinar_comentario').val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>establecimientos/agregar_establecimiento_comentario",
                    data: "id_establecimiento=" + idestablecimiento + "&calificacion=" + calificacion+  "&comentario=" + comentario,
                    async: false,
                    success: function(data){
                        var corrio = data.split('|');
                        if(corrio[0] == 'true'){
                            $('.lightboxme-opinar').trigger('close'); 
                            try{
                                var respuesta = $.parseJSON(corrio[1]);
                                var usuario = respuesta.usuario;
                                var comentario = respuesta.comentario;
                                var calificacion = respuesta.calificacion;
                                agregarComentario(usuario, comentario, calificacion);
                            }catch(e){
                                alert(e);
                            }
                               
                               
                        }else{
                            alert(data);
                        }
                            
                        return false;
                    }
                }); 
            }
                   
        }); 
        
        //pone las estrellas del color que tienen que ser
        $(function(){
            var $caption, $cap = $("<h4 style=\"color: black; padding-top: 35px; \" />").addClass("caption");
            $(".multiField").children().hide();
            $caption = $cap.clone();
            $("#calificacion-comentario-div").stars({
                callback: function(ui, type, value){
                    document.getElementById("calificacion").value = value;
                },
                inputType: "select",
                cancelShow: false,
                captionEl: $caption
            })
            .append($caption);
        });
                
                

        $('.talleres-detalle-opinar-calificacion-estrella').live('click',function(e){
            $('.estrella-elegida').removeClass('estrella-elegida');
            $(this).addClass('estrella-elegida');
            $('img', this).attr('src','<?php echo base_url(); ?>resources/images/autopartes/estrella-roja.png');
            $('.talleres-detalle-opinar-calificacion-estrella-tag',this).css('color','#c60200');

        });

        //si el número de caracteres del comentario es menor a 155, se esconde la 
        //opción de expandir
        $('.talleres-detalle-div-opinion-comentario').each(function(i, e){
//            console.log('texto: '+$(e).text());
            if($(e).text().length < 155){
                var padre = $('.talleres-detalle-div-opinion').has(e);
                $('.talleres-detalle-div-opinion-expandir', padre).css('display', 'none');
            }
        });
        
        //cuando se hace click en expandir el overflow-y del div cambia a none
        $('.talleres-detalle-div-opinion-expandir').live('click',function(){
            var padre = $('.talleres-detalle-div-opinion').has(this);
            var hijo = $('.talleres-detalle-div-opinion-comentario', padre);
            if($(hijo).hasClass('comentario-visible')){
                $(hijo).css('overflow-y','hidden');
                $(hijo).css('max-height','30px'); 
                $(hijo).removeClass('comentario-visible');
                $('span', this).text('EXPANDIR');
                $('img', this).attr('src', '<?php echo base_url(); ?>resources/images/autopartes/expandir.png');
            }else{
                $('span', this).text('CONTRAER');
                $(hijo).css('overflow-y','visible');
                $(hijo).css('max-height','none');
                $(hijo).addClass('comentario-visible');
                $('img', this).attr('src', '<?php echo base_url(); ?>resources/images/autopartes/contraer.png');
            }

        });
        
        //valída el formulario de contacto en línea
        $('form#form_contacto_linea').validate({
            rules:{
                asunto_contactar:{
                    required: true
                },mensaje_contactar:{
                    required: true
                    
                }
            },
            messages: {
                asunto_contactar: "*El asunto es un campo requerido",
                mensaje_contactar: "*El mensaje es un campo requerido"
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
            },submitHandler: function(form){
                var idestablecimiento = ((window.location.pathname.split('/'))[2].split('-'))[0];
                var asunto = $('#contacto-div-contacto-asunto').val();
                var mensaje = $('#contacto-div-contacto-mensaje').val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>establecimientos/contactar_establecimiento",
                    data: "id_establecimiento_contactar=" + idestablecimiento + "&asunto_contactar=" + asunto+  "&mensaje_contactar=" + mensaje,
                    async: false,
                    success: function(data){
                        if(data)
                            $('.lightboxme-contacto').trigger('close'); 
                        alert('Tu mensaje ha sido enviado');
                    }
                }); 
            }
                   
        }); 
        
        //activa el lightbox cuando se hace click sobre el div de hacer contacto
        $('#lightbox-contacto').click(function(e){
            $.ajax({
                url: '<?php echo base_url(); ?>usuario/dar_sesion_activa_ajax',
                type: "POST",
                success: function(data) {
                    var sesion = data;
                    if(sesion){
                        $('.lightboxme-contacto').lightbox_me({centered: true});  
                    }else{
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>usuario/mostrar_registro_ajax",
                            async: false,
                            success: function(data){
                                $('#registro-login-div').empty();
                                $('#registro-login-div').html(data);
                                $('#input-registro-callback').val('lightboxmecontacto');
                                $('#registro-login-div').lightbox_me(); 
                            }
                        }); //ajax
                    }//else
                }//success
            });//ajax     
            e.preventDefault();
        });//click
        
        
    });
    //agrega un comentario realizado dinámicamente
    function agregarComentario(usuario, comentario, calificacion){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>establecimientos/mostrar_comentario",
            data: "usuario=" + usuario + "&comentario=" + comentario+  "&calificacion=" + calificacion,
            async: false,
            success: function(data){
                var numero = parseInt($('.talleres-detalle-div-opiniones-titulo #autopart-div-titulo-icono').text());
                $('.talleres-detalle-div-opiniones-titulo #autopart-div-titulo-icono').text(numero+1);
                $('#talleres-detalle-div-opiniones').prepend(data);
                var textogrande = $('.estrellas-clasificadas-grandes span');

                                    textogrande.each(function(i, e){
                                        var padre = $('.estrellas-clasificadas-grandes').has(this);
                                        var porcentaje = $(e).text();
                                        $(padre).css('width', porcentaje);
                                    });
            }
        }); 
    }
    
    
    function lightboxmeopinar(){
        $('#registro-login-div').trigger('close');
        $.ajax({
            url: '<?php echo base_url(); ?>usuario/dar_sesion_activa_ajax',
            type: "POST",
            success: function(data) {
                var sesion = data;
                if(sesion){
                    $('.lightboxme-opinar').lightbox_me({centered: true});  
                }else{
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>usuario/mostrar_registro_ajax",
                        async: false,
                        success: function(data){
                            $('#registro-login-div').empty();
                            $('#registro-login-div').html(data);
                            $('#input-registro-callback').val('lightboxmeopinar');
                            $('#registro-login-div').lightbox_me({centered: true}); 
                        }
                    }); 
                }
            }
        }); 
    }
    
    function lightboxmecontacto(){
        $('#registro-login-div').trigger('close');
        $.ajax({
            url: '<?php echo base_url(); ?>usuario/dar_sesion_activa_ajax',
            type: "POST",
            success: function(data) {
                var sesion = data;
                if(sesion){
                    $('.lightboxme-contacto').lightbox_me({centered: true});  
                }else{
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>usuario/mostrar_registro_ajax",
                        async: false,
                        success: function(data){
                            $('#registro-login-div').empty();
                            $('#registro-login-div').html(data);
                            $('#input-registro-callback').val('lightboxmecontacto');
                            $('#registro-login-div').lightbox_me({centered: true}); 
                        }
                    }); 
                }
            }
        }); 
    }
    
    //aregla la url para que se redireccione a laspartes.com/establecimientos
    function arreglarURL(){
        var url = window.location.pathname;
        var urlArray =  url.split("/");
        var nuevaUrl = '';
        $.each(urlArray, function(i, e){
            if(i!=0 && i!= 2){
                nuevaUrl = nuevaUrl+'/'+ e;
            }
        });
        return nuevaUrl;
    }
</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=7735652183";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
{lang: 'es'}
</script>