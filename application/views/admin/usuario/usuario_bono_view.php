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
                        //----
                    }
                });
            });
            
            
            $(document).ready(function() {
                $('#bono').validate({
                    rules:{
                        nombres:{
                            required: true
                        },ciudadEnvio:{
                            required: true
                        },email:{
                            required: true,
                            email: true
                        },direccionEnvio:{
                            required: true
                        },vehiculo_id:{
                            required: true,
                            number: true
                        },telefonoMovil:{
                            required:true
                        },id_talleres:{
                            required: true
                        },bono:{
                            required: true
                        }
                    },
            
                    messages: {
                        nombres: "*Debes ingresar tus nombres",
                        ciudadEnvio: "*Debes ingresar tu ciudad",
                        email: {
                            required: "*Debes ingresar una dirección de correo válida",
                            email: "*Debe ser un correo válido"
                        },
                        vehiculo_id:{
                            required: "*El vehículo que especificaste no se encuentra registrado en nuestra base de datos",
                            number: "*Debes ingresar un vehículo válido"
                        },
                        direccionEnvio:"*Debes ingresar tu dirección de envío",
                        telefonoMovil:"*Deebes ingresar tu número telefónico",
                        id_talleres:"*Debes ingresar un taller",
                        bono: "*Debes ingresar la descripción de la orden de remisión"
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
                        form.submit();
                        return false; 
                    }
                   
                }); 
            });
            
        </script>
    </head>

    <body>
        <?php include_once './resources/admin/templates/header_include.php'; ?>
        <?php include_once './resources/admin/templates/usuario_submenu_include.php'; ?>

        <div id="main_content_wrap" class="container_12"
             <div class="container_12">
                <h2>Datos de envío</h2>
                <?php echo validation_errors('<div class="notification failure canhide"><p>', '</p></div>'); ?>
                <?php echo form_open('admin/usuario/generar_bono', 'id="bono"'); ?>
                <input type="hidden" name="id_usuario" value="<?php echo $usuario->id_usuario; ?>" />
                <p>
                    <label>Nombres</label><br />
                    <input name="nombres" id="nombres" type="text" class="text medium" value="<?php echo $usuario->nombres . ' ' . $usuario->apellidos; ?>" />
                </p>
                <p>
                    <label>Correo Electrónico</label><br />
                    <input id="email" name="email" type="text" class="text medium" value="<?php echo $usuario->email; ?>" />
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
                    <label>Dirección de envío:</label>
                    <input type="text" name="direccionEnvio" class="text medium" id="direccionEnvio"/>
                </p>
                <p>
                    <label>Teléfono de contacto:</label>
                    <input type="text" name="telefonoMovil" class="text medium" id="telefonoMovil"/>
                </p>
                <p>
                    <input type="submit" class="submit" value="Generar orden de remisión" />
                </p>

                <h2>Datos de la orden de remisión</h2> 
                <p>

                    <div id="autopart-div-buscar-input" class="ui-widget">
                        <label>Vehículo:</label>
                        <input type="hidden" value="na" name="vehiculo_id" class="hidden_carro_selected">
                            <?php if (sizeof($vehiculoMarcaBusqueda) > 0 && sizeof($vehiculoLineaBusqueda) > 0): ?>
                                <input class="vehiculos text medium" name="id_vehiculos[]" type="text" value="<?php echo $vehiculoMarcaBusqueda . ' ' . $vehiculoLineaBusqueda; ?>">
                                <?php else: ?>
                                    <input class="vehiculos text medium" name="id_vehiculos[]" onclick="this.value='';" type="text" value="ESCRIBE AQUÍ LA MARCA">
                                    <?php endif; ?>
                                    </div>
                                    </p>
                                    <label>Nombre del taller</label>
                                    <select name="id_talleres" id="taller">
                                        <?php foreach ($establecimientos as $establecimiento): ?>
                                            <option value="<?php echo $establecimiento->id_establecimiento ?>"><?php echo $establecimiento->nombre; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <br/><br/>
                                    <label>Descripción de la orden de remisión</label>
                                    <textarea name="bono"></textarea>

                                    <p>
                                        <input type="submit" class="submit" value="Generar orden de remisión" />
                                    </p>

                                    <?php echo form_close(); ?>


                                    <?php include_once './resources/admin/templates/footer_include.php'; ?>
                                    </div>
                                    </body>
                                    </html>