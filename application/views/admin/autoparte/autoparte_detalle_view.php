<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Autopartes :: Ver o Actualizar Autoparte</title>

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
                <h2>Ver o Actualizar Autoparte</h2>
                <?php echo validation_errors('<div class="notification failure canhide"><p>', '</p></div>'); ?>
                <?php if(isset ($confirmacion)){ ?>
                <div class="notification success canhide">
                    <p><?php echo $confirmacion; ?></p>
                </div>
                <?php } ?>

                <?php echo form_open_multipart('admin/autoparte/actualizar_autoparte'); ?>
                    <input type="hidden" name="id_autoparte" value="<?php echo $autoparte->id_autoparte; ?>" />
                    <p>
                      <label>Nombre</label><br />
                      <input name="nombre" type="text" class="text medium" value="<?php echo $autoparte->nombre; ?>" />
                    </p>
                    <p>
                        <label>Marca</label><br />
                        <select name="id_autoparte_marca" class="select">
                            <?php if(sizeof($marcas)!=0){
                                foreach($marcas as $marca){ ?>
                                    <option value="<?php echo $marca->id_autoparte_marca; ?>" <?php if($marca->id_autoparte_marca == $autoparte->id_autoparte_marca){ ?>selected<?php }?>><?php echo $marca->nombre; ?></option>
                            <?php }
                            } ?>
                        </select>
                    </p>
                    <p>
                      <label>Categoría</label><br />
                      <select name="id_autoparte_categoria" class="select">
                            <?php if(sizeof($categorias)!=0){
                                foreach($categorias as $categoria){ ?>
                                    <option value="<?php echo $categoria->id_autoparte_categoria; ?>" <?php if($categoria->id_autoparte_categoria == $autoparte->id_autoparte_categoria){ ?>selected<?php }?>><?php echo $categoria->nombre; ?></option>
                            <?php }
                            } ?>
                        </select>
                    </p>
                    <p>
                        <label>Descripción</label><br />
                        <textarea name="descripcion" cols="8" rows="6" class="wysiwyg"><?php echo $autoparte->descripcion; ?></textarea>
                    </p>
                    <p>
                        <label>Imagen</label><br />
                        <?php if($autoparte->imagen_thumb_url == '' || $autoparte->imagen_thumb_url == NULL){ ?>
                            <input name="imagen" type="file" class="text medium" />
                        <?php } else { ?>
                            <img src="<?php echo $autoparte->imagen_thumb_url; ?>" alt="Imagen Actual de la Autoparte" /><br />
                            <a href="<?php echo base_url(); ?>admin/autoparte/eliminar_autoparte_imagen/<?php echo $autoparte->id_autoparte; ?>"><img src="<?php echo base_url(); ?>resources/admin/images/cancel.png" alt="Eliminar esta imagen" />Eliminar esta imagen</a>
                        <?php } ?>
                    </p>
                    <p>
                      <label>Origen</label><br />
                      <input name="origen" type="text" class="text medium" value="<?php echo $autoparte->origen; ?>" />
                    </p>
                    <p>
                      <label>Referencia</label><br />
                      <input name="referencia" type="text" class="text medium" value="<?php echo $autoparte->referencia; ?>" />
                    </p>
                    <p>
                      <label>Estado</label><br />
                      <select name="estado">
                          <option value="Activo" <?php if($autoparte->estado=='Activo'){?>selected<?php } ?>>Activo</option>
                          <option value="No Activo" <?php if($autoparte->estado=='No Activo'){?>selected<?php } ?>>No Activo</option>
                      </select>
                    </p>
                    <p>
          		<input type="submit" class="submit" value="Actualizar Autoparte" />
                    </p>
                <?php echo form_close(); ?>

                <h2>Autoparte en relación con los Vehículos</h2>
                <p>A continuación se muestra las relaciones de la autoparte con los vehículos.</p>
                <div class="grid_4">
                    <h2>Vehículos Agregados</h2>
                    <p>Vehículos asociados a la autoparte:</p>
                    <table width="100%">
                        <tr>
                            <th>Marca</th>
                            <th>Línea</th>
                        </tr>
                        <?php if(sizeof($autoparte_vehiculos)!=0){
                            foreach($autoparte_vehiculos as $autoparte_vehiculo){ ?>
                        <tr>
                            <td><?php echo $autoparte_vehiculo->marca; ?></td>
                            <td><?php echo $autoparte_vehiculo->linea; ?></td>
                        </tr>
                        <?php }
                        } ?>
                    </table>
                </div>

                <div class="grid_8">
                    <h2>Vehículos Existentes</h2>
                    <p>Posibles vehículos para asociarlos/desasociarlos a la autoparte:</p>
                    <?php echo form_open('admin/autoparte/actualizar_autoparte_vehiculos'); ?>
                        <input type="hidden" name="id_autoparte" value="<?php echo $autoparte->id_autoparte; ?>" />
                        <table width="100%">
                            <tr>
                                <th width="5%" scope="col"><input type="checkbox" name="checkbox" id="checkbox" class="checkall" /><label for="checkbox"></label></th>
                                <th>Marca</th>
                                <th>Línea</th>
                            </tr>
                            <?php if(sizeof($vehiculos)!=0){
                                foreach($vehiculos as $vehiculo){ ?>
                            <tr>
                                <td><input type="checkbox" name="id_vehiculos[]" value="<?php echo $vehiculo->id_vehiculo; ?>"
                                <?php if(sizeof($autoparte_vehiculos)!=0){
                                    foreach($autoparte_vehiculos as $autoparte_vehiculo){
                                        if($autoparte_vehiculo->id_vehiculo == $vehiculo->id_vehiculo){?>
                                           checked
                                <?php }
                                    }
                                } ?>
                                /></td>
                                <td><?php echo $vehiculo->marca; ?></td>
                                <td><?php echo $vehiculo->linea; ?></td>
                            </tr>
                            <?php }
                            } ?>
                        </table>
                        <p>
                            <input type="submit" class="submit" value="Actualizar Asociaciones Autoparte-Vehículo" />
                        </p>
                    <?php echo form_close(); ?>
                </div>
            </div>

            <?php include_once './resources/admin/templates/footer_include.php'; ?>
        </div>
    </body>
</html>