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
                            <td width="507" class="box_fondo_contenido box_ordenamiento">Ordenar por <?php if($orden=='recientes'){ ?><b>Fecha</b><?php } else { ?><a href="<?php echo base_url(); ?>taller_en_linea/ver_preguntas/<?php echo str_replace(' ', '-', convert_accented_characters($categoria)); ?>/recientes/<?php echo $limit; ?>/0">Fecha</a><?php } ?> <strong>|</strong> <?php if($orden=='mas-respuestas'){ ?><b>Respuestas</b><?php } else { ?><a href="<?php echo base_url(); ?>taller_en_linea/ver_preguntas/<?php echo str_replace(' ', '-', convert_accented_characters($categoria)); ?>/mas-respuestas/<?php echo $limit; ?>/0">Respuestas</a><?php } ?> | <?php if($limit==10){ ?><b>10</b><?php } else { ?><a href="<?php echo base_url(); ?>taller_en_linea/ver_preguntas/<?php echo str_replace(' ', '-', convert_accented_characters($categoria)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($orden)); ?>/10/0">10</a><?php } ?> - <?php if($limit==25){ ?><b>25</b><?php } else { ?><a href="<?php echo base_url(); ?>taller_en_linea/ver_preguntas/<?php echo str_replace(' ', '-', convert_accented_characters($categoria)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($orden)); ?>/25/0">25</a><?php } ?> - <?php if($limit==50){ ?><b>50</b><?php } else { ?><a href="<?php echo base_url(); ?>taller_en_linea/ver_preguntas/<?php echo str_replace(' ', '-', convert_accented_characters($categoria)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($orden)); ?>/50/0">50</a><?php } ?> Resultados por página</td>
                            <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="7" class="general_separador_transparente"></td>
                                    </tr>
                                    <tr>
                                        <td width="15">&nbsp;</td>
                                        <td colspan="5" class="box_paginacion"><?php echo $this->pagination->create_links(); ?></td>
                                        <td width="15">&nbsp;</td>
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

                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="5" class="box_paginacion"><?php echo $this->pagination->create_links(); ?></td>
                                        <td>&nbsp;</td>
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

                <td width="20">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5" class="general_separador_transparente"></td>
            </tr>
        </table></td>
</tr>