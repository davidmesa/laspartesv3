<?php
// Verifica que hayan sido inicializados

$i = 0;
while($i < 14)
{
    if( !isset($indicadores[$i] ) )
    {
        $indicadores[$i] = (object) array(
            'nombre' => '',
            'valor' => ''
        );
    }
    $i++;
}

if(!isset ($noticias[0]))
    $noticias[0] = (object) array(
            'id_noticia' => 0,
            'titulo' => '',
            'noticia' => '',
            'imagen_thumb_url' => NULL,
            'imagen_url' => NULL,
            'me_gusta' => 0,
            'no_me_gusta' => 0,
            'fecha' => '',
            'numero_visitas' => 0,
            'estado' => 'Activo'
        );

if(!isset ($noticias[1]))
    $noticias[1] = (object) array(
            'id_noticia' => 0,
            'titulo' => '',
            'noticia' => '',
            'imagen_thumb_url' => NULL,
            'imagen_url' => NULL,
            'me_gusta' => 0,
            'no_me_gusta' => 0,
            'fecha' => '',
            'numero_visitas' => 0,
            'estado' => 'Activo'
        );

if(!isset ($noticias[2]))
    $noticias[2] = (object) array(
            'id_noticia' => 0,
            'titulo' => '',
            'noticia' => '',
            'imagen_thumb_url' => NULL,
            'imagen_url' => NULL,
            'me_gusta' => 0,
            'no_me_gusta' => 0,
            'fecha' => '',
            'numero_visitas' => 0,
            'estado' => 'Activo'
        );

if(!isset ($tutoriales[0]))
    $tutoriales[0] = (object) array(
            'id_tutorial' => 0,
            'titulo' => '',
            'resumen' => '',
            'tutorial' => '',
            'imagen_thumb_url' => NULL,
            'imagen_url' => NULL,
            'me_gusta' => 0,
            'no_me_gusta' => 0,
            'fecha' => '',
            'numero_visitas' => 0,
            'estado' => 'Activo'
        );

if(!isset ($tutoriales[1]))
    $tutoriales[1] = (object) array(
            'id_tutorial' => 0,
            'titulo' => '',
            'resumen' => '',
            'tutorial' => '',
            'imagen_thumb_url' => NULL,
            'imagen_url' => NULL,
            'me_gusta' => 0,
            'no_me_gusta' => 0,
            'fecha' => '',
            'numero_visitas' => 0,
            'estado' => 'Activo'
        );
?>

