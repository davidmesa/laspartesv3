<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Correo de anular factura de compra en laspartes.com</title>
    </head>

    <body bgcolor="#efefef" style="font-family:Arial, Helvetica, sans-serif; text-align:left; padding:0; padding:0;" leftpadding="0" toppadding="0" paddingwidth="0" paddingheight="0">
        <p>
            Estimado(a) <?php echo $usuario->nombres.' '.$usuario->apellidos;?>,</br>
            Confirmamos que la factura de compra con Número <?php echo str_pad($factura_model->id_consecutivo_factura, 4, '0', STR_PAD_LEFT)?> ha sido anulada
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
