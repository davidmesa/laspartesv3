<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Establecimientos :: Lista de Ofertas</title>

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
        <?php include_once './resources/admin-establecimiento/templates/header_include.php'; ?>
        <?php include_once './resources/admin-establecimiento/templates/establecimiento_submenu_include.php'; ?>

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

                <h2>Lista de Ofertas</h2>
                <a href="<?php echo base_url(); ?>admin-establecimiento/establecimiento/formulario_oferta/<?php echo $id_establecimineto; ?>"><img src="<?php echo base_url(); ?>resources/admin/images/add.png" alt="Agregar una oferta" /> Agregar una oferta</a>

                <table width="100%">
                    <tr>
                        <th>ID</th>
                        <th>Titulo</th>
                        <th>Precio</th>
                        <th>Condiciones</th>
                        <th>Incluye</th>
                        <th>Acciones</th>
                    </tr>
                    <?php if(sizeof($establecimiento_ofertas)!=0){
                        foreach($establecimiento_ofertas as $oferta): ?>
                    <tr>
                        <td><a href="<?php echo base_url(); ?>admin-establecimiento/establecimiento/ver_oferta/<?php echo $oferta->id_oferta; ?>/<?php echo $id_establecimineto; ?>"><?php echo $oferta->id_oferta; ?></a></td>
                        <td><?php echo $oferta->titulo; ?></td>
                        <td><?php echo $oferta->precio; ?></td>
                        <td><?php echo $oferta->condiciones; ?></td>
                        <td><?php echo $oferta->incluye; ?></td> 
                        <td><a href="<?php echo base_url(); ?>admin-establecimiento/establecimiento/ver_oferta/<?php echo $oferta->id_oferta; ?>/<?php echo $id_establecimineto; ?>"><img src="<?php echo base_url(); ?>resources/admin/images/pencil.png" alt="Ver o Actualizar Oferta" /></a>  <a href="<?php echo base_url(); ?>admin/establecimiento/eliminar_oferta/<?php echo $id_establecimineto; ?>/<?php echo $oferta->id_oferta; ?>" onclick="return confirm('¿Está seguro de eliminar esta oferta?');"><img src="<?php echo base_url(); ?>resources/admin/images/cancel.png" alt="Eliminar Oferta" /></a></td>
                    </tr>
                    <?php endforeach;
                    }?>
                </table>
            </div>

            <?php include_once './resources/admin-establecimiento/templates/footer_include.php'; ?>
        </div>
    </body>
</html>