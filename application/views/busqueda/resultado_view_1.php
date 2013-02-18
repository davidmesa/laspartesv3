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
                                        <td width="443" class="box_fondo_contenido general_link" align="right" style="padding-right:10px;"><h4><?php if($limit==10){?><b>10</b><?php } else { ?><a href="<?php echo base_url();?>buscar/<?php echo $seccion; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($busqueda)); ?>/10/0">10</a><?php } ?> - <?php if($limit==25){?><b>25</b><?php } else { ?><a href="<?php echo base_url();?>buscar/<?php echo $seccion; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($busqueda)); ?>/25/0">25</a><?php } ?> - <?php if($limit==50){?><b>50</b><?php } else { ?><a href="<?php echo base_url();?>buscar/<?php echo $seccion; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($busqueda)); ?>/50/0">50</a><?php } ?> Resultados por página</h4></td>
                                        <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="box_borde_izq">&nbsp;</td>
                                        <td colspan="2" class="box_fondo_contenido">
                                            <table width="610" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="17" class="general_separador_transparente"></td>
                                                    <td width="144"></td>
                                                    <td width="12"></td>
                                                    <td width="118"></td>
                                                    <td width="12"></td>
                                                    <td width="86"></td>
                                                    <td width="12"></td>
                                                    <td width="100"></td>
                                                    <td width="12"></td>
                                                    <td width="77"></td>
                                                    <td width="20"></td>
                                                </tr>
                                                <tr>
                                                    <td width="17">&nbsp;</td>
                                                    <td colspan="9" class="general_texto_secundario" align="left" style="padding-bottom:10px;"><h3>Para obtener resultados especificos de una sección, haga clic en la sección respectiva.</h3></td>
                                                    <td width="20">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td class="<?php if($seccion=='general'){ echo 'titulo_fondo_izq_selected'; } else { echo 'titulo_fondo_izq'; } ?>">&nbsp;</td>
                                                    <td class="titulo_fondo_<?php if($seccion=='general'){ echo 'selected'; } else { echo 'centrado general_link_blanco'; } ?>"><h4><?php if($seccion!='general'){ ?><a href="<?php echo base_url(); ?>buscar/general/<?php echo str_replace(' ', '-', convert_accented_characters($busqueda)); ?>/<?php echo $limit; ?>/0"><?php } ?>Todos los resultados<?php if($seccion!='general'){ ?></a><?php } ?></h4></td>
                                                    <td class="<?php if($seccion=='general'){ echo 'titulo_fondo_medio_negro_rojo'; } else if($seccion=='establecimientos'){ echo 'titulo_fondo_medio_rojo_negro'; } else { echo 'titulo_fondo_medio_rojo_rojo'; } ?>"">&nbsp;</td>
                                                    <td class="titulo_fondo_<?php if($seccion=='establecimientos'){ echo 'selected'; } else { echo 'centrado general_link_blanco'; } ?>"><h4><?php if($seccion!='establecimientos'){ ?><a href="<?php echo base_url(); ?>buscar/establecimientos/<?php echo str_replace(' ', '-', convert_accented_characters($busqueda)); ?>/<?php echo $limit; ?>/0"><?php } ?>Establecimientos<?php if($seccion!='establecimientos'){ ?></a><?php } ?></h4></td>
                                                    <td class="<?php if($seccion=='establecimientos'){ echo 'titulo_fondo_medio_negro_rojo'; } else if($seccion=='autopartes'){ echo 'titulo_fondo_medio_rojo_negro'; } else { echo 'titulo_fondo_medio_rojo_rojo'; } ?>">&nbsp;</td>
                                                    <td class="titulo_fondo_<?php if($seccion=='autopartes'){ echo 'selected'; } else { echo 'centrado general_link_blanco'; } ?>"><h4><?php if($seccion!='autopartes'){ ?><a href="<?php echo base_url(); ?>buscar/autopartes/<?php echo str_replace(' ', '-', convert_accented_characters($busqueda)); ?>/<?php echo $limit; ?>/0"><?php } ?>Autopartes<?php if($seccion!='autopartes'){ ?></a><?php } ?></h4></td>
                                                    <td class="<?php if($seccion=='autopartes'){ echo 'titulo_fondo_medio_negro_rojo'; } else if($seccion=='taller_en_linea'){ echo 'titulo_fondo_medio_rojo_negro'; } else { echo 'titulo_fondo_medio_rojo_rojo'; } ?>">&nbsp;</td>
                                                    <td class="titulo_fondo_<?php if($seccion=='taller_en_linea'){ echo 'selected'; } else { echo 'centrado general_link_blanco'; } ?>"><h4><?php if($seccion!='taller_en_linea'){ ?><a href="<?php echo base_url(); ?>buscar/taller_en_linea/<?php echo str_replace(' ', '-', convert_accented_characters($busqueda)); ?>/<?php echo $limit; ?>/0"><?php } ?>Taller en línea<?php if($seccion!='taller_en_linea'){ ?></a><?php } ?></h4></td>
                                                    <td class="<?php if($seccion=='taller_en_linea'){ echo 'titulo_fondo_medio_negro_rojo'; } else if($seccion=='aprende'){ echo 'titulo_fondo_medio_rojo_negro'; } else { echo 'titulo_fondo_medio_rojo_rojo'; } ?>">&nbsp;</td>
                                                    <td class="titulo_fondo_<?php if($seccion=='aprende'){ echo 'selected'; } else { echo 'centrado general_link_blanco'; } ?>"><h4><?php if($seccion!='aprende'){ ?><a href="<?php echo base_url(); ?>buscar/aprende/<?php echo str_replace(' ', '-', convert_accented_characters($busqueda)); ?>/<?php echo $limit; ?>/0"><?php } ?>Aprende<?php if($seccion!='aprende'){ ?></a><?php } ?></h4></td>
                                                    <td class="<?php if($seccion=='aprende'){ echo 'titulo_fondo_der_selected'; } else { echo 'titulo_fondo_der'; } ?>">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td colspan="9" class="general_borde_inferior" height="10"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td colspan="9" class="box_paginacion"><?php echo $this->pagination->create_links(); ?></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <?php $numero_resultado = 0;
                                                    if(sizeof($resultados)!=0){
                                                    foreach($resultados as $resultado){ ?>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="9" align="left" class="general_link <?php if($numero_resultado%2==0){ ?>box_fondo<?php } ?>" style="padding-bottom:5px;padding-left:10px;padding-right:10px;padding-top:5px;"><h3><a href="<?php echo base_url().$resultado->url; ?>"><?php echo $resultado->titulo; ?></a></h3></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="9" style="padding-bottom:10px;padding-left:10px;padding-right:10px;" align="left" class="general_link <?php if($numero_resultado%2==0){ ?>box_fondo<?php } ?>"><h4><?php echo character_limiter($resultado->resumen, 200); ?> <a href="<?php echo base_url().$resultado->url; ?>">Ver más</a></h4></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="9" align="right" style="padding-bottom:5px;padding-right:10px;" class="<?php if($numero_resultado%2==0){ ?>box_fondo<?php } ?>"><h4>Encontrado en <strong><?php echo $resultado->seccion; ?></strong></h4></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                <?php $numero_resultado++;
                                                    }
                                                } ?>

                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td colspan="9" class="box_paginacion"><?php echo $this->pagination->create_links(); ?></td>
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
                            <td width="119" height="22" class="box_fondo box_titulo"><h1>REG&Iacute;STRATE</h1></td>
                            <td width="123" class="box_fondo_contenido general_link" align="right" style="padding-right:10px;"><h4>&nbsp;</h4></td>
                            <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">
                                <h3 style="padding: 15px;"><strong>¿Te gustaría que Laspartes.com te asesore con el mantenimiento de tu vehículo?</strong></h3>
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