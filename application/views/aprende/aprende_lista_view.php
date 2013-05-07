<tr>
    <td>
        <table width="969" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="20">&nbsp;</td>
                <td width="639" valign="top">
                    <table width="639" border="0" cellspacing="0" cellpadding="0">
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
                                        <td width="168" height="22" class="box_fondo box_titulo"><h1>BÚSQUEDA GENERAL</h1></td>
                                        <td width="443" class="box_fondo_contenido general_link" align="right" style="padding-right:10px;">
                                            <?php if($tab=='noticias'){ ?>
                                                <h4>Ordenar por <?php if($orden=='fecha'){ ?><b>Fecha</b><?php } else { ?><a href="<?php echo base_url(); ?>aprende/noticias/fecha/<?php echo $limit; ?>/0">Fecha</a><?php } ?> - <?php if($orden=='visitas'){ ?><b>Más visto</b><?php } else { ?><a href="<?php echo base_url(); ?>aprende/noticias/visitas/<?php echo $limit; ?>/0">Más vistas</a><?php } ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($limit==10){?><b>10</b><?php } else { ?><a href="<?php echo base_url(); ?>aprende/noticias/<?php echo $orden; ?>/10/0">10</a><?php } ?> - <?php if($limit==25){?><b>25</b><?php } else { ?><a href="<?php echo base_url(); ?>aprende/noticias/<?php echo $orden; ?>/25/0">25</a><?php } ?>  - <?php if($limit==50){?><b>50</b><?php } else { ?><a href="<?php echo base_url(); ?>aprende/noticias/<?php echo $orden; ?>/50/0">50</a><?php } ?> Resultados por página</h4>
                                            <?php } else if($tab=='tips'){ ?>
                                                <h4>Ordenar por <?php if($orden=='fecha'){ ?><b>Fecha</b><?php } else { ?><a href="<?php echo base_url(); ?>aprende/tips/fecha/<?php echo $limit; ?>/0">Fecha</a><?php } ?> - <?php if($orden=='visitas'){ ?><b>Más visto</b><?php } else { ?><a href="<?php echo base_url(); ?>aprende/tips/visitas/<?php echo $limit; ?>/0">Más vistas</a><?php } ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($limit==10){?><b>10</b><?php } else { ?><a href="<?php echo base_url(); ?>aprende/tips/<?php echo $orden; ?>/10/0">10</a><?php } ?> - <?php if($limit==25){?><b>25</b><?php } else { ?><a href="<?php echo base_url(); ?>aprende/tips/<?php echo $orden; ?>/25/0">25</a><?php } ?>  - <?php if($limit==50){?><b>50</b><?php } else { ?><a href="<?php echo base_url(); ?>aprende/tips/<?php echo $orden; ?>/50/0">50</a><?php } ?> Resultados por página</h4>
                                            <?php } else { ?>
                                                <h4>Ordenar por <?php if($orden=='fecha'){ ?><b>Fecha</b><?php } else { ?><a href="<?php echo base_url(); ?>aprende/tutoriales/fecha/<?php echo $limit; ?>/0">Fecha</a><?php } ?> - <?php if($orden=='visitas'){ ?><b>Más visto</b><?php } else { ?><a href="<?php echo base_url(); ?>aprende/tutoriales/visitas/<?php echo $limit; ?>/0">Más vistas</a><?php } ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($limit==10){?><b>10</b><?php } else { ?><a href="<?php echo base_url(); ?>aprende/tutoriales/<?php echo $orden; ?>/10/0">10</a><?php } ?> - <?php if($limit==25){?><b>25</b><?php } else { ?><a href="<?php echo base_url(); ?>aprende/tutoriales/<?php echo $orden; ?>/25/0">25</a><?php } ?>  - <?php if($limit==50){?><b>50</b><?php } else { ?><a href="<?php echo base_url(); ?>aprende/tutoriales/<?php echo $orden; ?>/50/0">50</a><?php } ?> Resultados por página</h4>
                                            <?php } ?>

                                        </td>
                                        <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="box_borde_izq">&nbsp;</td>
                                        <td colspan="2" class="box_fondo_contenido">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="3%">&nbsp;</td>
                                                    <td width="94%">
                                                        <table width="573" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td width="10" class="general_separador_transparente"></td>
                                                                <td width="120"></td>
                                                                <td width="12"></td>
                                                                <td width="153"></td>
                                                                <td width="12"></td>
                                                                <td width="138"></td>
                                                                <td width="6"></td>
                                                                <td width="63"></td>
                                                                <td width="10"></td>
                                                                <td width="49"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td colspan="9" class="general_texto_secundario" align="left" style="padding-bottom:10px;"><h3>Para ver los contenidos de otra sección, haga clic en la sección respectiva.</h3></td>
                                                            </tr>
                                                            <tr>
                                                                <?php if($tab=='noticias'){ ?>
                                                                    <td class="titulo_fondo_izq_selected">&nbsp;</td>
                                                                    <td class="titulo_fondo_selected"><h4>Noticias</h4></td>
                                                                    
                                                                <?php } else { ?>
                                                                    <td class="titulo_fondo_izq">&nbsp;</td>
                                                                    <td class="titulo_fondo_centrado general_link_blanco"><h4><a href="<?php echo base_url(); ?>aprende/noticias">Noticias</a></h4></td>
                                                                <?php } ?>

                                                                <?php if($tab=='noticias'){ ?>
                                                                    <td class="titulo_fondo_medio_negro_rojo">&nbsp;</td>
                                                                <?php } else if($tab=='tips'){ ?>
                                                                    <td class="titulo_fondo_medio_rojo_negro">&nbsp;</td>
                                                                <?php } else if($tab=='tutoriales'){ ?>
                                                                    <td class="titulo_fondo_medio_rojo_rojo">&nbsp;</td>
                                                                <?php } ?>
                                                                    
                                                                <?php if($tab=='tips'){ ?>
                                                                    <td class="titulo_fondo_selected"><h4>Tips</h4></td>
                                                                <?php } else { ?>
                                                                    <td class="titulo_fondo_centrado general_link_blanco"><h4><a href="<?php echo base_url(); ?>aprende/tips">Tips</a></h4></td>
                                                                <?php } ?>

                                                                <?php if($tab=='noticias'){ ?>
                                                                    <td class="titulo_fondo_medio_rojo_rojo">&nbsp;</td>
                                                                 <?php } else if($tab=='tips'){ ?>
                                                                    <td class="titulo_fondo_medio_negro_rojo">&nbsp;</td>
                                                                <?php } else if($tab=='tutoriales'){ ?>
                                                                    <td class="titulo_fondo_medio_rojo_negro">&nbsp;</td>
                                                                <?php } ?>

                                                                <?php if($tab=='tutoriales'){ ?>
                                                                    <td class="titulo_fondo_selected"><h4>Tutoriales</h4></td>
                                                                    <td  class="titulo_fondo_der_selected">&nbsp;</td>
                                                                <?php } else { ?>
                                                                    <td class="titulo_fondo_centrado general_link_blanco"><h4><a href="<?php echo base_url(); ?>aprende/tutoriales">Tutoriales</a></h4></td>
                                                                    <td  class="titulo_fondo_der">&nbsp;</td>
                                                                <?php } ?>
                                                                    
                                                                
                                                                <td><h4>&nbsp;</h4></td>
                                                                <td>&nbsp;</td>
                                                                <td><h4>&nbsp;</h4></td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td colspan="9" class="general_borde_inferior" height="10"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td colspan="9" class="box_paginacion"><?php echo $this->pagination->create_links(); ?></td>
                                                            </tr>
                                                            <?php $numero_resultado = 0;
                                                                if($tab=='noticias'){
                                                                    if(sizeof($noticias)!=0){
                                                                        foreach($noticias as $noticia){ ?>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td colspan="9" align="left" class="general_link <?php if($numero_resultado%2==0){ ?>box_fondo<?php } ?>" style="padding-bottom:5px;padding-left:10px;padding-right:10px;padding-top:5px;"><h3><a href="<?php echo base_url(); ?>aprende/noticia/<?php echo $noticia->id_noticia; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($noticia->titulo)); ?>"><?php echo $noticia->titulo; ?></a></h3></td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td colspan="9" style="padding-bottom:10px;padding-left:10px;padding-right:10px;" align="left" class="general_link <?php if($numero_resultado%2==0){ ?>box_fondo<?php } ?> general_texto_secundario"><h4><strong>Publicado el <?php echo real_date($noticia->fecha); ?></strong></h4></td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td colspan="9" style="padding-bottom:10px;padding-left:10px;padding-right:10px;" align="left" class="general_link <?php if($numero_resultado%2==0){ ?>box_fondo<?php } ?>"><h4><?php echo character_limiter($noticia->noticia, 200); ?> <a href="<?php echo base_url(); ?>aprende/noticia/<?php echo $noticia->id_noticia; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($noticia->titulo)); ?>">Ver más</a></h4></td>
                                                            </tr>
                                                            <?php $numero_resultado++;
                                                                    }
                                                                }
                                                            } ?>

                                                            <?php if($tab=='tips'){
                                                                if(sizeof($tips)!=0){
                                                                    foreach($tips as $tip){ ?>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td colspan="9" align="left" class="general_link <?php if($numero_resultado%2==0){ ?>box_fondo<?php } ?>" style="padding-bottom:5px;padding-left:10px;padding-right:10px;padding-top:5px;"><h3><a href="<?php echo base_url(); ?>aprende/tip/<?php echo $tip->id_tip; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($tip->titulo)); ?>"><?php echo $tip->titulo; ?></a></h3></td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td colspan="9" style="padding-bottom:10px;padding-left:10px;padding-right:10px;" align="left" class="general_link <?php if($numero_resultado%2==0){ ?>box_fondo<?php } ?> general_texto_secundario"><h4><strong>Publicado el <?php echo real_date($tip->fecha); ?></strong></h4></td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td colspan="9" style="padding-bottom:10px;padding-left:10px;padding-right:10px;" align="left" class="general_link <?php if($numero_resultado%2==0){ ?>box_fondo<?php } ?>"><h4><?php echo character_limiter($tip->tip, 200); ?> <a href="<?php echo base_url(); ?>aprende/tip/<?php echo $tip->id_tip; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($tip->titulo)); ?>">Ver más</a></h4></td>
                                                            </tr>
                                                            <?php $numero_resultado++;
                                                                    }
                                                                }
                                                            } ?>

                                                            <?php if($tab=='tutoriales'){
                                                                if(sizeof($tutoriales)!=0){
                                                                    foreach($tutoriales as $tutorial){ ?>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td colspan="9" align="left" class="general_link <?php if($numero_resultado%2==0){ ?>box_fondo<?php } ?>" style="padding-bottom:5px;padding-left:10px;padding-right:10px;padding-top:5px;"><h3><a href="<?php echo base_url(); ?>aprende/tutorial/<?php echo $tutorial->id_tutorial; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($tutorial->titulo)); ?>"><?php echo $tutorial->titulo; ?></a></h3></td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td colspan="9" style="padding-bottom:10px;padding-left:10px;padding-right:10px;" align="left" class="general_link <?php if($numero_resultado%2==0){ ?>box_fondo<?php } ?> general_texto_secundario"><h4><strong>Publicado el <?php echo real_date($tutorial->fecha); ?></strong></h4></td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td colspan="9" style="padding-bottom:10px;padding-left:10px;padding-right:10px;" align="left" class="general_link <?php if($numero_resultado%2==0){ ?>box_fondo<?php } ?>"><h4><?php echo character_limiter($tutorial->resumen, 200); ?> <a href="<?php echo base_url(); ?>aprende/tutorial/<?php echo $tutorial->id_tutorial; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($tutorial->titulo)); ?>">Ver más</a></h4></td>
                                                            </tr>
                                                            <?php $numero_resultado++;
                                                                    }
                                                                }
                                                            } ?>
                                                            
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td colspan="9" class="box_paginacion"><?php echo $this->pagination->create_links(); ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td width="3%">&nbsp;</td>
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
                <td width="22">&nbsp;</td>
                <td width="270" valign="top" align="right">
                    <table width="270" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td class="box_fondo"></td>
                            <td class="box_borde_sup" ></td>
                            <td class="box_esquina_sup_der" height="14"></td>
                        </tr>
                        <tr>
                            <td width="119" height="22" class="box_fondo box_titulo"><h1>PUBLICIDAD</h1></td>
                            <td width="123" class="box_fondo_contenido general_link" align="right" style="padding-right:10px;"><h4>&nbsp;</h4></td>
                            <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">&nbsp;</td>
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
        </table>
    </td>
</tr>