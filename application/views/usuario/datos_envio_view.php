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
                        <span style="color: #C60200;">DATOS</span>
                        <span> DE ENVÍO</span>
                    </h1>
                </div>

                <div class="clear"></div>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>

            <div id="datos-div-detalles-compra-titulo">
                <div id="datos-div-detalles-compra-titulo-izq">
                    <span>DETALLES DE TU COMPRA</span>
                </div>
                <div id="datos-div-detalles-compra-titulo-center" style="background-color: #404040;">
                    <img src="<?php echo base_url();?>/resources/images/carrito/doble-mayor-blanco.png" alt="dible mayor qué" />
                    <span>DATOS DE ENVÍO</span>
                </div>
                <div id="datos-div-detalles-compra-titulo-der">
                    PAGO Y CONFIRMACIÓN
                </div>
                <div class="clear"></div>
            </div>
            
            <div id="datos-div-compra">
                <form id="datos-envio-form" method="post" action="<?php echo $urlPagosOnline ?>"> 
                <input name="prueba" class="prueba" id="prueba" type="hidden" value="<?php echo $prueba ?>">
                <input name="url_respuesta" class="url_respuesta" id="url_respuesta" type="hidden" value="<?php echo $url_respuesta ?>">
                <input name="url_confirmacion" class="url_confirmacion" id="url_confirmacion" type="hidden" value="<?php echo $url_confirmacion ?>">
                <input name="valor" class="valor" id="valor" type="hidden" value="<?php echo $valor; ?>">
                <input name="iva" class="iva" id="iva" type="hidden" value="<?php echo $iva; ?>">
                <input name="baseDevolucionIva" class="baseDevolucionIva" id="baseDevolucionIva" type="hidden" value="<?php echo $baseDevolucionIva; ?>">
                <input name="refVenta" class="refVenta" id="refVenta" type="hidden" value="<?php echo $refVenta; ?>">
                <input name="firma" class="firma" id="firma" type="hidden" value="<?php echo $firma; ?>">
                <input name="usuarioId" class="usuarioId" id="usuarioId" type="hidden" value="<?php echo $usuarioId; ?>">
                <input name="descripcion" class="descripcion" id="descripcion" type="hidden" value="<?php echo $descripcion; ?>">
                    <div id="datos-envio-div-titulo">TUS DATOS PERSONALES</div>
                    <label>Nombres y apellidos</label>
                    <input type="text" name="nombreComprador" id="nombreComprador" value="<?php echo $usuario->nombres.' '.$usuario->apellidos;?>"/>
                    <label>¿En qué ciudad vives?</label>
                    <?php
                    $option_ciudades = array();
                    $selected = false;
                    $ciudades = array("Aguachica", "Apartadó", "Arauca", "Arjona", "Armenia", "Barrancabermeja", "Barranquilla", "Bello", "Bogotá", "Bucaramanga", "Buenaventura", "Calarcá", "Caldas", "Cali", "Candelaria", "Carmen de Bolívar", "Cartagena de indias", "Cartago", "Caucasia", "Cereté", "Chía", "Chigorodó", "Chiquinquirá", "Ciénaga", "Copacabana", "Dosquebradas", "Duitama", "Envigado", "Espinal", "Facatativa", "Florencia", "Floridablanca", "Fundación", "Funza", "Fusagasugá", "Garzón", "Girardot", "Guadalajara de Buga", "Ibagué", "Ipiales", "Itagüi", "Jamundí", "La Dorada", "Los Patios", "Madrid", "Magangué", "Maicao", "Malambo", "Manizales", "Medellín", "Montelíbano", "Monteria", "Mosquera", "Neiva", "Ocaña", "Palmira", "Pamplona", "Pasto", "Pereira", "Piedecuesta", "Pitalito", "Planeta Rica", "Popayán", "Quibdó", "Riohacha", "Rionegro", "Sabanalarga", "Sahagun", "San Andrés", "San Andrés de Sotavento", "San Andrés de Tumaco", "San José de Cúcuta", "San Juan de Girón", "Santa Cruz de Lorica", "Santa Marta", "Santa Rosa de Cabal", "Santander de Quilichao", "Sincelejo", "Soacha", "Sogamoso", "Soledad", "Tierralta", "Tuluá", "Tunja", "Turbaco", "Valledupar", "Villa del Rosario", "Villavicencio", "Yopal", "Yumbo", "Zipaquirá");
                    foreach ($ciudades as $ciudad) {
                        if ($ciudad != 'default') {
                            $option_ciudades[$ciudad] = $ciudad;
                            if (!$selected) {
                                $selected = $ciudad;
                            }
                        }
                    }
                    echo form_dropdown('ciudadEnvio', $option_ciudades, $usuario->lugar, 'id="ciudadEnvio"'); //, 'id="marca_registrarse"');
                    ?>
                    <label>Dirección de envío:</label>
                    <input type="text" name="direccionEnvio" id="direccionEnvio"/>
                    <label>Teléfono de contacto:</label>
                    <input type="text" name="telefonoMovil" id="telefonoMovil"/>
                    <label>Documento de identidad: (*opcional)</label>
                    <input type="text" name="di" id="di"/>
                    <label>Marca y línea del vehículo: (*opcional)</label>
                    <input type="text" name="carro" id="carro" value="<?php echo $vehiculo->marca.' '.$vehiculo->linea?>"/>
                    <label>Número de placa: (*opcional)</label>
                    <input type="text" name="placa" id="placa" value="<?php echo $vehiculo->numero_placa; ?>"/> 
                    <label>Correo electrónico:</label>
                    <input name="emailComprador" class="emailComprador" id="emailComprador" type="text" value="<?php echo $emailComprador;?>">
                    <input type="submit" value="Enviar"/>
                    <div class="clear"></div>
                </form>
            </div>

            <div id="carrito-div-detalle-pago">
                <div id="carrito-div-detalle-pago-subtotal">
                    <strong>Subtotal a pagar:</strong> <span class="format-precio" id="carrito-span-detalle-pago-subtotal">$<?php echo number_format($baseDevolucionIva,0,',','.');?></span>
                </div>
                <div id="carrito-div-detalle-pago-iva">
                    <strong>IVA:</strong> <span class="format-precio" id="carrito-span-detalle-pago-iva">$<?php echo number_format($iva,0,',','.');?></span>
                </div>
                <div id="carrito-div-detalle-pago-total">
                    <strong>Total a pagar:</strong> <span id="carrito-span-detalle-pago-total" class="format-precio">$<?php echo number_format($valor,0,',','.');?></span>
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
                                <?php echo strip_tags($autoparte['options']['descripcion']); ?> 
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