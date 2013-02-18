<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Aprende :: Ver o Actualizar Noticia</title>

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
        <?php include_once './resources/admin/templates/aprende_submenu_include.php'; ?>

        <div id="main_content_wrap" class="container_12">
            <div class="container_12">
                <h2>Ver o Actualizar Noticia</h2>
                <?php echo validation_errors('<div class="notification failure canhide"><p>', '</p></div>'); ?>
                <?php echo form_open_multipart('admin/aprende/actualizar_noticia'); ?>
                    <input type="hidden" name="id_noticia" value="<?php echo $noticia->id_noticia; ?>" />
                    <p>
                      <label>Título</label><br />
                      <input name="titulo" type="text" class="text medium" value="<?php echo $noticia->titulo; ?>" />
                    </p>
                    <p>
                      <label>Noticia</label><br />
                      <textarea name="noticia" cols="20" rows="15" class="wysiwyg"><?php echo $noticia->noticia; ?></textarea>
                    </p>
                    <p>
                        <label>Imagen</label><br />
                        <?php if($noticia->imagen_thumb_url!='' && $noticia->imagen_thumb_url!=NULL){ ?>
                            <img src="<?php echo base_url().$noticia->imagen_thumb_url; ?>" alt="Imagen Noticia" /><br />
                            <a href="<?php echo base_url(); ?>admin/aprende/eliminar_noticia_imagen/<?php echo $noticia->id_noticia; ?>"><img src="<?php echo base_url(); ?>resources/admin/images/cancel.png" alt="Eliminar Imagen" /> Eliminar esta Imagen</a>
                        <?php } else { ?>
                            <input name="imagen" type="file" class="text medium" />
                        <?php } ?>
                    </p>
                    <p>
                      <label>Estado</label><br />
                      <select name="estado" class="select">
                          <option value="Activo" <?php if($noticia->estado=='Activo'){ ?>selected<?php } ?>>Activo</option>
                            <option value="No Activo" <?php if($noticia->estado=='No Activo'){ ?>selected<?php } ?>>No Activo</option>
                        </select>
                    </p>
                    <p>
                        <input type="submit" class="submit" value="Actualizar Noticia" />
                    </p>
                <?php echo form_close(); ?>
            </div>

            <?php include_once './resources/admin/templates/footer_include.php'; ?>
        </div>
    </body>
</html>