<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Usuarios :: Generar recibo</title>

        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin/css/styles.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin/css/facebox.css" />

        
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/scripts.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/facebox.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery.flot.pack.js"></script>
        <script src="<?php echo base_url(); ?>resources/js/jquery.ui.autocomplete.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>resources/css/jquery.ui.all.css" rel="stylesheet" type="text/css"  media="screen" />
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script> 
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery-ui-1.8.23.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.validate.js"></script>
        <!--[if IE]>
            <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/excanvas.pack.js"></script>
        <![endif]-->

        <!--[if IE 6]>
            <script src="<?php echo base_url(); ?>resources/admin/js/pngfix.js"></script>
            <script>
                DD_belatedPNG.fix('.png_bg');
            </script>
        <![endif]-->
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
            
            td p select{
                width: 299px;
            }
            
            form table label{
                display: inline;
            }
        </style>
        <script>
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
                                window.location = 'http://'+window.location.host+window.location.pathname +'/vehiculo/' + vehiculo_actual;
                        }
                        //----
                    }
                });
                
                $('.ofertaNombre').change(function(){
                    var padre = $('p').has(this);
                    var id = $(this).val();
                    $('.idOferta', padre).val(id);
                });
                
                $('.idOferta').change(function(){
                    var padre = $('p').has(this);
                    var id = $(this).val();
                    $('.ofertaNombre', padre).val(id);
                });

                $('.nombreAutoparte').change(function(){
                    var padre = $('p').has(this);
                    var id = $(this).val();
                    $('.idAutoparte', padre).val(id);
                });
                
                $('.idAutoparte').change(function(){
                    var padre = $('p').has(this);
                    var id = $(this).val();
                    $('.nombreAutoparte', padre).val(id);
                });

            });
        </script>
    </head>

    <body>
        <?php include_once './resources/admin/templates/header_include.php'; ?>
        <?php include_once './resources/admin/templates/usuario_submenu_include.php'; ?>

        <div id="main_content_wrap" class="container_12">
            <div class="container_12">
                <h2>Datos de envío</h2>
                <?php echo validation_errors('<div class="notification failure canhide"><p>', '</p></div>'); ?>
                <?php echo form_open('admin/usuario/generar_recibo'); ?>
                    <input type="hidden" name="id_usuario" value="<?php echo $usuario->id_usuario; ?>" />
                    <p>
                      <label>Nombres</label><br />
                      <input name="nombres" type="text" class="text medium" value="<?php echo $usuario->nombres.' '.$usuario->apellidos; ?>" />
                    </p>
                    <p>
                        <label>Documento de identidad: (*opcional)</label>
                        <input type="text" name="documento" class="text medium" id="documento"/>
                    </p>
                    <p>
                      <label>Correo Electrónico</label><br />
                      <input name="email" type="text" class="text medium" value="<?php echo $usuario->email; ?>" />
                    </p>
                    <p>
                      <label>Lugar</label><br />
                      <?php
                        $option_ciudades = array();
                        $selected = false;
                        $ciudades = array("Aguachica", "Apartadó", "Arauca", "Arjona", "Armenia", "Barrancabermeja", "Barranquilla", "Bello", "Bogotá", "Bucaramanga", "Buenaventura", "Calarcá", "Caldas", "Cali", "Candelaria", "Carmen de Bolívar", "Cartagena de indias", "Cartago", "Caucasia", "Cereté", "Chía", "Chigorodó", "Chiquinquirá", "Ciénaga", "Copacabana", "Dosquebradas", "Duitama", "Envigado", "Espinal", "Facatativa", "Florencia", "Floridablanca", "Fundación", "Funza", "Fusagasugá", "Garzón", "Girardot", "Guadalajara de Buga", "Ibagué", "Ipiales", "Itagüi", "Jamundí", "La Dorada", "Los Patios", "Madrid", "Magangué", "Maicao", "Malambo", "Manizales", "Medellín", "Montelíbano", "Monteria", "Mosquera", "Neiva", "Ocaña", "Palmira", "Pamplona", "Pasto", "Pereira", "Piedecuesta", "Pitalito", "Planeta Rica", "Popayán", "Quibdó", "Riohacha", "Rionegro", "Sabanalarga", "Sahagun", "San Andrés", "San Andrés de Sotavento", "San Andrés de Tumaco", "San José de Cúcuta", "San Juan de Girón", "Santa Cruz de Lorica", "Santa Marta", "Santa Rosa de Cabal", "Santander de Quilichao", "Sincelejo", "Soacha", "Sogamoso", "Soledad", "Tierralta", "Tuluá", "Tunja", "Turbaco", "Valledupar", "Villa del Rosario", "Villavicencio", "Yopal", "Yumbo", "Zipaquirá");
                        foreach ($ciudades as $ciudad) {
                            if ($ciudad != 'default') {
                                $option_ciudades[$ciudad] = $ciudad;
                                if (!$selected) {
                                    $selected = $ciudad;
                                }
                            }
                        }
                        echo form_dropdown('ciudadEnvio', $option_ciudades, $usuario->lugar, 'id="ciudadEnvio" class="text medium"'); //, 'id="marca_registrarse"');
                        ?>
                    </p>
                    <p>
                        <label>Dirección de envío:  (*opcional)</label>
                        <input type="text" name="direccionEnvio" class="text medium" id="direccionEnvio"/>
                    </p>
                    <p>
                        <label>Teléfono de contacto:  (*opcional)</label>
                        <input type="text" name="telefonoMovil" class="text medium" id="telefonoMovil"/>
                    </p>
                    <p>
          		<input type="submit" class="submit" value="Generar recibo" />
                    </p>
                    
                    <h2>Datos de compra</h2>
                    <p>
                        
                            <div id="autopart-div-buscar-input" class="ui-widget">
                                <label>Vehículo: (*opcional)</label>
                                <input type="hidden" value="na" name="vehiculo_id" class="hidden_carro_selected">
                                <?php if(sizeof($vehiculoMarcaBusqueda)>0 && sizeof($vehiculoLineaBusqueda)>0): ?>
                                    <input class="vehiculos text medium" name="id_vehiculos" type="text" value="<?php echo $vehiculoMarcaBusqueda.' '.$vehiculoLineaBusqueda;?>">
                                <?php else:?>
                                    <input class="vehiculos text medium" name="id_vehiculos" onclick="this.value='';" type="text" value="ESCRIBE AQUÍ LA MARCA">
                                <?php endif; ?>
                            </div>
                    </p>
                    <p>
                        <label>Placas del carro: (*opcional)</label>
                        <input type="text" name="placa" class="text medium" id="placaEnvio"/>
                    </p>
                    <table width="100%">
                        <tr>
                            <th width="50%">
                                <h3 style="text-align: center;">Autopartes</h3>
                            </th>
                            <th  width="50%">
                                <h3 style="text-align: center;">Ofertas y promociones</h3>
                            </th>
                        </tr>
                        <tr>
                            <td  width="50%">
                                <p>
                                    <label>ID:</label><input style="width: 25px;" type="text" name="idAutoparte[]" class="text medium idAutoparte" id="idAutoparte" value="0"/>
                                    <label>Cant:</label><input style="width: 25px;" type="text" name="cantAutoparte[]" class="text medium cantAutoparte" id="cantAutoparte" value="0"/>
                                    <br/><label> Autoparte:</label><?php
                                        $option_autopartes = array();
                                        $selected = false;
                                        foreach ($autopartes as $autoparte) {
                                                 if ($selected == false) {
                                                    $option_autopartes[0] = 'Escoge una autoparte';
                                                    $selected = 'Escoge una autoparte';
                                                }
                                                $option_autopartes[$autoparte->id_autoparte] = $autoparte->nombre. ' MARCA '.  $autoparte->marca.' PARA CARROS '. $autoparte->vehiculo_marca;;
                                        }
                                        echo form_dropdown('nombreAutoparte', $option_autopartes, $selected, 'id="nombreAutoparte" class="nombreAutoparte text medium"'); //, 'id="marca_registrarse"');
                                        ?>
                                </p>
                                 
                            </td>
                            <td  width="50%">
                                <p>
                                    <label>ID:</label><input  style="width: 25px;"type="text" name="idOferta[]" class="text medium idOferta" id="idOferta" value="0" />
                                    <label>Cant:</label><input style="width: 25px;" type="text" name="cantOferta[]" class="text medium cantOferta" id="cantOferta" value="0"/>
                                    <br/><label> Oferta:</label><?php
                                        $option_ofertas = array();
                                        $selected = false;
                                        foreach ($ofertas as $oferta) {
                                                if ($selected == false) {
                                                    $option_ofertas[0] = 'Escoge una oferta';
                                                    $selected = 'Escoge una oferta';
                                                }
                                                $option_ofertas[$oferta->id_oferta] = $oferta->titulo;
                                        }
                                        echo form_dropdown('ofertaNombre', $option_ofertas, $selected, 'id="ofertaNombre" class="text medium ofertaNombre"'); //, 'id="marca_registrarse"');
                                        ?>
                                </p>
                                
                            </td>
                        </tr>
                        <tr>
                            <td  width="50%">
                                <p>
                                    <label>ID:</label><input style="width: 25px;" type="text" name="idAutoparte[]" class="text medium idAutoparte" id="idAutoparte" value="0"/>
                                    <label>Cant:</label><input style="width: 25px;" type="text" name="cantAutoparte[]" class="text medium cantAutoparte" id="cantAutoparte" value="0"/>
                                    <br/><label> Autoparte:</label><?php
                                        $option_autopartes = array();
                                        $selected = false;
                                        foreach ($autopartes as $autoparte) {
                                                 if ($selected == false) {
                                                    $option_autopartes[0] = 'Escoge una autoparte';
                                                    $selected = 'Escoge una autoparte';
                                                }
                                                $option_autopartes[$autoparte->id_autoparte] = $autoparte->nombre. ' MARCA '.  $autoparte->marca.' PARA CARROS '. $autoparte->vehiculo_marca;;
                                        }
                                        echo form_dropdown('nombreAutoparte', $option_autopartes, $selected, 'id="nombreAutoparte" class="nombreAutoparte text medium"'); //, 'id="marca_registrarse"');
                                        ?>
                                </p>
                                 
                            </td>
                            <td  width="50%">
                                <p>
                                    <label>ID:</label><input  style="width: 25px;"type="text" name="idOferta[]" class="text medium idOferta" id="idOferta" value="0" />
                                    <label>Cant:</label><input style="width: 25px;" type="text" name="cantOferta[]" class="text medium cantOferta" id="cantOferta" value="0"/>
                                    <br/><label> Oferta:</label><?php
                                        $option_ofertas = array();
                                        $selected = false;
                                        foreach ($ofertas as $oferta) {
                                                if ($selected == false) {
                                                    $option_ofertas[0] = 'Escoge una oferta';
                                                    $selected = 'Escoge una oferta';
                                                }
                                                $option_ofertas[$oferta->id_oferta] = $oferta->titulo;
                                        }
                                        echo form_dropdown('ofertaNombre', $option_ofertas, $selected, 'id="ofertaNombre" class="text medium ofertaNombre"'); //, 'id="marca_registrarse"');
                                        ?>
                                </p>
                                
                            </td>
                        </tr>
                        <tr>
                            <td  width="50%">
                                <p>
                                    <label>ID:</label><input style="width: 25px;" type="text" name="idAutoparte[]" class="text medium idAutoparte" id="idAutoparte" value="0"/>
                                    <label>Cant:</label><input style="width: 25px;" type="text" name="cantAutoparte[]" class="text medium cantAutoparte" id="cantAutoparte" value="0"/>
                                    <br/><label> Autoparte:</label><?php
                                        $option_autopartes = array();
                                        $selected = false;
                                        foreach ($autopartes as $autoparte) {
                                                 if ($selected == false) {
                                                    $option_autopartes[0] = 'Escoge una autoparte';
                                                    $selected = 'Escoge una autoparte';
                                                }
                                                $option_autopartes[$autoparte->id_autoparte] = $autoparte->nombre. ' MARCA '.  $autoparte->marca.' PARA CARROS '. $autoparte->vehiculo_marca;;
                                        }
                                        echo form_dropdown('nombreAutoparte', $option_autopartes, $selected, 'id="nombreAutoparte" class="nombreAutoparte text medium"'); //, 'id="marca_registrarse"');
                                        ?>
                                </p>
                                 
                            </td>
                            <td  width="50%">
                                <p>
                                    <label>ID:</label><input  style="width: 25px;"type="text" name="idOferta[]" class="text medium idOferta" id="idOferta" value="0" />
                                    <label>Cant:</label><input style="width: 25px;" type="text" name="cantOferta[]" class="text medium cantOferta" id="cantOferta" value="0"/>
                                    <br/><label> Oferta:</label><?php
                                        $option_ofertas = array();
                                        $selected = false;
                                        foreach ($ofertas as $oferta) {
                                                if ($selected == false) {
                                                    $option_ofertas[0] = 'Escoge una oferta';
                                                    $selected = 'Escoge una oferta';
                                                }
                                                $option_ofertas[$oferta->id_oferta] = $oferta->titulo;
                                        }
                                        echo form_dropdown('ofertaNombre', $option_ofertas, $selected, 'id="ofertaNombre" class="text medium ofertaNombre"'); //, 'id="marca_registrarse"');
                                        ?>
                                </p>
                                
                            </td>
                        </tr>
                        <tr>
                            <td  width="50%">
                                <p>
                                    <label>ID:</label><input style="width: 25px;" type="text" name="idAutoparte[]" class="text medium idAutoparte" id="idAutoparte" value="0"/>
                                    <label>Cant:</label><input style="width: 25px;" type="text" name="cantAutoparte[]" class="text medium cantAutoparte" id="cantAutoparte" value="0"/>
                                    <br/><label> Autoparte:</label><?php
                                        $option_autopartes = array();
                                        $selected = false;
                                        foreach ($autopartes as $autoparte) {
                                                 if ($selected == false) {
                                                    $option_autopartes[0] = 'Escoge una autoparte';
                                                    $selected = 'Escoge una autoparte';
                                                }
                                                $option_autopartes[$autoparte->id_autoparte] = $autoparte->nombre. ' MARCA '.  $autoparte->marca.' PARA CARROS '. $autoparte->vehiculo_marca;;
                                        }
                                        echo form_dropdown('nombreAutoparte', $option_autopartes, $selected, 'id="nombreAutoparte" class="nombreAutoparte text medium"'); //, 'id="marca_registrarse"');
                                        ?>
                                </p>
                                 
                            </td>
                            <td  width="50%">
                                <p>
                                    <label>ID:</label><input  style="width: 25px;"type="text" name="idOferta[]" class="text medium idOferta" id="idOferta" value="0" />
                                    <label>Cant:</label><input style="width: 25px;" type="text" name="cantOferta[]" class="text medium cantOferta" id="cantOferta" value="0"/>
                                    <br/><label> Oferta:</label><?php
                                        $option_ofertas = array();
                                        $selected = false;
                                        foreach ($ofertas as $oferta) {
                                                if ($selected == false) {
                                                    $option_ofertas[0] = 'Escoge una oferta';
                                                    $selected = 'Escoge una oferta';
                                                }
                                                $option_ofertas[$oferta->id_oferta] = $oferta->titulo;
                                        }
                                        echo form_dropdown('ofertaNombre', $option_ofertas, $selected, 'id="ofertaNombre" class="text medium ofertaNombre"'); //, 'id="marca_registrarse"');
                                        ?>
                                </p>
                                
                            </td>
                        </tr>
                    </table>
                    
                    <p>
          		<input type="submit" class="submit" value="Generar recibo" />
                    </p>
                    
                    <?php echo form_close(); ?>
                    

            <?php include_once './resources/admin/templates/footer_include.php'; ?>
        </div>
    </body>
</html>