<div id="home-div-content">
    <div id="autopart-div-banner">
        <div id="autopart-div-banner-encuentra">
            <div id="autopart-div-banner-encuentra-titulo">
                <h1>LAS MEJORES OFERTAS Y PROMOCIONES PARA TU VEHÍCULO</h1>
            </div>   
            <div id="autopart-div-banner-encuentra-pasos">
                <div class="autopart-div-banner-encuentra-paso">
                    <div class="autopart-div-banner-encuentra-paso-imagen">1</div>
                    <h1>ELIGE TU VEHICULO</h1>
                </div>
                <div class="autopart-div-banner-encuentra-paso no-padding">
                    <div class="autopart-div-banner-encuentra-paso-imagen">2</div>
                    <h1>ENCUENTRA LOS MEJORES PRECIOS</h1>
                </div>
                <div class="autopart-div-banner-encuentra-paso no-padding"> 
                    <div class="autopart-div-banner-encuentra-paso-imagen">3</div>
                    <h1 id="autopart-h1-banner-encuentra">PAGA EN LÍNEA SIN SALIR DE CASA</h1>
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

            <div class="autopart-div-espacio"></div>
        </div>

        <div class="div-content-center">

            <div id="autopart-div-autopartes-titulo">
                <div id="autopart-div-titulo">
                    <h1><span style="color: #C60200;">OFERTAS Y PROMOCIONES</span>&nbsp;<span  style="color: #404040;">/ DETALLE</span></h1>
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

                <div class="clear"></div>	
            </div>

            <div id="autopart-div-autopartes">

                <div class="autopart-detalle-div-autoparte" style="background-image: url(../../resources/images/autopartes/degrade-puntuacion.png); background-position: bottom right; background-repeat: no-repeat; padding-bottom: 10px;">
                    <div class="autopart-detalle-div-imagenes">
                        <div class="autopart-div-autoparte-marco">
                            <?php if(!($promocion->foto== '' ||$promocion->foto==NULL)):?>
                                <a href="<?php echo base_url().$promocion->foto; ?>" rel="galeria-imagenes"><img src="<?php echo base_url().$promocion->foto; ?>" alt="imagen promocion" /></a>
                            <?php  else:?>
                                <img style="opacity: 0.4;" src="<?php echo base_url().'resources/images/micuenta/tmpl_img_micuenta_vehiculo_nd1.png'; ?>" alt="imagen promocion" />
                            <?php endif; ?>
                            
                        </div>
                    </div>

                    <div class="autopart-div-autoparte-datos">
                        <div class="autopart-div-autoparte-info">
                            <div class="autopart-div-autoparte-titulo" style="text-transform: uppercase;">
                                <?php echo $promocion->titulo;?>
                            </div>

                               <?php if($promocion->dco_feria != 0): ?>
                            <div class="autopart-div-autoparte-precio">
                                <?php $precio = $promocion->precio;
                                      $iva = $promocion->iva;
                                      $dco = $promocion->dco_feria;
                                      $base = $precio-$iva; 
                                      $ivaPorce = $iva/$base;
                                      $valorDco = $base*((100-$dco)/100);
                                      $precionConDco = ($valorDco*(1+$ivaPorce));
                                ?>
                                $ <?php echo number_format($precionConDco, 0, ',', '.'); ?> 
                            </div>
                            <div class="autopart-div-autoparte-vendedores">
                                 <strike>$ <?php echo number_format($promocion->precio, 0, ',', '.'); ?></strike>
                            </div>
                            <?php else: ?>
                            <div class="autopart-div-autoparte-precio">
                                $ <?php echo number_format($promocion->precio, 0, ',', '.'); ?>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="clear"></div>
                        <div class="usuario-div-oferta-lightbox-fotoincluye">
                            <div class="usaurio-div-oferta-lightbox-incluye">
                                <span style="color: black; font-weight:bold; font-size: 12px;">Incluye:</span>
                                <div class="usaurio-div-oferta-lightbox-incluye-items">
                                    <?php echo $promocion->incluye;?>
                                </div>
                                <br/>
                            </div>
                            <div class="usaurio-div-oferta-lightbox-incluye">
                                <span style="color: black; font-weight:bold; font-size: 12px;">Condiciones y Restricciones:</span>
                                <div class="usaurio-div-oferta-lightbox-incluye-items">
                                    <?php echo $promocion->condiciones;?>
                                </div>
                                <br/>
                            </div>
                            <div class="usaurio-div-oferta-lightbox-incluye">
                                <span style="color: black; font-weight:bold; font-size: 12px;">Vigencia:</span>
                                <div class="usaurio-div-oferta-lightbox-incluye-items">
                                    <?php echo strftime("%d de %B de %Y",strtotime($promocion->vigencia));?>
                                </div>
                                <br/>
                            </div>
                            <div class="usaurio-div-oferta-lightbox-incluye">
                                <span style="color: black; font-weight:bold; font-size: 12px;">Plazo de uso:</span>
                                <div class="usaurio-div-oferta-lightbox-incluye-items">
                                    <?php echo $promocion->plazo.' días después de la compra';?>
                                </div>
                                <br/>
                            </div>

                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="usuario-div-oferta-tarjetas">
                        <img src="<?php echo base_url(); ?>/resources/images/micuenta/pago-visa.png" alt="visa" />
                        <img src="<?php echo base_url(); ?>/resources/images/micuenta/pago-mastercard.png" alt="master card" />
                        <img src="<?php echo base_url(); ?>/resources/images/micuenta/pago-americanexp.png" alt="american express" />
                    </div>

                    <div class="usuario-div-oferta-comprar" style="margin-top: 0px;">
                        <?php echo form_open('usuario/agregar_carrito_compras_promo', 'class="usuario-form-oferta-comprar"'); ?>
                        <input type="hidden" name="id_oferta" value="<?php echo $promocion->id_oferta; ?>" />
                        <input id="usuario-input-oferta-comprar" type="submit" value="COMPRAR" title="COMPRAR" onclick="_gaq.push(['_trackEvent', 'Promocion', 'pagar', <?php echo $promocion->titulo; ?>, <?php echo $promocion->id_oferta; ?>]);" >
                        <?php  echo form_close(); ?>
                    </div>
                    <div class="clear"></div>
                </div>
                 <div class="clear"></div>
                

                <div class="autopart-detalle-div-vendedores">
                    <div id="autopart-div-titulo">
                        <img src="<?php echo base_url();?>resources/images/autopartes/pinones.png" alt="Piñones" />
                        <h1><span>TALLERES</span>&nbsp;<span style="color: #C60200;">VENDEDORES</span></h1>
                    </div>
                    <div class="usuario-div-oferta-lightbox-fototaller">
                    <div class="usuario-div-oferta-lightbox-marco">
                        <a href="<?php echo base_url() . 'talleres/' . $establecimiento->id_establecimiento . '-' . str_replace(" ", "-", convert_accented_characters($establecimiento->nombre)); ?>" target="_blank">
                            <img src="<?php echo base_url().$establecimiento->logo_url; ?>" alt="icono oferta" />
                        </a>
                    </div>
                    <div class="usaurio-div-oferta-lightbox-tallerinfo">
                        <div class="usaurio-div-oferta-lightbox-taller-nombre">
                            <a href="<?php echo base_url() . 'talleres/' . $establecimiento->id_establecimiento . '-' . str_replace(" ", "-", convert_accented_characters($establecimiento->nombre)); ?>" target="_blank">
                                <?php echo $establecimiento->nombre; ?>
                            </a>
                        </div>

                        <div class="usaurio-div-oferta-lightbox-taller-url">
                            <div class=""><?php echo $establecimiento->descripcion; ?></div>
                            <a href="http://<?php echo $establecimiento->web; ?>" target="_blank"><?php echo $establecimiento->web; ?></a>
                        </div>

