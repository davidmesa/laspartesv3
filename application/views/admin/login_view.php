<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin</title>

        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery1.4.3.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery.validate.js" ></script>

        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin/css/styles.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin/css/login.css" />
    </head>

    <body>
        <div id="admin_wrapper">

            <?php echo validation_errors('<div class="error">', '</div>'); ?>
            <?php if(isset($error)){ ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
            <?php } 
            else if(isset($confirmacion)){ ?>
            <div class="confirmacion">
                <?php echo $confirmacion; ?>
            </div>
            <?php } ?>

            <?php echo form_open('admin/usuario/validar_usuario'); ?>
                <div id="logo">
                    <h1>Las Partes <span>Admin</span></h1>
                </div>

                <p>Por favor ingrese la información requerida.</p>

                <label>Correo Electrónico</label><br />
                <input name="email" type="text" class="text large required" /><br />

                <div class="clearfix">&nbsp;</div>

                <label>Contraseña</label><br />
                <input name="contrasena" type="password" class="text large required" /><br />

                <div class="clearfix">&nbsp;</div>

                <input name="btnLogin" type="submit" class="submit" id="btnLogin" value="Ingresar" />
            <?php echo form_close(); ?>
        </div>
    </body>
</html>