<tr>
    <td align="center" valign="middle">
        <table width="970" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="290" valign="top" align="center">
                    <table width="280" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td class="box_fondo"></td>
                            <td class="box_borde_sup" ></td>
                            <td class="box_esquina_sup_der" height="14"></td>
                        </tr>
                        <tr>
                            <td width="129" height="22" class="box_fondo box_titulo"><h1>REG&Iacute;STRATE</h1></td>
                            <td width="123" class="box_fondo_contenido general_link" align="right" style="padding-right:10px;"><h4>&nbsp;</h4></td>
                            <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido" align="left">
                                <h3 style="padding: 15px;"><strong>Encuentra las autopartes adecuadas para carro!</strong></h3>
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
                    <table width="280" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td class="box_fondo"></td>
                            <td class="box_borde_sup" ></td>
                            <td class="box_esquina_sup_der" height="14"></td>
                        </tr>
                      <tr>
                            <td width="90" height="22" class="box_fondo box_titulo"><h1>FILTROS</h1></td>
                            <td width="161" class="box_ordenamiento">&nbsp;</td>
                            <td width="15" rowspan="2" class="box_borde_der">&nbsp;</td>
                      </tr>
                      <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2">
                                <table width="250px" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="3" class="general_separador_transparente"></td>
                                    </tr>

                                    <tr>
                                        <td width="15" class="titulo_fondo_izq"></td>
                                        <td width="220" class="titulo_fondo"><h2>Por marca de veh&iacute;culo</h2></td>
                                        <td width="15" class="titulo_fondo_der"></td>
                                    </tr>
                                     <!-- Inicio marcas de vehículos -->
                                    <tr>
                                        <td colspan="3" class="filtros_categoria">
                                            <div class="ui-widget">
                                                <h3>Seleccione la marca: <br/>
                                                    <select id="combobox-marcas">
                                                        <option value="todas-las-marcas">Todas</option>
                                                        <?php
                                                            foreach( $marcas_vehiculos as $marca_veh ) {
                                                                if( $marca_veh->marca == $marca_vehiculo )
                                                                {
                                                        ?>
                                                        <option selected="selected" value="<?php echo str_replace(' ', '-', convert_accented_characters($marca_veh->marca)); ?>"><?php echo $marca_veh->marca; ?></option>
                                                        <?php
                                                                }
                                                                else
                                                                {

                                                        ?>
                                                        <option value="<?php echo $marca_veh->marca; ?>"><?php echo $marca_veh->marca; ?></option>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </h3>
                                                <?php
                                                    if( $marca_vehiculo != 'todas-las-marcas' ) {
                                                ?>
                                                    <h3>Seleccione la l&iacute;nea: <br/>
                                                        <select id="combobox-lineas">
                                                            <option value="todas-las-lineas">Todos</option>
                                                            <?php
                                                                foreach( $lineas_vehiculos as $linea_veh ) {
                                                                    if( $linea_veh->linea == $linea_vehiculo )
                                                                    {
                                                            ?>
                                                            <option selected="selected" value="<?php echo str_replace(' ', '-', convert_accented_characters($linea_veh->linea)); ?>"><?php echo $linea_veh->linea; ?></option>
                                                            <?php
                                                                    }
                                                                    else
                                                                    {

                                                            ?>
                                                            <option value="<?php echo str_replace(' ', '-', convert_accented_characters($linea_veh->linea)) ?>"><?php echo $linea_veh->linea; ?></option>
                                                            <?php
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                    </h3>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="3" class="general_separador_transparente"></td>
                                    </tr>

                                    <tr>
                                        <td width="15" class="titulo_fondo_izq"></td>
                                        <td width="220" class="titulo_fondo"><h2>Por categor&iacute;as</h2></td>
                                        <td width="15" class="titulo_fondo_der"></td>
                                    </tr>
                                     <!-- Inicio categorías -->
                                    <tr>
                                        <td colspan="3" class="filtros_categoria"><h3><a href="<?php echo base_url(); ?>autopartes/index/todas-las-categorias/<?php echo str_replace(' ', '-', convert_accented_characters($marca)); ?>/<?php echo $orden; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($marca_vehiculo)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($linea_vehiculo)); ?>/<?php echo $limit; ?>/0" class="filtros_categoria<?php if($categoria=='todas-las-categorias'){?>_selected<?php } ?>">Todas las categor&iacute;as</a></h3></td>
                                    </tr>
                                    <?php
                                    if($categoria!='todas-las-categorias'){
                                    ?>
                                    <tr>
                                        <td colspan="3" class="filtros_categoria"><h3><a href="<?php echo base_url(); ?>autopartes/index/<?php echo str_replace(' ', '-', convert_accented_characters($categoria)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($marca)); ?>/<?php echo $orden; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($marca_vehiculo)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($linea_vehiculo)); ?>/<?php echo $limit; ?>/0" class="filtros_categoria_selected"><?php echo $categoria; ?></a></h3></td>
                                    </tr>
                                    <?php
                                    }
                                    else if(sizeof($categorias)!=0){
                                        foreach($categorias as $categoria_actual){ ?>
                                    <tr>
                                        <td colspan="3" class="filtros_categoria"><h3><a href="<?php echo base_url(); ?>autopartes/index/<?php echo str_replace(' ', '-', convert_accented_characters($categoria_actual->nombre)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($marca)); ?>/<?php echo $orden; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($marca_vehiculo)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($linea_vehiculo)); ?>/<?php echo $limit; ?>/0"><?php echo $categoria_actual->nombre; ?> (<?php echo $categoria_actual->cantidad; ?>)</a></h3></td>
                                    </tr>
                                    <?php }
                                    } ?>
                                    <tr>
                                        <td colspan="3" class="general_separador_transparente"></td>
                                    </tr>
                                    <tr>
                                        <td width="15" class="titulo_fondo_izq"></td>
                                        <td width="220" class="titulo_fondo"><h2>Por marcas de autopartes</h2></td>
                                        <td width="15" class="titulo_fondo_der"></td>
                                    </tr>
                                    <!-- Inicio marcas -->
                                    <tr>
                                        <td colspan="3" class="filtros_categoria"><h3><a href="<?php echo base_url(); ?>autopartes/index/<?php echo str_replace(' ', '-', convert_accented_characters($categoria)); ?>/todas-las-marcas/<?php echo $orden; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($marca_vehiculo)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($linea_vehiculo)); ?>/<?php echo $limit; ?>/0" class="filtros_categoria<?php if($categoria=='todas-las-categorias'){?>_selected<?php } ?>" class="filtros_categoria<?php if($marca=='todas-las-marcas'){?>_selected<?php } ?>">Todas las marcas</a></h3></td>
                                    </tr>
                                    <?php
                                    if($marca!='todas-las-marcas'){
                                    ?>
                                    <tr>
                                        <td colspan="3" class="filtros_categoria"><h3><a href="<?php echo base_url(); ?>autopartes/index/<?php echo str_replace(' ', '-', convert_accented_characters($categoria)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($marca)); ?>/ordenar-nombre/<?php echo str_replace(' ', '-', convert_accented_characters($marca_vehiculo)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($linea_vehiculo)); ?>/<?php echo $limit; ?>/0" class="filtros_categoria_selected"><?php echo str_replace('-', ' ', convert_accented_characters($marca)); ?></a></h3></td>
                                    </tr>
                                    <?php
                                    }
                                    else if(sizeof($marcas)!=0){
                                        foreach($marcas as $marca_actual){ ?>
                                    <tr>
                                        <td colspan="3" class="filtros_categoria"><h3><a href="<?php echo base_url(); ?>autopartes/index/<?php echo str_replace(' ', '-', convert_accented_characters($categoria)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($marca_actual->nombre)); ?>/<?php echo $orden; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($marca_vehiculo)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($linea_vehiculo)); ?>/<?php echo $limit; ?>/0"><?php echo $marca_actual->nombre; ?> (<?php echo $marca_actual->cantidad; ?>)</a></h3></td>
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
                <td width="680" valign="top" align="center">
                    <table width="660" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td class="box_fondo"></td>
                            <td class="box_borde_sup" ></td>
                            <td class="box_esquina_sup_der" height="14"></td>
                        </tr>
                        <tr>
                            <td width="125" height="22" class="box_fondo box_titulo"><h1>AUTOPARTES</h1></td>
                            <td width="507" class="box_ordenamiento">Ordenar por <?php if($orden=='nombre'){ ?><b>Nombre</b><?php } else { ?><a href="<?php echo base_url(); ?>autopartes/index/<?php echo str_replace(' ', '-', convert_accented_characters($categoria)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($marca)); ?>/nombre/<?php echo str_replace(' ', '-', convert_accented_characters($marca_vehiculo)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($linea_vehiculo)); ?>/<?php echo $limit; ?>/0">Nombre</a><?php } ?> - <?php if($orden=='precio'){ ?><b>Precio</b><?php } else { ?><a href="<?php echo base_url(); ?>autopartes/index/<?php echo str_replace(' ', '-', convert_accented_characters($categoria)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($marca)); ?>/precio/<?php echo str_replace(' ', '-', convert_accented_characters($marca_vehiculo)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($linea_vehiculo)); ?>/<?php echo $limit; ?>/0">Precio</a><?php } ?> | <?php if($limit==10){?><b>10</b><?php } else { ?><a href="<?php echo base_url(); ?>autopartes/index/<?php echo str_replace(' ', '-', convert_accented_characters($categoria)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($marca)); ?>/<?php echo $orden; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($marca_vehiculo)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($linea_vehiculo)); ?>/10/0">10</a><?php } ?> - <?php if($limit==25){?><b>25</b><?php } else { ?><a href="<?php echo base_url(); ?>autopartes/index/<?php echo str_replace(' ', '-', convert_accented_characters($categoria)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($marca)); ?>/<?php echo $orden; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($marca_vehiculo)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($linea_vehiculo)); ?>/25/0">25</a><?php } ?> - <?php if($limit==50){?><b>50</b><?php } else { ?><a href="<?php echo base_url(); ?>autopartes/index/<?php echo str_replace(' ', '-', convert_accented_characters($categoria)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($marca)); ?>/<?php echo $orden; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($marca_vehiculo)); ?>/<?php echo str_replace(' ', '-', convert_accented_characters($linea_vehiculo)); ?>/50/0">50</a><?php } ?> Resultados por página</td>
                            <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2">
                                <table width="632" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="5" class="box_paginacion"><?php echo $this->pagination->create_links(); ?></td>
                                    </tr>
                                    <?php if(sizeof($autopartes)!=0){
                                        $contador = 0;
                                        foreach($autopartes as $autoparte){ ?>
                                    <tr>
                                        <td width="15" height="90" rowspan="3">&nbsp;</td>
                                        <td width="120" rowspan="3" align="center" valign="middle" class="listado_autopartes<?php if($contador%2==0){ ?>_selected<?php } ?>"><a href="<?php echo base_url(); ?>autopartes/<?php echo $autoparte->id_autoparte; ?>-<?php echo str_replace(' ', '-', convert_accented_characters($autoparte->nombre)); ?>"><img src="<?php if($autoparte->imagen_thumb_url==''||$autoparte->imagen_thumb_url==NULL){ echo base_url().'resources/images/template/logos/laspartes110x67.gif'; } else { echo $autoparte->imagen_thumb_url; } ?>" width="100" height="70" alt="<?php echo $autoparte->nombre; ?>" /></a></td>
                                        <td width="362" class="listado_autopartes<?php if($contador%2==0){ ?>_selected<?php } ?> general_link" align="left"><h4><a href="<?php echo base_url(); ?>autopartes/<?php echo $autoparte->id_autoparte; ?>-<?php echo str_replace(' ', '-', convert_accented_characters($autoparte->nombre)); ?>"><?php echo $autoparte->nombre; ?></a></h4></td>
                                        <td width="120" rowspan="2" class="listado_autopartes<?php if($contador%2==0){ ?>_selected<?php } ?>" style="padding-right:20px;" valign="bottom" align="right"><input type="submit" class="listado_autopartes_btn_compra" value="$<?php echo number_format($autoparte->precio,0,',','.'); ?>"></td>
                                        <td width="15" rowspan="3">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="listado_autopartes<?php if($contador%2==0){ ?>_selected<?php } ?>" align="left">
                                            <h5>
                                                <strong>Referencia: </strong><?php echo $autoparte->referencia; ?>
                                            </h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="listado_autopartes<?php if($contador%2==0){ ?>_selected<?php } ?> general_link" align="left">
                                            <h5>
                                        <?php echo substr( $autoparte->descripcion, 0, 150 ) . ' ...'; ?> <a href="<?php echo base_url(); ?>autopartes/<?php echo $autoparte->id_autoparte; ?>-<?php echo str_replace(' ', '-', convert_accented_characters($autoparte->nombre)); ?>">Ver más</a>
                                            </h5>
                                        </td>
                                        <td width="120" class="listado_autopartes<?php if($contador%2==0){ ?>_selected<?php } ?> general_link" align="center" valign="top"><h4><a href="<?php echo base_url(); ?>autopartes/<?php echo $autoparte->id_autoparte; ?>-<?php echo str_replace(' ', '-', convert_accented_characters($autoparte->nombre)); ?>">Comparar <br />precios</a></h4></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" height="10"></td>
                                    </tr>
                                    <?php $contador++;
                                        }
                                    }?>
                                    <tr>
                                        <td colspan="5" class="box_paginacion"><?php echo $this->pagination->create_links(); ?></td>
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
            <tr>
                <td colspan="2" class="general_separador_transparente"></td>
            </tr>
        </table>
    </td>
</tr>