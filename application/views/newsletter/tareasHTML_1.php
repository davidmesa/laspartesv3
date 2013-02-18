<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<html>


    <body>
        <div align ="center" witdh="610px" heigh="100%" >

            <table cellpadding="0" cellspacing="0">
                
                <tr width ="600px">
                    <td  height="26px" valign="middle" colspan="3" style="text-align: right;  ">
                <font  face="Arial" color="#9d9d9d"  size="2">Bolet&iacute;n Informativo <?php echo $fecha; ?>  </font>
                </td>
                </tr>
                <tr width ="600px">
                    <td width="10px" height="1200px"><img src="<?php echo base_url(); ?>resources/images/newsletter/fondo_izq.png" width="100%"/></td>
                    <td valign="top" height="1200px" width="330px" >
                        <div style="width: 100%;" >
                            <a href="<?php echo base_url(); ?>" ><img style="float: left;" alt="logo" src="<?php echo base_url(); ?>resources/images/newsletter/header_laspartes.png" /></a>
                        <a href="<?php echo base_url(); ?>aprende"><img style="float: left;" alt="aprende" src="<?php echo base_url(); ?>resources/images/newsletter/header_aprende_1.png"/></a>
                        <a href="<?php echo base_url(); ?>usuario"><img style="float: left;" alt="mi vehiculo" src="<?php echo base_url(); ?>resources/images/newsletter/header_mi_vehiculo_1.png"/></a>
                        </div>
                        <div style="clear: left;"></div>
                        <div style="display: block; padding-left: 15px;"><img  alt="automovil" src="<?php echo base_url(); ?>resources/images/newsletter/mi_vehiculo.png"/></div>
                        <div style="padding: 10px 10px 10px 5px;"><h1 style="font-family: HELVETICA; font-size: 18px; text-transform: uppercase;">Hola <?php echo  $nombre;?>,</h1></div>
                        <div style="padding-left: 5px; padding-right: 5px; font-family: HELVETICA; font-size: 12px; ">Según nuestros cálculos, tu carro <?php echo $marca." ".$linea;?><?php echo $numero_placa;?> debe tener <?php echo $kilometraje?> kms. 
                            <p>Por tanto debes hacer los siguiente mantenimientos:</p></div>
                       <div style="clear: left;"></div>
                       
                        <?php foreach ($tareas as $tarea): if($tarea->prioridad == 1 && $tarea->realizado != true):?>
                            <div style="text-align: justify;  padding: 10px 10px 10px 5px;">
                                <div style="text-transform: uppercase; font-family: HELVETICA; font-weight: bolder;font-size: 15px; color: #010101" ><?php echo $tarea->nombre; ?></div>
                                <div style="font-family: sans-serif;  font-size: 12px; color: #010101" ><span class ="mensaje"><?php echo $tarea->mensaje_dias_restantes; ?></span><span class ="numero"><?php echo $tarea->dias_restantes; ?></span><span> <?php echo $tarea->mensaje_dias_restantes2; ?></span></div>
                                <?php
                                if ($tarea->imagen_thumb_url):
                                    ?>
                                    <img width="100px" src="<?php echo base_url() . $tarea->imagen_thumb_url; ?>"  alt="imagen tarea" style="display:inline-block; float:left; padding: 10px 5px 10px 10px;"/>
                                    <?php
                                endif;
                                ?>
                                <p style=" font-family: sans-serif; font-size: 12px; color: #6f6b6b;" id="content_noticia">
                                    <?php
                                    if(isset($tarea->descripcion) && $tarea->descripcion != ""):
                                    $text = strip_tags($tarea->descripcion);
                                    $words = explode(" ", $text);
                                    $content = "";
                                    $i = 0;
                                    foreach ($words as $word) {
                                        if ($i == 40) {
                                            break;
                                        }
                                        if ($i) {
                                            $content .= " ";
                                        }
                                        $content .= $word;
                                        $i++;
                                    }
                                    echo $content . "…";
                                endif;
                                    ?>
                                </p>

                            </div>
                            <?php foreach ($ofertas[$tarea->id_servicio] as $oferta): ?>
                                <div style="text-transform: uppercase; font-family: HELVETICA; font-weight: bolder;font-size: 12px; color: #010101; border-bottom: 1px lightgrey solid">
                                    <p><?php echo $oferta->titulo;?><br/>
                                        <span>Precio: $<?php echo $oferta->precio;?></span>
                                    </p>   
                                    <div style="text-transform: lowercase; font-family: sans-serif; text-align: right; padding-right: 10px; font-weight: bold;font-size: 12px;  font-style: italic;"><a style="text-decoration: none; color: red;" href="<?php echo base_url() . 'usuario/registrate'; ?>">Ver más>></a></div>
                                </div>
                            <?php endforeach;?>
                            <div style=" font-family: sans-serif; text-align: right; padding-top: 5px; padding-right: 10px; font-weight: bold;font-size: 12px;  font-style: italic;"><a style="text-decoration: none; color: red;" href="<?php echo base_url() . 'establecimientos'; ?>">Talleres que ofrecen este servicio>></a></div>
                            <div><img src="<?php echo base_url() ?>resources/images/newsletter/linea_noticia.png"  width="250" style="padding-left: 20px;"/></div>

                        <?php endif; endforeach; ?>
                        
                    </td>
                    <td valign="top" height="1200px" width="150px" bgcolor="#f3f3f3">
                        <div style="height: 50px;"></div>
                        <div width="150px" style="
                             height: 30px;
                             color: white;
                             background-color: black;"><p style=" text-align: left; padding-bottom: 10px; padding-top: 11px;  padding-left: 7px; font-size: 11px; font-family: sans-serif; font-weight: bold;">PREGUNTAS</p>
                        </div>
                             <?php
                             foreach ($preguntas as $pregunta):
                                 ?>
                            <ul style=" padding-top: 8px;padding-left: 1em; text-align: justify; padding-right: 1em;">
                                <li style="font-size: 10px; font-family: sans-serif; color: #3d3d3d; ">
                                    <strong><?echo $pregunta->titulo_pregunta;?></strong><br/><br/>
                                    <?php
                                    $text = strip_tags($pregunta->cuerpo_pregunta);
                                    $words = explode(" ", $text);
                                    $content = "";
                                    $i = 0;
                                    foreach ($words as $word) {
                                        if ($i == 20) {
                                            break;
                                        }
                                        if ($i) {
                                            $content .= " ";
                                        }
                                        $content .= $word;
                                        $i++;
                                    }
                                    echo $content . "…";
                                    ?>
                                </li>
                            </ul>
                            <p style=" padding-right: 1em;font-size: 10px; font-family: sans-serif;" align="right"><a style="text-decoration: none; color: red;" href="<?php echo base_url() . 'taller_en_linea/ver_pregunta/' . $pregunta->id_pregunta; ?>">Leer más>></a></p>
                            <div><img align="left" style="padding-left: 15px; " width="120px" src="<?php echo base_url(); ?>/resources/images/newsletter/linea.png"/></div>
                            <?php
                        endforeach;
                        ?>
                            <div style="padding-top: 10px;padding-bottom: 10px; padding-left: 5px;">
                                <a href="<?php echo base_url();?>preguntas" style="border-style: none"><img  style="border-style: none" width ="140px" alt="preguntanos" src="<?php echo base_url();?>/resources/images/newsletter/envianos_preguntas_1.png"/></a>
                            </div>  
                        <div width="150px" style="
                             height: 30px;
                             color: white;
                             background-color: black;"><p style=" text-align: left; padding-top: 11px;  padding-left: 7px; font-size: 11px; font-family: sans-serif; font-weight: bold;">TIPS Y TUTORIALES</p>
                        </div>