<!--                        <div class="usaurio-div-oferta-lightbox-taller-direccion">
                            <?php echo $promocion->direccion; ?>
                        </div> 

                        <div class="usaurio-div-oferta-lightbox-taller-telefono">
                            <strong style="color: black;">Tel: </strong><?php echo $promocion->telefonos; ?>
                        </div>-->

                    </div>

                        <div class="talleres-detalle-div-calificacion-estrellas" style="float: right;">
                            <?php if($comentarios->promedio != ''):?>
                            <div class="talleres-detalle-div-calificacion-estrellas-imagen estrellas-sin-clasificar-grandes">
                                <div class="talleres-detalle-div-calificacion-estrellas-imagen-calificada estrellas-clasificadas-grandes"><span><?php echo (round($comentarios->promedio)*20).'%';?></span></div>
                            </div>
                            <?php endif; ?>   
                            <span><?php if($comentarios->promedio != '' && round($comentarios->promedio)== 5 ): echo '<strong>EXCELENTE</strong> - '.$comentarios->count.' opiniones de usuarios';
                            elseif($comentarios->promedio != '' && round($comentarios->promedio)== 4 ): echo '<strong>MUY BUENO</strong> - '.$comentarios->count.' opiniones de usuarios';
                            elseif($comentarios->promedio != '' && round($comentarios->promedio)== 3 ): echo '<strong>BUENO</strong> - '.$comentarios->count.' opiniones de usuarios';
                            elseif($comentarios->promedio != '' && round($comentarios->promedio)== 2 ): echo '<strong>REGULAR</strong> - '.$comentarios->count.' opiniones de usuarios';
                            elseif($comentarios->promedio != '' && round($comentarios->promedio)== 1 ): echo '<strong>MALO</strong> - '.$comentarios->count.' opiniones de usuarios';
                            else: echo '<strong>SIN CALIFICACIÓN</strong> - 0 opiniones de usuarios';
                            endif; ?></span>
                    </div>

                    <div class="clear"></div>
                </div>
                    
                </div>

                <div class="autopart-detalle-div-vehiculos" style="background-image: url(../../resources/images/autopartes/degrade-puntuacion.png); background-position: bottom right; background-repeat: no-repeat; padding-bottom: 10px;">
                    <div id="autopart-div-titulo">
                        <img src="<?php echo base_url();?>resources/images/autopartes/mi-vehiculo.png" alt="vehículo" />
                        <h1><span>VEHÍCULOS</span>&nbsp;<span style="color: #C60200;">COMPATIBLES</span></h1>
                    </div>

                    <div class="autopart-div-vehiculos-lista">
                        <table BORDER=1 bordercolor="#ccc" CELLSPACING=1 
                               RULES=COLS FRAME=BOX>
                            <td valign="top">
                                <ul>
                            <?php $size = sizeof($promocion_vehiculos);
                                    $tamanoCol = round($size/3);
                                foreach ($promocion_vehiculos as $key=>$promocion_vehiculo): if($key<=$tamanoCol):?>
                                    <li>todo <strong><?php echo $promocion_vehiculo->marca; ?></strong> tipo <?php if($promocion_vehiculo->tipo== 1) echo 'Automóvil'; else echo 'Camioneta'; ?></li>
                            <?php endif; endforeach; ?>
                                    </ul>
                            </td>
                            <td valign="top">
                                <ul>
                            <?php foreach ($promocion_vehiculos as $key=>$promocion_vehiculo): if($key>$tamanoCol && $key<=($tamanoCol*2)):?>
                                    <li>todo <strong><?php echo $promocion_vehiculo->marca; ?></strong> tipo <?php if($promocion_vehiculo->tipo== 1) echo 'Automóvil'; else echo 'Camioneta'; ?></li>
                            <?php endif; endforeach; ?>
                                    </ul>
                            </td>
                            <td valign="top">
                                <ul>
                            <?php foreach ($promocion_vehiculos as $key=>$promocion_vehiculo): if($key>($tamanoCol*2)):?>
                                    <li>todo <strong><?php echo $promocion_vehiculo->marca; ?></strong> tipo <?php if($promocion_vehiculo->tipo== 1) echo 'Automóvil'; else echo 'Camioneta'; ?></li>
                            <?php endif; endforeach; ?>
                                    </ul>
                            </td>
                        </table>

                    </div>

