<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Usuarios :: Agregar Usuario</title>

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
                <h2>Agregar Usuario</h2>
                <?php echo validation_errors('<div class="notification failure canhide"><p>', '</p></div>'); ?>
                <?php echo form_open('admin/usuario/agregar_usuario'); ?>
                    <p>
                      <label>Usuario</label><br />
                      <input name="usuario" type="text" class="text medium" value="<?php echo set_value('usuario'); ?>" />
                    </p>
                    <p>
                      <label>Tipo</label><br />
                      <select name="tipo">
                          <option value="20">Establecimiento</option>
                          <option value="10">Administrador</option>
                      </select>
                    </p>
                    <p>
                      <label>Nombres</label><br />
                      <input name="nombres" type="text" class="text medium" value="<?php echo set_value('nombres'); ?>" />
                    </p>
                    <p>
                      <label>Apellidos</label><br />
                      <input name="apellidos" type="text" class="text medium" value="<?php echo set_value('apellidos'); ?>" />
                    </p>
                    <p>
                      <label>Correo Electrónico</label><br />
                      <input name="email" type="text" class="text medium" value="<?php echo set_value('email'); ?>" />
                    </p>
                    <p>
                      <label>Contraseña</label><br />
                      <input name="contrasena" type="password" class="text medium" value="<?php echo set_value('contrasena'); ?>" />
                    </p>
                    <p>
                      <label>Lugar</label><br />
                      <input name="lugar" type="text" class="text medium" value="<?php echo set_value('lugar'); ?>" />
                    </p>
                    <p>
                      <label>Estado</label><br />
                      <select name="estado">
                          <option value="Activo">Activo</option>
                          <option value="No Activo">No Activo</option>
                      </select>
                    </p>
                    <p>
          		<input type="submit" class="submit" value="Agregar Usuario" />
                    </p>
                    <?php echo form_close(); ?>
            </div>

            <?php include_once './resources/admin/templates/footer_include.php'; ?>
        </div>
    </body>
</html>