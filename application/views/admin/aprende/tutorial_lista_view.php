<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Aprende :: Lista de Tutoriales</title>

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

                <h2>Lista de Tutoriales</h2>
                <a href="<?php echo base_url(); ?>admin/aprende/formulario_agregar_tutorial"><img src="<?php echo base_url(); ?>resources/admin/images/add.png" alt="Agregar un tutorial" /> Agregar un tutorial</a>

                <table width="100%">
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                    <?php if(sizeof($tutoriales)!=0){
                        foreach($tutoriales as $tutorial){ ?>
                    <tr>
                        <td><a href="<?php echo base_url(); ?>admin/aprende/ver_tutorial/<?php echo $tutorial->id_tutorial; ?>"><?php echo $tutorial->id_tutorial; ?></a></td>
                        <td><?php echo $tutorial->titulo; ?></td>
                        <td><?php echo $tutorial->fecha; ?></td>
                        <td><?php if($tutorial->estado=='Activo'){ ?><img src="<?php echo base_url(); ?>resources/admin/images/bullet_green.png" alt="Activo" /><?php } else { ?><img src="<?php echo base_url(); ?>resources/admin/images/bullet_red.png" alt="No Activo" /><?php } ?></td>
                        <td><a href="<?php echo base_url(); ?>admin/aprende/ver_tutorial/<?php echo $tutorial->id_tutorial; ?>"><img src="<?php echo base_url(); ?>resources/admin/images/pencil.png" alt="Ver o Actualizar Tutorial" /></a></td>
                    </tr>
                    <?php }
                    }?>
                </table>
            </div>

            <?php include_once './resources/admin/templates/footer_include.php'; ?>
        </div>
    </body>
</html>