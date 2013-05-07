<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Establecimientos :: Lista de Establecimientos</title>

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

                <h2>Mi Establecimiento</h2>
                
                <table width="100%">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Zona</th>
                        <th>Correo Electrónico</th>
                        <th>Dirección</th>
                        <th>Teléfonos</th>
                        <th>Estado</th>
                        <th>Acciones</th> 
                    </tr>
                    <?php if(sizeof($establecimientos)!=0){
                        foreach($establecimientos as $establecimiento){ ?>
                    <tr>
                        <td><a href="<?php echo base_url(); ?>admin-establecimiento/establecimiento/ver_establecimiento/<?php echo $establecimiento->id_establecimiento; ?>"><?php echo $establecimiento->id_establecimiento; ?></a></td>
                        <td><?php echo $establecimiento->nombre; ?></td>
                        <td><?php echo $establecimiento->zona; ?></td>
                        <td><?php echo $establecimiento->email; ?></td>
                        <td><?php echo $establecimiento->direccion; ?></td>
                        <td><?php echo $establecimiento->telefonos; ?></td>
                        <td><?php if($establecimiento->estado=='Activo'){ ?><img src="<?php echo base_url(); ?>resources/admin-establecimiento/images/bullet_green.png" alt="Activo" /><?php } else { ?><img src="<?php echo base_url(); ?>resources/admin-establecimiento/images/bullet_red.png" alt="No Activo" /><?php } ?></td>
                        <td>
                            <a href="<?php echo base_url(); ?>admin-establecimiento/establecimiento/ver_establecimiento/<?php echo $establecimiento->id_establecimiento; ?>"><img src="<?php echo base_url(); ?>resources/admin-establecimiento/images/pencil.png" alt="Ver o Actualizar Establecimiento" /></a> 
                            <a href="<?php echo base_url(); ?>admin-establecimiento/establecimiento/ver_establecimiento_autopartes/<?php echo $establecimiento->id_establecimiento; ?>"><img src="<?php echo base_url(); ?>resources/admin-establecimiento/images/car_add.png" alt="Agregar o Actualizar Autopartes del Establecimiento" /></a>
                            <a href="<?php echo base_url(); ?>admin-establecimiento/establecimiento/ver_ofertas/<?php echo $establecimiento->id_establecimiento; ?>"><img src="<?php echo base_url(); ?>resources/admin/images/shopping-cart.png" alt="Agregar o Actualizar Ofertas del Establecimiento" /></a>
                        </td>
                    </tr>
                    <?php }
                    }?>
                </table>
            </div>

            <?php include_once './resources/admin-establecimiento/templates/footer_include.php'; ?>
        </div>
    </body>
</html>