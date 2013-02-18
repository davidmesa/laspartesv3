<div id="home-div-content">
    <div id="carrito-div-banner">
        <div id="carrito-div-banner-comunidad">
            <div id="carrito-div-banner-comunidad-titulo">
                <h1 style="margin-top: 17px;"><strong>COMPRA EN LÍNEA</strong> LO QUE NECESITES</h1>
                <h1>DE MANERA <strong>RÁPIDA Y SEGURA.</strong></h1>
            </div>
            <img src="<?php echo base_url();?>resources/images/iconos/pol-format.png" alt="pagos online"/>
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
        <div class="div-content-left-carrito">
            <div id="autopart-div-autopartes-titulo">
                <div id="autopart-div-titulo-icono">
                    <img src="<?php echo base_url();?>/resources/images/carrito/carrito.png" alt="icono carrito de compras" />
                </div>
                <div id="autopart-div-titulo">
                    <h1>
                        <span style="color: #C60200;">PAGO</span>
                        <span> Y CONFIRMACIÓN</span>
                    </h1>
                </div>

                <div class="clear"></div>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>

            <div id="datos-div-detalles-compra-titulo">
                <div id="datos-div-detalles-compra-titulo-izq">
                    <span>DETALLES DE TU COMPRA</span>
                </div>
                <div id="confirmacion_div-detalle-compra-titulo-center" >
                    <span>DATOS DE ENVÍO</span>
                </div>
                <div id="confirmacion-div-detalles-compra-titulo-der" style="background-color: #404040;">
                    <img src="<?php echo base_url();?>/resources/images/carrito/doble-mayor-blanco.png" alt="dible mayor qué" />
                    PAGO Y CONFIRMACIÓN
                </div>
                <div class="clear"></div>
            </div>
            
            <div id="datos-div-compra">
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                    <th width="100%" scope="col"><h1><?php echo $respuesta;?></h1>
                    <br />
                    </tr>
                    <td align="center">

                    <a href="http://www.pagosonline.com/" target="_blank"><img src="http://www.pagosonline.com/logos/images/transgrande_03_460x60.png" alt="j" width="460" height="60" border="0" /></a>
                    <br />
                    <h2 align="center"><?php echo $mensaje;?></h2>
                    <div align="center">

                    
                    </div></td>

                    </tr>
                    </table>
            </div>
            <?php $numero_items_carrito = 0;
                                    foreach($this->cart->contents() as $autoparte): 
                                    $total += $autoparte['price']*$autoparte['qty'];
                                    $iva += $autoparte['iva']*$autoparte['qty'];
            endforeach;?>
            <div id="carrito-div-detalle-pago">
                <div id="carrito-div-detalle-pago-subtotal">
                    <strong>Subtotal pagado:</strong> <span class="format-precio" id="carrito-span-detalle-pago-subtotal">$<?php echo number_format($total-round($iva),0,',','.');?></span>
                </div>
                <div id="carrito-div-detalle-pago-iva">
                    <strong>IVA:</strong> <span class="format-precio" id="carrito-span-detalle-pago-iva">$<?php echo number_format(round($iva),0,',','.');?></span>
                </div>
                <div id="carrito-div-detalle-pago-total">
                    <strong>Total pagado:</strong> <span id="carrito-span-detalle-pago-total" class="format-precio">$<?php echo number_format($total,0,',','.');?></span>
                </div>
                <div class="clear"></div>
            </div>
            <div class="autopart-div-espaciador-rallas" id="carrito-div-no-margin"></div>


            <div id="carrito-div-items">
                <?php $numero_items_carrito = 0;
                                    foreach($this->cart->contents() as $autoparte): ?>
                <?php  $urlAutoparte = base_url().'autopartes/'.$autoparte['id'].'-'.str_replace(' ', '-', convert_accented_characters($autoparte['nombre'])); ?>
                <div class="carrito-div-item"> 
                    <div class="carrito-div-item-detalles">
                        <div class="carrito-div-item-detalles-marco">
                            <a href="<?php echo $urlAutoparte;?>">
                                <img src="<?php if($autoparte['foto'] ==''||$autoparte['foto']==NULL){ echo base_url().'resources/images/micuenta/tmpl_img_micuenta_vehiculo_nd1.png'; } else { echo base_url().$autoparte['foto']; } ?>" alt="<?php echo $autoparte['nombre']; ?>" />
                            </a>
                        </div>
                        <div class="carrito-div-item-detalles-desc">
                            <div class="carrito-div-item-detalle-titulo">
                                
                                <a href="<?php echo $urlAutoparte;?>"><?php echo $autoparte['nombre']; ?></a>
                            </div>

                            <div class="carrito-div-item-detalle-descrip">
                                <?php echo $autoparte['options']['descripcion']; ?>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="carrito-div-item-detalles-pago">
                        <label>Cantidad: </label> <span class="carrito-div-item-subtitulo"><?php echo $autoparte['qty'];?></span>
                        <div class="carrito-div-item-subtitulo">Sub total</div>
                        <div class="carrito-div-item-subtotal format-precio">$<?php echo number_format((($autoparte['price']-$autoparte['iva'])*$autoparte['qty']),0,',','.'); ?></div>
                        <div class="carrito-div-item-subtitulo">IVA</div>
                        <div class="carrito-div-item-iva format-precio">$<?php echo number_format( ($autoparte['iva']*$autoparte['qty']),0,',','.'); ?></div>
                        <div class="carrito-div-item-subtitulo-total">TOTAL</div>
                        <div class="carrito-div-item-total format-precio">$<?php echo number_format(($autoparte['price']*$autoparte['qty']),0,',','.'); ?></div>
                    </div>

                    <div class="clear"></div>

                    <div class="carrito-div-item-condiciones">
<!--                        Condiciones de la autoparte que se quiere decir.-->
                    </div>

                    <div class="clear"></div>
                </div>
                <?php endforeach;?>
            </div>


        </div>

        <div class="div-content-center-novedades">
            <div id="carrito-div-publicidad-titulo" class="font-universe">
                <div>PUBLICIDAD</div>
            </div>
            <div class="carrito-div-publicidad-imagen">
                <img src="<?php echo base_url();?>/resources/images/home/imagen-publicidad.png" alt="imagen publicidad" />
            </div>
        </div>

        <div class="clear"></div>
    </div>
</div>