<tr>
    <td>
        <table width="969" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="20">&nbsp;</td>
                <td width="639" valign="top"><table width="639" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="400" height="290"><img src="<?php echo base_url(); ?>resources/images/aprende/home.gif" width="400" height="290" alt="Home aprende" /></td>
                            <td width="239" class="aprende_texto_home" align="left"><h2><strong>Aprenda</strong> todo sobre su veh&iacute;culo de manera f&aacute;cil junto a la comunidad de Laspartes.com. Lea los <strong>consejos y tips</strong> que har&aacute;n ver el m&aacute;ximo potencial de su veh&iacute;culo. Mant&eacute;ngase actualizado con las &uacute;ltimas <strong>noticias</strong> en el mercado de autopartes. Por &uacute;ltimo,<strong> h&aacute;galo usted mismo</strong>. Conozca c&oacute;mo usted puede reparar su veh&iacute;culo con tutoriales pr&aacute;cticos y sencillos. </h2></td>
                        </tr>
                    </table>
                    <table width="639" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="general_separador_transparente"></td>
                        </tr>
                        <tr>
                            <td>
                                <table width="639" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                                        <td class="box_fondo"></td>
                                        <td class="box_borde_sup" ></td>
                                        <td class="box_esquina_sup_der" height="14"></td>
                                    </tr>
                                    <tr>
                                        <td width="105" height="22" class="box_fondo box_titulo"><h1>NOTICIAS</h1></td>
                                        <td width="496" class="box_fondo_contenido general_link" align="right" style="padding-right:10px;"><h4><a href="<?php echo base_url(); ?>aprende/noticias">Ver m&aacute;s noticias</a></h4></td>
                                        <td width="24" rowspan="2" class="box_borde_der">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="box_borde_izq">&nbsp;</td>
                                        <td colspan="2" class="box_fondo_contenido"><table width="608" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td>
                                                        <table width="607" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td width="20" class="general_separador_transparente"></td>
                                                                <td width="283"></td>
                                                                <td width="284"></td>
                                                                <td width="20"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td colspan="2" align="right" style="padding-bottom:5px;" class="general_texto_secundario"><h5><strong>Publicada hace <?php echo relative_time($noticias[0]->fecha); ?></strong></h5></td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                            <?php if($noticias[0]->imagen_thumb_url != '' && $noticias[0]->imagen_thumb_url != NULL){ ?>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                    <td colspan="2" align="center" style="padding-bottom:5px;"><a href="<?php echo base_url(); ?>aprende/noticia/<?php echo $noticias[0]->id_noticia; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($noticias[0]->titulo)); ?>"><img src="<?php echo base_url().$noticias[0]->imagen_url; ?>" alt="<?php echo $noticias[0]->titulo; ?>" /></a></td>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                            <?php } ?>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td colspan="2" align="center" class="general_link tallerenlinea_texto_pregunta"><a href="<?php echo base_url(); ?>aprende/noticia/<?php echo $noticias[0]->id_noticia; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($noticias[0]->titulo)); ?>"><?php echo $noticias[0]->titulo; ?></a></td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td colspan="2" align="left" style="padding-top:10px;padding-bottom:5px;line-height:1.3;"><h2><?php echo character_limiter($noticias[0]->noticia, 450); ?></h2></td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td align="left" class="general_link general_borde_inferior general_texto_secundario" style="padding-bottom:5px;"><h5>&nbsp;</h5></td>
                                                                <td align="right" class="general_link general_borde_inferior" style="padding-bottom:5px;"><h4><a href="<?php echo base_url(); ?>aprende/noticia/<?php echo $noticias[0]->id_noticia; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($noticias[0]->titulo)); ?>">Leer completo</a></h4></td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table width="607" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td width="20">&nbsp;</td>
                                                                <td valign="top" width="273" class="general_link">
                                                                    <h5 style="padding-top:10px;padding-bottom:5px;" align="right" class="general_texto_secundario"><strong>Publicada hace <?php echo relative_time($noticias[1]->fecha); ?></strong></h5>
                                                                    <?php if($noticias[1]->imagen_thumb_url != '' && $noticias[1]->imagen_thumb_url != NULL){ ?><h2 style="margin-bottom:2px;" align="center"><a href="<?php echo base_url(); ?>aprende/noticia/<?php echo $noticias[1]->id_noticia; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($noticias[1]->titulo)); ?>"><img src="<?php echo base_url().$noticias[1]->imagen_thumb_url; ?>" width="250" height="150" alt="<?php echo $noticias[1]->titulo; ?>" /></a></h2><?php } ?>
                                                                    <h2 align="left"><a href="<?php echo base_url(); ?>aprende/noticia/<?php echo $noticias[1]->id_noticia; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($noticias[1]->titulo)); ?>"><?php echo $noticias[1]->titulo; ?></a></h2>
                                                                    <h3 align="left" style="line-height:1.3;margin-top:10px;"><?php echo character_limiter($noticias[1]->noticia, 250); ?></h3>
                                                                    <h4 align="right" style="padding-bottom:10px;"><a href="<?php echo base_url(); ?>aprende/noticia/<?php echo $noticias[1]->id_noticia; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($noticias[1]->titulo)); ?>">Leer completo.</a></h4>
                                                                </td>
                                                                <td width="20">&nbsp;</td>
                                                                <td width="274" valign="top" class="general_link" >
                                                                    <h5 style="padding-top:10px;padding-bottom:5px;" align="right" class="general_texto_secundario"><strong>Publicada hace <?php echo relative_time($noticias[2]->fecha); ?></strong></h5>
                                                                    <?php if($noticias[2]->imagen_thumb_url != '' && $noticias[2]->imagen_thumb_url != NULL){ ?><h2 style="margin-bottom:2px;" align="center"><a href="<?php echo base_url(); ?>aprende/noticia/<?php echo $noticias[2]->id_noticia; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($noticias[2]->titulo)); ?>"><img src="<?php echo base_url().$noticias[2]->imagen_thumb_url; ?>" width="250" height="150" alt="<?php echo $noticias[2]->titulo; ?>" /></a></h2><?php } ?>
                                                                    <h2 align="left"><a href="<?php echo base_url(); ?>aprende/noticia/<?php echo $noticias[2]->id_noticia; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($noticias[2]->titulo)); ?>"><?php echo $noticias[2]->titulo; ?></a></h2>
                                                                    <h3 align="left" style="line-height:1.3;margin-top:10px;"><?php echo character_limiter($noticias[2]->noticia, 350); ?></h3>
                                                                    <h4 align="right" style="padding-bottom:10px;"><a href="<?php echo base_url(); ?>aprende/noticia/<?php echo $noticias[2]->id_noticia; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($noticias[2]->titulo)); ?>">Leer completo.</a></h4>
                                                                </td>
                                                                <td width="20">&nbsp;</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="14" class="box_esquina_inf_izq"></td>
                                        <td colspan="2" class="box_borde_inf"></td>
                                        <td class="box_esquina_inf_der"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="20">&nbsp;</td>
                <td width="272" valign="top">
                    <table width="270" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td class="box_fondo"></td>
                            <td class="box_borde_sup" ></td>
                            <td class="box_esquina_sup_der" height="14"></td>
                        </tr>
                        <tr>
                            <td width="129" height="22" class="box_fondo box_titulo"><h1>REG&Iacute;STRATE</h1></td>
                            <td width="113" class="box_fondo_contenido general_link" align="right" style="padding-right:10px;"><h4>&nbsp;</h4></td>
                            <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido" align="left">
                                <h3 style="padding-left: 15px; padding-right: 15px; padding-top: 15px;"><strong>Aprende a hacerle el mantenimiento adecuado a tu carro!</strong></h3>
                                <img align="bottom" alt="Registro" src="<?php echo base_url(); ?>resources/images/iconos/mecanico.png" style="float: right; padding-right: 15px; padding-top: 15px; padding-bottom: 15px;" />
                                <h3 style="padding: 15px;">Reg&iacute;strate <a class="general_link" href="<?php echo base_url(); ?>usuario">aqu&iacute;</a> y nosotros te avisamos qué debes tener en cuenta, cuándo tienes que hacerlo, y quiénes pueden hacerle el adecuado mantenimiento a tu carro en tu ciudad.</h3>
                            </td>
                        </tr>
                        <tr>
                            <td height="14" class="box_esquina_inf_izq"></td>
                            <td colspan="2" class="box_borde_inf"></td>
                            <td class="box_esquina_inf_der"></td>
                        </tr>
                    </table>
                    <table width="270" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td class="box_fondo"></td>
                            <td class="box_borde_sup" ></td>
                            <td class="box_esquina_sup_der" height="14"></td>
                        </tr>
                        <tr>
                            <td width="139" height="22" class="box_fondo box_titulo"><h1>CONSEJOS Y TIPS</h1></td>
                            <td width="97" class="box_fondo_contenido general_link" align="right" style="padding-right:10px;"><h4><a href="<?php echo base_url(); ?>aprende/tips">Ver m&aacute;s tips</a></h4></td>
                            <td width="20" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">
                                <table width="238" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="16" class="general_separador_transparente"></td>
                                        <td width="210" class="general_separador_transparente"></td>
                                        <td width="10" class="general_separador_transparente"></td>
                                    </tr>
                                    <?php if(sizeof($tips)!=0){
                                        foreach($tips as $tip){ ?>
                                    <tr>
                                        <td class="general_link " align="left">&nbsp;</td>
                                        <td class="general_link " align="left"><h2><a href="<?php echo base_url(); ?>aprende/tip/<?php echo $tip->id_tip; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($tip->titulo)); ?>"><?php echo $tip->titulo; ?></a></h2></td>
                                        <td class="general_link " align="left">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="left" class=" general_texto_secundario">&nbsp;</td>
                                        <td align="right" class=" general_texto_secundario"><h4><strong>Publicado hace <?php echo relative_time($tip->fecha); ?></strong></h4></td>
                                        <td align="left" class=" general_texto_secundario">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="" align="right">&nbsp;</td>
                                        <td class="" align="right" style="padding-bottom:10px;"><h4><img src="<?php echo base_url(); ?>resources/images/iconos/megusta.gif" width="20" height="20" alt="Me gusta" /> A <strong><?php echo $tip->me_gusta; ?></strong> personas les gusta</h4></td>
                                        <td class="" align="right">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="general_separador_transparente"></td>
                                        <td class="general_separador_transparente_borde_sup2"></td>
                                        <td ></td>
                                    </tr>
                                    <?php }
                                    } ?>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td height="14" class="box_esquina_inf_izq"></td>
                            <td colspan="2" class="box_borde_inf"></td>
                            <td class="box_esquina_inf_der"></td>
                        </tr>
                    </table>
                    <table width="270" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td class="box_fondo"></td>
                            <td class="box_borde_sup" ></td>
                            <td class="box_esquina_sup_der" height="14"></td>
                        </tr>
                        <tr>
                            <td width="139" height="22" class="box_fondo box_titulo"><h1>INDICADORES</h1></td>
                            <td width="103" class="box_fondo_contenido">&nbsp;</td>
                            <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">
                                <table width="241" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="15" class="general_separador_transparente"></td>
                                        <td colspan="2"></td>
                                        <td width="15"></td> 
                                    </tr>
                                    <tr>
