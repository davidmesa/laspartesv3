<link href="<?php echo base_url() ?>resources/css/flota.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>resources/css/jquery.ui.all.css" rel="stylesheet" type="text/css"  media="screen" />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />

<script src="<?php echo base_url(); ?>resources/js/jquery.ui.core.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.widget.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.button.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.position.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.ui.autocomplete.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>resources/js/ajaxfileupload.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/ajaxupload.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>resources/js/jquery.datepick-es.js" type="text/javascript"></script> 

<script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery.tablesorte.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery.tablesorter.widgets.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.tablesorter.pager.js"></script> 
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin/css/themes/theme.default.css" /> 
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/css/jquery.tablesorter.pager.css" /> 


<script type="text/javascript" src="<?php echo base_url() ?>resources/js/jquery.lightbox_me.js"></script>

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


<!--[if lt IE 9]>
    //hay que llevar este script a live para que funcione los SELECTS con IE
    //ver: http://css-tricks.com/select-cuts-off-options-in-ie-fix/
    <script>
        $(function() {
        
            var el;
            
            $("select.fix-me")
                .live('each', function() {
                    el = $(this);
                    el.data("origWidth", el.outerWidth()) // IE 8 will take padding on selects
                })
              .mouseenter(function(){
                $(this).css("width", "auto");
              })
              .bind("blur change", function(){
                el = $(this);
                el.css("width", el.data("origWidth"));
              });
        
        });
    </script>
    <![endif]-->
