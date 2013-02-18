<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Aprende :: Ver o Actualizar Tutorial</title>

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
                <h2>Ver o Actualizar Tutorial</h2>
                <?php if(isset ($confirmacion)){ ?>
                <div class="notification success canhide">
                    <p><?php echo $confirmacion; ?></p>
                </div>
                <?php }
                if(isset ($error)){ ?>
                <div class="notification failure canhide">
                    <p><?php echo $error; ?></p>
                </div>
                <?php } ?>
                
                <?php echo validation_errors('<div class="notification failure canhide"><p>', '</p></div>'); ?>
                <?php echo form_open_multipart('admin/aprende/actualizar_tutorial'); ?>
                    <input type="hidden" name="id_tutorial" value="<?php echo $tutorial->id_tutorial; ?>" />
                    <p>
                      <label>Título</label><br />
                      <input name="titulo" type="text" class="text medium" value="<?php echo $tutorial->titulo; ?>" />
                    </p>
                    <p>
                      <label>Resumen</label><br />
                      <textarea name="resumen" cols="20" rows="15" class="wysiwyg"><?php echo $tutorial->resumen; ?></textarea>
                    </p>
                    <p>
                        <label>Imagen</label><br />
                        <?php if($tutorial->imagen_thumb_url!='' && $tutorial->imagen_thumb_url!=NULL){ ?>
                            <img src="<?php echo base_url().$tutorial->imagen_thumb_url; ?>" alt="Imagen Tutorial" /><br />
                            <a href="<?php echo base_url(); ?>admin/aprende/eliminar_tutorial_imagen/<?php echo $tutorial->id_tutorial; ?>"><img src="<?php echo base_url(); ?>resources/admin/images/cancel.png" alt="Eliminar Imagen" /> Eliminar esta Imagen</a>
                        <?php } else { ?>
                            <input name="imagen" type="file" class="text medium" />
                        <?php } ?>
                    </p>
                    <p>
                      <label>Estado</label><br />
                      <select name="estado" class="select">
                          <option value="Activo" <?php if($tutorial->estado=='Activo'){ ?>selected<?php } ?>>Activo</option>
                            <option value="No Activo" <?php if($tutorial->estado=='No Activo'){ ?>selected<?php } ?>>No Activo</option>
                        </select>
                    </p>
                    <p>
                        <input type="submit" class="submit" value="Actualizar Tutorial" />
                    </p>
                <?php echo form_close(); ?>

                <hr />
                
                <h2>Pasos del Tutorial</h2>
                <table width="100%">
                    <tr>
                        <th>ID</th>
                        <th>Paso</th>
                        <th>Acciones</th>
                    </tr>
                    <?php if(sizeof($tutorial_pasos)!=0){
                        foreach($tutorial_pasos as $tutorial_paso){ ?>
                    <tr>
                        <td><a href="<?php echo base_url(); ?>admin/aprende/ver_tutorial_paso/<?php echo $tutorial_paso->id_tutorial_paso; ?>"><?php echo $tutorial_paso->id_tutorial_paso; ?></a></td>
                        <td><?php echo $tutorial_paso->paso; ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>admin/aprende/ver_tutorial_paso/<?php echo $tutorial_paso->id_tutorial_paso; ?>"><img src="<?php echo base_url(); ?>resources/admin/images/pencil.png" alt="Ver o Actualizar Paso del Tutorial" /></a>
                            <a href="<?php echo base_url(); ?>admin/aprende/eliminar_tutorial_paso/<?php echo $tutorial_paso->id_tutorial_paso; ?>" onclick="return confirm('¿Está seguro de eliminar este paso del tutorial?');"><img src="<?php echo base_url(); ?>resources/admin/images/cancel.png" alt="Eliminar Paso del Tutorial" /></a>
                        </td>
                    </tr>
                    <?php }
                    }?>
                </table>
                <p>
                    <a href="<?php echo base_url(); ?>admin/aprende/formulario_agregar_tutorial_paso/<?php echo $tutorial->id_tutorial; ?>">Agregar un Paso al Tutorial</a>
                </p>
            </div>
            
            <?php include_once './resources/admin/templates/footer_include.php'; ?>
        </div>
    </body>
</html>