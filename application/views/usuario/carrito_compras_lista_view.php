<div class="registro-login-div" id="registro-login-div"></div>
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
                        <span style="color: #C60200;">CARRITO</span>
                        <span> DE COMPRAS</span>
                    </h1>
                </div>

                <div class="clear"></div>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>

            <div id="carrito-div-detalles-compra-titulo">
                <div id="carrito-div-detalles-compra-titulo-izq">
                    <img src="<?php echo base_url();?>/resources/images/carrito/doble-mayor-blanco.png" alt="dible mayor qué" />
                    <span>DETALLES DE TU COMPRA</span>
                </div>
                <div id="carrito-div-detalles-compra-titulo-der">
                    <span id="carrito-span-detalles-num-items"><?php echo $this->cart->total_items();?></span> items en tu carrito
                </div>
                <div class="clear"></div>
            </div>

            <div id="carrito-div-detalle-pago">
                <div id="carrito-div-detalle-pago-subtotal">
                    <strong>Subtotal a pagar:</strong> <span class="format-precio" id="carrito-span-detalle-pago-subtotal">$<?php echo number_format($base,0,',','.');?></span>
                </div>
                <div id="carrito-div-detalle-pago-iva">
                    <strong>IVA:</strong> <span class="format-precio" id="carrito-span-detalle-pago-iva">$<?php echo number_format($iva,0,',','.');?></span>
                </div>
                <div id="carrito-div-detalle-pago-total">
                    <strong>Total a pagar:</strong> <span id="carrito-span-detalle-pago-total" class="format-precio">$<?php echo number_format($precio,0,',','.');?></span>
                </div>
                <div class="clear"></div>
            </div>
            <div class="autopart-div-espaciador-rallas" id="carrito-div-no-margin"></div>

            <div id="carrito-div-tajetas-pagar">
                <div id="carrito-div-tarjetas">
                    <img src="<?php echo base_url();?>/resources/images/carrito/tarjeta-pse.png" alt="pago por PSE" />
                    <img src="<?php echo base_url();?>/resources/images/carrito/tarjeta-visa.png" alt="pago por visa" />
                    <img src="<?php echo base_url();?>/resources/images/carrito/tarjeta-master-card.png" alt="pago por Masterd Card" />
                    <img src="<?php echo base_url();?>/resources/images/carrito/tarjeta-american.png" alt="pago por american express" />
                    <img src="<?php echo base_url();?>/resources/images/carrito/baloto.png" alt="pago por baloto" />
                    <img src="<?php echo base_url();?>/resources/images/carrito/tarjeta-efecty.png" alt="pago por efecty" />	                    
                </div>
                <div id="carrito-div-pagar">
<!--                    <a href="<?php // echo base_urL().'carrito/datos_envio'?>">PAGAR</a>-->
                    <input type="submit" value="PAGAR" />
                </div>

                <div class="clear"></div>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>

            <div id="carrito-div-items">
                <?php $numero_items_carrito = 0;
                                    foreach($this->cart->contents() as $autoparte): ?>
                <?php  if($autoparte['name'] == 'autoparte')
                         $url = base_url().'autopartes/'.$autoparte['id'].'-'.preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $autoparte['nombre']); 
                        else if($autoparte['name'] == 'oferta')
                           $url = base_url().'promociones/'.$autoparte['id'].'-'.preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $autoparte['nombre']); 
                ?>
                <div class="carrito-div-item"> 
                    <div class="carrito-div-item-detalles">
                        <div class="carrito-div-item-detalles-marco">
                            <a href="<?php echo $url;?>">
                                <img src="<?php if($autoparte['options']['foto'] ==''||$autoparte['options']['foto']==NULL){ echo base_url().'resources/images/micuenta/tmpl_img_micuenta_vehiculo_nd1.png'; } else { echo base_url().$autoparte['options']['foto']; } ?>" alt="<?php echo $autoparte['name']; ?>" />
                            </a>
                        </div>
                        <div class="carrito-div-item-detalles-desc">
                            <div class="carrito-div-item-detalle-titulo">
                                
                                <a href="<?php echo $url;?>"><?php echo $autoparte['nombre']; ?></a>
                            </div>

                            <div class="carrito-div-item-detalle-descrip">
                                <?php echo strip_tags($autoparte['options']['descripcion']); ?> 
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="carrito-div-item-detalles-pago">
                        <input type="hidden" class="carrito-input-row-item" value="<?php echo $autoparte['rowid']; ?>"/>
                        <input type="hidden" class="carrito-input-id-item" value="<?php echo $autoparte['id']; ?>"/>
                        <input type="hidden" class="carrito-input-precio" value="<?php echo $autoparte['price']; ?>"/>
                        <input type="hidden" class="carrito-input-iva" value="<?php echo $autoparte['iva']; ?>"/>
                        <label>Cantidad: </label> <input onkeypress="return onlyNumbers(event)" maxlength="3" class="carrito-input-item-cantidad" type="text" value="<?php echo $autoparte['qty'];?>" />
                        <div class="carrito-div-item-actualizar">actualizar</div>
                        <div class="carrito-div-item-subtitulo">Sub total</div>
                        <div class="carrito-div-item-subtotal format-precio">$<?php echo number_format((($autoparte['price']-$autoparte['iva'])*$autoparte['qty']),0,',','.'); ?></div>
                        <div class="carrito-div-item-subtitulo">IVA</div>
                        <div class="carrito-div-item-iva format-precio">$<?php echo number_format( ($autoparte['iva']*$autoparte['qty']),0,',','.'); ?></div>
                        <div class="carrito-div-item-subtitulo-total">TOTAL</div>
                        <div class="carrito-div-item-total format-precio">$<?php echo number_format(($autoparte['price']*$autoparte['qty']),0,',','.'); ?></div>
                    </div>

                    <div class="clear"></div>

                    <div class="carrito-div-item-condiciones">
                        *Costos de envío no están incluídos, dependen del peso y destino de la autoparte.<br/>
                        *Precios sujetos a disponibilidad.
                    </div>

                    <div class="carrito-div-item-eliminar">
                        eliminar
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