<script>
$(function(){
    var vehiculosMarca = <?php echo json_encode($allmarcas); ?>;
    $(".editar-perfil-hidden.marca:not(.ui-autocomplete-input)").live("focus", function (event) {
            $(this).autocomplete({
                source: vehiculosMarca,
                change: function(e, ui){
                    $(this).next('.linea').val('');
                    $(this).prev('.nuevo_carro').val(1);
                },select: function(e, ui) {
                    var linea_elem = $(this).next('.linea');
                    linea_elem.val('');
                    var marca_actual = ui.item.value;
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>usuario/dar_linea_vehiculos_marca_ajax",
                        async: false,
                        data: "marca=" + marca_actual,
                        success: function(data){
                            var lineas = $.parseJSON(data);
                            $(linea_elem).autocomplete({
                                source: lineas,
                                select: function(){
                                    $(this).prev('.nuevo_carro').val(0);
                                }
                            });
                        }
                    });    
                }
            });         
        });
    // });

    $('#input_vehiculo_marca').autocomplete({
            source: vehiculosMarca,
            change: function(e, ui){
                $('#input_vehiculo_linea').val('');
                $('#nuevo_carro').val(1);
            },select: function(e, ui) {
                var linea_elem = $('#input_vehiculo_linea');
                linea_elem.val('');
                var marca_actual = ui.item.value;
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>usuario/dar_linea_vehiculos_marca_ajax",
                    async: false,
                    data: "marca=" + marca_actual,
                    success: function(data){
                        var lineas = $.parseJSON(data);
                        $(linea_elem).autocomplete({
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
</script>


<script>  
    $(document).ready(function() {
        
        
        $("#input_vehiculo_marca, #input_vehiculo_linea").on({
            change: function(event){
                sugerir_carro2(this);
            }
        });

        //tablesorter
        $("#tablesorter").tablesorter({
                    theme: 'default',

                    // hidden filter input/selects will resize the columns, so try to minimize the change
                    widthFixed : true,

                    // initialize zebra striping and filter widgets
                    widgets: ["zebra", "filter"],

                    // headers: { 5: { sorter: false, filter: false } },

                    widgetOptions : {

                        // If there are child rows in the table (rows with class name from "cssChildRow" option)
                        // and this option is true and a match is found anywhere in the child row, then it will make that row
                        // visible; default is false
                        filter_childRows : false,

                        // if true, a filter will be added to the top of each table column;
                        // disabled by using -> headers: { 1: { filter: false } } OR add class="filter-false"
                        // if you set this to false, make sure you perform a search using the second method below
                        filter_columnFilters : true,

                        // css class applied to the table row containing the filters & the inputs within that row
                        filter_cssFilter : 'tablesorter-filter',

                        // add custom filter functions using this option
                        // see the filter widget custom demo for more specifics on how to use this option
                        filter_functions : null,

                        // if true, filters are collapsed initially, but can be revealed by hovering over the grey bar immediately
                        // below the header row. Additionally, tabbing through the document will open the filter row when an input gets focus
                        filter_hideFilters : false,

                        // Set this option to false to make the searches case sensitive
                        filter_ignoreCase : true,

                        // jQuery selector string of an element used to reset the filters
                        filter_reset : 'button.reset',

                        // Delay in milliseconds before the filter widget starts searching; This option prevents searching for
                        // every character while typing and should make searching large tables faster.
                        filter_searchDelay : 300,

                        // Set this option to true to use the filter to find text from the start of the column
                        // So typing in "a" will find "albert" but not "frank", both have a's; default is false
                        filter_startsWith : false,

                        // Filter using parsed content for ALL columns
                        // be careful on using this on date columns as the date is parsed and stored as time in seconds
                        filter_useParsedData : false

                    }

                });


        $("#tablesorter").bind("sortStart",function() { 
            $("#overlay").show(); 
        }).bind("sortEnd",function() { 
            $("#overlay").hide(); 
        }); 

        $("#tablesorter") 
                        .tablesorter({widthFixed: true, widgets: ['zebra']}) 
                        .tablesorterPager({container: $("#pager")});

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
                        }
                    }
                }); 
                return false;
            }
        });
    });

    //al dar click en el carro sugerido se carga la información de ese carro
    function carro_sugerido(e){
        var padre = $('.editar-vehiculo').has(e);
        var marca = $('.quisiste_decir_marca', padre).val();
        var linea = $('.quisiste_decir_linea', padre).val();
        $(".marca", padre).val(marca);
        $(".linea", padre).val(linea);
        $('.nuevo_carro', padre).val(0);
    }

    //al dar click en el carro sugerido se carga la información de ese carro
    function carro_sugerido2(e){
        var marca = $('#quisiste_decir_marca').val();
        var linea = $('#quisiste_decir_linea').val();
        $("#input_vehiculo_marca").val(marca);
        $("#input_vehiculo_linea").val(linea);
        $('#nuevo_carro').val(0);
    }


    //cuando se hace click en editar perfil se edita la información del perfil
    function clickEditarPerfil(e){ 
        var padre = $('#usuario-div-perfil-info');
        $(e).text('Guardar');
        $('.editar-perfil-show', padre).hide('fast');
        $('.editar-perfil-hidden', padre).show('fast');
        $(e).hide();
    }

    //al hacer click sobre cancelar, se esconde el formulario de editar 
    //y muestra la información que había antes
    function cancelFormPerfil(e){
        var padre_perfil = $('#usuario_formulario_perfil');     
        $('.editar-perfil-hidden', padre_perfil).hide();
        $('.editar-perfil-show', padre_perfil).show();
        $('.usuario-div-editar', padre_perfil).text('Editar Perfil');
    }

    //cuando se hace click en editar carro se edita la información del carro
    function clickEditarCarro(e){
        var padre = $('.inf-carro-datos').has(e);
        $('.editar-perfil-show', padre).hide('fast');
        $('.editar-perfil-hidden', padre).show('fast');
        $('.titl-dato-h', padre).show('fast');
        $('.marca', padre).focus();
        $('.linea', padre).focus();
        $(e).hide();
        $('.ui-datepicker-append', padre).show();
    }


    //al hacer click sobre cancelar, se esconde el formulario de editar 
    //y muestra la información que había antes
    function cancelFormCarro(e){
        var padre_perfil = $('.inf-carro-datos').has(e);
        $('.editar-perfil-hidden', padre_perfil).hide();
        $('.editar-perfil-show', padre_perfil).show();
        $('.titl-dato-h', padre_perfil).hide();
        $('.ui-datepicker-append', padre_perfil).hide();
    }

    //consigue la información del vehículo y lo muestra en un lightbox
    var currentDate = new Date();
    var day = currentDate.getDate();
    var month = currentDate.getMonth() + 1;
    var year = currentDate.getFullYear();
    var fecha = year+"-"+month+"-"+day;
    function dar_vehiculo(e, id_usuario_vehiculo){
        if($.isEmptyObject($.find('#vehiculo-'+id_usuario_vehiculo))){
        var html = $('#flota-div-template').html();
        var vehiculo_div = '<div id="vehiculo-'+ id_usuario_vehiculo+ '" class="flota-div-template open-sans">'+ html+'</div>';
        $('#usuario-div-mis-vehiculos').append(vehiculo_div);

        var padre = $('#vehiculo-'+id_usuario_vehiculo);
        var data = dar_vehiculo_ajax(id_usuario_vehiculo);
        data = $.parseJSON(data);
        if(data.status){
            data = data.data;
            var data_uv = data.usuario_vehiculo;
            var data_tarea = data.tareas;
            var data_tareas_cat = data.tareasCategoria;
            var data_hojas = data.hojas;
            var data_herramientas = data.herramientas;
            // mostrar_hmto(padre, data_tareas_cat, data_hojas);
            $('.input_imageUpload_automovil', padre).attr('id', 'imageUpload_'+id_usuario_vehiculo);
            if(data_uv.imagen_url)
                $('.inf-carro-marco img', padre).attr('src', data_uv.imagen_url);
            $('.editar_id_usuario_vehiculo',padre).val(data_uv.id_usuario_vehiculo);
            $('.marca-linea',padre).children('.span-dato').text(data_uv.marca+' '+data_uv.linea);
            $('.marca-linea',padre).children('.editar-perfil-hidden.marca').val(data_uv.marca);
            $('.marca-linea',padre).children('.editar-perfil-hidden.linea').val(data_uv.linea);
            $('.modelo',padre).children('.span-dato').text(data_uv.modelo);
            $('.modelo',padre).children('.editar-perfil-hidden').val(data_uv.modelo);
            $('.kilometraje',padre).children('.span-dato').text(data_uv.kilometraje);
            $('.kilometraje',padre).children('.editar-perfil-hidden').val(data_uv.kilometraje);
            $('.placa',padre).children('.span-dato').text(data_uv.numero_placa);
            $('.placa',padre).children('.editar-perfil-hidden').val(data_uv.numero_placa);
            if(data_uv.vida_util == null)
                data_uv.vida_util = '';
            $('.vida_util',padre).children('.span-dato').text(data_uv.vida_util);
            $('.vida_util',padre).children('.editar-perfil-hidden').val(data_uv.vida_util);
            var numero = Math.floor(Math.random() * 1000) + 1;
            var new_id = 'editar_vida_util_'+numero;
            $('.editar_vida_util', padre).attr('id', new_id); var new_id = '#editar_vida_util_'+numero;
            $(new_id).datepicker({ appendText: "(aaaa-mm-dd)",altField: new_id, altFormat: 'yy-mm-dd', 
                rangeSelect: false , changeMonth: true, changeYear: true});
            $('.ui-datepicker-append', padre).hide();
            $.each( data_tarea, function( key, tarea ) {
              if(tarea.realizado == true){
                var div = $('<div>').addClass('hist-compra');
                var ul = $('<ul>');
                var li = $('<li>');
                if(tarea.trabajo)
                   var span_nombre = $('<span>').text('Se registró el trabajo: '); 
                else
                    var span_nombre = $('<span>').text('Se realizó la tarea: ');
                if(!!tarea.adjunto){
                    var strong = $('<strong>').text(tarea.nombre);span_nombre.append(strong); li.append(span_nombre);
                    var nombre_adjunto = tarea.adjunto.split('/'); var size = nombre_adjunto.length -1;
                    var ahref = $('<a>').attr('href', '<?php echo base_url();?>'+tarea.adjunto).attr('target', '_blank').text(nombre_adjunto[size]); li.append('Ver: ');li.append(ahref);
                }else{
                    
                    var strong = $('<strong>').text(tarea.nombre);span_nombre.append(strong); li.append(span_nombre);
                }
                var span_fecha = $('<span>').addClass('hist-fecha').text(tarea.due); li.append(span_fecha);
                ul.append(li);
                var input_id = $('<input>').attr('type', 'hidden').val(tarea.id_tarea_realizada); div.append(input_id);
                div.append(ul);
                var div_clear =  $('<div>').addClass('clear');
                div.append(div_clear);
                $('.menu-hist', padre).append(div);
              }else{
                var div = $('<div>').addClass('tarea-item');
                var input = $('<input>').addClass('tarea-chk-box').attr('type', 'checkbox').val(tarea.id_servicio);
                var img = $('<img>').addClass('tarea-img').attr('src', '<?php echo base_url();?>'+tarea.imagen_thumb_url).attr('alt', tarea.nombre);
                var tarea_texto = $('<div>').addClass('tarea-texto');
                var tarea_nombre = $('<div>').addClass('tarea-nombre').text(tarea.nombre); tarea_texto.append(tarea_nombre);
                var texto_tiempo = '';
                if(!!tarea.dias_restantes){
                    texto_tiempo = ' '+tarea.dias_restantes + ' '+ tarea.mensaje_dias_restantes2;
                }
                var tarea_tiempo = $('<div>').addClass('tarea-tiempo').text(tarea.mensaje_dias_restantes + texto_tiempo);  
                tarea_texto.append(tarea_tiempo);tarea_texto.append(tarea_tiempo);
                div.append(input);
                div.append(img);
                div.append(tarea_texto);
                if(!!tarea.dias_restantes && tarea.dias_restantes>15)
                    $('.tareas-pendiente', padre).children('.tarea-content').append(div);
                else
                    $('.tareas-debo', padre).children('.tarea-content').append(div);
              }
            });            
                
            //se muestra el lightbox de la información del vehículo
            $('#vehiculo-'+id_usuario_vehiculo).lightbox_me({
                    closeEsc: true,
                    lightboxSpeed: 'fast',
                    closeSelector: ".flota-t-close",
                    onLoad: function() { 
                        $(padre).on("click", ".tarea-chk-box:checked", function(event){
                            var tarea_item = $('.tarea-item').has(this);
                            $('.usuario-lightbox-ya-hise').hide();
                            if($('.usuario-lightbox-ya-hise', tarea_item).length > 0){
                                $('.usuario-lightbox-ya-hise', tarea_item).show(); 
                            }else{
                                ver_realizar_tarea(this);
                                validate_tarea_realizar($('form.tarea-realizada', tarea_item));
                                $('.tarea-realizada-fecha', padre).val( fecha );
                                $(".tarea-realizada-fecha", padre).datepicker({ appendText: "(aaaa-mm-dd)",altField: ".tarea-realizada-fecha", altFormat: 'yy-mm-dd', rangeSelect: false, maxDate: "+0D" });
                                $(".tarea-realizada-fecha", padre).on({
                                    change: function(event){
                                        fix_kilometraje(this, padre);
                                    }
                                }); 
                            }
                        });

                        $(".linea, .marca", padre).on({
                            change: function(event){
                                sugerir_carro(this);
                            }
                        });
                        editar_foto_carro(padre);
                        validate_form_editar_carro(id_usuario_vehiculo);
                        mostrar_hmto(padre, data_tareas_cat, data_hojas, id_usuario_vehiculo);
                        $(".input_change", padre).on({
                            change: function(event){
                                modificar_hmto(this);
                            },keypress: function(event){
                                modificar_hmto(this);
                            }
                        });

                        mostrar_herrmts(padre, data_herramientas);
                        $(".input_change_h", padre).on({
                            change: function(event){
                                modificar_herrmts(this);
                            },keypress: function(event){
                                modificar_herrmts(this);
                            }
                        });
                    },onClose: function(){
                        asignar_hmto(padre);
                    }
            });
            }else{
                confirm(error, function () {
                                $.modal.close();
                            });   
            } 
        }else{
            $('#vehiculo-'+id_usuario_vehiculo).lightbox_me({
                closeEsc: true,
                staticBackground: true,
                onClose: function(){
                    asignar_hmto($('#vehiculo-'+id_usuario_vehiculo));
                }
            });  
        }
    }

    //muestra la información de la hoja de mantenimiento de un carro
    var select_template;
    function mostrar_hmto(padre, data_tareas_cat, data_hojas, id_usuario_vehiculo){
        $('.htmo-div-button', padre).attr('href', '<?php echo base_url();?>usuario/cronograma_flotas/'+id_usuario_vehiculo);
        select_template = $('<select>').addClass('input_change').addClass('hmto_cat');
        var count_selected = 0;
        var opt_selected = 0;
             $.each( data_tareas_cat, function( key1, categoria ) {
                
                var option = $('<option>').val(key1).text(categoria);
                if(count_selected <1)
                    count_selected ++;
                else if(count_selected == 1){
                    opt_selected  = key1;
                    option.attr('selected', 'selected');
                }
                   
                select_template.append(option);
            });
         

        var tabla = $('.hmto-table', padre);
        var tbody = $('tbody', tabla);

        var even = true;
        $.each( data_hojas, function( key, hoja ) {
            if(even){
                var tr = $('<tr>').addClass('even');
                even = false;
            }else{
                var tr = $('<tr>').addClass('odd');
                even = true;
            }
            var td1 = $('<td>');
            var inputChk = $('<input>').attr('type', 'checkbox').addClass('input_chk'); td1.append(inputChk);
            var select = $('<select>').addClass('input_change').addClass('hmto_cat').attr('name', 'hmto_cat_'+key).attr('onchange', 'mostrar_otro(this)');
             $.each( data_tareas_cat, function( key1, categoria ) {
                
                var option = $('<option>').val(key1).text(categoria);
                if(key1 === hoja.id_servicio) 
                    option.attr('selected', 'selected');
                select.append(option);
            });
            var spanOtro = $('<span>').text('si otro, cuál: ').addClass('hmto_span_otro');
            var inputOtro = $('<input>').addClass('input_change').addClass('hmto_otro').attr('name', 'hmto_otro_'+key);
            var td2 = $('<td>'); td2.append(select); td2.append(spanOtro); td2.append(inputOtro);
            var td3 = $('<td>');
            var inputPerio = $('<input>').val(hoja.periodicidad).addClass('input_change').addClass('hmto_periodicidad').attr('name', 'hmto_periodicidad_'+key);td3.append(inputPerio);
            var td4 = $('<td>');
            var inputRango = $('<input>').val(hoja.rango).addClass('input_change').addClass('hmto_rango').attr('name', 'hmto_rango_'+key);td4.append(inputRango);
            tr.append(td1);
            tr.append(td2);
            tr.append(td3);
            tr.append(td4);
            tbody.append(tr);
        });
    }

    //muestra las herramientas de un vehículo
    function mostrar_herrmts(padre, data_herramientas){
        var tabla = $('.herrmts-table', padre);
        var tbody = $('tbody', tabla);

        var even = true;
        $.each( data_herramientas, function( key, herramienta ) {
            if(even){
                var tr = $('<tr>').addClass('even');
                even = false;
            }else{
                var tr = $('<tr>').addClass('odd');
                even = true;
            }
            var td1 = $('<td>');
            var inputChk = $('<input>').attr('type', 'checkbox').addClass('input_chk'); td1.append(inputChk);
            var td2 = $('<td>');
            var inputHerramienta = $('<input>').val(herramienta.herramienta).addClass('input_change_h').addClass('herrmts_herramienta').attr('name', 'herrmts_herramienta_'+key);td2.append(inputHerramienta);
            var td3 = $('<td>');
            var inputVida = $('<input>').val(herramienta.vida_util).addClass('input_change_h').addClass('herrmts_vida').attr('id', 'herrmts_vida_'+key).attr('name', 'herrmts_vida_'+key);td3.append(inputVida);
            tr.append(td1);
            tr.append(td2);
            tr.append(td3);
            tbody.append(tr);
            $('#herrmts_vida_'+key).datepicker({ altField: '#herrmts_vida_'+key, altFormat: 'yy-mm-dd', 
                rangeSelect: false , changeMonth: true, changeYear: true});
        });
    }

    //da la información del vehículo vía ajax
    function dar_vehiculo_ajax(id_usuario_vehiculo){
        var postData = '';
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>usuario/dar_vehiculo_flota",
            async: false,
            data: "id_usuario_vehiculo=" + id_usuario_vehiculo,
            success: function(data){
                postData = data;
            }
        });
        return postData; 
    }

    //da la información del vehículo vía ajax
    function dar_tareas_flota_ajax(id_usuario_vehiculo){
        var postData = '';
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>usuario/dar_tareas_flota",
            async: false,
            data: "id_usuario_vehiculo=" + id_usuario_vehiculo,
            success: function(data){
                postData = data;
            }
        });
        return postData; 
    }

    //selecciona el menu deseado
    function select_menu(e, seccion){
        var padre = $('.flotas-menu').has(e);
        if(!$(e).hasClass('fm-act')){            
            $('.fm-act', padre).removeClass('fm-act');
            $(e).addClass('fm-act');
            $('.fc-inactive', padre).removeClass('fc-inactive');
            if(seccion === 'hist'){
               $('.menu-hmto', padre).addClass('fc-inactive'); 
               $('.menu-herramientas', padre).addClass('fc-inactive'); 
               $('.flota-registrar-trabajo', padre).css('visibility', 'visible');
            }
            else if(seccion === 'hmto'){
                $('.flota-registrar-trabajo', padre).css('visibility', 'hidden');
                $('.menu-hist', padre).addClass('fc-inactive');
                $('.menu-herramientas', padre).addClass('fc-inactive'); 
                var form = $('form.hmto-form', padre);
                validate_hmto(form);
            }else{
                $('.flota-registrar-trabajo', padre).css('visibility', 'hidden');
                $('.menu-hist', padre).addClass('fc-inactive');
                $('.menu-hmto', padre).addClass('fc-inactive'); 
                var form = $('form.herrmts-form', padre);
                validate_herramientas(form);
            }  
        }
    }

    //actualiza las tareas de un carro
    function actualizar_tareas(id_usuario_vehiculo){
        var padre = $('#vehiculo-'+id_usuario_vehiculo);
        $('.tareas-pendiente', padre).children('.tarea-content').empty();
        $('.tareas-debo', padre).children('.tarea-content').empty();
        var data = dar_tareas_flota_ajax(id_usuario_vehiculo);
        var num_debo = 0;
        data = $.parseJSON(data);
        if(data.status){
            data = data.data;
            var data_uv = data.usuario_vehiculo;
            var data_tarea = data.tareas;
            var data_tareas_cat = data.tareasCategoria;
            
            $.each( data_tarea, function( key, tarea ) {
              if(tarea.realizado == false){
                var div = $('<div>').addClass('tarea-item');
                var input = $('<input>').addClass('tarea-chk-box').attr('type', 'checkbox').val(tarea.id_servicio);
                var img = $('<img>').addClass('tarea-img').attr('src', '<?php echo base_url();?>'+tarea.imagen_thumb_url).attr('alt', tarea.nombre);
                var tarea_texto = $('<div>').addClass('tarea-texto');
                var tarea_nombre = $('<div>').addClass('tarea-nombre').text(tarea.nombre); tarea_texto.append(tarea_nombre);
                var texto_tiempo = '';
                if(!!tarea.dias_restantes){
                    texto_tiempo = ' '+tarea.dias_restantes + ' '+ tarea.mensaje_dias_restantes2;
                }
                var tarea_tiempo = $('<div>').addClass('tarea-tiempo').text(tarea.mensaje_dias_restantes + texto_tiempo);  
                tarea_texto.append(tarea_tiempo);tarea_texto.append(tarea_tiempo);
                div.append(input);
                div.append(img);
                div.append(tarea_texto);
                if(!!tarea.dias_restantes && tarea.dias_restantes>15)
                    $('.tareas-pendiente', padre).children('.tarea-content').append(div);
                else{
                    $('.tareas-debo', padre).children('.tarea-content').append(div);
                    num_debo ++;
                }
              }
          });
            if(num_debo >0){
                var div_notificacion = $('<div>').addClass('notificacion-tarea').text(num_debo);
                $('#carro-'+id_usuario_vehiculo +' td:nth-of-type(1)').append(div_notificacion);
            }
            $('.hmto-guardar.htmo-div-button', padre).hide();
        }
    }

    //Valida el formulario de editar vehiculo
    function validate_form_editar_carro(id_usuario_vehiculo){
        $('#vehiculo-'+id_usuario_vehiculo +' .editar-vehiculo').validate({
            rules:{
                editar_marca:{
                    required: true,
                    maxlength: 30
                },
                editar_linea:{
                    required: true,
                    maxlength: 50
                },
                editar_kms:{
                    required: true,
                    number: true
                },
                editar_placa:{
                    maxlength: 7
                },
                editar_modelo:{
                    required: true,
                    number: true
                }
            },
            messages: {
                editar_marca: {
                    required: "*Debes ingresar la marca de tu carro",
                    maxlength: "*La marca del carro no puede contener más de 30 caracteres"
                },
                editar_linea: {
                    required: "*Debes ingresar la línea de tu carro",
                    maxlength: "*La línea del carro no puede contener más de 40 caracteres"
                },
                editar_kms: {
                    required: "*Debes ingresar el kilometraje de tu carro",
                    number: "*El kilometraje debe ser un número"
                },
                editar_modelo: {
                    required: "*Debes ingresar el modelo de tu carro",
                    number: "*El modelo de tu carro debe ser un número"
                },
                editar_placa: {
                    maxlength: "*La placa no puede tener más de 7 caracteres"
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
                }
                validator.focusInvalid();
            }
            ,submitHandler: function(form){
                var padre = $(form);
                var elem = $('.usuario-div-editar', padre);

                var marca = $('.marca', padre);
                var linea = $('.linea', padre);
                var modelo = $('.inf-dato.modelo select', padre);
                var kilometraje = $('.inf-dato.kilometraje input', padre);
                var placa = $('.inf-dato.placa input', padre);
                var vida_util = $('.inf-dato.vida_util input', padre);

                var nuevo_carro = $('.nuevo_carro', padre).val();

                $.ajax({
                    type: "POST",
                    url: "usuario/editar_vehiculo_fix",
                    async: false,
                    data: "id_usuario_vehiculo=" + id_usuario_vehiculo + "&modelo=" + modelo.val() + "&kilometraje=" + kilometraje.val() + 
                    "&placa=" + placa.val()+ "&marca=" + marca.val()+ "&linea=" + linea.val()+ "&vida_util=" + vida_util.val(),
                    success: function(data){
                        var corrio = data.split('|');
                        if(data == 'true'){
                            $('.marca-linea .span-dato', padre).text(marca.val() + ' ' + linea.val());
                            $('.modelo .span-dato', padre).text(modelo.val());
                            $('.kilometraje .span-dato', padre).text(kilometraje.val());
                            $('.placa .span-dato', padre).text(placa.val());
                            $('.vida_util .span-dato', padre).text(vida_util.val());
                            $('.ui-datepicker-append', padre).hide();
                            $('#carro-'+id_usuario_vehiculo +' td:nth-of-type(1)').text('8').append('&nbsp;&nbsp;&nbsp;').append(placa.val());
                            $('#carro-'+id_usuario_vehiculo +' td:nth-of-type(2)').text(marca.val());
                            $('#carro-'+id_usuario_vehiculo +' td:nth-of-type(3)').text(linea.val());
                            $('#carro-'+id_usuario_vehiculo +' td:nth-of-type(4)').text(kilometraje.val());

                            $('.editar-perfil-show', padre).show('fast');
                            $('.editar-perfil-hidden', padre).hide('fast'); 
                        
                            //carga la información de las tareas por ajax
                            actualizar_tareas(id_usuario_vehiculo);
                        }
                        else{
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
                        }
                    }
                });
                return false;
            }

        });
    }

    //cuando se le da click al checkbox de la tarea, se le muestra un menú para ingresar
    //la fecha, kilometraje y adjunto de cuando se realizó el mantenimiento
    function ver_realizar_tarea(elem){
        var tarea_item = $('.tarea-item').has(elem);
        var nombreTarea = $('.tarea-nombre', tarea_item).text();
        var padre = $('.flota-div-template').has(tarea_item);
        var kilometraje = $('.kilometraje .span-dato', padre).text();
        var div = $('<div>').addClass('usuario-lightbox-ya-hise');
        var t1 = $('<div>').addClass('usuario-lightbox-ya-hise-t1').text('Cuándo fue la última vez que realizaste');div.append(t1);
        var t2 = $('<div>').addClass('usuario-lightbox-ya-hise-t2').text(nombreTarea);div.append(t2);
        var form = $('<form>').addClass('tarea-realizada');
        var id_servicio = $('<input>').attr('type', 'hidden').attr('name', 'tarea_realizada_id_tarea').addClass('tarea-realizada-id-tarea').val($(elem).val()); form.append(id_servicio);
        var id_usuario_vehiculo = $('<input>').attr('type', 'hidden').attr('name', 'tarea_realizada_id_usuario_vehiculo').addClass('tarea-realizada-id-usuario_vehiculo').val($('.editar_id_usuario_vehiculo', padre).val());form.append(id_usuario_vehiculo);
        var content = $('<div>').addClass('usuario-lightbox-ya-hise-content');
        var divFecha = $('<div>').addClass('usuario-lightbox-ya-hise-fecha');
        var lblFecha = $('<label>').text('Cuándo realizaste el mantenimiento?'); divFecha.append(lblFecha);
        var fecha = $('<input>').attr('name', 'tarea_realizada_fecha').attr('type', 'text').addClass('tarea-realizada-fecha');divFecha.append(fecha);
        content.append(divFecha);
        var divKms = $('<div>').addClass('usuario-lightbox-ya-hise-kilometraje');
        var lblKms = $('<label>').text('Kilometraje:'); divKms.append(lblKms);
        var kms = $('<input>').attr('name', 'tarea_realizada_kilometraje').attr('type', 'text').addClass('tarea-realizada-kilometraje').val(kilometraje);divKms.append(kms);
        content.append(divKms);
        form.append(content);
        var divAdjunto = $('<div>').addClass('usuario-lightbox-ya-hise-adjunto');
        var lblAdjunto = $('<lable>').text('Adjunta el recibo o comprobante: (*opcional)');divAdjunto.append(lblAdjunto);
        var adjunto = $('<input>').attr('type', 'file').attr('name', 'tarea_realizada_adjunto').addClass('tarea_realizada_adjunto').attr('id', 'tarea_realizada_adjunto_'+$(elem).val()+'_'+$('.editar_id_usuario_vehiculo', padre).val()); divAdjunto.append(adjunto);
        form.append(divAdjunto);
        var divSubmit = $('<div>').addClass('usuario-lightbox-ya-hise-submit');
        var enviar = $('<input>').attr('type', 'submit').val('Enviar').addClass('tarea_realizada_submit').addClass('tarea_realizada_submit');divSubmit.append(enviar);
        var cancelar = $('<input>').attr('type', 'button').val('Cancelar').addClass('tarea_realizada_cancelar').addClass('tarea_realizada_cancelar').attr('onclick', 'cancelar_hmto(this)');divSubmit.append(cancelar);
        var img = $('<img>').attr('src', '').addClass('ajax_img_loader'); divSubmit.append(img);
        form.append(divSubmit);
        form.append('<div class="clear"></div>');
        div.append(form);
        var padre = $('.tarea-item').has(elem);
        padre.append(div);
        $(elem).prev('.editar_id_usuario_vehiculo');
    }

    //cuando cambia algún elemento de la hoja de mantenimiento
    //se muestra el boton de guardar
    function modificar_hmto(elem){
        var padre = $('.menu-hmto').has(elem);
        if($('.hmto-guardar.htmo-div-button', padre).is(":hidden"))
            $('.hmto-guardar.htmo-div-button', padre).show();
    }

    //cuando cambia algún elemento de la hoja de mantenimiento
    //se muestra el boton de guardar
    function modificar_herrmts(elem){
        var padre = $('.menu-herramientas').has(elem);
        if($('.herrmts-guardar.herrmts-div-button', padre).is(":hidden"))
            $('.herrmts-guardar.herrmts-div-button', padre).show();
    }

    function cancelar_hmto(elem){
        var padre = $('.tarea-item').has(elem);
        $('.tarea-chk-box').attr('checked', false);
        if($('.usuario-lightbox-ya-hise', padre).is(":visible"))
            $('.usuario-lightbox-ya-hise', padre).hide();
    }

    //Busca la referencia del carro más parecida
    var globalTimeout = null; 
    function sugerir_carro(elem){
        var padre = $('.editar-vehiculo').has(elem);
        var marca = $('.marca', padre);
        var linea = $('.linea', padre);
        $('.inf-dato-editar-submit input', padre).attr('disabled', 'disabled');
        padre.bind('submit',function(e){e.preventDefault();});
        var vehiculo = marca.val()+' '+linea.val();
        if(vehiculo.length > 0){
            if (globalTimeout != null) {
                clearTimeout(globalTimeout);
              }
              globalTimeout = setTimeout(function() {
                globalTimeout = null;  

                $.ajax({
                    url: "<?php echo base_url(); ?>usuario/buscar_vehiculo_similar_ajax",
                    type: "POST",
                    data: {
                        vehiculo: vehiculo
                    },
                    onsubmit: false,
                    success: function(data, status){
                        if(data !== 'true'){
                            data = JSON.parse(data); 
                            var carro = data.marca +' '+ data.linea; 
                            $('.quisiste_decir', padre).text(carro);
                            $('.quisiste_decir_marca', padre).val(data.marca);
                            $('.quisiste_decir_linea', padre).val(data.linea);
                            $('.div_quisiste_decir', padre).css('display', 'block');
                            $('.nuevo_carro', padre).val(1);
                        }else{
                            $('.div_quisiste_decir', padre).css('display', 'none');
                            $('.nuevo_carro', padre).val(0);
                        }
                        $('.inf-dato-editar-submit input', padre).removeAttr('disabled', 'disabled');
                    }
                });

              }, 1000);  
        }else{
           clearTimeout(globalTimeout); 
        }
    }

    var globalTimeout2 = null; 
    function sugerir_carro2(elem){
        var padre = $('#form_vehiculo').has(elem);
        var marca = $('#input_vehiculo_marca');
        var linea = $('#input_vehiculo_linea');
        $('#input-vehiculo-submit').attr('disabled', 'disabled');
        padre.bind('submit',function(e){e.preventDefault();});
        var vehiculo = marca.val()+' '+linea.val();
        if(vehiculo.length > 0 && linea.val().length > 0){
            if (globalTimeout2 != null) {
                clearTimeout(globalTimeout2);
              }
              globalTimeout2 = setTimeout(function() {
                globalTimeout2 = null;  

                $.ajax({
                    url: "<?php echo base_url(); ?>usuario/buscar_vehiculo_similar_ajax",
                    type: "POST",
                    data: {
                        vehiculo: vehiculo
                    },
                    onsubmit: false,
                    success: function(data, status){
                        if(data !== 'true'){
                            data = JSON.parse(data); 
                            var carro = data.marca +' '+ data.linea; 
                            $('#quisiste_decir').text(carro);
                            $('#quisiste_decir_marca').val(data.marca);
                            $('#quisiste_decir_linea').val(data.linea);
                            $('.div_quisiste_decir', padre).css('display', 'block');
                            $('#nuevo_carro').val(1);
                        }else{
                            $('.div_quisiste_decir', padre).css('display', 'none');
                            $('#nuevo_carro').val(0);
                        }
                        $('#input-vehiculo-submit').removeAttr('disabled', 'disabled');
                    }
                });

              }, 1000);  
        }else{
           clearTimeout(globalTimeout2); 
        }
    }

    //cambia el formato de la fecha y cambia el kilometraje
    function fix_kilometraje(elem, padre){
        var fecha = $(elem).val();
        var tarea_realizada = $('.tarea-realizada').has(elem);
        var arrayFecha = fecha.split('-');
        var formatFecha = new Date(arrayFecha[0], arrayFecha[1]-1, arrayFecha[2]);
        var fechaActual = new Date();
        var diff = Math.abs(formatFecha.getTime() - fechaActual.getTime());
        var diffDias  = Math.ceil( diff/(60*60*24*1000)) -1;
        var kilometraje = $('.kilometraje .span-dato', padre).text();  
        var kms_fix =  kilometraje - (diffDias * 34);
        $('.tarea-realizada-kilometraje', tarea_realizada).val( kms_fix ); //kilometraje actual - diff * kilometraje diario ponderado de la ciudad
    }

    //valida el formulario de la tarea que se va a realizar
    function validate_tarea_realizar(forma){
        $(forma).validate({
            rules: {
                tarea_realizada_kilometraje:{
                    required: true,
                    number: true
                },
                tarea_realizada_fecha: {
                    required: true
                }
            },
            messages: {
                tarea_realizada_kilometraje:{
                    required: "*debes escribir el kilometraje en que realizaste el mantenimiento",
                    number: "*el kilometraje debe ser un número"
                },
                tarea_realizada_fecha: {
                    required: "*debes escribir la fecha en que realizaste el mantenimiento"
                }
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
                    confirm(message + errors, function () {
                                                        $.modal.close();
                                                    });
//                    alert(message + errors)
                }
                validator.focusInvalid()
            },
            errorClass: "form-invalid",
            validClass: "form-valid",
            // onsubmit: false,
            submitHandler: function (form) {
                $(form).bind('click');
                $('.ajax_img_loader', form).show();
                var padre = $('.flota-div-template').has(form);
                var input_submit = $('.tarea_realizada_submit', form);
                var id_tarea = $('.tarea-realizada-id-tarea', form).val();
                var id_usuario_vehiculo = $('.tarea-realizada-id-usuario_vehiculo', form).val();
                var kilometraje = $('.tarea-realizada-kilometraje', form).val();
                var fecha = $('.tarea-realizada-fecha', form).val();
                $.ajaxFileUpload({
                    url: "<?php echo base_url();?>usuario/tarea_realizada_ajax",
                    secureuri      :false,
                    fileElementId  :'tarea_realizada_adjunto_'+id_tarea+'_'+id_usuario_vehiculo,
                    dataType    : 'json',
                    data: {
                        'id_tarea': id_tarea,
                        'id_usuario': id_usuario_vehiculo,
                        'kilometraje': kilometraje,
                        'fecha': fecha
                    },
                    success: function (data, status){
                        // sube el adjunto
                        if(data.status==true){
                            var temp = (data.msg).split("|"); console.log(temp[0]+temp[1]+temp[2]);
                            var div = $('<div>').addClass('hist-compra').css('background-color', '#fefefe');
                            var ul = $('<ul>');
                            var li = $('<li>');
                            var span_nombre = $('<span>').text('Se realizó la tarea: ');
                            if(!!temp[3]){
                                var strong = $('<strong>').text(temp[2]);span_nombre.append(strong); li.append(span_nombre);
                                var nombre_adjunto = temp[3].split('/'); var size = nombre_adjunto.length -1;
                                var ahref = $('<a>').attr('href', '<?php echo base_url();?>'+temp[3]).attr('target', '_blank').text(nombre_adjunto[size]); li.append('Ver: ');li.append(ahref);
                            }else{
                                var strong = $('<strong>').text(temp[2]);span_nombre.append(strong); li.append(span_nombre);
                            }
                            var span_fecha = $('<span>').addClass('hist-fecha').text(temp[0]); li.append(span_fecha);
                            ul.append(li);
                            var input_id = $('<input>').attr('type', 'hidden').val(temp[1]); div.append(input_id);
                            div.append(ul);
                            var div_clear =  $('<div>').addClass('clear');
                            div.append(div_clear);
                            $('.menu-hist', padre).prepend(div);
                            $('.tarea-item').has(form).hide();

                            cancelar_hmto(input_submit);
                        }else{
                            confirm(data.msg, function () {
                                                        $.modal.close();
                                                    });
                        }
                    }
                });
                $('.ajax_img_loader', form).hide();
                $(form).unbind('click');
            }
        });
    }

    //valida la forma de las herramientas
    function validate_herramientas(forma){
        var padre = $('.flota-div-template').has(forma);
        $(forma).validate({
        errorClass: "form-invalid",
        validClass: "form-valid",
        showErrors: function(errorMap, errorList) {
            // Do nothing here
         },
        invalidHandler: function (form, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                var message = errors == 1 ? 'Se encontró el siguiente error:\n' : 'Se encontraron los siguientes ' + errors + ' errores:\n';
                var errors = "";
                if (validator.errorList.length > 0) {
                        errors += "<br/>" +  "\n\u25CF " + validator.errorList[0].message;

                }
                confirm(message + errors, function () {
                                            $.modal.close();
                                            validator.errorList[0].element.focus();
                                        });
            }
        },
        submitHandler: function (form) {
          $(form).bind('click');
            $('.ajax_img_loader', form).show();
            $.ajax({
                url: "<?php echo base_url(); ?>usuario/actualizar_herramientas_ajax",
                type: "POST",
                data: {
                    id_usuario_vehiculo: function () {
                        return $(".editar_id_usuario_vehiculo", padre).val();
                    },
                    input_herramientas: function () {
                        return $(".herrmts_herramienta", form).serialize();
                    },
                    input_vidas: function () {
                        return $(".herrmts_vida", form).serialize();
                    }
                },
                success: function (data) {
                    var data = $.parseJSON(data);
                    if(data.status)
                        $('.herrmts-guardar.herrmts-div-button', padre).hide();
                    else{
                        confirm(data.msg, function () {
                                        $.modal.close();
                                    });   
                    }
                }
            });
            $('.ajax_img_loader', form).hide();
            $(form).unbind('click');
        }
    });

    $("input.herrmts_herramienta", forma).each(function() {
        $(this).rules("add", { 
            required: true,
            messages: {
                required: '*Debes ingresar la herramienta'
            } 
        });
    });

    }
    //valida la forma de la hoja de mantenimiento
    function validate_hmto(forma){
        var padre = $('.flota-div-template').has(forma);
        $(forma).validate({
        errorClass: "form-invalid",
        validClass: "form-valid",
        showErrors: function(errorMap, errorList) {
            // Do nothing here
         },
        invalidHandler: function (form, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                var message = errors == 1 ? 'Se encontró el siguiente error:\n' : 'Se encontraron los siguientes ' + errors + ' errores:\n';
                var errors = "";
                if (validator.errorList.length > 0) {
                        errors += "<br/>" +  "\n\u25CF " + validator.errorList[0].message;

                }
                confirm(message + errors, function () {
                                            $.modal.close();
                                            validator.errorList[0].element.focus();
                                        });
            }
        },
        submitHandler: function (form) {
          $(form).bind('click');
            $('.ajax_img_loader', form).show();
            $.ajax({
                url: "<?php echo base_url(); ?>usuario/actualizar_htmo_usuario_ajax",
                type: "POST",
                data: {
                    id_usuario_vehiculo: function () {
                        return $(".editar_id_usuario_vehiculo", padre).val();
                    },
                    input_otro: function () {
                        return $(".hmto_otro", form).serialize();
                    },
                    input_categoria: function () {
                        return $(".hmto_cat", form).serialize();
                    },
                    input_rango: function () {
                        return $(".hmto_rango", form).serialize();
                    },
                    input_periodicidad: function () {
                        return $(".hmto_periodicidad", form).serialize();
                    }
                },
                onsubmit: false,
                success: function (data) {
                    var data = $.parseJSON(data);
                    if(data.status)
                        actualizar_tareas($(".editar_id_usuario_vehiculo", padre).val());
                    else{
                        confirm(data.msg, function () {
                                        $.modal.close();
                                    });   
                    }
                }
            });
            $('.ajax_img_loader', form).hide();
            $(form).unbind('click');
        }
    });

    $("input.hmto_cat", forma).each(function() {
        $(this).rules("add", { 
            required: true,
            number: true,
            messages: {
                required: '*Debes ingresar la categoría',
                number: '*Categoría debe ser un número'
            } 
        });
    });

    $("input.hmto_otro", forma).each(function(i, e) {
        var cat_padre = $("td").has(e);
        $(this).rules("add", { 
            required:{
               depends: function(elem){
                    return ($('.hmto_cat',cat_padre).val() ==0)
               } 
            },
            messages: {
                required: '*Debes ingresar el nombre de la categoría nueva'
            } 
        });
    });

    $("input.hmto_rango", forma).each(function() {
        $(this).rules("add", { 
            required: true,
            number: true,
            messages: {
                required: '*Debes ingresar un rango',
                number: '*El rango debe ser un número'
            } 
        });
    });
    $("input.hmto_periodicidad", forma).each(function() {
        $(this).rules("add", { 
            required: true,
            number: true,
            messages: {
                required: '*Debes ingresar una periodicidad',
                number: '*La periodicidad debe ser un número'
            } 
        });
    });
    }

    //elimina las filas de tareas seleccionadas
    function eliminar_tareas(elem){
        // console.log('entro a eliminar');
        var padre = $('.menu-hmto').has(elem);
        var count= 0;
        $('.input_chk:checked', padre).each(function(i, e) {
            $('tr').has(e).remove();  
            count ++;
        });  
        if(count > 0)
            $('.hmto-guardar.htmo-div-button', padre).show();
    }

    //agrega una fila de tarea
    function agregar_tarea(elem){
        var padre = $('.menu-hmto').has(elem);
        var tbody = $('.hmto-table tbody', padre);
       
        var numero = Math.floor(Math.random() * 1000) + 1;

        var tr = $('<tr>').addClass('odd');
        var td1 = $('<td>');
        var inputChk = $('<input>').attr('type', 'checkbox').addClass('input_chk'); td1.append(inputChk);
        var select = select_template.clone(); //hay que cambiarlo
        select.attr('name', 'hmto_cat_'+numero).attr('onchange', 'mostrar_otro(this)');
        var spanOtro = $('<span>').text('si otro, cuál: ').addClass('hmto_span_otro');
        var inputOtro = $('<input>').addClass('input_change').addClass('hmto_otro').attr('name', 'hmto_otro_'+numero);
        var td2 = $('<td>'); td2.append(select); td2.append(spanOtro); td2.append(inputOtro);
        var td3 = $('<td>');
        var inputPerio = $('<input>').addClass('input_change').addClass('hmto_periodicidad').attr('name', 'hmto_periodicidad_'+numero);td3.append(inputPerio);
        var td4 = $('<td>');
        var inputRango = $('<input>').val('0').addClass('input_change').addClass('hmto_rango').attr('name', 'hmto_rango_'+numero);td4.append(inputRango);
        tr.append(td1);
        tr.append(td2);
        tr.append(td3);
        tr.append(td4);
        tbody.append(tr);

        $(inputRango).rules("add", { 
            required: true,
            number: true,
            messages: {
                required: '*Debes ingresar un rango',
                number: '*El rango debe ser un número'
            } 
        });

        var cat_padre = $("td").has(inputOtro);
        $(inputOtro).rules("add", { 
            required:{
               depends: function(elem){
                    return ($('.hmto_cat',cat_padre).val() ==0)
               } 
            },
            messages: {
                required: '*Debes ingresar el nombre de la categoría nueva'
            } 
        });

        $(inputPerio).rules("add", { 
            required: true,
            number: true,
            messages: {
                required: '*Debes ingresar una periodicidad',
                number: '*La periodicidad debe ser un número'
            } 
        });
        $('.hmto-guardar', padre).show();
    }

    //cuando se le da click al boton asignar, muestra el lightbox de asignar
    //la hoja de mantenimiento a otros carros
    function lighbox_asignar(elem){
        var lightbox = $(elem).next('.asignar-lightbox');
        lightbox.show();
    }

    //cierra el div de asignar
    function cerrar_asignar(elem){
        var lightbox = $('.asignar-lightbox').has(elem);
        lightbox.hide();
    }

    //cuando selecciona un carro lo deja resaltado
    function asignar_vehiculo(elem){
        if( $(elem).hasClass('selected') ){
            $(elem).removeClass('selected');
        }else{
            $(elem).addClass('selected');
        }   
    }

    //asigna la hoja de mantenimiento actual a los carros seleccionados
    function asignar_hmto(padre){
        var carros_seleccionados = new Array();
        $('.asignar-lb-carro.selected', padre).each(function(i, e) {
            carros_seleccionados.push($(e).attr('data-id-usuario-vehiculo'));
        }); 
        if(carros_seleccionados.length > 0){
           $.ajax({
                url: "<?php echo base_url(); ?>usuario/asignar_htmo",
                type: "POST",
                data: {
                    id_usuario_vehiculo: function(){
                        return $(".editar_id_usuario_vehiculo", padre).val();
                    },asignados: function(){
                        return JSON.stringify(carros_seleccionados);
                    }
                },
                onsubmit: false,
                success: function(data, status){
                    location.reload();
                }
            }); 
        }
    }

    //muestra el campo de otra categoría para ingresar
    function mostrar_otro(elem){
        var padre = $('td').has(elem);
        if($(elem).val() == 0){
            $('.hmto_span_otro:hidden', padre).show();
            $('.input_change.hmto_otro:hidden', padre).show();
        }else{
            $('.hmto_span_otro:visible', padre).hide();
            $('.input_change.hmto_otro:visible', padre).hide();
        }
            
    }
    //Edita la foto de los automoviles
    function editar_foto_carro(padre){
        var thumb = $('.inf-carro-marco img', padre);  
        var id = $('.input_imageUpload_automovil', padre).attr('id');
        new AjaxUpload(id, {
            action: '<?php echo base_url();?>usuario/subir_imagen_temp_ajax',
            name: 'image',
            onSubmit: function(file, extension) {

                $('.inf-carro-marco', padre).addClass('loading_subir_imagen_automovil');
                $('.inf-carro-marco img', padre).css('display', 'none');
                this.setData({id_usuario_vehiculo: $('.editar_id_usuario_vehiculo', padre).val() });
            },
            onComplete: function(file, response) {
                thumb.load(function(){
                    $('.inf-carro-marco', padre).removeClass('loading_subir_imagen_automovil');
                    $('.inf-carro-marco img', padre).css('display', 'block');
                    thumb.unbind();
                });
                thumb.attr('src', response);

            }
        });
    }

    //cuando se le da click al checkbox de la tarea, se le muestra un menú para ingresar
    //la fecha, kilometraje y adjunto de cuando se realizó el mantenimiento
    function ver_realizar_trabajo(elem){
        var lightbox = $('.flota-div-template').has(elem);
        var padre = $(elem).next('.flota-rt-div');
        if($('.trabajo-realizado', padre).length > 0){
            if($('.trabajo-realizado', padre).is(':hidden')){
                $('.trabajo-realizado', padre).show();
            }else{
                $('.trabajo-realizado', padre).hide();
            }
        }else{
            var div = $('<div>').addClass('trabajo-realizado');
            var t1 = $('<div>').addClass('trabajo-realizado-t1').text('Registra los datos del trabajo realizado');div.append(t1);
            var form = $('<form>').addClass('form_trabajo');
            var content = $('<div>').addClass('trabajo-realizado-content');
            var divTrabajo = $('<div>').addClass('trabajo-realizado-trabajo');
            var lblTrabajo = $('<label>').text('Trabajo:'); divTrabajo.append(lblTrabajo);
            var trabajo = $('<input>').attr('name', 'trabajo_realizada_trabajo').attr('type', 'text').addClass('tr-trabajo').val(trabajo);divTrabajo.append(trabajo);
            content.append(divTrabajo);
            var divFecha = $('<div>').addClass('trabajo-realizado-fecha');
            var lblFecha = $('<label>').text('Fecha de realización:'); divFecha.append(lblFecha);
            var fechaInput = $('<input>').attr('name', 'trabajo_realizada_fecha').attr('type', 'text').addClass('tr-fecha');divFecha.append(fechaInput);
            content.append(divFecha);
            var divKms = $('<div>').addClass('trabajo-realizado-kilometraje');
            var lblKms = $('<label>').text('Kilometraje:'); divKms.append(lblKms);
            var kms = $('<input>').attr('name', 'trabajo_realizada_kilometraje').attr('type', 'text').addClass('tr-kilometraje');divKms.append(kms);
            content.append(divKms);
            form.append(content);
            var divAdjunto = $('<div>').addClass('trabajo-realizado-adjunto');
            var lblAdjunto = $('<lable>').text('Adjunta recibo o comprobante: (*opcional)');divAdjunto.append(lblAdjunto);
            var adjunto = $('<input>').attr('type', 'file').attr('name', 'trabajo_realizada_adjunto').addClass('tr_adjunto').attr('id', 'tr_adjunto_'+$('.editar_id_usuario_vehiculo', lightbox).val()); divAdjunto.append(adjunto);
            form.append(divAdjunto);
            var divSubmit = $('<div>').addClass('trabajo-realizado-submit');
            var enviar = $('<input>').attr('type', 'submit').val('Enviar').addClass('trabajo_realizado_submit').addClass('tr_submit');divSubmit.append(enviar);
            var cancelar = $('<input>').attr('type', 'button').val('Cancelar').addClass('trabajo_realizado_cancelar').addClass('tr_cancelar').attr('onclick', 'cancelar_trabajo(this)');divSubmit.append(cancelar);
            var img = $('<img>').attr('src', '').addClass('ajax_img_loader'); divSubmit.append(img);
            form.append(divSubmit);
            form.append('<div class="clear"></div>');
            div.append(form);
            padre.append(div);
            $(fechaInput).val( fecha );
            $(fechaInput).datepicker({ appendText: "(aaaa-mm-dd)",altField: ".tr-fecha", altFormat: 'yy-mm-dd', rangeSelect: false, maxDate: "+0D" });
            validate_trabajo_realizado(form);
        }
    }

     function validate_trabajo_realizado(forma){
        $(forma).validate({
            rules: {
                trabajo_realizada_trabajo:{
                    required: true
                },
                trabajo_realizada_kilometraje:{
                    number: true
                },trabajo_realizada_fecha:{
                    required: true
                }
            },
            messages: {
                trabajo_realizada_trabajo: "*Ingresa el trabajo realizado",
                trabajo_realizada_kilometraje: "*El kilometraje debe ser un número",
                trabajo_realizada_fecha: "*Ingresa la fecha en que realizaste el trabajo"
            },
            invalidHandler: function (form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {
                    var message = errors == 1 ? 'Se encontró el siguiente error:\n' : 'Se encontraron los siguientes ' + errors + ' errores:\n';
                    var errors = "";
                    if (validator.errorList.length > 0) {
                            errors += "<br/>" +  "\n\u25CF " + validator.errorList[0].message;

                    }
                    confirm(message + errors, function () {
                                    $.modal.close();
                                    validator.errorList[0].element.focus();
                                });
                }
            },
            errorClass: "form-invalid",
            validClass: "form-valid",
            submitHandler: function (form) {
                $(form).bind('click');
                $('.ajax_img_loader', form).show();
                // console.log($(form).html());
                var padre = $('.flota-div-template').has(form);
                // var formita = $('.form_trabajo', padre)
                // var input_submit = $('.tarea_realizada_submit', form);
                var id_usuario_vehiculo = $('.editar_id_usuario_vehiculo', padre).val();
                var trabajo = $('.tr-trabajo', form).val();
                var kilometraje = $('.tr-kilometraje', form).val();
                var fecha = $('.tr-fecha', form).val();

                $.ajaxFileUpload({
                    url: "<?php echo base_url();?>usuario/trabajo_realizado_ajax",
                    secureuri      :false,
                    fileElementId  :'tr_adjunto_'+id_usuario_vehiculo,
                    dataType    : 'json',
                    data: {
                        'id_usuario_vehiculo': id_usuario_vehiculo,
                        'trabajo': trabajo,
                        'kilometraje': kilometraje,
                        'fecha': fecha
                    },
                    success: function (data, status){
                        // sube el adjunto
                        if(data.status==true){
                            var menu_content = $('.menu-content', padre);
                            var temp = (data.msg).split("|");
                            var div = $('<div>').addClass('hist-compra').css('background-color', '#fefefe');
                            var ul = $('<ul>');
                            var li = $('<li>');
                            var span_nombre = $('<span>').text('Se registró el trabajo: ');
                            if(!!temp[3]){
                                var strong = $('<strong>').text(temp[2]);span_nombre.append(strong); li.append(span_nombre);
                                var nombre_adjunto = temp[3].split('/'); var size = nombre_adjunto.length -1;
                                var ahref = $('<a>').attr('href', '<?php echo base_url();?>'+temp[3]).attr('target', '_blank').text(nombre_adjunto[size]); li.append('Ver: ');li.append(ahref);
                            }else{
                                var strong = $('<strong>').text(temp[2]);span_nombre.append(strong); li.append(span_nombre);
                            }
                            
                            var span_fecha = $('<span>').addClass('hist-fecha').text(temp[0]); li.append(span_fecha);
                            ul.append(li);
                            var input_id = $('<input>').attr('type', 'hidden').val(temp[1]); div.append(input_id);
                            div.append(ul);
                            var div_clear =  $('<div>').addClass('clear');
                            div.append(div_clear);
                            $('.menu-hist', menu_content).prepend(div);
                            $('.trabajo-realizado').has(form).hide();
                            $('.flota-rt-div').has(form).empty();

                            // cancelar_hmto(input_submit);
                        }else{
                            confirm(data.msg, function () {
                                                        $.modal.close();
                                                    });
                        }
                    }
                });
                $('.ajax_img_loader', form).hide();
                $(form).unbind('click');
            }
        });
    }

    //esconde el formulario de agregar trabajo
    function cancelar_trabajo(elem){
        $('.trabajo-realizado').has(elem).hide();
    }

    function mostrar_agregar_vehiculo(elem, id_flota){
        $('#loging-div').lightbox_me({
            closeEsc: true,
            lightboxSpeed: 'fast',
            onLoad: function() { 
                //Valida el formulario de login
                $("#form_vehiculo").validate({
                    rules: {
                        input_vehiculo_marca: {
                            required: true,
                            maxlength: 20
                        },
                        input_vehiculo_linea: {
                            required: true,
                            maxlength: 50
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
                            required: true,
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
                            required: "*Debes ingresar la placa de tu carro",
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
                        }
                        validator.focusInvalid()
                    },
                    submitHandler: function (form) {
                        var nuevo_carro = $('#nuevo_carro').val();
                        var input_vehiculo_marca = $("#input_vehiculo_marca").val();
                        var input_vehiculo_linea = $("#input_vehiculo_linea").val();
                        var input_vehiculo_kilometraje = $("#input_vehiculo_kilometraje").val();
                        var input_vehiculo_modelo = $("#input_vehiculo_modelo").val();
                        var input_vehiculo_placa = $("#input_vehiculo_placa").val();
                        if(nuevo_carro == 1){
                            confirmNO('El carro <strong>'+ marca+' '+linea+'</strong> no aparece en el sistema, está seguro que desea registrar este carro', function () {
                                $(form).bind('click');
                                $('.ajax_img_loader', form).show();
                                $.ajaxFileUpload({
                                    url: "<?php echo base_url(); ?>usuario/agregar_vehiculo_flota_ajax",
                                    secureuri: false,
                                    fileElementId  :'input_vehiculo_imagen',
                                    dataType    : 'json',
                                    data: {
                                        'input_vehiculo_marca': input_vehiculo_marca
                                        ,'input_vehiculo_linea': input_vehiculo_linea
                                        ,'input_vehiculo_kilometraje': input_vehiculo_kilometraje
                                        ,'input_vehiculo_modelo': input_vehiculo_modelo
                                        ,'input_vehiculo_placa': input_vehiculo_placa
                                        ,'input_id_flota': id_flota
                                    },success: function (data, status){
                                        // var data = $.parseJSON(data);
                                        if(data.status){
                                            agregar_carro_tabla(id_flota, data.id_usuario_vehiculo, input_vehiculo_placa, input_vehiculo_marca, input_vehiculo_linea, input_vehiculo_kilometraje);
                                            $('#loging-div').trigger('close');
                                            $('#nuevo_carro').val('');
                                            $("#input_vehiculo_marca").val('');
                                            $("#input_vehiculo_linea").val('');
                                            $("#input_vehiculo_kilometraje").val('');
                                            $("#input_vehiculo_modelo").val('');
                                            $("#input_vehiculo_placa").val('');
                                            $('.form_login_div_campo.div_quisiste_decir').hide();
                                        }else{
                                            confirm(data.msg, function () {
                                                        $.modal.close();
                                                    });
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
                                $.ajaxFileUpload({
                                    url: "<?php echo base_url(); ?>usuario/agregar_vehiculo_flota_ajax",
                                    secureuri: false,
                                    fileElementId  :'input_vehiculo_imagen',
                                    dataType    : 'json',
                                    data: {
                                        'input_vehiculo_marca': input_vehiculo_marca
                                        ,'input_vehiculo_linea': input_vehiculo_linea
                                        ,'input_vehiculo_kilometraje': input_vehiculo_kilometraje
                                        ,'input_vehiculo_modelo': input_vehiculo_modelo
                                        ,'input_vehiculo_placa': input_vehiculo_placa
                                        ,'input_id_flota': id_flota
                                    },success: function (data, status){
                                        // var data = $.parseJSON(data);
                                        console.log(data.id_usuario_vehiculo);
                                        if(data.status){
                                            agregar_carro_tabla(id_flota, data.id_usuario_vehiculo, input_vehiculo_placa, input_vehiculo_marca, input_vehiculo_linea, input_vehiculo_kilometraje);
                                            $('#loging-div').trigger('close');
                                            $('#nuevo_carro').val('');
                                            $("#input_vehiculo_marca").val('');
                                            $("#input_vehiculo_linea").val('');
                                            $("#input_vehiculo_kilometraje").val('');
                                            $("#input_vehiculo_modelo").val('');
                                            $("#input_vehiculo_placa").val('');
                                            $('.form_login_div_campo.div_quisiste_decir').hide();
                                        }else{
                                            confirm(data.msg, function () {
                                                    $.modal.close();
                                                });
                                        }
                                    }
                                });
                            $('.ajax_img_loader', form).hide();
                            $(form).unbind('click'); 
                        }
                    }
                });
            }
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

    //agrega un carro a la tabla de carros
    function agregar_carro_tabla(id_flota, id_usuario_vehiculo, placa, marca, linea, kilometraje){
        var tr = $('<tr>').addClass('newRow').attr('id', 'carro-'+id_usuario_vehiculo).attr('onclick', 'dar_vehiculo(this, '+id_usuario_vehiculo+')');
        var td1 = $('<td>').text(placa); tr.append(td1);
        var td2 = $('<td>').text(marca); tr.append(td2);
        var td3 = $('<td>').text(linea); tr.append(td3);
        var td4 = $('<td>').text(kilometraje);  tr.append(td4);
        $('#tablesorter').prepend(tr);
    }

    //agrega un campo para agregar una herramienta
    function agregar_herrmts(elem){ console.log('entra');
        var padre = $('.herrmts-form').has(elem);
        var tabla = $('.herrmts-table', padre);
        var tbody = $('tbody', tabla);
        var numero = Math.floor(Math.random() * 1000) + 1;
        var tr = $('<tr>').addClass('odd');
        var td1 = $('<td>');
        var inputChk = $('<input>').attr('type', 'checkbox').addClass('input_chk'); td1.append(inputChk);
        var td2 = $('<td>');
        var inputHerramienta = $('<input>').addClass('input_change_h').addClass('herrmts_herramienta').attr('name', 'herrmts_herramienta_'+numero);td2.append(inputHerramienta);
        var td3 = $('<td>');
        var inputVida = $('<input>').addClass('input_change_h').addClass('herrmts_vida').attr('id', 'herrmts_vida_'+numero).attr('name', 'herrmts_vida_'+numero);td3.append(inputVida);
        tr.append(td1);
        tr.append(td2);
        tr.append(td3);
        tbody.append(tr);
        $('#herrmts_vida_'+numero).datepicker({ altField: '#herrmts_vida_'+numero, altFormat: 'yy-mm-dd', 
                rangeSelect: false , changeMonth: true, changeYear: true});

        $("input.herrmts_herramienta", padre).each(function() {
            $(this).rules("add", { 
                required: true,
                messages: {
                    required: '*Debes ingresar la herramienta'
                } 
            });
        });
        $('.herrmts-guardar', padre).show();
    }

    //elimina las filas de herramientas seleccionads
    function eliminar_herrmts(elem){
        var padre = $('.menu-herramientas').has(elem);
        var count= 0;
        $('.input_chk:checked', padre).each(function(i, e) {
            $('tr').has(e).remove();  
            count ++;
        });  
        if(count > 0)
            $('.herrmts-guardar.herrmts-div-button', padre).show();
    }
</script>