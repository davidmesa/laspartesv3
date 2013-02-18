<tr>
    <td>
        <table width="970" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>&nbsp;</td>
                <td colspan="2" valign="top" class="box_fondo">
                    <table width="930" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td class="box_fondo"></td>
                            <td class="box_borde_sup" ></td>
                            <td class="box_esquina_sup_der" height="14"></td>
                        </tr>
                        <tr>
                            <td width="133" height="22" class="box_fondo box_titulo"><h1>AUTOPARTE</h1></td>
                            <td width="769" class="box_fondo_contenido">&nbsp;</td>
                            <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="6" class="general_separador_transparente"></td>
                                    </tr>
                                    <tr>
                                        <td width="1%">&nbsp;</td>
                                        <td width="1%" class="titulo_fondo_izq">&nbsp;</td>
                                        <td colspan="3" class="titulo_fondo"><h3><?php echo $autoparte->nombre; ?></h3></td>
                                        <td width="2%" class="titulo_fondo_der">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="20" colspan="6" class="general_separador_transparente"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td width="22%" class="autoparte_descripcion" valign="top"><img src="<?php if($autoparte->imagen_thumb_url==''||$autoparte->imagen_thumb_url==NULL){ echo base_url().'resources/images/template/logos/laspartes110x67.gif'; } else { echo $autoparte->imagen_url; } ?>" width="173" height="120" alt="<?php echo $autoparte->nombre; ?>" /></td>
                                        <td width="2%">&nbsp;</td>
                                        <td width="72%" class="autoparte_descripcion" align="left">
                                            <h2><strong>Precio:</strong> <span class="general_texto_importante">Entre $<?php echo number_format($rango_precios->precio_minimo,0,',','.'); ?> y $<?php echo number_format($rango_precios->precio_maximo,0,',','.'); ?></span></h2>
                                            <br />
                                            <h3 style="line-height: 20px;"><strong>Marca:</strong><?php echo $autoparte->marca; ?><br />
                                                <strong>Referencia: </strong><?php echo $autoparte->referencia; ?><br />
                                                <strong>Veh&iacute;culos: </strong>
                                                <?php
                                                    $texto = '';
                                                    foreach( $autoparte_vehiculos as $autoparte_vehiculo )
                                                    {
                                                        $texto.= $autoparte_vehiculo->marca.' '.$autoparte_vehiculo->linea.', ' ;
                                                    }
                                                    echo substr($texto, 0, strlen($texto)-2);
                                                ?>
                                                <br />
                                                <strong>Descripci&oacute;n:</strong> <?php echo $autoparte->descripcion; ?></h3>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="general_separador_transparente"></td>
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
                <td width="20">&nbsp;</td>
                <td width="660" valign="top" class="box_fondo">
                    <table width="660" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td class="box_fondo"></td>
                            <td class="box_borde_sup" ></td>
                            <td class="box_esquina_sup_der" height="14"></td>
                        </tr>
                        <tr>
                            <td width="125" height="22" class="box_fondo box_titulo"><h1>PRECIOS</h1></td>
                            <td width="507" class="box_fondo_contenido box_ordenamiento">Ordenar por <?php if($orden=='nombre'){ ?><strong>Nombre</strong><?php }else{?><a href="<?php echo base_url(); ?>autopartes/<?php echo $autoparte->id_autoparte; ?>_<?php echo str_replace(' ', '-', convert_accented_characters($autoparte->nombre)); ?>_nombre">Nombre</a><?php } ?> - <?php if($orden=='precio'){ ?><strong>Precio</strong><?php }else{?><a href="<?php echo base_url(); ?>autopartes/<?php echo $autoparte->id_autoparte; ?>_<?php echo str_replace(' ', '-', convert_accented_characters($autoparte->nombre)); ?>_precio">Precio</a><?php } ?> - <?php if($orden=='establecimientos.id_zona'){ ?><strong>Zona</strong><?php }else{?><a href="<?php echo base_url(); ?>autopartes/<?php echo $autoparte->id_autoparte; ?>_<?php echo str_replace(' ', '-', convert_accented_characters($autoparte->nombre)); ?>_zona">Zona</a><?php } ?></td>
                            <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="10" class="general_separador_transparente"></td>
                                    </tr>
                                    <tr>
                                        <td width="2%">&nbsp;</td>
                                        <td width="2%" class="titulo_fondo_izq">&nbsp;</td>
                                        <td width="41%" class="titulo_fondo"><h3>Establecimiento</h3></td>
                                        <td width="1%">&nbsp;</td>
                                        <td width="18%" class="titulo_fondo"><h3>Zona</h3></td>
                                        <td width="1%">&nbsp;</td>
                                        <td colspan="2" class="titulo_fondo"><h3>Precio</h3></td>
                                        <td width="2%" class="titulo_fondo_der">&nbsp;</td>
                                        <td width="2%">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="10" class="general_separador_transparente"></td>
                                    </tr>
                                    <?php if(sizeof($establecimientos)){
                                    foreach($establecimientos as $establecimiento){ ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td align="left"><h3><?php echo $establecimiento->nombre; ?></h3></td>
                                        <td>&nbsp;</td>
                                        <td align="left"><h3><?php echo $establecimiento->zona; ?></h3></td>
                                        <td>&nbsp;</td>
                                        <td align="left" width="18%" class="autoparte_establecimientos_precio">
                                            <input type="submit" class="listado_autopartes_btn_compra" value="<?php if($establecimiento->precio!=0){ echo number_format($establecimiento->precio,0,',','.'); } else { echo 'No Disp.'; } ?>" />
                                        </td>
                                        <td width="13%" class="general_link autoparte_establecimientos_precio">
                                            <?php if($establecimiento->precio!=0){ ?>
                                                <?php echo form_open('usuario/agregar_carrito_compras'); ?>
                                                    <input type="hidden" name="id_autoparte" value="<?php echo $autoparte->id_autoparte; ?>" />
                                                    <input type="hidden" name="id_establecimiento" value="<?php echo $establecimiento->id_establecimiento; ?>" />
                                                    <input type="submit" class="boton_link" value="Comprar" />
                                                <?php echo form_close(); ?>
                                            <?php } ?>
                                        </td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <?php }
                                    } ?>
                                    <tr>
                                        <td colspan="10" class="general_separador_transparente"></td>
                                    </tr>
                                </table></td>
                        </tr>
                        <tr>
                            <td height="14" class="box_esquina_inf_izq"></td>
                            <td colspan="2" class="box_borde_inf"></td>
                            <td class="box_esquina_inf_der"></td>
                        </tr>
                    </table>
                </td>
                <td width="270" valign="top" class="box_fondo"><table width="270" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td class="box_fondo"></td>
                            <td class="box_borde_sup" ></td>
                            <td class="box_esquina_sup_der" height="14"></td>
                        </tr>
                        <tr>
                            <td width="121" height="22" class="box_fondo box_titulo"><h1>REG&Iacute;STRATE</h1></td>
                            <td width="121" class="box_fondo_contenido">&nbsp;</td>
                            <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">
                                <h3 style="padding: 15px;"><strong>¿Te gustaría que Laspartes.com te ayude con el mantenimiento de tu carro?</strong></h3>
                                <img align="bottom" alt="Registro" src="<?php echo base_url(); ?>resources/images/iconos/mecanico.png" style="float: right; padding-right: 15px; padding-bottom: 20px;" />
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
                <td width="20">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5" class="general_separador_transparente"></td>
            </tr>
        </table></td>
</tr>
<tr>
    <td class="borde_superior"></td>
</tr>