<div id="home-div-content">
    <div id="autopart-div-banner">
        <div id="autopart-div-banner-encuentra">
            <div id="autopart-div-banner-encuentra-titulo">
                <h1>ENCUENTRA LAS AUTOPARTES QUE NECESITAS DE FORMA FÁCIL!</h1>
            </div>   
            <div id="autopart-div-banner-encuentra-pasos">
                <div class="autopart-div-banner-encuentra-paso">
                    <div class="autopart-div-banner-encuentra-paso-imagen">1</div>
                    <h1>ELIGE TU VEHICULO</h1>
                </div>
                <div class="autopart-div-banner-encuentra-paso no-padding">
                    <div class="autopart-div-banner-encuentra-paso-imagen">2</div>
                    <h1>FILTRA TU BÚSQUEDA</h1>
                </div>
                <div class="autopart-div-banner-encuentra-paso no-padding">
                    <div class="autopart-div-banner-encuentra-paso-imagen">3</div>
                    <h1 id="autopart-h1-banner-encuentra">ENCUENTRA TODO LO QUE NECESITAS</h1>
                </div>                                                
            </div>
        </div>
        <div class="clear"></div>


    </div>

    <div id="autopart-div-banner-bottom"></div>

    <div class="div-content">
        <div class="div-breadcrumb open-sans">
            <div style="color:white; background-color:black; font-weight:bold;">>></div>

            <?php echo $breadcrumb;?>
        </div>
        <div class="clear"></div>
        <div class="div-content-left">
            <div id="autopart-div-titulo">
                <h1><span>MARCA</span>&nbsp;<span style="color: #C60200;">VEHÍCULO</span></h1>
            </div>

            <div id="autopart-div-buscar">
                <form>
                    <div id="autopart-div-buscar-boton">
                        <input name="input-buscar-boton" type="button">
                    </div>
                    <div id="autopart-div-buscar-input" class="ui-widget">
                        <input type="hidden" value="na" name="vehiculo_id" class="hidden_carro_selected">
                        <?php if(sizeof($vehiculoMarcaBusqueda)>0 && sizeof($vehiculoLineaBusqueda)>0): ?>
                            <input class="vehiculos" name="id_vehiculos[]" type="text" value="<?php echo $vehiculoMarcaBusqueda.' '.$vehiculoLineaBusqueda;?>">
                        <?php else:?>
                            <input class="vehiculos" name="id_vehiculos[]" type="text" onclick="this.value='';" value="ESCRIBE AQUÍ LA MARCA">
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>

            <div id="autopart-div-titulo">
                <h1><span>CATEGORIAS</span></h1>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>


            <div class="autopart-div-categoria">
                <div class="autopart-div-categoria-bullet comprimido"><img src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que rojo" /></div>
                <div class="autopart-div-categoria-content">
                    <h4 class="autopart-h4-categoria-titulo autopart-div-filtro" id="categoria-filtro-todos-categorias"><span class="categorias-div-filtro-x">Todas las categorias</span>
                        <span class="utopart-h4-span-cantidad"> </span>
                    </h4>
                </div>
                <div class="clear"></div>
            </div>
            <?php foreach ($categorias as $categoria):?>
            <div class="autopart-div-categoria filtro-categoria">
                <div class="autopart-div-categoria-bullet comprimido"><img src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que rojo" /></div>
                <div class="autopart-div-categoria-content">
                    <h4 class="autopart-h4-categoria-titulo"><span><?php echo $categoria->nombre; ?></span>
                        <span class="utopart-h4-span-cantidad">(<?php echo $categoria->cantidad;?>)</span>
                    </h4>
<!--                    <ul>
                        <li><h4>cat 1</h4></li>
                        <li><h4>cat 2</h4></li>
                        <li><h4>cat 3</h4></li>
                        <li><h4>cat 4</h4></li>
                    </ul>-->
                </div>
                <div class="clear"></div>
            </div>
            
            <?php endforeach; ?>

            <div class="autopart-div-espaciador-rallas"></div>

            <div id="autopart-div-titulo">
                <h1><span>MARCAS</span>&nbsp;<span style="color: #C60200;">AUTOPARTES</span></h1>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>

            <div class="autopart-div-categoria">
                <div class="autopart-div-categoria-bullet comprimido"><img src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que rojo" /></div>
                <div class="autopart-div-categoria-content">
                    <h4 class="autopart-h4-categoria-titulo autopart-div-filtro" id="categoria-filtro-todos-marcas"><span class="categorias-div-filtro-x">Todas las marcas</span>
                        <span class="utopart-h4-span-cantidad"> </span>
                    </h4>
                </div>
                <div class="clear"></div>
            </div>
            <?php foreach ($marcas as $marca):?>
            <div class="autopart-div-categoria filtro-marca">
                <div class="autopart-div-categoria-bullet comprimido"><img src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que rojo" /></div>
                <div class="autopart-div-categoria-content">
                    <h4 class="autopart-h4-categoria-titulo"><span><?php echo $marca->nombre;?></span>
                        <span class="utopart-h4-span-cantidad">(<?php echo $marca->cantidad;?>)</span>
                    </h4>
