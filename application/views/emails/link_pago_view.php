<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Correo de anular orden de compra en laspartes.com</title>
</head>

<body  style="font-family:Arial, Helvetica, sans-serif; text-align:left; padding:0; padding:0;" leftpadding="0" toppadding="0" paddingwidth="0" paddingheight="0">
    <p>
        Estimado <?php echo $usuario->nombres.' '.$usuario->apellidos;?>,</br><br/>
        Enviamos el <a href="<?php echo base_url().$link_pago->url?>">link de pago</a> con relación a <?php echo $titulo?>.
    </p>

    <p>
        <strong>incluye:</strong><br/>
        <?php echo $incluye;?>
    </p>

    <p><?php echo base_url().$link_pago->url?></p>

    <p>Adicionalmente, cuenta usted con otras opciones para la cancelación:</p>
    <p>1.    Transferencia o consignación en Corpbanca cuenta corriente No. 054023346 a nombre de laspartes.com.co ltda.<br/>
       2.    Transferencia o consignación en Davivienda cuenta ahorros No. 008700367918 a nombre de laspartes.com.co ltda.<br/>
       3.    Datáfono o pago en efectivo acercándose a nuestra oficina en la Carrera 16 # 80 - 11 Oficina 602 Edificio El Escorial 
    </p>

    <p>
        Recuerde que si presenta inconsistencia, con gusto le colaboraremos.
    </p>
    <p>
        Cordialmente,<br/>
        Laspartes.com
    </p>
    <a href="" style="padding-right:20px;"> 
        <img style="border:none;"  width="120" height="77" src="<?php echo base_url(); ?>resources/template/header/logo-laspartes.png" alt="laspartes.com" />
    </a>
</body>
</html>
