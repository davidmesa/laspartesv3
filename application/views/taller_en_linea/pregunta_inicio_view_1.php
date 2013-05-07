<tr>
    <td>
        <table width="970" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="20">&nbsp;</td>
                <td width="270" valign="top" class="box_fondo">
                    <table width="270" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td class="box_fondo"></td>
                            <td class="box_borde_sup" ></td>
                            <td class="box_esquina_sup_der" height="14"></td>
                        </tr>
                        <tr>
                            <td width="121" height="22" class="box_fondo box_titulo"><h1>CATEGOR&Iacute;AS</h1></td>
                            <td width="121" class="box_fondo_contenido">&nbsp;</td>
                            <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="3" class="general_separador_transparente"></td>
                                    </tr>
                                    <tr>
                                        <td width="6%" class="titulo_fondo_izq">&nbsp;</td>
                                        <td width="88%" class="titulo_fondo"><h2>Categorías</h2></td>
                                        <td width="6%" class="titulo_fondo_der">&nbsp;</td>
                                    </tr>
                                    <!-- Inicio categorías -->
                                    <tr>
                                        <td colspan="3" class="filtros_categoria"><h3><a href="<?php echo base_url(); ?>taller_en_linea/ver_preguntas/todas-las-categorias/<?php echo str_replace(' ', '-', convert_accented_characters($orden)); ?>/<?php echo $limit; ?>/0" class="filtros_categoria<?php if($categoria=='todas-las-categorias'){?>_selected<?php } ?>">Todas las categor&iacute;as</a></h3></td>
                                    </tr>
                                    <?php
                                    if($categoria!='todas-las-categorias'){
                                    ?>
                                    <tr>
                                        <td colspan="3" class="filtros_categoria"><h3><a href="<?php echo base_url(); ?>taller_en_linea/ver_preguntas/<?php echo str_replace(' ', '-', convert_accented_characters($categoria)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($orden)); ?>/<?php echo $limit; ?>/0" class="filtros_categoria_selected"><?php echo $categoria; ?></a></h3></td>
                                    </tr>
                                    <?php
                                    }
                                    else if(sizeof($preguntas_categorias)!=0){
                                        foreach($preguntas_categorias as $categoria_actual){ ?>
                                    <tr>
                                        <td colspan="3" class="filtros_categoria"><h3><a href="<?php echo base_url(); ?>taller_en_linea/ver_preguntas/<?php echo str_replace(' ', '-', convert_accented_characters($categoria_actual->nombre)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($orden)); ?>/<?php echo $limit; ?>/0"><?php echo $categoria_actual->nombre; ?> (<?php echo $categoria_actual->cantidad; ?>)</a></h3></td>
                                    </tr>
                                    <?php }
                                    } ?>
                                    <tr>
                                        <td colspan="3" class="general_separador_transparente"></td>
                                    </tr>
                                    <!-- Inicio marcas -->
                                </table></td>
                        </tr>
                        <tr>
                            <td height="14" class="box_esquina_inf_izq"></td>
                            <td colspan="2" class="box_borde_inf"></td>
                            <td class="box_esquina_inf_der"></td>
                        </tr>
                    </table>

                </td>
                <td width="660" valign="top" class="box_fondo">
                    <table width="660" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td class="box_fondo"></td>
                            <td class="box_borde_sup" ></td>
                            <td class="box_esquina_sup_der" height="14"></td>
                        </tr>
                        <tr>
                            <td width="125" height="22" class="box_fondo box_titulo"><h1>PREGUNTAS</h1></td>
                            <td width="507" class="box_fondo_contenido box_ordenamiento">&nbsp;</td>
                            <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido"><table border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="15" class="general_separador_transparente"></td>
                                        <td colspan="5"></td>
                                        <td width="15"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td width="15">&nbsp;</td>
                                        <td width="270">
                                            <b class="b1"></b>
                                            <b class="b2"></b>
                                            <b class="b3"></b>
                                            <b class="b4"></b>
                                            <b class="b5"></b>
                                            <b class="b6"></b>
                                            <div class="contentb">
                                                <div>
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td  colspan="4" align="center" valign="middle" height="5"></td>
                                                        </tr>
                                                        <tr>
                                                            <td rowspan="2" class="general_texto_centrado"><h3>Tu pregunta ser&aacute; respondida por nuestra comunidad de expertos en autopartes.</h3></td>
                                                            <td>&nbsp;</td>
                                                            <td align="center" valign="middle" ><a href="taller_en_linea/preguntar" class="tallerenlinea_btn_preguntar" title="Preguntar"><span></span></a></td>
                                                            <td align="center" valign="middle" >&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td class="general_link general_texto_centrado"><h3><a href="<?php echo base_url(); ?>taller_en_linea/preguntar">Preguntar</a></h3></td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td  colspan="4" align="center" valign="middle" height="5"></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <b class="b6"></b>
                                            <b class="b5"></b>
                                            <b class="b4"></b>
                                            <b class="b3"></b>
                                            <b class="b2"></b>
                                            <b class="b1"></b>
                                        </td>
                                        <td width="20">&nbsp;</td>
                                        <td width="282">
                                            <b class="b1"></b>
                                            <b class="b2"></b>
                                            <b class="b3"></b>
                                            <b class="b4"></b>
                                            <b class="b5"></b>
                                            <b class="b6"></b>
                                            <div class="contentb">
                                                <div>
                                                    <table border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td  colspan="4" align="center" valign="middle" height="5"></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="159" rowspan="2" class="general_texto_centrado"><h3>Comparte tu conocimiento y ayuda a otros miembros a resolver sus problemas con sus veh&iacute;culos.</h3></td>
                                                            <td width="16">&nbsp;</td>
                                                            <td width="88" align="center" valign="middle" ><a href="<?php echo base_url(); ?>preguntas" class="tallerenlinea_btn_responder" title="Preguntar"><span></span></a></td>
                                                            <td width="10" align="center" valign="middle" >&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td colspan="2" class="general_link" align="left"><h3><a href="<?php echo base_url(); ?>preguntas">Ver preguntas</a></h3></td>
                                                        </tr>
                                                        <tr>
                                                            <td  colspan="4" align="center" valign="middle" height="5"></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <b class="b6"></b>
                                            <b class="b5"></b>
                                            <b class="b4"></b>
                                            <b class="b3"></b>
                                            <b class="b2"></b>
                                            <b class="b1"></b>
                                        </td>
                                        <td width="15">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="5">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="5" align="left" class="general_link general_borde_inferior" style="padding-bottom:5px;"><h2><?php if($orden=='recientes'){ ?><b>Las 10 más recientes</b><?php } else { ?><a href="<?php echo base_url(); ?>taller_en_linea/index/<?php echo str_replace(' ', '-', convert_accented_characters($categoria)); ?>/recientes/<?php echo $limit; ?>/0">Las 10 más recientes</a><?php } ?> <strong>|</strong> <?php if($orden=='mas-respuestas'){ ?><b>Las 10 más respondidas</b><?php } else { ?><a href="<?php echo base_url(); ?>taller_en_linea/index/<?php echo str_replace(' ', '-', convert_accented_characters($categoria)); ?>/mas-respuestas/<?php echo $limit; ?>/0">Las 10 más respondidas</a><?php } ?></h2></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <?php $numero_pregunta = 0;
                                        if(sizeof($preguntas!=0)){
                                            foreach($preguntas as $pregunta){ ?>
                                        <tr>
                                            <td colspan="7" class="general_separador_transparente"></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td colspan="5">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td width="14%" rowspan="4" align="center" valign="middle" <?php if($numero_pregunta%2==0){ ?>class="general_fondo_impar"<?php } ?> style="padding:10px;">
                                                            <a href="<?php  
                                                            if(strlen($pregunta->thumb)>0):
                                                                echo base_url().'establecimientos/'.$pregunta->idEstablecimiento.'-'.$pregunta->nombreEstablecimiento;
                                                            else: echo base_url().'usuario';
                                                            endif;?>
                                                                ">
                                                                <img src="<?php if($pregunta->imagen_thumb_url!='' && $pregunta->imagen_thumb_url!=NULL){ echo base_url().$pregunta->imagen_thumb_url; } else if(strlen($pregunta->thumb)>0) {echo base_url().$pregunta->thumb; } else { echo base_url().'resources/images/usuarios/avatar_thumb.gif'; } ?>" width="63" height="70" alt="<?php echo $pregunta->usuario; ?>" /></a>
                                                            <div><h4><?php echo $pregunta->usuario;?></h4></div>
                                                        </td>
                                                        <td width="86%" class="general_link<?php if($numero_pregunta%2==0){ ?> general_fondo_impar<?php } ?>" align="left" valign="top" style="padding:5px;"><h2><a href="<?php echo base_url(); ?>preguntas/<?php echo $pregunta->id_pregunta; ?>-<?php echo str_replace(' ', '-', convert_accented_characters($pregunta->titulo_pregunta)); ?>"><?php echo $pregunta->titulo_pregunta; ?></a></h2></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="general_link<?php if($numero_pregunta%2==0){ ?> general_fondo_impar<?php } ?>" align="left" valign="top" ></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="general_link<?php if($numero_pregunta%2==0){ ?> general_fondo_impar<?php } ?>" align="left" valign="top" style="padding-left:5px;"><h3><?php echo character_limiter($pregunta->cuerpo_pregunta, 250); ?> <a href="<?php echo base_url(); ?>preguntas/<?php echo $pregunta->id_pregunta; ?>-<?php echo str_replace(' ', '-', convert_accented_characters($pregunta->titulo_pregunta)); ?>"> Ver más</a></h3></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="general_link<?php if($numero_pregunta%2==0){ ?> general_fondo_impar<?php } ?>" align="right" valign="bottom" style="padding:5px;" ><h4>Categoría: <a href="<?php echo base_url(); ?>taller_en_linea/ver_preguntas/<?php echo str_replace(' ', '-', convert_accented_characters($pregunta->pregunta_categoria)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($orden)); ?>/<?php echo $limit; ?>/0"><?php echo $pregunta->pregunta_categoria; ?></a> | Publicado hace <?php echo relative_time($pregunta->fecha); ?> | Respuestas: <?php echo $pregunta->numero_respuestas; ?></h4></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    <?php $numero_pregunta++;
                                        }
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
                </td>

                <td width="20">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5" class="general_separador_transparente"></td>
            </tr>
        </table>
    </td>
</tr>