<!--                                        <td class="titulo_fondo_izq">&nbsp;</td>
                                        <td colspan="2" class="titulo_fondo"><h3>GASOLINA (GAL&Oacute;N)</h3></td>
                                        <td class="titulo_fondo_der">&nbsp;</td>-->
                                    </tr>
                                    <tr>
<!--                                        <td>&nbsp;</td>
                                        <td align="left"><h3><?php echo $indicadores[0]->nombre; ?></h3></td>
                                        <td align="right"><h3><?php echo $indicadores[0]->valor; ?></h3></td>
                                        <td>&nbsp;</td>-->
                                    </tr>
                                    <tr>
<!--                                        <td>&nbsp;</td>
                                        <td align="left"><h3><?php echo $indicadores[1]->nombre; ?></h3></td>
                                        <td align="right"><h3><?php echo $indicadores[1]->valor; ?></h3></td>
                                        <td>&nbsp;</td>-->
                                    </tr>
                                    <tr>
<!--                                        <td>&nbsp;</td>
                                        <td align="left" width="132"><h3><?php echo $indicadores[2]->nombre; ?></h3></td>
                                        <td width="79" align="right"><h3><?php echo $indicadores[2]->valor; ?></h3></td>
                                        <td>&nbsp;</td>-->
                                    </tr>
                                    <tr>
                                        <td class="general_separador_transparente"></td>
                                        <td width="132"></td>
                                        <td width="79" align="right"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
