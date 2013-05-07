<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Correo de respuesta en laspartes.com</title>
    </head> 

    <body bgcolor="#efefef" style="font-family:Arial, Helvetica, sans-serif; text-align:left; padding:0; padding:0;" leftpadding="0" toppadding="0" paddingwidth="0" paddingheight="0">

        <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#efefef" style="font-size:12px; color:#424242; text-align:left;">
            <tbody>
                <tr>
                    <td align="center">
                        <table width="660" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#FFFFFF">
                            <tbody>
                                <tr>
                                    <td width="160"> 
                                        <img src="<?php echo base_url(); ?>resources/images/correos/pregunta/pregunta-mujer.png" alt="Resumen de compra" />
                                    </td>
                                    <td width="500" align="right">
                                        <a href="" style="padding-right:20px;"> 
                                            <img style="border:none;"  width="120" height="77" src="<?php echo base_url(); ?>resources/template/header/logo-laspartes.png" alt="laspartes.com" />
                                        </a> <br/>
                                        <span style="color:#c9c9c9; padding-right:20px;  font-size:20px;">Detalles de compra</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="660" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#FFFFFF" style="color:#737373;">
                            <tbody>
                                <tr>
                                    <td align="center" valign="top">
                                        <img style="border:none;" src="<?php echo base_url(); ?>resources/images/correos/pregunta/separador-vehiculos.png" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table width="660" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#FFFFFF" style="color:#737373; font-size:12px; padding-bottom:40px; padding-top:30px;">
                            <tbody>
                                <tr>
                                    <td align="left" style="padding-left: 30px; padding-right:30px; color: black;">
                                        Gracias por tu compra, a continuacion puedes ver el resumen de tu compra:<br/><br/>
                                        <strong>Estado de la compra:</strong> <?php echo $mensaje; ?><br/>
                                        <strong>Usuario:</strong> <?php echo $venta->usuario; ?> <br />
                                        <strong>Nombres:</strong> <?php echo $venta->nombre_apellido; ?><br />
                                        <strong>Documento:</strong> <?php echo $venta->documento; ?><br />
                                        <strong>Email:</strong> <?php echo $venta->email; ?><br />   
                                        <strong>Ciudad:</strong> <?php echo $venta->ciudad; ?><br />  
                                        <strong>Direccion:</strong> <?php echo $venta->direccion; ?><br />  
                                        <strong>Telefono:</strong> <?php echo $venta->telefono; ?><br />  
                                        <strong>Documento:</strong> <?php echo $venta->documento; ?><br />
                                        <strong>Carro:</strong> <?php echo $venta->carro; ?><br />
                                        <strong>Placa del carro:</strong> <?php echo $venta->placa; ?><br />
                                        <strong>Precio:</strong> $<?php echo number_format($venta->total, 0, ',', '.'); ?><br/><br/>
                                        <strong>Items ordenados:</strong><br/>
                                        <ul style="padding-left:25px; color:#404040; font-size:13px;">
                                            <?php foreach ($autopartes as $row): ?>
                                                <li style="font-size: 16px;">
                                                    <?php echo $row->cantidad . ' de: ' . $row->autoparte . ' por $' . number_format($row->precio, 0, ',', '.'); ?>                    
                                                </li>
                                            <?php
                                            endforeach;
                                            foreach ($ofertas as $row):
                                                if ($row->dco_feria != 0):
                                                    $precio = $row->precio;
                                                    $iva = $row->iva;
                                                    $dco = $row->dco_feria;
                                                    $base = $precio - $iva;
                                                    $ivaPorce = $iva / $base;
                                                    $valorDco = $base * ((100 - $dco) / 100);
                                                    $precionConDco = ($valorDco * (1 + $ivaPorce));
                                                    ?>
                                                    <li style="font-size: 16px;">
                                                        <?php echo $row->cantidad . ' de: ' . $row->titulo . ' por $' . number_format($precionConDco, 0, ',', '.'); ?>                    
                                                    </li>  
                                                <?php else: ?>
                                                    <li style="font-size: 16px;">
                                                        <?php echo $row->cantidad . ' de: ' . $row->titulo . ' por $' . number_format($row->precio, 0, ',', '.'); ?>                    
                                                    </li>
                                                <?php
                                                endif;

                                            endforeach;
                                            ?>

                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
