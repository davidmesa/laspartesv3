<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Usuarios :: Ver o Actualizar Carrito de Compra</title>

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

                <h2>Ver o Actualizar Carrito de Compra</h2>
                <?php echo validation_errors('<div class="notification failure canhide"><p>', '</p></div>'); ?>
                <?php echo form_open('admin/usuario/actualizar_carrito_compra'); ?>
                    <input type="hidden" name="id_carrito_compra" value="<?php echo $carrito_compra->id_carrito_compra; ?>" />
                    <p>
                      <label>Usuario</label><br />
                      <?php echo $carrito_compra->usuario; ?>
                    </p>
                    <p>
                      <label>Fecha</label><br />
                      <?php echo $carrito_compra->fecha; ?>
                    </p>
                    <p>
                      <label>Estado</label><br />
                      <select name="estado">
                          <option value="Revisando disponibilidad de autopartes" <?php if($carrito_compra->estado=='Revisando disponibilidad de autopartes'){ ?>selected<?php } ?>>Revisando disponibilidad de autopartes</option>
                          <option value="Enviada al cliente" <?php if($carrito_compra->estado=='Enviada al cliente'){ ?>selected<?php } ?>>Enviada al cliente</option>
                          <option value="Entregada" <?php if($carrito_compra->estado=='Entregada'){ ?>selected<?php } ?>>Entregada</option>
                      </select>
                    </p>
                    <p>
                      <label>Total</label><br />
                      <?php echo $carrito_compra->total; ?>
                    </p>
                    <p>
          		<input type="submit" class="submit" value="Actualizar Carrito de Compra" />
                    </p>
                    <?php echo form_close(); ?>

                    <hr />

                    <h2>Autopartes del Carrito de Compra</h2>
                    <table width="100%">
                    <tr>
                        <th>Autoparte</th>
                        <th>Establecimiento</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                    <?php if(sizeof($carrito_compra_autopartes)!=0){
                        foreach($carrito_compra_autopartes as $carrito_compra_autoparte){ ?>
                    <tr>
                        <td><?php echo $carrito_compra_autoparte->autoparte; ?></td>
                        <td><?php echo $carrito_compra_autoparte->establecimiento; ?></td>
                        <td><?php echo $carrito_compra_autoparte->descripcion; ?></td>
                        <td><?php echo $carrito_compra_autoparte->precio; ?></td>
                        <td><?php echo $carrito_compra_autoparte->cantidad; ?></td>
                        <td><?php echo $carrito_compra_autoparte->cantidad*$carrito_compra_autoparte->precio; ?></td>
                    </tr>
                    <?php }
                    }?>
                </table>
                    
            </div>
            <?php include_once './resources/admin/templates/footer_include.php'; ?>
        </div>
    </body>
</html>