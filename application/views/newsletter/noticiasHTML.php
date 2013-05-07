<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Correo de noticias en laspartes.com</title>
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
                            	<img src="<?php echo base_url();?>resources/images/correos/pregunta/pregunta-mujer.png" alt="Newsletter noticias" />
                            </td>
                            <td width="500" align="right">
                            	<a href="" style="padding-right:20px;">  
                                    <img style="border:none;"  width="120" height="77" src="<?php echo base_url();?>resources/template/header/logo-laspartes.png" alt="laspartes.com" />
                                </a> <br/>
                                <span style="color:#c9c9c9; padding-right:20px;  font-size:28px;">"Conoce más sobre tu carro"</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="660" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#FFFFFF" style="color:#737373;">
                	<tbody>
                    	<tr>
                        	<td align="center" valign="top" bgcolor="#ffffff">
                            	<img style="border:none;" src="<?php echo base_url();?>resources/images/correos/registro/sombra.png" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="660" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#ffffff" style="padding-top:10px; color:#737373; font-size:12px;">
                	<tbody>
                    	<tr>
                        	<td width="275" valign="middle" align="left" style="padding-left:30px;">
                            <img src="<?php echo base_url();?>/resources/images/novedades/novedad-icon.png" alt="piñon"/> <span style="color:#c60200; font-size:28px;">NOVEDADES</span> 
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="660" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#FFFFFF" style="color:#737373;">
                	<tbody>
                    	<tr>
                        	<td style="padding:10px 30px;">
                            	<img style="border:none;" src="<?php echo base_url();?>resources/images/autopartes/espaciador-rallas.png"  /><img style="border:none;" src="<?php echo base_url();?>resources/images/autopartes/espaciador-rallas.png"  /><img style="border:none;" src="<?php echo base_url();?>resources/images/autopartes/espaciador-rallas.png"  />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="660" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#FFFFFF" style="color:#737373; font-size:12px; padding-top:20px;">
                	<tbody>
                        <?php foreach ($noticia as $noti): ?>
                    	<tr>
                        	<td align="left" width="200px" style="padding-left: 30px;"  valign="top">
                            	<a href="<?php echo base_url() . 'noticias/' . $noti->id_noticia.'-'.str_replace(' ', '-', convert_accented_characters($noti->titulo)); ?>">
                                	<img style="border:2px solid #ccc; max-width:200px;" src="<?php echo base_url() . $noti->imagen_thumb_url; ?>" alt="<?php echo $noti->titulo; ?>" />
                                </a>
                            </td>
                            <td width="560" align="left" valign="top" style="padding-left:20px; padding-right:30px;">
                            	<a href="<?php echo base_url() . 'noticias/' . $noti->id_noticia.'-'.str_replace(' ', '-', convert_accented_characters($noti->titulo)); ?>" style="text-decoration:underline; color:black; font-size:16px;"><?php echo $noti->titulo; ?></a>
                                <p style="color:#404040; font-size:12px;">
                                	<?php echo character_limiter($noti->noticia, 300); ?>
                                </p>
                                <p style="margin-right:30px; color:#c60200; font-size:12px; text-align:right;">
                                	<a style="color:#c60200; font-size:12px;" href="<?php echo base_url() . 'noticias/' . $noti->id_noticia.'-'.str_replace(' ', '-', convert_accented_characters($noti->titulo)); ?>">Leer más</a> >>
                                </p>
                            </td>
                        </tr>
                        
                        <tr>
                        	<td width="660" colspan="2" align="center" style="padding-bottom:15px;">
                            	<img src="<?php echo base_url();?>resources/images/correos/registro/sombra.png" />
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <table width="660" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#ffffff" style="padding-top:10px; color:#737373; font-size:12px;">
                	<tbody>
                    	<tr>
                        	<td width="275" valign="middle" align="left" style="padding-left:30px;">
                            <img src="<?php echo base_url();?>/resources/images/novedades/bombillo-pequeno-icono.png" alt="piñon"/><span style="color:BLACK; font-size:28px; padding-left:10px;">TIPS Y</span> <span style="color:#c60200; font-size:28px;">CONSEJOS</span> 
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="660" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#FFFFFF" style="color:#737373;">
                	<tbody>
                    	<tr>
                        	<td style="padding:10px 30px;">
                            	<img style="border:none;" src="<?php echo base_url();?>resources/images/autopartes/espaciador-rallas.png"  /><img style="border:none;" src="<?php echo base_url();?>resources/images/autopartes/espaciador-rallas.png"  /><img style="border:none;" src="<?php echo base_url();?>resources/images/autopartes/espaciador-rallas.png"  />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table width="660" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#FFFFFF" style="color:#737373; font-size:12px; padding-bottom:40px; padding-top:20px;">
                	<tbody>
                    	<tr>
                        	<td width="50%" align="left" style="padding-left:35px; padding-right:30px;">
                            	<a href="<?php echo base_url() . 'tips/' . $tip[0]->id_tip.'-'.str_replace(' ', '-', convert_accented_characters($tip[0]->titulo)); ?>" style="font-size:16px; text-decoration:underline; color:#424242;"><?php echo $tip[0]->titulo; ?></a>
                                <p style="font-size:12px;">
                                	<?php echo character_limiter($tip[0]->tip, 100); ?>
                                </p>
                                <p style="margin-right:15px; color:#c60200; font-size:12px; text-align:right;">
                                	<a style="color:#c60200; font-size:12px;" href="<?php echo base_url() . 'tips/' . $tip[0]->id_tip.'-'.str_replace(' ', '-', convert_accented_characters($tip[0]->titulo)); ?>">Leer más</a> >>
                                </p>
                                <img src="<?php echo base_url();?>resources/images/newsletter/separador-tip.png" />
                                <p style="margin-right:15px; text-align:right;color:#4040404;">
                                	<?php echo strftime("%B %d de %Y", strtotime($tip[0]->fecha)); ?>
                                </p>
                            </td>
                            <td align="left" width="50%" style="padding-left:30px; padding-right:35px;">
                            	<a href="<?php echo base_url() . 'tips/' . $tip[1]->id_tip.'-'.str_replace(' ', '-', convert_accented_characters($tip[1]->titulo)); ?> style="font-size:16px; text-decoration:underline; color:#424242;"><?php echo $tip[1]->titulo; ?></a>
                                <p style="font-size:12px;">
                                	<?php echo character_limiter($tip[1]->tip, 100); ?>
                                </p>
                                <p style="margin-right:15px; color:#c60200; font-size:12px; text-align:right;">
                                	<a style="color:#c60200; font-size:12px;" href="<?php echo base_url() . 'tips/' . $tip[1]->id_tip.'-'.str_replace(' ', '-', convert_accented_characters($tip[1]->titulo)); ?>">Leer más</a> >>
                                </p>
                                <img src="<?php echo base_url();?>resources/images/newsletter/separador-tip.png" />
                                <p style="margin-right:15px; text-align:right;color:#4040404;">
                                	<?php echo strftime("%B %d de %Y", strtotime($tip[1]->fecha)); ?>
                                </p>
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
