<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Usuarios :: Ver o Actualizar Usuario</title>

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
        <?php include_once './resources/admin/templates/usuario_submenu_include.php'; ?>

        <div id="main_content_wrap" class="container_12">
            <div class="container_12">
                <h2>Ver o Actualizar Usuario</h2>
                <?php echo validation_errors('<div class="notification failure canhide"><p>', '</p></div>'); ?>
                <?php echo form_open('admin/usuario/actualizar_usuario'); ?>
                    <input type="hidden" name="id_usuario" value="<?php echo $usuario->id_usuario; ?>" />
                    <p>
                      <label>Usuario</label><br />
                      <input name="usuario" type="text" class="text medium" value="<?php echo $usuario->usuario; ?>" />
                    </p>
                    <p>
                      <label>Imagen</label><br />
                      <?php if($usuario->imagen_thumb_url!='' && $usuario->imagen_thumb_url!=NULL){ ?><img src="<?php echo $usuario->imagen_thumb_url; ?>" alt="Imagen del Usuario" /><br />
                      <a href="<?php echo base_url(); ?>admin/usuario/eliminar_usuario_imagen/<?php echo $usuario->id_usuario; ?>" onclick="return confirm('¿Está seguro de eliminar esta imagen? Recuerde que no se puede deshacer esta decisión.');"><img src="<?php echo base_url(); ?>resources/admin/images/cancel.png" alt="Eliminar la imagen" />Eliminar la imagen del usuario</a><?php } ?>
                    </p>
                    <p>
                      <label>Tipo</label><br />
                      <?php if($usuario->tipo==10){ echo 'Administrador'; }
                      else if($usuario->tipo==20){ echo 'Establecimiento'; }
                      else if($usuario->tipo==30){ echo 'Usuario Normal'; } ?>
                    </p>
                    <p>
                      <label>Nombres</label><br />
                      <input name="nombres" type="text" class="text medium" value="<?php echo $usuario->nombres; ?>" />
                    </p>
                    <p>
                      <label>Apellidos</label><br />
                      <input name="apellidos" type="text" class="text medium" value="<?php echo $usuario->apellidos; ?>" />
                    </p>
                    <p>
                      <label>Correo Electrónico</label><br />
                      <input name="email" type="text" class="text medium" value="<?php echo $usuario->email; ?>" />
                    </p>
                    <p>
                      <label>Lugar</label><br />
                      <input name="lugar" type="text" class="text medium" value="<?php echo $usuario->lugar; ?>" />
                    </p>
                    <p>
                      <label>Estado</label><br />
                      <select name="estado">
                          <option value="Activo" <?php if($usuario->estado=='Activo'){ ?>selected<?php } ?>>Activo</option>
                          <option value="No Activo" <?php if($usuario->estado=='No Activo'){ ?>selected<?php } ?>>No Activo</option>
                      </select>
                    </p>
                    <p>
          		<input type="submit" class="submit" value="Actualizar Usuario" />
                    </p>
                    <?php echo form_close(); ?>

                    <hr />

                    <h2>Preguntas</h2>
                    <table width="100%">
                    <tr>
                        <th>ID</th>
                        <th>Pregunta</th>
                        <th>Respuestas</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                    <?php if(sizeof($preguntas)!=0){
                        foreach($preguntas as $pregunta){ ?>
                    <tr>
                        <td><a href="<?php echo base_url(); ?>admin/taller_en_linea/ver_pregunta/<?php echo $pregunta->id_pregunta; ?>"><?php echo $pregunta->id_pregunta; ?></a></td>
                        <td><b><?php echo $pregunta->titulo_pregunta; ?></b><br /><?php echo $pregunta->cuerpo_pregunta; ?></td>
                        <td><?php echo $pregunta->numero_respuestas; ?></td>
                        <td><?php if($pregunta->estado=='Activo'){ ?><img src="<?php echo base_url(); ?>resources/admin/images/bullet_green.png" alt="Activo" /><?php } else { ?><img src="<?php echo base_url(); ?>resources/admin/images/bullet_red.png" alt="No Activo" /><?php } ?></td>
                        <td><a href="<?php echo base_url(); ?>admin/taller_en_linea/ver_pregunta/<?php echo $pregunta->id_pregunta; ?>"><img src="<?php echo base_url(); ?>resources/admin/images/pencil.png" alt="Ver o Actualizar Pregunta" /></a></td>
                    </tr>
                    <?php }
                    }?>
                </table>

                <hr />

                <h2>Respuestas</h2>
                <table width="100%">
                    <tr>
                        <th>ID</th>
                        <th>Pregunta</th>
                        <th>Respuesta</th>
                        <th>Acciones</th>
                    </tr>
                    <?php if(sizeof($respuestas)!=0){
                        foreach($respuestas as $respuesta){ ?>
                    <tr>
                        <td><a href="<?php echo base_url(); ?>admin/taller_en_linea/ver_pregunta/<?php echo $respuesta->id_pregunta; ?>"><?php echo $respuesta->id_respuesta; ?></a></td>
                        <td><?php echo $respuesta->titulo_pregunta; ?></td>
                        <td><?php echo $respuesta->respuesta; ?></td>
                        <td><a href="<?php echo base_url(); ?>admin/taller_en_linea/ver_pregunta/<?php echo $respuesta->id_pregunta; ?>"><img src="<?php echo base_url(); ?>resources/admin/images/pencil.png" alt="Ver o Actualizar Pregunta / Respuesta" /></a></td>
                    </tr>
                    <?php }
                    }?>
                </table>

                <hr />

                <h2>Carritos de Compras</h2>
                <table width="100%">
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                    <?php if(sizeof($carritos_compras)!=0){
                        foreach($carritos_compras as $carrito_compra){ ?>
                    <tr>
                        <td><a href="<?php echo base_url(); ?>admin/usuario/ver_carrito_compra/<?php echo $carrito_compra->id_carrito_compra; ?>"><?php echo $carrito_compra->id_carrito_compra; ?></a></td>
                        <td><?php echo $carrito_compra->fecha; ?></td>
                        <td><?php echo $carrito_compra->total; ?></td>
                        <td><?php echo $carrito_compra->estado; ?></td>
                        <td><a href="<?php echo base_url(); ?>admin/usuario/ver_carrito_compra/<?php echo $carrito_compra->id_carrito_compra; ?>"><img src="<?php echo base_url(); ?>resources/admin/images/pencil.png" alt="Ver o Actualizar Carrito de Compra" /></a></td>
                    </tr>
                    <?php }
                    }?>
                </table>

                <hr />

                <h2>Vehículos</h2>
                <table width="100%">
                    <tr>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Placa</th>
                        <th>Marca</th>
                        <th>Línea</th>
                        <th>Modelo</th>
                        <th>Kilometraje</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                    <?php if(sizeof($vehiculos)!=0){
                        foreach($vehiculos as $vehiculo){ ?>
                    <tr>
                        <td><a href="<?php echo base_url(); ?>admin/usuario/ver_usuario_vehiculo/<?php echo $vehiculo->id_usuario_vehiculo; ?>"><?php echo $vehiculo->id_usuario_vehiculo; ?></a></td>
                        <td><?php if($vehiculo->imagen_thumb_url!='' && $vehiculo->imagen_thumb_url!=NULL){ ?><img src="<?php echo $vehiculo->imagen_thumb_url; ?>" alt="Imagen del Vehículo" /><?php } ?></td>
                        <td><?php echo $vehiculo->numero_placa; ?></td>
                        <td><?php echo $vehiculo->marca; ?></td>
                        <td><?php echo $vehiculo->linea; ?></td>
                        <td><?php echo $vehiculo->modelo; ?></td>
                        <td><?php echo $vehiculo->kilometraje; ?></td>
                        <td><?php echo $vehiculo->fecha; ?></td>
                        <td><a href="<?php echo base_url(); ?>admin/usuario/ver_usuario_vehiculo/<?php echo $vehiculo->id_usuario_vehiculo; ?>"><img src="<?php echo base_url(); ?>resources/admin/images/pencil.png" alt="Ver o Actualizar Vehículo" /></a> <a href="<?php echo base_url(); ?>admin/usuario/eliminar_usuario_vehiculo/<?php echo $vehiculo->id_usuario_vehiculo; ?>" onclick="return confirm('¿Está seguro de eliminar esta vehículo? Recuerde que no se puede deshacer esta decisión.');"><img src="<?php echo base_url(); ?>resources/admin/images/cancel.png" alt="Eliminar Vehículo" /></a></td>
                    </tr>
                    <?php }
                    }?>
                </table>
            </div>

            <?php include_once './resources/admin/templates/footer_include.php'; ?>
        </div>
    </body>
</html>