<!--                    <ul>
                        <li><h4>cat 1</h4></li>
                        <li><h4>cat 2</h4></li>
                        <li><h4>cat 3</h4></li>
                        <li><h4>cat 4</h4></li>
                    </ul>-->
                </div>
                <div class="clear"></div>
            </div>
            <?php endforeach; ?>

            <div class="autopart-div-espacio"></div>
        </div>

        <div class="div-content-center">

            <div id="autopart-div-autopartes-titulo">
                <div id="autopart-div-titulo">
                    <h1><span style="color: #C60200;">AUTOPARTES</span>&nbsp;<span  style="color: #404040;">/ DETALLE</span></h1>
                </div>


                <div class="clear"></div>
            </div>
            <div class="autopart-div-espaciador-rallas"></div>

            <div class="autopart-div-filtros">
                <?php if(isset($vehiculoMarcaBusqueda) && sizeof($vehiculoMarcaBusqueda)>0):?>
                <div class="autopart-div-filtro" id="filtro-vehiculo">
                    <span><?php echo $vehiculoMarcaBusqueda;?></span>
                    <div class="autopart-div-filtro-x">X</div>
                </div>
                <?php endif; ?>

                <?php if(isset($categoriaBusqueda) && sizeof($categoriaBusqueda)>0):?>
                <div class="autopart-div-filtro" id="filtro-categoria">
                    <span><?php echo $categoriaBusqueda;?></span>
                    <div class="autopart-div-filtro-x">X</div>
                </div>
                <?php endif; ?>
                
                <?php if(isset($marcaBusqueda) && sizeof($marcaBusqueda)>0):?>
                <div class="autopart-div-filtro" id="filtro-marca">
                    <span><?php echo $marcaBusqueda; ?></span>
                    <div class="autopart-div-filtro-x">X</div>
                </div>
                <?php endif; ?>

                <div class="clear"></div>	
            </div>

            <div id="autopart-div-autopartes">

                <div class="autopart-detalle-div-autoparte">
                    <div class="autopart-detalle-div-imagenes">
                        <div class="autopart-div-autoparte-marco">
                            <?php if(!($autoparte->imagen_url== '' ||$autoparte->imagen_url==NULL)):?>
                                <a href="<?php echo $autoparte->imagen_url; ?>" rel="galeria-imagenes"><img src="<?php echo base_url().$autoparte->imagen_url; ?>" alt="imagen autoparte" /></a>
                            <?php  else:?>
                                <img style="opacity: 0.4;" src="<?php echo base_url().'resources/images/micuenta/tmpl_img_micuenta_vehiculo_nd1.png'; ?>" alt="imagen autoparte" />
                            <?php endif; ?>
                            
                        </div>
                    </div>

                    <div class="autopart-div-autoparte-datos">
                        <div class="autopart-div-autoparte-info">
                            <div class="autopart-div-autoparte-titulo" style="text-transform: uppercase;">
                                <?php echo $autoparte->nombre. ' MARCA '.  $autoparte->marca.' PARA CARROS '; foreach ($vehiculos_marcas as $vehiculo_marca) { echo $vehiculo_marca->marca.' '; }?>
                            </div>

                            <div class="autopart-div-autoparte-precio">
                                $ <?php echo number_format($rango_precios->precio_minimo, 0, ',', '.');?>
                            </div>
                            <div class="autopart-div-autoparte-vendedores">
                                (<?php echo sizeof($establecimientos);?> vendedores)
                            </div>

                            <div class="autopart-div-autoparte-descripcion">
                                <?php echo $autoparte->descripcion;?>
                            </div>
                            
                            <div class="autopart-div-autoparte-descripcion">
                                <strong>Observaciones:</strong><br/>
                                <?php echo $autoparte->observacion;?>
                            </div>
                        </div>

                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="autopart-detalle-div-vendedores">
                    <div id="autopart-div-titulo">
                        <img src="<?php echo base_url();?>resources/images/autopartes/pinones.png" alt="Piñones" />
                        <h1><span>TALLERES</span>&nbsp;<span style="color: #C60200;">VENDEDORES</span></h1>
                    </div>

                    <div id="autopart-detalle-div-tabla-vendedores">
                        <table cellspacing="4">
                            <th id="autopart-detalle-th-taller">TALLER</th>
                            <th id="autopart-detalle-th-precio">PRECIO</th>
                            <th id="autopart-detalle-th-agregar"></th>
                            
                            <?php foreach ($establecimientos as $establecimiento):?>
                            <tr>
                                <td class="autopart-detalle-td-nombre">Laspartes</td> 
                                <td class="autopart-detalle-td-precio">$<?php echo number_format($establecimiento->precio, 0, ',', '.');?></td>
                                <td class="autopart-detalle-td-anadir" align="center">
                                    <div>
                                        <?php if($establecimiento->precio!=0){ ?>
                                            <?php echo form_open('usuario/agregar_carrito_compras'); ?>
                                                <input type="hidden" name="id_autoparte" value="<?php echo $autoparte->id_autoparte; ?>" />
                                                <input type="hidden" name="id_establecimiento" value="<?php echo $establecimiento->id_establecimiento; ?>" />
                                                <input type="submit" class="boton_link" value="COMPRAR" onclick="_gaq.push(['_trackEvent', 'Autoparte', 'pagar', <?php echo $autoparte->nombre. ' MARCA '.  $autoparte->marca;?>, <?php echo $autoparte->id_autoparte;?>]);" />
                                            <?php echo form_close(); ?>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            
                            
                        </table>
                        <div id="autopart-detalle-div-tabla-terminos">
                            (*) Precio para compras hechas a través de laspartes.com. Los precios pueden cambiar dependiendo del taller vendedor y están sujetos a la disponibilidad de las autopartes.
                        </div>
                    </div>
                </div>

                <div class="autopart-detalle-div-vehiculos">
                    <div id="autopart-div-titulo">
                        <img src="<?php echo base_url();?>resources/images/autopartes/mi-vehiculo.png" alt="vehículo" />
                        <h1><span>VEHÍCULOS</span>&nbsp;<span style="color: #C60200;">COMPATIBLES</span></h1>
                    </div>

                    <div class="autopart-div-vehiculos-lista">
                        <table BORDER=1 bordercolor="#ccc" CELLSPACING=1 
                               RULES=COLS FRAME=BOX>
                            <td valign="top">
                                <ul>
                            <?php $size = sizeof($autoparte_vehiculos);
                                    $tamanoCol = round($size/3);
                                foreach ($autoparte_vehiculos as $key=>$autoparte_vehiculo): if($key<$tamanoCol):?>
                                    <li><strong><?php echo $autoparte_vehiculo->marca; ?></strong> <?php echo $autoparte_vehiculo->linea; ?></li>
                            <?php endif; endforeach; ?>
                                    </ul>
                            </td>
                            <td valign="top">
                                <ul>
                            <?php foreach ($autoparte_vehiculos as $key=>$autoparte_vehiculo): if($key>=$tamanoCol && $key<($tamanoCol*2)):?>
                                    <li><strong><?php echo $autoparte_vehiculo->marca; ?></strong> <?php echo $autoparte_vehiculo->linea; ?></li>
                            <?php endif; endforeach; ?>
                                    </ul>
                            </td>
                            <td valign="top">
                                <ul>
                            <?php foreach ($autoparte_vehiculos as $key=>$autoparte_vehiculo): if($key>=($tamanoCol*2)):?>
                                    <li><strong><?php echo $autoparte_vehiculo->marca; ?></strong> <?php echo $autoparte_vehiculo->linea; ?></li>
                            <?php endif; endforeach; ?>
                                    </ul>
                            </td>
                        </table>

                    </div>

<!--                    <div class="autopart-detalle-div-vermas div-ver-mas open-sans">
                        <span class="autopart-detalle-span-vermas">VER MÁS VEHÍCULOS</span>
                        <img style="margin-left:3px;" src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" /><img src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" />
                    </div>-->
                </div>
            </div>

        </div>

        <div class="clear"></div>
    </div>
</div>