<!--                                        <td class="titulo_fondo_izq">&nbsp;</td>
                                        <td colspan="2" class="titulo_fondo"><h3>GAS NATURAL VEHICULAR (GNV)</h3></td>
                                        <td class="titulo_fondo_der">&nbsp;</td>-->
                                    </tr>
                                    <tr>
<!--                                        <td>&nbsp;</td>
                                        <td align="left"><h3><?php echo $indicadores[3]->nombre; ?></h3></td>
                                        <td align="right"><h3><?php // echo $indicadores[3]->valor; ?></h3></td>
                                        <td>&nbsp;</td>-->
                                    </tr>
                                    <tr>
                                        <td class="general_separador_transparente"></td>
                                        <td width="132"></td>
                                        <td width="79" align="right"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
<!--                                        <td class="titulo_fondo_izq">&nbsp;</td>
                                        <td colspan="2" class="titulo_fondo"><h3>ECONOMIC&Oacute;S</h3></td>
                                        <td class="titulo_fondo_der">&nbsp;</td>-->
                                    </tr>
                                    <tr>
<!--                                        <td>&nbsp;</td>
                                        <td align="left"><h3><?php echo $indicadores[4]->nombre; ?></h3></td>
                                        <td align="right"><h3><?php echo $indicadores[4]->valor; ?></h3></td>
                                        <td>&nbsp;</td>-->
                                    </tr>
                                    <tr>
