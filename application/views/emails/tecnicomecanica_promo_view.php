<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Correo de promoción de tecnicomecanica en laspartes.com</title>
</head>

<body bgcolor="#efefef" style="font-family:Arial, Helvetica, sans-serif; text-align:left; padding:0; padding:0;" leftpadding="0" toppadding="0" paddingwidth="0" paddingheight="0">

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#efefef" style="font-size:12px; color:#424242; text-align:left;">
	<tbody>
    	<tr>
        	<td align="center">
            	<table width="660" cellpadding="0" cellspacing="0" border="0" bgcolor="#FFFFFF" style="padding-top:10px;">
                	<tbody>
                    	<tr>
                            <td align="center"> 
                                <img  src="<?php echo base_url();?>resources/images/correos/tecnicomecanica/baner-alerta.png"  alt="debes renovar tu técnico mecánica"/>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <table width="620" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#FFFFFF" style="padding-top:30px; padding-left:20px; padding-right:20px; padding-bottom:20px;">
                	<tbody>
                    	<tr>
                        	<td>
                            	<span style="font-size:25px; color:black;"><strong>HOLA:</strong> <?php echo $usuario->nombres.' '.$usuario->apellidos?></span><br/><br/>
                                <span style="color:#c60200; font-size:20px; font-weight: bold;">¡Te quedan <?php $diff_fecha_Tecnicomecanica = abs(strtotime(mdate("%Y-%m-%d")) - strtotime($usuario->ultima_fecha)) / (60 * 60 * 24); echo $diff_fecha_Tecnicomecanica;?> días para que renueves tu Técnico-mecánica!</span><br/>
                                <ul style="color:#c60200; font-size:15px;">
                                	<li>Vehiculo con placas: <strong style="color:#424242;"><?php echo $usuario->placa;?></strong></li>
                                        <li>Vencimiento: <strong style="color:#424242;"><?php echo str_replace('-', '/', $usuario->ultima_fecha);?></strong></li>                                    
                                </ul>
                            </td>
                        </tr>
                        <tr>
	                        <td align="center">
                            	<img src="<?php echo base_url();?>resources/images/correos/tecnicomecanica/triangulo-rojo.png" />
                            </td>
                        </tr>
                        <tr>
                        	<td bgcolor="#c80000;" style="text-align:center; font-size: 30px; padding: 20px 10px;"><a href="http://www.laspartes.com/promociones/254-Revisi-n-de-gases-GRATIS-por-comprar-T-cnico-Mec-nica-para-automoviles-particulares/buscar/categoria/T-cnicomecanica" style="text-decoration:none; color:white;">
                            	<strong>¡Compra aquí</strong> la revisión Técnico-mecánica para tu vehículo!</a>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top:20px;" align="center">
                                <img src="<?php echo base_url();?>resources/images/correos/tecnicomecanica/linea.png" /><img src="<?php echo base_url();?>resources/images/correos/tecnicomecanica/linea.png" /><img src="<?php echo base_url();?>resources/images/correos/tecnicomecanica/linea.png" />
                            </td>
                        </tr>
                        <tr>
                        	<td  style="padding-top: 20px;">
	                        	<a style="color:#c60200; font-size:20px;" href="http://www.laspartes.com/promociones/254-Revisi-n-de-gases-GRATIS-por-comprar-T-cnico-Mec-nica-para-automoviles-particulares/buscar/categoria/T-cnicomecanica">Adquierelo a través de laspartes.com</a>
                            </td>
                        </tr>
                        <tr>
                        	<td style="padding-top:10px;">
                            	<table width="620" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#FFFFFF" >
                                	<tbody>
                                    	<tr>
                                        	<td width="130">
                                            	<img style="border: 1px solid #ccc;" width="120" src="<?php echo base_url().$oferta->foto;?>" />
                                            </td>
                                            <td width="530" align="left" bgcolor="#f5f5f5" style="padding: 30px 40px; font-size:18px;" valign="top">
                                            	Cómpralo en línea desde la comonidad de tu casa en talleres <strong>recomendados</strong> por nuestros usuarios y aprovechando <strong>ofertas especiales.</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                        	<td style="padding-top:10px; font-size:12px;">
	                        	<strong>Después de comprar recibirás un recibo</strong> y podras agendar el horario que mejor se te acomode con el taller .<br/><br/>
                                <span style="color:#c60200; font-size:15px; font-weight: bold;">Rápido, seguro y confiable</span> a través de <a style="color:#424242;" href="">laspartes.com</a>, todo para tu vehículo.
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top:20px;" align="center">
                                <img src="<?php echo base_url();?>resources/images/correos/tecnicomecanica/linea.png" /><img src="<?php echo base_url();?>resources/images/correos/tecnicomecanica/linea.png" /><img src="<?php echo base_url();?>resources/images/correos/tecnicomecanica/linea.png" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <table width="620" border="0" cellpadding="0" cellspacing="0"border="0" style="padding-top:20px;">
                                    <tbody>
										<tr>
                                        	<td width="100">
                                            	<img src="<?php echo base_url();?>resources/images/correos/tecnicomecanica/icon-promo.png" />
                                            </td>
                                            <td width="560" style="font-size:20px; color:black;">
                                            	<strong style="color:#c60200;">OFERTAS ESPECIALES</strong><br />
                                                <span>PARA REVISIÓN TÉCNICO-MECÁNICA</span>
                                            </td>
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                        	<td align="center" style="padding-top:10px;">
                            	<img src="<?php echo base_url();?>resources/images/correos/tecnicomecanica/sombra.png"  />
                            </td>
                        </tr>
                         <tr>
                            <td>
                                <table width="620" border="0" cellpadding="0" cellspacing="0"border="0" style="padding-top:20px;">
                                    <tbody>
                                        <tr>
                                            <td valign="top" style="font-size:16px;">
                                                <a style="text-decoration:none;" href="http://www.laspartes.com/promociones/254-Revisi-n-de-gases-GRATIS-por-comprar-T-cnico-Mec-nica-para-automoviles-particulares/buscar/categoria/T-cnicomecanica"><span style="font-size:20px; color:black;"><strong>5% Dcto. </strong><span style="color:#c60200;">en Revisión TecnicoMecánica para automóviles particulares.</span><strong> En navidad te regalamos el análisis de gases previo.</strong></span></span></a><br/><br/>
                                                <span>
                                                	<?php echo $oferta->incluye;?>
                                                </span><br/><br/>
                                                <strong>Aplica para las líneas:</strong> Todas las líneas de vehículos<br/>
                                                <strong>Válido hasta el 31 de diciembre de 2012</strong>
                                            </td>
                                            <td width="190">
                                            	<a href="http://www.laspartes.com/promociones/254-Revisi-n-de-gases-GRATIS-por-comprar-T-cnico-Mec-nica-para-automoviles-particulares/buscar/categoria/T-cnicomecanica"><img style="border: 1px solid #ccc;" width="160" src="<?php echo base_url().$oferta->foto;?>" alt="tecnico-mecanica" /></a><br/><br/>
                                                <a href="http://www.laspartes.com/promociones/254-Revisi-n-de-gases-GRATIS-por-comprar-T-cnico-Mec-nica-para-automoviles-particulares/buscar/categoria/T-cnicomecanica">
                                                	<img src="<?php echo base_url();?>resources/images/correos/tecnicomecanica/ver-oferta.png" alt="ver oferta"  />
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <table width="620" border="0" cellpadding="0" cellspacing="0"border="0" style="padding-top:30px; padding-left:20px; padding-right:20px;">
                	<tr>
                    	<td>
                        	<a href="www.laspartes.com" style="text-decoration:none"><img style="border:none;" width="60" src="http://www.laspartes.com/resources/template/header/logo-laspartes.png" alt="laspartes.com"  /></a>
                        </td>
                        <td align="right">
                        	Este es un boletín informativo de <a style="color:#c60200; text-decoration:none;" href="www.laspartes.com">laspartes.com</a>
                        </td>
                    </tr>
                </table>
                
            </td>
        </tr>
    </tbody>
</table>
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
</body>
</html>
