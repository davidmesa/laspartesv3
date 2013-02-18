<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Taller en Línea :: Agregar Categoría</title>

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
        <?php include_once './resources/admin/templates/taller_en_linea_submenu_include.php'; ?>

        <div id="main_content_wrap" class="container_12">
            <div class="container_12">
                <h2>Agregar Categoría</h2>
                <?php echo validation_errors('<div class="notification failure canhide"><p>', '</p></div>'); ?>
                <?php echo form_open('admin/taller_en_linea/agregar_pregunta_categoria'); ?>
                    <p>
                      <label>Nombre</label><br />
                      <input name="nombre" type="text" class="text medium" value="<?php echo set_value('nombre'); ?>" />
                    </p>
                    <p>
          		<input type="submit" class="submit" value="Agregar Categoría" />
                    </p>
                <?php echo form_close(); ?>
            </div>

            <?php include_once './resources/admin/templates/footer_include.php'; ?>
        </div>
    </body>
</html>