<!--                                        <td>&nbsp;</td>
                                        <td align="left"><h3><?php echo $indicadores[5]->nombre; ?></h3></td>
                                        <td align="right"><h3><?php echo $indicadores[5]->valor; ?></h3></td>
                                        <td>&nbsp;</td>-->
                                    </tr>
                                    <tr>
<!--                                        <td>&nbsp;</td>
                                        <td align="left" width="132"><h3><?php echo $indicadores[6]->nombre; ?></h3></td>
                                        <td width="79" align="right"><h3><?php echo $indicadores[6]->valor; ?></h3></td>
                                        <td>&nbsp;</td>-->
                                    </tr>
                                    <tr>
<!--                                        <td>&nbsp;</td>
                                        <td align="left"><h3><?php echo $indicadores[7]->nombre; ?></h3></td>
                                        <td align="right"><h3><?php echo $indicadores[7]->valor; ?></h3></td>
                                        <td>&nbsp;</td>-->
                                    </tr>
                                    <tr>
<!--                                        <td>&nbsp;</td>
                                        <td align="left"><h3><?php echo $indicadores[8]->nombre; ?></h3></td>
                                        <td align="right"><h3><?php echo $indicadores[8]->valor; ?></h3></td>
                                        <td>&nbsp;</td>-->
                                    </tr>
                                    <tr>
<!--                                        <td>&nbsp;</td>
                                        <td align="left"><h3><?php echo $indicadores[9]->nombre; ?></h3></td>
                                        <td align="right"><h3><?php echo $indicadores[9]->valor; ?></h3></td>
                                        <td>&nbsp;</td>-->
                                    </tr>
                                    <tr>
<!--                                        <td>&nbsp;</td>
                                        <td align="left"><h3><?php echo $indicadores[10]->nombre; ?></h3></td>
                                        <td align="right"><h3><?php echo $indicadores[10]->valor; ?></h3></td>
                                        <td>&nbsp;</td>-->
                                    </tr>
                                    <tr>
<!--                                        <td>&nbsp;</td>
                                        <td align="left"><h3><?php echo $indicadores[11]->nombre; ?></h3></td>
                                        <td align="right"><h3><?php echo $indicadores[11]->valor; ?></h3></td>
                                        <td>&nbsp;</td>-->
                                    </tr>
                                    <tr>
<!--                                        <td>&nbsp;</td>
                                        <td align="left"><h3><?php echo $indicadores[12]->nombre; ?></h3></td>
                                        <td align="right"><h3><?php echo $indicadores[12]->valor; ?></h3></td>
                                        <td>&nbsp;</td>-->
                                    </tr>
                                    <tr>
