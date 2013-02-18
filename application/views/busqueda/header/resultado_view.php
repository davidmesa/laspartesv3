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
        
    $(document).ready(function(){
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
        
</script>