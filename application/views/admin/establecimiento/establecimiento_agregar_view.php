<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Establecimientos :: Agregar Establecimiento</title>

        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin/css/styles.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin/css/facebox.css" />

        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery1.4.3.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/scripts.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/facebox.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery.flot.pack.js"></script>
        <!--[if IE]>
            <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/excanvas.pack.js"></script>
        <![endif]-->

        <!--[if IE 6]>
            <script src="<?php echo base_url(); ?>resources/admin/js/pngfix.js"></script>
            <script>
                DD_belatedPNG.fix('.png_bg');
            </script>
        <![endif]-->

        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript">
            var map;
            var marker;
            function initialize() {
                var latlng = new google.maps.LatLng(4.627500, -74.081583);
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
        <?php include_once './resources/admin/templates/header_include.php'; ?>
        <?php include_once './resources/admin/templates/establecimiento_submenu_include.php'; ?>

        <div id="main_content_wrap" class="container_12">
            <div class="container_12">
                <h2>Agregar Establecimiento</h2>
                <?php echo validation_errors('<div class="notification failure canhide"><p>', '</p></div>'); ?>
                <?php if(isset ($confirmacion)){ ?>
                <div class="notification success canhide">
                    <p><?php echo $confirmacion; ?></p>
                </div>
                <?php } ?>

                <?php echo form_open_multipart('admin/establecimiento/agregar_establecimiento'); ?>
                    <p>
                      <label>Nombre</label><br />
                      <input name="nombre" type="text" class="text medium" value="<?php echo set_value('nombre'); ?>" />
                    </p>
                    <p>
                        <label>Usuario Responsable</label><br />
                        <select name="id_usuario" class="select">
                            <option value="">Seleccione...</option>
                            <?php if(sizeof($usuarios)!=0){
                                foreach($usuarios as $usuario){ ?>
                            <option value="<?php echo $usuario->id_usuario; ?>" <?php echo set_select('id_usuario', $usuario->id_usuario); ?>><?php echo $usuario->usuario; ?></option>
                            <?php }
                            } ?>
                        </select>
                    </p>
                    <p>
                        <label>Estado</label><br />
                        <select name="estado" class="select">
                            <option value="Activo" <?php echo set_select('estado', 'Activo'); ?>>Activo</option>
                            <option value="No Activo" <?php echo set_select('estado', 'No Activo'); ?>>No Activo</option>
                        </select>
                    </p>
                    <p>
                        <label>Zona</label><br />
                        <select name="id_zona" class="select">
                            <option value="">Seleccione...</option>
                            <?php if(sizeof($zonas)!=0){
                                foreach($zonas as $zona){ ?>
                            <option value="<?php echo $zona->id_zona; ?>" <?php echo set_select('id_zona', $zona->id_zona); ?>><?php echo $zona->nombre; ?></option>
                            <?php }
                            } ?>
                        </select>
                    </p>
                    <p>
                        <label>Descripción</label><br />
                        <textarea name="descripcion" cols="8" rows="6"><?php echo set_value('descripcion'); ?></textarea>
                    </p>
                    <p>
                      <label>Correo Electrónico</label><br />
                      <input name="email" type="text" class="text medium" value="<?php echo set_value('email'); ?>" />
                    </p>
                    <p>
                      <label>Dirección</label><br />
                      <input name="direccion" type="text" class="text medium" value="<?php echo set_value('direccion'); ?>" />
                    </p>
                    <p>
                      <label>Web</label><br />
                      <input name="web" type="text" class="text medium" value="<?php echo set_value('web'); ?>" />
                    </p>
                    <p>
                        <label>Logo</label><br />
                        <input name="logo" type="file" class="text medium" />
                    </p>
                    <p>
                      <label>Teléfonos</label><br />
                      <input name="telefonos" type="text" class="text medium" value="<?php echo set_value('telefonos'); ?>" />
                    </p>
                    <p>
                      <label>Faxes</label><br />
                      <input name="faxes" type="text" class="text medium" value="<?php echo set_value('faxes'); ?>" />
                    </p>
                    <p>
                      <label>Horario</label><br />
                      <input name="horario" type="text" class="text medium" value="<?php echo set_value('horario'); ?>" />
                    </p>
                    <p>
                        <label>Mapa</label><br />
                        Haga click en donde está situado el establecimiento.
                        <div id="gmap-container">
                            <div id="gmap-add"></div>
                            <input type="hidden" id="lat" name="lat" />
                            <input type="hidden" id="lng" name="lng" />
                        </div>
                    </p>
                    <h2>Servicios</h2>
                    <p>Seleccione los servicios ofrecidos por el establecimiento.</p>
                    <table width="100%">
                        <tr>
                            <th width="5%" scope="col"><input type="checkbox" name="checkbox" id="checkbox" class="checkall" /><label for="checkbox"></label></th>
                            <th>Nombre</th>
                        </tr>
                        <?php if(sizeof($servicios)!=0){
                            foreach($servicios as $servicio){ ?>
                        <tr>
                            <td><input type="checkbox" name="id_servicios[]" value="<?php echo $servicio->id_servicio; ?>" /></td>
                            <td><?php echo $servicio->nombre; ?></td>
                        </tr>
                        <?php }
                        } ?>
                    </table>
                    <h2>Imágenes del Establecimiento</h2>
                    <p>
                        <label>Imagen 1</label><br />
                        <input name="imagen_1" type="file" class="text medium" />
                    </p>
                    <p>
                        <label>Imagen 2</label><br />
                        <input name="imagen_2" type="file" class="text medium" />
                    </p>
                    <p>
                        <label>Imagen 3</label><br />
                        <input name="imagen_3" type="file" class="text medium" />
                    </p>
                    <p>
          		<input type="submit" class="submit" value="Agregar Establecimiento" />
                    </p>
                <?php echo form_close(); ?>
            </div>

            <?php include_once './resources/admin/templates/footer_include.php'; ?>
        </div>
    </body>
</html>