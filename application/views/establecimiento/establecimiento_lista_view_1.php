<tr>
    <td>
        <table width="970" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="20">&nbsp;</td>
                <td width="250" valign="top">
                    <table width="250" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td class="box_fondo"></td>
                            <td class="box_borde_sup" ></td>
                            <td class="box_esquina_sup_der" height="14"></td>
                        </tr>
                        <tr>
                            <td width="99" height="22" class="box_fondo box_titulo"><h1>REG&Iacute;STRATE</h1></td>
                            <td width="123" class="box_fondo_contenido general_link" align="right" style="padding-right:10px;"><h4>&nbsp;</h4></td>
                            <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido" align="left">
                                <h3 style="padding: 15px;"><strong>Encuentra el taller adecuado para tu carro!</strong></h3>
                                <img align="bottom" alt="Registro" src="<?php echo base_url(); ?>resources/images/iconos/mecanico.png" style="float: right; padding-right: 15px; padding-bottom: 25px;" />
                                <h3 style="padding: 15px;">Reg&iacute;strate <a class="general_link" href="<?php echo base_url(); ?>usuario">aqu&iacute;</a> y nosotros te avisamos qué debes tener en cuenta, cuándo tienes que hacerlo, y quiénes pueden hacerle el adecuado mantenimiento a tu carro en tu ciudad.</h3>
                            </td>
                        </tr>
                        <tr>
                            <td height="14" class="box_esquina_inf_izq"></td>
                            <td colspan="2" class="box_borde_inf"></td>
                            <td class="box_esquina_inf_der"></td>
                        </tr>
                    </table>
                    <table width="250" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td class="box_fondo"></td>
                            <td class="box_borde_sup" ></td>
                            <td class="box_esquina_sup_der" height="14"></td>
                        </tr>
                        <tr>
                            <td width="85" height="22" class="box_fondo box_titulo"><h1>FILTROS</h1></td>
                            <td width="137" >&nbsp;</td>
                            <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="3" class="general_separador_transparente"></td>
                                    </tr>
                                    <tr>
                                        <td width="6%" class="titulo_fondo_izq">&nbsp;</td>
                                        <td width="88%" class="titulo_fondo"><h2>Servicios</h2></td>
                                        <td width="6%" class="titulo_fondo_der">&nbsp;</td>
                                    </tr>
                                    <!-- Inicio categorías -->
                                    <tr>
                                        <td colspan="3" class="filtros_categoria"><h3><a href="<?php echo base_url(); ?>establecimientos/index/todos-los-servicios/<?php echo str_replace(' ', '-', convert_accented_characters($zona)); ?>/<?php echo $orden; ?>/<?php echo $limit; ?>/0" class="filtros_categoria<?php if($servicio=='todos-los-servicios'){?>_selected<?php } ?>">Todos los servicios</a></h3></td>
                                    </tr>
                                    <?php
                                    if($servicio!='todos-los-servicios'){
                                    ?>
                                    <tr>
                                        <td colspan="3" class="filtros_categoria"><h3><a href="<?php echo base_url(); ?>establecimientos/index/<?php echo str_replace(' ', '-', convert_accented_characters($servicio)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($zona)); ?>/<?php echo $orden; ?>/<?php echo $limit; ?>/0"><?php echo $servicio; ?></a></h3></td>
                                    </tr>
                                    <?php
                                    }
                                    else if(sizeof($servicios)!=0){
                                        foreach($servicios as $servicio_actual){ ?>
                                    <tr>
                                        <td colspan="3" class="filtros_categoria"><h3><a href="<?php echo base_url(); ?>establecimientos/index/<?php echo str_replace(' ', '-', convert_accented_characters($servicio_actual->nombre)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($zona)); ?>/<?php echo $orden; ?>/<?php echo $limit; ?>/0"><?php echo $servicio_actual->nombre; ?> (<?php echo $servicio_actual->cantidad; ?>)</a></h3></td>
                                    </tr>
                                    <?php }
                                    } ?>
                                    <tr>
                                        <td colspan="3" class="general_separador_transparente"></td>
                                    </tr>

                                    <tr>
                                        <td width="6%" class="titulo_fondo_izq">&nbsp;</td>
                                        <td width="88%" class="titulo_fondo"><h2>Zonas</h2></td>
                                        <td width="6%" class="titulo_fondo_der">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="filtros_categoria"><h3><a href="<?php echo base_url(); ?>establecimientos/index/<?php echo str_replace(' ', '-', convert_accented_characters($servicio)); ?>/todas-las-zonas/<?php echo $orden; ?>/<?php echo $limit; ?>/0" class="filtros_categoria<?php if($servicio=='todas-las-zonas'){?>_selected<?php } ?>">Todas las zonas</a></h3></td>
                                    </tr>
                                    <?php
                                    if($zona!='todas-las-zonas'){
                                    ?>
                                    <tr>
                                        <td colspan="3" class="filtros_categoria"><h3><a href="<?php echo base_url(); ?>establecimientos/index/<?php echo str_replace(' ', '-', convert_accented_characters($servicio)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($zona)); ?>/<?php echo $orden; ?>/<?php echo $limit; ?>/0"><?php echo str_replace('-', ' ', convert_accented_characters($zona)); ?></a></h3></td>
                                    </tr>
                                     <?php
                                    }
                                    else if(sizeof($zonas)!=0){
                                        foreach($zonas as $zona_actual){ ?>
                                    <tr>
                                        <td colspan="3" class="filtros_categoria"><h3><a href="<?php echo base_url(); ?>establecimientos/index/<?php echo str_replace(' ', '-', convert_accented_characters($servicio)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($zona_actual->nombre)); ?>/<?php echo $orden; ?>/<?php echo $limit; ?>/0"><?php echo $zona_actual->nombre; ?> (<?php echo $zona_actual->cantidad; ?>)</a></h3></td>
                                    </tr>
                                    <?php }
                                    } ?>
                                    <tr>
                                        <td colspan="3" class="general_separador_transparente"></td>
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
                <td width="660" valign="top">
                    <table width="660" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td class="box_fondo"></td>
                            <td class="box_borde_sup" ></td>
                            <td class="box_esquina_sup_der" height="14" width="14"></td>
                        </tr>
                        <tr>
                            <td width="149" height="22" class="box_fondo box_titulo"><h1>ESTABLECIMIENTOS</h1></td>
                            <td width="483" class="box_ordenamiento">Ordenar por <?php if($orden=='nombre'){ ?><b>Nombre</b><?php } else { ?><a href="<?php echo base_url(); ?>establecimientos/index/<?php echo str_replace(' ', '-', convert_accented_characters($servicio)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($zona)); ?>/nombre/<?php echo $limit; ?>/0">Nombre</a><?php } ?> - <?php if($orden=='zona'){ ?><b>Zona</b><?php } else { ?><a href="<?php echo base_url(); ?>establecimientos/index/<?php echo str_replace(' ', '-', convert_accented_characters($servicio)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($zona)); ?>/zona/<?php echo $limit; ?>/0">Zona</a><?php } ?> | <?php if($limit==10){?><b>10</b><?php } else { ?><a href="<?php echo base_url(); ?>establecimientos/index/<?php echo str_replace(' ', '-', convert_accented_characters($servicio)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($zona)); ?>/<?php echo $orden; ?>/10/0">10</a><?php } ?> - <?php if($limit==25){?><b>25</b><?php } else { ?><a href="<?php echo base_url(); ?>establecimientos/index/<?php echo str_replace(' ', '-', convert_accented_characters($servicio)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($zona)); ?>/<?php echo $orden; ?>/25/0">25</a><?php } ?> - <?php if($limit==50){ ?><b>50</b><?php } else { ?><a href="<?php echo base_url(); ?>establecimientos/index/<?php echo str_replace(' ', '-', convert_accented_characters($servicio)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($zona)); ?>/<?php echo $orden; ?>/50/0">50</a><?php } ?> Resultados por página</td>
                            <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="3" class="box_paginacion"><?php echo $this->pagination->create_links(); ?></td>
                                    </tr>
                                    <?php if(sizeof($establecimientos)!=0){
                                        $contador = 0;
                                        foreach($establecimientos as $establecimiento){ ?>
                                    <tr>
                                        <td width="3%">&nbsp;</td>
                                        <td width="94%">
                                            <table border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="180" rowspan="3" align="center" valign="middle" class="listado_autopartes<?php if($contador%2==0){ ?>_selected<?php } ?>">
                                                        <a href="<?php echo base_url(); ?>establecimientos/<?php echo $establecimiento->id_establecimiento; ?>-<?php echo str_replace(' ', '-', convert_accented_characters($establecimiento->nombre)); ?>">
                                                            <img src="<?php if($establecimiento->logo_thumb_url==''||$establecimiento->logo_thumb_url==NULL){ echo base_url().'resources/images/establecimientos/tmpl_logo_establecimiento_thumb_nd.gif'; } else { echo base_url().$establecimiento->logo_thumb_url; } ?>" alt="<?php echo $establecimiento->nombre; ?>" />
                                                        </a>
                                                    </td>
                                                    <td width="305" class="general_link listado_autopartes<?php if($contador%2==0){ ?>_selected<?php } ?>" align="left">
                                                        <h3><a href="<?php echo base_url(); ?>establecimientos/<?php echo $establecimiento->id_establecimiento; ?>-<?php echo str_replace(' ', '-', convert_accented_characters($establecimiento->nombre)); ?>"><?php echo $establecimiento->nombre; ?></a></h3>
                                                    </td>
                                                    <td width="110" rowspan="3" valign="middle" align="center" class="general_link listado_autopartes<?php if($contador%2==0){ ?>_selected<?php } ?>">
                                                        <a href="<?php echo base_url(); ?>establecimientos/<?php echo $establecimiento->id_establecimiento; ?>-<?php echo str_replace(' ', '-', convert_accented_characters($establecimiento->nombre)); ?>"><input type="submit" width="120" class="listado_establecimientos_btn_detalle" value="Ir al sitio"></a></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="middle" class="listado_autopartes<?php if($contador%2==0){ ?>_selected<?php } ?> general_link">
                                                        <h5><strong>Direcci&oacute;n: </strong><?php echo $establecimiento->direccion; ?></h5>
                                                        <h5><strong>Descripci&oacute;n: </strong>
                                                            <?php echo $establecimiento->descripcion; ?>
                                                            <a href="<?php echo base_url(); ?>establecimientos/<?php echo $establecimiento->id_establecimiento; ?>-<?php echo str_replace(' ', '-', convert_accented_characters($establecimiento->nombre)); ?>">Ver más</a></h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="general_link listado_autopartes<?php if($contador%2==0){ ?>_selected<?php } ?>">

                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td width="3%">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="general_separador_transparente"></td>
                                    </tr>
                                    <?php $contador++;
                                        }
                                    }?>
                                    <tr>
                                        <td colspan="3" class="box_paginacion"><?php echo $this->pagination->create_links(); ?></td>
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
        </table>
    </td>
</tr>