<!--                    <div class="autopart-detalle-div-vermas div-ver-mas open-sans">
                        <span class="autopart-detalle-span-vermas">VER MÁS VEHÍCULOS</span>
                        <img style="margin-left:3px;" src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" /><img src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" />
                    </div>-->
                    <br/>
                    <div class="usuario-div-oferta-tarjetas" style="margin-top: 0px;">
                        <img src="<?php echo base_url(); ?>/resources/images/micuenta/pago-visa.png" alt="visa" />
                        <img src="<?php echo base_url(); ?>/resources/images/micuenta/pago-mastercard.png" alt="master card" />
                        <img src="<?php echo base_url(); ?>/resources/images/micuenta/pago-americanexp.png" alt="american express" />
                    </div>

                    <div class="usuario-div-oferta-comprar" style="margin-top: 0px;">
                        <?php echo form_open('usuario/agregar_carrito_compras_promo'); ?>
                        <input type="hidden" name="id_oferta" value="<?php echo $promocion->id_oferta; ?>" />
                        <input  type="submit" value="COMPRAR" title="COMPRAR" onclick="_gaq.push(['_trackEvent', 'Promocion', 'pagar', <?php echo $promocion->titulo; ?>, <?php echo $promocion->id_oferta; ?>]);">
                        <?php  echo form_close(); ?>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

        </div>

        <div class="clear"></div>
    </div>
</div>