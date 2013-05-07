<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Correo de tareas en laspartes.com</title>
<script type="text/javascript"> 
    
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-23173661-1']);
    _gaq.push(['_trackPageview']);
    
    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
    
    _gaq.push(['_trackEvent', 'campaign', 'tarea', 'cambio de aceite']); 
    
</script>
</head>

<body bgcolor="#efefef" style="font-family:Arial, Helvetica, sans-serif; text-align:left; padding:0; padding:0;" leftpadding="0" toppadding="0" paddingwidth="0" paddingheight="0">

<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#f5f5f5" style="font-size:12px; color:#424242; text-align:left;">
	<tbody>
    	<tr>
        	<td align="center">
            	<table width="660" border="0" cellpadding="0" cellspacing="0"border="0"  style="padding-top:10px;">
                	<tbody>
                    	<tr>
                        	<td width="660"> 
                            	<img  src="<?php echo base_url();?>resources/images/correos/tareas/recordatorio-mantenimeinto1.jpg"  alt="Recordatorio de mantenimiento"/>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <table width="620" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#FFFFFF" style="padding-top:30px; padding-left:20px; padding-right:20px; padding-bottom:20px;">
                	<tbody>
                    	<tr>
                        	<td>
                            	<span style="font-size:25px; color:black;"><strong>HOLA</strong> <?php echo $nombre;?></span><br/><br/>
                                <span style="color:black; font-size:16px;">Tu <strong><?php echo $marca.' '.$linea;?></strong><?php echo $numero_placa;?> <strong>puede necesitar:</strong></span><br/>
                            </td>
                        </tr>
                        <tr>
	                        <td align="center">
                            	<img src="<?php echo base_url();?>resources/images/correos/tareas/triangulo-rojo.png" />
                            </td>
                        </tr>
                        <tr>
                        	<td bgcolor="#c80000;" style="text-align:center; font-size: 30px; padding: 20px 10px; color:white; text-transform: uppercase;">
                            	<strong><?php echo $tarea->nombre;?></strong>
                            </td>
                        </tr>
                        <tr>
                        	<td style="color:black;"><br/>
                            	<strong style="font-size:14px;">¿Qué pasa si no lo haces?</strong><br/>
                                <span style="font-size:13;"><?php echo character_limiter($tarea->descripcion, 300);?></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top:20px;" align="center">
                                <img src="<?php echo base_url();?>resources/images/correos/tareas/linea.png" /><img src="<?php echo base_url();?>resources/images/correos/tareas/linea.png" /><img src="<?php echo base_url();?>resources/images/correos/tareas/linea.png" />
                            </td>
                        </tr>
                        <tr>
                        	<td  style="padding-top: 20px; color:#c60200; font-size:20px;">
	                        	Adquierelo a través de laspartes.com
                            </td>
                        </tr>
                        <tr>
                        	<td style="padding-top:10px;">
                            	<table width="620" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#FFFFFF" >
                                	<tbody>
                                    	<tr>
                                        	<td width="130">
                                            	<img style="border: 1px solid #ccc;" width="120" src="<?php echo base_url().$tarea->imagen_thumb_url;?>" />
                                            </td> 
                                            <td width="530" align="left" bgcolor="#f5f5f5" style="color:black; padding: 30px 40px; font-size:18px;" valign="top">
                                            	Cómpralo en línea desde la comodidad de tu casa en talleres <strong>recomendados</strong> por nuestros usuarios y aprovechando <strong>ofertas especiales.</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                        	<td style="padding-top:10px; font-size:12px;">
	                        	<strong>Después de comprar recibirás un recibo</strong> y podras agendar el horario que mejor se te acomode con el taller .<br/><br/>
                                <span style="color:#c60200; font-size:15px; font-weight: bold;">Rápido, seguro y confiable</span> a través de <a style="color:#424242;" href="<?php echo base_url();?>">laspartes.com</a>, todo para tu vehículo.
                            </td>
                        </tr>
                        
                        <?php if(sizeof($ofertas)>0):?>
                            
                        <tr>
                            <td style="padding-top:20px;" align="center">
                                <img src="<?php echo base_url();?>resources/images/correos/tareas/linea.png" /><img src="<?php echo base_url();?>resources/images/correos/tareas/linea.png" /><img src="<?php echo base_url();?>resources/images/correos/tareas/linea.png" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <table width="620" border="0" cellpadding="0" cellspacing="0"border="0" style="padding-top:20px;">
                                    <tbody>
										<tr>
                                        	<td width="100">
                                            	<img src="<?php echo base_url();?>resources/images/correos/tareas/icon-promo.png" />
                                            </td>
                                            <td width="560" style="font-size:20px; color:black;">
                                            	<strong style="color:#c60200;">OFERTAS ESPECIALES</strong><br />
                                                <span style="text-transform: uppercase;">PARA <?php echo $tarea->nombre;?></span>
                                            </td>
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                        	<td align="center" style="padding-top:10px;">
                            	<img src="<?php echo base_url();?>resources/images/correos/tareas/sombra.png"  />
                            </td>
                        </tr>
                        <?php endif;?> 
                        <?php foreach ($ofertas as $oferta):
                                $url = base_url().'promociones/'.$oferta->id_oferta.'-'.preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $oferta->titulo).'?utm_source=email&utm_medium=cambio%2Bde%2Baceite&utm_campaign=tarea';
                            ?>
                            
                        <tr>
                            <td>
                                <table width="620" border="0" cellpadding="0" cellspacing="0"border="0" style="padding-top:20px;">
                                    <tbody>
                                        <tr>
                                            <td valign="top" style="font-size:16px;">
                                                <a style="text-decoration:none;" href="<?php echo $url;?>"><span style="font-size:20px; color:black;"><strong>$<?php echo number_format($oferta->precio, '0', ',', '.');?></strong><span style="color:#c60200;"> por <?php echo $oferta->titulo;?></span></span></a><br/><br/>
                                                <span>
                                                	<?php echo $oferta->incluye;?>
                                                </span><br/><br/>
                                                <!--<strong>Aplica para las líneas:</strong> Todas las líneas de vehículos<br/>-->
                                                <strong>Válido hasta el <?php echo strftime("%B %d de %Y", strtotime($oferta->vigencia));?></strong>
                                            </td>
                                            <td width="190">
                                            	<a href="<?php echo $url;?>"><img style="border: 1px solid #ccc;" width="160" src="<?php echo base_url().$oferta->foto;?>" alt="tecnico-mecanica" /></a><br/><br/>
                                                <a href="<?php echo $url;?>">
                                                	<img src="<?php echo base_url();?>resources/images/correos/tareas/ver-oferta.png" alt="ver oferta"  />
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="padding-top:20px;" align="center">
                                                <img src="<?php echo base_url();?>resources/images/correos/tareas/linea.png" /><img src="<?php echo base_url();?>resources/images/correos/tareas/linea.png" /><img src="<?php echo base_url();?>resources/images/correos/tareas/linea.png" />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <?php endforeach;?>
                        <?php if(sizeof($ofertas)>0):?>
                        <tr><td height="10"></td></tr>
                        <tr>
                            <td bgcolor="#676666" style="padding: 10px 30px 10px 30px; color:white; font-size:24px; text-align:right;">
                                <a style="text-decoration: none; color: white;" href="<?php echo base_url().'promociones/buscar/categoria/'.str_replace('-', ' ', convert_accented_characters($ofertas[0]->categoria_servicio)).'/vehiculo/'.str_replace(' ', '_', convert_accented_characters($marca)).'-'.str_replace(' ', '-', convert_accented_characters($linea));?>">
                                    <span><strong>VER MÁS OFERTAS</strong></span><img style="margin-left:10px;" src="<?php echo base_url();?>resources/images/correos/tareas/doble-mayor-blanco.png" />
                                </a>
                            </td>
                        </tr>
                        <tr><td height="10"></td></tr>
                        <tr>
                            <td align="center">
                                <img src="<?php echo base_url();?>resources/images/correos/tareas/linea.png" /><img src="<?php echo base_url();?>resources/images/correos/tareas/linea.png" /><img src="<?php echo base_url();?>resources/images/correos/tareas/linea.png" />
                            </td>
                        </tr>
                        <?php endif;?>
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