<? foreach ($tip as $tips): ?>
                            <ul style=" padding-top: 8px; padding-left: 1em; text-align: justify; padding-right: 1em;">
                                <li style="font-size: 10px; font-family: sans-serif; color: #3d3d3d;">
                                    <strong><?echo $tips->titulo;?></strong><br/><br/>
                                    <?php
                                    $text = strip_tags($tips->tip);
                                    $words = explode(" ", $text);
                                    $content = "";
                                    $i = 0;
                                    foreach ($words as $word) {
                                        if ($i == 20) {
                                            break;
                                        }
                                        if ($i) {
                                            $content .= " ";
                                        }
                                        $content .= $word;
                                        $i++;
                                    }
                                    echo $content . "…";
                                    ?>
                                </li>
                            </ul> 
                            <p style=" padding-right: 1em;font-size: 10px; font-family: sans-serif;" align="right"><a style="text-decoration: none; color: red;" href="<?php echo base_url() . 'aprende/tip/' . $tips->id_tip; ?>">Leer más>></a></p>
                            <div><img align="left" style="padding-left: 15px; " width="120px" src="<?php echo base_url(); ?>/resources/images/newsletter/linea.png"/></div>
<? endforeach; ?>
                    </td>
                    <td width="10px" height="1200px"><img src="<?php echo base_url(); ?>resources/images/newsletter/fondo_der.png" width="100%"/></td>
                </tr>
                <tr width ="600px" >
                    <td colspan="4"  height="30" valign="middle" bgcolor="black" style=" color: white; text-align: center; font-family: sans-serif; font-size: 12px;">
                        Boletín informativo <a style="text-decoration: none; color: red;" href="www.laspartes.com">laspartes.com</a>, todos los derechos reservados
                    </td>
                </tr>
            </table>

        </div>
    </body>
</html>