<!--                                        <td>&nbsp;</td>
                                        <td align="left"><h3><?php echo $indicadores[13]->nombre; ?></h3></td>
                                        <td align="right"><h3><?php echo $indicadores[13]->valor; ?></h3></td>
                                        <td>&nbsp;</td>-->
                                    </tr>
                                    <tr>
                                        <td class="general_separador_transparente"></td>
                                        <td width="132"></td>
                                        <td width="79" align="right"></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td height="14" class="box_esquina_inf_izq"></td>
                            <td colspan="2" class="box_borde_inf"></td>
                            <td class="box_esquina_inf_der"></td>
                        </tr>
                    </table>
                </td>
                <td width="18">&nbsp;</td>
            </tr>
            <tr>
                <td class="general_separador_transparente"></td>
                <td valign="top"></td>
                <td></td>
                <td valign="top"></td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="3" valign="top">
                    <table width="930" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td class="box_fondo"></td>
                            <td class="box_borde_sup" ></td>
                            <td class="box_esquina_sup_der" height="14"></td>
                        </tr>
                        <tr>
                            <td width="172" height="22" class="box_fondo box_titulo"><h1>H&Aacute;GALO USTED MISMO</h1></td>
                            <td width="728" class="box_fondo_contenido general_link" align="right" style="padding-right:10px;"><h4><a href="<?php echo base_url(); ?>aprende/tutoriales">Ver m&aacute;s tutoriales</a></h4></td>
                            <td width="15" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">
                                <table width="900" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td class="general_separador_transparente"></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td valign="top"><table width="399" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td class="general_link" align="left" style="padding-left:10px;padding-right:10px;"><h2><a href="<?php echo base_url(); ?>aprende/tutorial/<?php echo $tutoriales[0]->id_tutorial; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($tutoriales[0]->titulo)); ?>"><?php echo $tutoriales[0]->titulo; ?></a></h2></td>
                                                </tr>
                                                <tr>
                                                    <td align="right" class="general_texto_secundario" style="padding-right:10px;"><h3><strong>Publicado hace <?php echo relative_time($tutoriales[0]->fecha); ?></strong></h3></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="padding:10px;"><h3><?php echo character_limiter($tutoriales[0]->resumen, 250); ?></h3></td>
                                                </tr>
                                                <tr>
                                                    <td align="right" class="general_link" style="padding-right:10px;"><h4><a href="<?php echo base_url(); ?>aprende/tutorial/<?php echo $tutoriales[0]->id_tutorial; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($tutoriales[0]->titulo)); ?>">Leer completo</a></h4></td>
                                                </tr>
                                            </table></td>
                                            <td valign="top" align="left" class="general_box_borde_derecho">
                                            <img src="<?php if($tutoriales[0]->imagen_url=='' || $tutoriales[0]->imagen_url==NULL){ echo base_url().'resources/images/aprende/noticia_1.gif'; } else { echo base_url().$tutoriales[0]->imagen_url; } ?>" width="180" height="120" alt="<?php echo $tutoriales[0]->titulo; ?>" />
                                        </td>
                                        <td valign="top">
                                            <table width="299" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td align="left" class="general_link" style="padding-left:10px;padding-right:10px;"><h2><a href="<?php echo base_url(); ?>aprende/tutorial/<?php echo $tutoriales[1]->id_tutorial; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($tutoriales[1]->titulo)); ?>"><?php echo $tutoriales[1]->titulo; ?></a></h2></td>
                                                </tr>
                                                <tr>
                                                    <td align="right" class="general_texto_secundario" style="padding-right:10px;"><h3><strong>Publicado hace <?php echo relative_time($tutoriales[1]->fecha); ?></strong></h3></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="padding:10px;"><h3><?php echo character_limiter($tutoriales[1]->resumen, 150); ?></h3></td>
                                                </tr>
                                                <tr>
                                                    <td class="general_link" align="right"><h4><a href="<?php echo base_url(); ?>aprende/tutorial/<?php echo $tutoriales[1]->id_tutorial; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($tutoriales[1]->titulo)); ?>">Leer completo</a></h4></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="400" class="general_separador_transparente"></td>
                                        <td width="200" ></td>
                                        <td width="300" ></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td height="14" class="box_esquina_inf_izq"></td>
                            <td colspan="2" class="box_borde_inf"></td>
                            <td class="box_esquina_inf_der"></td>
                        </tr>
                    </table>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="general_separador_transparente"></td>
                <td colspan="3" valign="top"></td>
                <td></td>
            </tr>
        </table>
    </td>
</tr>