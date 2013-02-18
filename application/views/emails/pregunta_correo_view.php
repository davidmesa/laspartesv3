<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Correo de registro en laspartes.com</title>
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
                            	<img src="<?php echo base_url();?>resources/images/correos/pregunta/pregunta-mujer.png" alt="Nueva pregunta" />
                            </td>
                            <td width="500" align="right">
                            	<a href="<?php echo base_url();?>" style="padding-right:20px;">
                                    <img style="border:none;"  width="120" height="77" src="<?php echo base_url();?>resources/template/header/logo-laspartes.png" alt="laspartes.com" />
                                </a> <br/>
                                <span style="color:#c9c9c9; padding-right:20px;  font-size:28px;">Buscan una respuesta</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table height="8" width="660" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#FFFFFF" style="color:#737373;">
                	<tbody>  
                    	<tr>
                            <td height="8" width="660" align="center" valign="top" bgcolor="#f4f4f4">
                            	<img style="border:none;" src="<?php echo base_url();?>resources/images/correos/registro/sombra.png"/>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="660" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#f4f4f4" style="padding-top:10px; color:#737373; font-size:12px;">
                	<tbody>
                    	<tr>
                        	<td width="275" valign="top" align="left" style="padding-left:30px;">
                            	<span style="color:black; font-weight:bold; font-size:20px;"><?php echo $usuario->nombres.' '.$usuario->apellidos;?><span>
                               <p style="color:#c60200; font-size:16px;">Pregunta:</p>
                            </td>
                            <td width="60px" align="center">
                            	<img src="<?php echo base_url();?>resources/images/correos/pregunta/separador-rallitas.png" alt="separador de rallas" />
                            </td>
                            <td width="275" valign="top" align="left">
                            	<img src="<?php echo base_url();?>resources/images/correos/pregunta/carro-laspartes.png" alt="carro de laspartes.com" style="padding-right:10px;"/> 
                                <span style="color:#c60200; font-size:14px;">Sus autos:</span>
                                <table border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#f4f4f4" style="color:#737373; font-size:12px;">
                                	<tbody>
                                    	<tr>
                                            <td width="50%" valign="top">
                                            	<ul style="padding-left:0px; color:black;">
                                                    <?php foreach ($vehiculos as $index => $vehiculo): if($index%2 == 0): ?>
                                                    <li style="padding-bottom:10px;"><?php echo $vehiculo->marca.' '.$vehiculo->linea?></li>
                                                    <?php endif;  endforeach; ?>
                                                </ul>
                                            </td>
                                            <td width="50%" valign="top">
                                            	<ul style="color:black; padding-left:10px; ">
                                                    <?php foreach ($vehiculos as $index => $vehiculo): if($index%2 == 1): ?>
                                                    <li style="padding-bottom:10px;"><?php echo $vehiculo->marca.' '.$vehiculo->linea?></li>
                                                    <?php endif;  endforeach; ?>
                                                </ul>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="660" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#FFFFFF" style="color:#737373;">
                	<tbody>
                    	<tr>
                        	<td align="center" valign="top">
                            	<img style="border:none;" src="<?php echo base_url();?>resources/images/correos/pregunta/separador-vehiculos.png"  />
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
                                            <span style="font-weight: bold; font-size: 18px;"><?php echo $pregunta->titulo_pregunta;?></span><br/>
                                            <span style="font-size:13px;"><?php echo $pregunta->cuerpo_pregunta;?></span>
                                        </li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                        	<td align="right" style="padding-right:40px; padding-top:30px;">
                                <?php if($aprobado):?>
                                    <a href="<?php echo $url;?>">
                                            <img style="border:none;" src="<?php echo base_url();?>resources/images/correos/pregunta/responder-ahora.png" alt="ver la respuesta" />
                                    </a>  
                                <?php else:?>
                                    <a href="<?php echo $url_no_activar;?>">
                                        <img style="border:none;" src="<?php echo base_url();?>resources/images/correos/pregunta/no-activar.png" alt="No activar" />
                                    </a> 
                                    <a href="<?php echo $url_activar;?>">
                                        <img style="border:none;" src="<?php echo base_url();?>resources/images/correos/pregunta/activar.png" alt="Activar" />
                                    </a> 
                                <?php endif;?>
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
