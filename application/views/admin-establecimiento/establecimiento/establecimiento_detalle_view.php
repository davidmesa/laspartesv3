<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Establecimientos :: Ver o Actualizar Establecimiento</title>

        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin-establecimiento/css/styles.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin-establecimiento/css/facebox.css" />

        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin-establecimiento/js/jquery1.4.3.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin-establecimiento/js/scripts.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/admin-establecimiento/js/facebox.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin-establecimiento/js/jquery.flot.pack.js"></script>
        <!--[if IE]>
            <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>resources/admin-establecimiento/js/excanvas.pack.js"></script>
        <![endif]-->

        <!--[if IE 6]>
            <script src="<?php echo base_url(); ?>resources/admin-establecimiento/js/pngfix.js"></script>
            <script>
                DD_belatedPNG.fix('.png_bg');
            </script>
        <![endif]-->

        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript">
            var map;
            var marker;
            function initialize() {
                <?php if($establecimiento->lat==0){ ?>
                    var latlng = new google.maps.LatLng(4.627500, -74.081583);
                 <?php } else{ ?>
                    var latlng = new google.maps.LatLng(<?php echo $establecimiento->lat; ?>, <?php echo $establecimiento->lng; ?>);
                 <?php } ?>
                marker = new google.maps.Marker({
                    position: latlng,
                    draggable: false
                });

                 var config = {
                      zoom: 13,
                      center: latlng,
                      mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                map = new google.maps.Map(document.getElementById("gmap-add"), config);
                marker.setMap(map);
                google.maps.event.addListener(map, 'click', function(event){
                    marker.setPosition(event.latLng);
                    document.getElementById("lat").value = event.latLng.lat();
                    document.getElementById("lng").value = event.latLng.lng();
                });
            }
        </script>
    </head>

    <body onload="initialize()">
        <?php include_once './resources/admin-establecimiento/templates/header_include.php'; ?>
        <?php include_once './resources/admin-establecimiento/templates/establecimiento_submenu_include.php'; ?>

        <div id="main_content_wrap" class="container_12">
            <div class="container_12">
                <h2>Ver o Actualizar Establecimiento</h2>
                <?php echo validation_errors('<div class="notification failure canhide"><p>', '</p></div>'); ?>
                <?php if(isset ($confirmacion)){ ?>
                <div class="notification success canhide">
                    <p><?php echo $confirmacion; ?></p>
                </div>
                <?php } ?>

                <?php echo form_open_multipart('admin-establecimiento/establecimiento/actualizar_establecimiento'); ?>
                    <input type="hidden" name="id_establecimiento" value="<?php echo $establecimiento->id_establecimiento; ?>" />
                    <p>
                      <label>Nombre</label><br />
                      <input name="nombre" type="text" class="text medium" value="<?php echo $establecimiento->nombre; ?>" />
                    </p>
                    <p>
                        <label>Zona</label><br />
                        <select name="id_zona" class="select">
                            <option value="0">No Definido</option>
                            <?php if(sizeof($zonas)!=0){
                                foreach($zonas as $zona){ ?>
                                    <option value="<?php echo $zona->id_zona; ?>" <?php if($zona->id_zona == $establecimiento->id_zona){ ?>selected<?php }?>><?php echo $zona->nombre; ?></option>
                            <?php }
                            } ?>
                        </select>
                    </p>
                    <p>
                        <label>Descripción</label><br />
                        <textarea name="descripcion" cols="8" rows="6"><?php echo $establecimiento->descripcion; ?></textarea>
                    </p>
                    <p>
                      <label>Correo Electrónico</label><br />
                      <input name="email" type="text" class="text medium" value="<?php echo $establecimiento->email; ?>" disabled />
                    </p>
                    <p>
                      <label>Dirección</label><br />
                      <input name="direccion" type="text" class="text medium" value="<?php echo $establecimiento->direccion; ?>" />
                    </p>
                    <p>
                      <label>Web</label><br />
                      <input name="web" type="text" class="text medium" value="<?php echo $establecimiento->web; ?>" />
                    </p>
                    <p>
                        <label>Logo</label><br />
                        <?php if($establecimiento->logo_thumb_url == '' || $establecimiento->logo_thumb_url == NULL){ ?>
                            <input name="logo" type="file" class="text medium" />
                        <?php } else { ?>
                            <img src="<?php echo base_url().$establecimiento->logo_thumb_url; ?>" alt="Logo Actual del Establecimiento" /><br />
                            <a href="<?php echo base_url(); ?>admin-establecimiento/establecimiento/eliminar_establecimiento_logo/<?php echo $establecimiento->id_establecimiento; ?>"><img src="<?php echo base_url(); ?>resources/admin-establecimiento/images/cancel.png" alt="Eliminar este logo" />Eliminar este logo</a>
                        <?php } ?>
                    </p>
                    <p>
                      <label>Teléfonos</label><br />
                      <input name="telefonos" type="text" class="text medium" value="<?php echo $establecimiento->telefonos; ?>" />
                    </p>
                    <p>
                      <label>Faxes</label><br />
                      <input name="faxes" type="text" class="text medium" value="<?php echo $establecimiento->faxes; ?>" />
                    </p>
                    <p>
                      <label>Horario</label><br />
                      <input name="horario" type="text" class="text medium" value="<?php echo $establecimiento->horario; ?>" />
                    </p>
                    <p>
                        <label>Mapa</label><br />
                        Haga click en donde está situado el establecimiento.
                        <div id="gmap-container">
                            <div id="gmap-add"></div>
                            <input type="hidden" id="lat" name="lat" value="<?php echo $establecimiento->lat; ?>" />
                            <input type="hidden" id="lng" name="lng" value="<?php echo $establecimiento->lng; ?>" />
                        </div>
                    </p>
                    <p>
          		<input type="submit" class="submit" value="Actualizar Establecimiento" />
                    </p>
                <?php echo form_close(); ?>

                <h2>Establecimiento en relación con los Servicios</h2>
                <p>A continuación se muestra las relaciones del establecimiento con los servicios.</p>
                <div class="grid_4">
                    <h2>Servicios Agregados</h2>
                    <p>Servicios asociados al establecimiento:</p>
                    <table width="100%">
                        <tr>
                            <th>Nombre</th>
                        </tr>
                        <?php if(sizeof($establecimiento_servicios)!=0){
                            foreach($establecimiento_servicios as $establecimiento_servicio){ ?>
                        <tr>
                            <td><?php echo $establecimiento_servicio->nombre; ?></td>
                        </tr>
                        <?php }
                        } ?>
                    </table>
                </div>

                <div class="grid_8">
                    <h2>Servicios Existentes</h2>
                    <p>Posibles servicios para asociarlos/desasociarlos el establecimiento:</p>
                    <?php echo form_open('admin-establecimiento/establecimiento/actualizar_establecimiento_servicios'); ?>
                        <input type="hidden" name="id_establecimiento" value="<?php echo $establecimiento->id_establecimiento; ?>" />
                        <table width="100%">
                            <tr>
                                <th width="5%" scope="col"><input type="checkbox" name="checkbox" id="checkbox" class="checkall" /><label for="checkbox"></label></th>
                                <th>Nombre</th>
                            </tr>
                            <?php if(sizeof($servicios)!=0){
                                foreach($servicios as $servicio){ ?>
                            <tr>
                                <td><input type="checkbox" name="id_servicios[]" value="<?php echo $servicio->id_servicio; ?>"
                                <?php if(sizeof($establecimiento_servicios)!=0){
                                    foreach($establecimiento_servicios as $establecimiento_servicio){
                                        if($establecimiento_servicio->id_servicio == $servicio->id_servicio){?>
                                           checked
                                <?php }
                                    }
                                } ?>
                                /></td>
                                <td><?php echo $servicio->nombre; ?></td>
                            </tr>
                            <?php }
                            } ?>
                        </table>
                        <p>
                            <input type="submit" class="submit" value="Actualizar Asociaciones Establecimiento-Servicios" />
                        </p>
                    <?php echo form_close(); ?>
                </div>

                <h2>Imágenes del Establecimiento</h2>
                <?php echo form_open_multipart('admin-establecimiento/establecimiento/agregar_establecimiento_imagenes'); ?>
                <input type="hidden" name="id_establecimiento" value="<?php echo $establecimiento->id_establecimiento; ?>" />
                <?php
                $numero_imagenes = 0;
                if(sizeof($establecimiento_imagenes)!=0){
                    foreach($establecimiento_imagenes as $establecimiento_imagen){
                        $numero_imagenes++;
                        ?>
                        <p>
                            <label>Imagen <?php echo $numero_imagenes; ?></label><br />
                            <input type="hidden" name="imagen_<?php echo $numero_imagenes; ?>" />
                            <img src="<?php echo base_url().$establecimiento_imagen->imagen_thumb_url; ?>" alt="Imagen del Establecimiento" /><br />
                            <a href="<?php echo base_url(); ?>admin-establecimiento/establecimiento/eliminar_establecimiento_imagen/<?php echo $establecimiento->id_establecimiento; ?>/<?php echo $establecimiento_imagen->id_establecimiento_imagen; ?>"><img src="<?php echo base_url(); ?>resources/admin-establecimiento/images/cancel.png" alt="Eliminar este logo" />Eliminar esta imagen</a>
                        </p>
               <?php }
                }
                while($numero_imagenes<3){ 
                    $numero_imagenes++; ?>
                <p>
                    <label>Subir la Imagen <?php echo $numero_imagenes; ?></label><br />
                    <input name="imagen_<?php echo $numero_imagenes; ?>" type="file" class="text medium" />
                </p>
                <?php } ?>
                <p>
                    <input type="submit" class="submit" value="Agregar Imágenes al Establecimiento" />
                </p>
                <?php echo form_close(); ?>
            </div>

            <?php include_once './resources/admin-establecimiento/templates/footer_include.php'; ?>
        </div>
    </body>
</html>