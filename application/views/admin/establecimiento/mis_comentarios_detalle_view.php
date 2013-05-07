<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Establecimientos :: Ver Comentarios del Establecimiento</title>

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
       <script>
             
            $(document).ready(function() {
                
                
                $('.estado').click(function(){
                    var activo = $('img', this).attr('alt');
                    var id_comentario = $('span', this).text();
                     var url = "<?php echo base_url(); ?>admin/establecimiento/cambiar_estado_ajax";
                    if(activo == 'Activo'){
                        $.ajax({
                            type: "POST",
                            url: url,
                            async: false,
                            data: "id_comentario=" + id_comentario +"&estado=0",
                            success: function(contenido){
                                window.location.reload();
                            }
                        });
                    }else{
                        $.ajax({
                            type: "POST",
                            url: url,
                            async: false,
                            data: "id_comentario=" + id_comentario +"&estado=1",
                            success: function(contenido){
                                window.location.reload();
                            }
                        });
                    }
                   

                });
                
                
            });
        </script>


    </head>

    <body onload="initialize()">
        <?php include_once './resources/admin/templates/header_include.php'; ?>
        <?php include_once './resources/admin/templates/establecimiento_submenu_include.php'; ?>

        <div id="main_content_wrap" class="container_12">
            <div class="container_12">
                <h2>Ver Comentarios del Establecimiento</h2>
                <h6>Haciendo click sobre el estado, podrá cambiarlo de activo a inactivo.</h6>
                <?php echo validation_errors('<div class="notification failure canhide"><p>', '</p></div>'); ?>
                <?php if (isset($confirmacion)) { ?>
                    <div class="notification success canhide">
                        <p><?php echo $confirmacion; ?></p>
                    </div>
                <?php } ?>

                <table width="950px">
                    <tr>
                        <th width="200px">Usuario</th>
                        <th width="600px">Comentario</th>
                        <th width="100px">Fecha</th>
                        <th width="50px">Estado</th>
                    </tr>
                <?php foreach ($comentarios as $comentario):?>
                    <tr>
                        <td><?php echo $comentario->usuario;?></td>
                        <td><?php echo $comentario->comentario;?></td>
                        <td><?php echo $comentario->fecha;?></td>
                        <td class="estado" style="cursor: pointer;"><?php if($comentario->est == '1'){ ?><img class = "imagen_estado" src="<?php echo base_url(); ?>resources/admin-establecimiento/images/bullet_green.png" alt="Activo" /><?php } else { ?><img class = "imagen_estado" src="<?php echo base_url(); ?>resources/admin-establecimiento/images/bullet_red.png" alt="No Activo" /><?php } ?> <span style="display: none;"><?php echo $comentario->id_establecimiento_comentario; ?></span></td>
                    </tr>
               <?php endforeach; ?>
                </table>


            <?php include_once './resources/admin/templates/footer_include.php'; ?>
            </div>
    </body>
</html>