<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Establecimientos :: Ver Ventas del Establecimiento</title>

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
                $('input:checkbox').click(function(){
                    var chk = $(this).is(':checked');
                    var chk_val = $(this).val();
                    var url = "<?php echo base_url(); ?>admin/establecimiento/carrito_realizado_ajax";
                    if(chk){
                        $.ajax({
                            type: "POST",
                            url: url,
                            async: false,
                            data: "id_carrito=" + chk_val +"&estado=1",
                            success: function(contenido){
                                checkbox.attr('disabled','disabled');
                                $('#notificacion-venta').css('display', 'block');
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

        <div class="notification success canhide" id="notificacion-venta" style="display: none;">
        <p>La venta ha sido realizada, se enviará un correo a laspartes con la información de la venta completada.</p>
        </div>
        <div id="main_content_wrap" class="container_12">
            <div class="container_12">
                <h2>Ver Ventas del Establecimiento</h2>
                <?php echo validation_errors('<div class="notification failure canhide"><p>', '</p></div>'); ?>
                <?php if (isset($confirmacion)) { ?>
                    <div class="notification success canhide">
                        <p><?php echo $confirmacion; ?></p>
                    </div>
                <?php } ?>





                <?php
                if (sizeof($carritos_compras) != 0) {
                    foreach ($carritos_compras as $carrito_compra) {
                        ?>
                            <table class="mis_compras" width="830" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 30px; ">
                                <tr>
                                    <td colspan="4"  align="right" valign="middle" class="general_link titulo_fondo" >
                                        Compra # <strong><?php echo $carrito_compra->carrito; ?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"  align="left" valign="middle"  style="padding-left:5px;padding-top:5px;">
                                        <span class="general_texto_secundario">
                                            <strong>Estado: </strong>
                                        </span><?php echo $carrito_compra->estado; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"  align="left" valign="middle"  style="padding-left:5px;padding-top:5px;">
                                        <span class="general_texto_secundario">
                                            <strong>Consecutivo: </strong>
                                        </span><?php echo $carrito_compra->consecutivo; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"  align="left" valign="middle"  style="padding-left:5px;padding-top:5px;">
                                        <span class="general_texto_secundario">
                                            <strong>No. recibo: </strong>
                                        </span><?php echo $carrito_compra->recibo; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"  align="left" valign="middle" style="padding-left:5px;">
                                        <span class="general_texto_secundario">
                                            <strong>Fecha:</strong>
                                        </span> <?php echo $carrito_compra->fecha; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"  align="left" valign="middle"  style="padding-left:5px;padding-bottom:5px;">
                                        <span><strong>Total:</strong></span> $<?php echo number_format($carrito_compra->carritoTotal, 0, ',', '.'); ?>
                                    </td>
                                </tr>

                                <?php
                                $numero_carrito_compra_autoparte = 1;
                                $show_banner = true;
                                if (sizeof($carritos_compras_autopartes) != 0) {
                                    foreach ($carritos_compras_autopartes as $carrito_compra_autoparte) {
                                        if ($carrito_compra_autoparte->carrito == $carrito_compra->carrito && strlen($carrito_compra_autoparte->nombre) > 0) {

                                            if ($show_banner): $show_banner = false;
                                                ?>

                                                <tr>
                                                    <td  align="center" valign="middle" style="padding:5px;">
                                                        <strong>Cantidad</strong>
                                                    </td>
                                                    <td  align="center" valign="middle"  >
                                                        <strong>Autoparte</strong>
                                                    </td>
                                                    <td align="center" valign="middle"  >
                                                        <strong>Cliente</strong>
                                                    </td>
                                                    <td style="padding-right:10px;" align="right" valign="middle"  >
                                                        <strong>Precio</strong>
                                                    </td>
                                                </tr>

                                                    <?php endif; ?>
                                            <tr>
                                                <td  align="center" valign="middle" >
                                                    <?php echo $carrito_compra_autoparte->cantidad; ?>
                                                </td>
                                                <td align="center" valign="middle" style="padding:5px;">
                                                    <?php echo $carrito_compra_autoparte->nombre; ?>
                                                </td>
                                                <td align="center" valign="middle"  >
                    <?php echo $carrito_compra_autoparte->usuario; ?>
                                                </td>
                                                <td align="right" valign="middle" style="padding-right:10px;">
                                                    $<?php echo ($carrito_compra_autoparte->total * $carrito_compra_autoparte->cantidad); ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $numero_carrito_compra_autoparte++;
                                        }else if ($carrito_compra_autoparte->carrito == $carrito_compra->carrito && strlen($carrito_compra_autoparte->nombre) == 0) {
                                            ?>
                                            <tr>
                                                <td  align="center" valign="middle"  style="padding:5px;">

                                                    <strong>Cantidad</strong>

                                                </td>
                                                <td  align="center" valign="middle" >

                                                    <strong>Oferta</strong>

                                                </td>
                                                <td align="center" valign="middle" >

                                                    <strong>Cliente</strong>

                                                </td>
                                                <td style="padding-right:10px;" align="right" valign="middle" >

                                                    <strong>Precio</strong>

                                                </td>
                                            </tr>

                                            <tr>
                                                <td  align="center" valign="middle"  >
                                                    1
                                                </td>
                                                <td align="center" valign="middle" style="padding:5px;">
                                                    <?php echo $carrito_compra_autoparte->titulo; ?>
                                                </td>
                                                <td align="center" valign="middle" >

                    <?php echo $carrito_compra_autoparte->usuario; ?>

                                                </td>
                                                <td align="right" valign="middle"style="padding-right:10px;">
                                                    $<?php echo number_format($carrito_compra_autoparte->precioOferta, 0, ',', '.'); ?>
                                                </td>
                                            </tr>

                                            <?php
                                            $numero_carrito_compra_autoparte++;
                                        }
                                    }
                                }
                                ?>
                                 <label>Realizado: </label><input type="checkbox" name="realizado[]" class="chk_realizado" value="<?php echo $carrito_compra->carrito; ?>"   <?php if ($carrito_compra->realizado == 1) {echo 'checked '.'DISABLED';} ?>/>
    <?php } ?>

                        </table>
                    
<?php } ?>


            <?php include_once './resources/admin/templates/footer_include.php'; ?>
            </div>
    </body>
</html>