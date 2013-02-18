<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Autopartes :: Agregar Autoparte</title>

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
    </head>

    <body>
        <?php include_once './resources/admin/templates/header_include.php'; ?>
        <?php include_once './resources/admin/templates/autoparte_submenu_include.php'; ?>

        <div id="main_content_wrap" class="container_12">
            <div class="container_12">
                <h2>Agregar Autoparte</h2>
                <?php echo validation_errors('<div class="notification failure canhide"><p>', '</p></div>'); ?>
                <?php echo form_open_multipart('admin/autoparte/agregar_autoparte'); ?>
                    <p>
                      <label>Nombre</label><br />
                      <input name="nombre" type="text" class="text medium" value="<?php echo set_value('nombre'); ?>" />
                    </p>
                    <p>
                        <label>Marca</label><br />
                        <select name="id_autoparte_marca" class="select">
                            <?php if(sizeof($marcas)!=0){
                                foreach($marcas as $marca){ ?>
                                    <option value="<?php echo $marca->id_autoparte_marca; ?>"><?php echo $marca->nombre; ?></option>
                            <?php }
                            } ?>
                        </select>
                    </p>
                    <p>
                      <label>Categoría</label><br />
                      <select name="id_autoparte_categoria" class="select">
                            <?php if(sizeof($categorias)!=0){
                                foreach($categorias as $categoria){ ?>
                                    <option value="<?php echo $categoria->id_autoparte_categoria; ?>"><?php echo $categoria->nombre; ?></option>
                            <?php }
                            } ?>
                        </select>
                    </p>
                    <p>
                      <label>Descripción</label><br />
                      <textarea name="descripcion" cols="8" rows="6" class="wysiwyg"><?php echo set_value('descripcion'); ?></textarea>
                    </p>
                    <p>
                      <label>Imagen</label><br />
                      <input name="imagen" type="file" class="text medium" />
                    </p>
                    <p>
                      <label>Origen</label><br />
                      <input name="origen" type="text" class="text medium" value="<?php echo set_value('origen'); ?>" />
                    </p>
                    <p>
                      <label>Referencia</label><br />
                      <input name="referencia" type="text" class="text medium" value="Todas Las Referencias" />
                    </p>
                    <p>
                      <label>Estado</label><br />
                      <select name="estado">
                          <option value="Activo">Activo</option>
                          <option value="No Activo">No Activo</option>
                      </select>
                    </p>

                    <h2>Autoparte en relación con los Vehículos</h2>
                    <p>Seleccione los vehículos compatibles con esta autoparte.</p>
                    <table width="100%">
                        <tr>
                            <th width="5%" scope="col"><input type="checkbox" name="checkbox" id="checkbox" class="checkall" /><label for="checkbox"></label></th>
                            <th>Marca</th>
                            <th>Línea</th>
                        </tr>
                        <?php if(sizeof($vehiculos)!=0){
                            foreach($vehiculos as $vehiculo){ ?>
                        <tr>
                            <td><input type="checkbox" name="id_vehiculos[]" value="<?php echo $vehiculo->id_vehiculo; ?>" /></td>
                            <td><?php echo $vehiculo->marca; ?></td>
                            <td><?php echo $vehiculo->linea; ?></td>
                        </tr>
                        <?php }
                        } ?>
                    </table>
                    <p>
                        <input type="submit" class="submit" value="Agregar Autoparte" />
                    </p>
                <?php echo form_close(); ?>
            </div>

            <?php include_once './resources/admin/templates/footer_include.php'; ?>
        </div>
    </body>
</html>