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
                            	<img src="<?php echo base_url();?>resources/images/correos/pregunta/pregunta-mujer.png" alt="Nueva respuesta" />
                            </td>
                            <td width="500" align="right">
                            	<a href="" style="padding-right:20px;"> 
                                    <img style="border:none;"  width="120" height="77" src="<?php echo base_url();?>resources/template/header/logo-laspartes.png" alt="laspartes.com" />
                                </a> <br/>
                                <span style="color:#c9c9c9; padding-right:20px;  font-size:20px;">"Contacto directo a nuestros talleres aliados"</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="660" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#FFFFFF" style="color:#737373;">
                	<tbody>
                    	<tr>
                        	<td align="center" valign="top" bgcolor="#f4f4f4">
                            	<img style="border:none;" src="<?php echo base_url();?>resources/images/correos/registro/sombra.png" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="660" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#f4f4f4" style="padding-top:10px; color:#737373; font-size:12px;">
                	<tbody>
                    	<tr>
                        	<td valign="top" align="left" style="padding-left:30px;">
                            	<span style="color:black; font-weight:bold; font-size:20px;"><?php echo $establecimiento->nombre;?><span>
                               <p style="color:#c60200; font-size:16px;">
                               	<strong><?php echo $usuario->nombres.' '.$usuario->apellidos;?> </strong>te ha enviado un mensaje<br/>
                                Correo electrónico: <?php echo $usuario->email;?>
                               </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="660" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#FFFFFF" style="color:#737373;">
                	<tbody>
                    	<tr>
                        	<td align="center" valign="top">
                            	<img style="border:none;" src="<?php echo base_url();?>resources/images/correos/pregunta/separador-vehiculos.png" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="660" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#FFFFFF" style="color:#737373; font-size:12px; padding-bottom:40px; padding-top:30px;">
                	<tbody>
                    	<tr>
                        	<td align="left" style="padding-left: 30px; padding-right:30px;">
                                <ul style="padding-left:25px; color:#404040; font-size:13px;">
                                	<li>
                                    	<span style="font-weight: bold; font-size: 18px;"><?php echo $asunto;?></span><br/>
                                        <span style="font-size:13px;"><?php echo $mensaje;?></span>
                                    </li>
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
