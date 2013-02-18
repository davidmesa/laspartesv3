<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin</title>

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
    </head>

    <body>
        <?php include_once './resources/admin-establecimiento/templates/header_include.php'; ?>
        
        <div id="main_content_wrap" class="container_12">
            <div class="container_12">
                <h2>Bienvenido al administrador de Las Partes</h2>
                <p>Seleccione la acción que desee realizar...</p>
            </div>

            <?php include_once './resources/admin-establecimiento/templates/footer_include.php'; ?>
        </div>
    </body>
</html>