<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Correo de recordatorio de renovación de SOAT</title>
<script type="text/javascript"> 
    
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-23173661-1']);
    _gaq.push(['_trackPageview']);
    
    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
    
    _gaq.push(['_trackEvent', 'campaign', 'soat']); 
    
</script>
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
                                <img  src="<?php echo base_url();?>resources/images/correos/SOAT/recordatorio-soat.jpg"  alt="debes renovar tu SOAT"/>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <table width="660" border="0" cellpadding="0" cellspacing="0"border="0" bgcolor="#FFFFFF" style="padding-top:30px; padding-left:20px; padding-right:20px; padding-bottom:20px;">
                	<tbody>
                    	<tr>
                            <td>
                            	<span style="font-size:25px; color:black;"><strong>HOLA </strong><?php echo $usuario->nombres.' '.$usuario->apellidos;?></span><br/><br/>
                                <span style="color:#c60200; font-size:20px; font-weight: bold;"><?php echo $tarea->mensaje_dias_restantes.' '.$tarea->dias_restantes.' '.$tarea->mensaje_dias_restantes2;?></span><br/>
                                <ul style="color:#c60200; font-size:15px;">
                                	<li>Vehiculo con placas: <strong style="color:#424242;"><?php echo $carro->numero_placa;?></strong></li>
                                        <li>Vencimiento: <strong style="color:#424242;"><?php echo str_replace('-', '/', $tarea->ultima_fecha);?></li>                                    
                                </ul>
                            </td>
                        </tr>
                        <tr>
	                    <td align="center">
                            	<img src="<?php echo base_url();?>resources/images/correos/tecnicomecanica/triangulo-rojo.png" />  
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#c80000;" style="text-align:center; font-size: 30px; padding: 20px 10px;"><a href="<?php echo base_url();?>?utm_source=email&utm_medium=soat&utm_campaign=revision%2Bsoat" style="text-decoration:none; color:white;">
                            	<strong>¡Cotiza el SOAT con nosotros</strong> y te lo enviamos a la casa sin costo alguno!</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                    
                <table width="660" border="0" cellpadding="0" cellspacing="0" border="0" bgcolor="#FFFFFF" style="padding-left:20px; padding-right:20px;">
                	<tbody>
                    	<tr>
                            <td style="font-size:14px; color:black;">
                            	<strong>¡Recibelo desde la comodidad de tu casa!</strong><br/>
                         		Con laspartes.com puedes adquirir el SOAT y te llega a la casa, esto te evitará un trancon en Bogotá y sobre todo: Lo tendrás a tiempo, justo antes de que se venza.       
                            </td>
                        </tr>
                            
                        <tr>
                            <td align="right" style="padding-top: 20px; padding-bottom: 20px;">
                                <a href="<?php echo base_url();?>ayuda"><img style="border: none;" src="<?php echo base_url();?>resources/images/correos/SOAT/cotiza-soat.png"/></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
                <table width="660" border="0" cellpadding="0" cellspacing="0"border="0" style="padding-top:30px; padding-left:20px; padding-right:20px;">
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
