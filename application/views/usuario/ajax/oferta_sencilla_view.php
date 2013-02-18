<div class="usuario-div-oferta-lightbox open-sans">
    <form class="forma_pagosonline" id="forma_pagosonline" method="post" action="usuario/agregar_carrito_compras_promo">
        <input name="id_oferta" class="id_oferta" type="hidden" value="<?php echo $oferta->id_oferta ?>" >
    
        <?php $urlOferta = base_url().'promociones/'.$oferta->id_oferta.'-'.preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $oferta->titulo);?>
    <div class="usuario-div-oferta-lightbox-etiqueta">

        <div class="usuario-div-oferta-lightbox-titulo">
            
            <?php
                $text = strip_tags($oferta->titulo);
                $words = explode(" ", $text);
                $content = "";
                $i = 0;
                foreach ($words as $word) {
                    if ($i == 5) {
                        break;
                    }
                    if ($i) {
                        $content .= " ";
                    }
                    $content .= $word;
                    $i++;
                }
                echo $content . "…";
            ?>
        </div>

        <div class="usuario-div-oferta-lightbox-precio">
            <?php if($oferta->dco_feria != 0): 
                    $precio = $oferta->precio;
                    $iva = $oferta->iva;
                    $dco = $oferta->dco_feria;
                    $base = $precio-$iva;
                    $ivaPorce = $iva/$base;
                    $valorDco = $base*((100-$dco)/100);
                    $precionConDco = ($valorDco*(1+$ivaPorce));    

            ?>
            <span>$ <?php echo number_format($precionConDco, 0, ",", "."); ?></span>
            <div class="usuario-div-oferta-lightbox-precio-sin-descuento">Antes: <strike>$ <?php echo number_format($oferta->precio, 0, ",", "."); ?></strike></div>
            <?php else: ?>
            <span>$ <?php echo number_format($oferta->precio, 0, ",", "."); ?></span>
            <?php endif; ?>
        </div>

        <div class="usuario-div-oferta-lightbox-condiciones">
            <strong>Términos y condiciones:</strong> <?php echo $oferta->condiciones;?><br/><br/>
            <div class="usuario-div-oferta-lightbox-condiciones-vehiculos">*Oferta válida para vehículos identificados con la oferta. <a href="<?php echo $urlOferta;?>">Ver vehículos</a></div>
        </div>

    </div>

    <div class="usuario-div-oferta-lightbox-informacion">

        <div class="usuario-div-oferta-lightbox-cerrar"></div>

        <div class="usuario-div-oferta-lightbox-info-titulo">
            <a href="<?php echo $urlOferta;?>"><?php echo $oferta->titulo ;?></a>
        </div>
        <div class="usuario-div-oferta-lightbox-validez">
            OFERTA VÁLIDA HASTA <strong><?php echo strftime("%d de %B de %Y", strtotime($oferta->vigencia));?></strong>
        </div>
        <div class="usuario-div-oferta-lightbox-fotoincluye">
            <div class="usuario-div-oferta-lightbox-marco">
                <img src="<?php echo base_url().$oferta->logoTarea; ?>" alt="icono oferta" />
            </div>
            <div class="usaurio-div-oferta-lightbox-incluye">
                <span style="color: black; font-weight:bold; font-size: 12px;">Incluye:</span>
                <div class="usaurio-div-oferta-lightbox-incluye-items">
                    <?php echo $oferta->incluye;?>
                </div>

            </div>

            <div class="clear"></div>
        </div>

        <div style="margin-left:20px; color: black; font-size: 12px; font-weight:bold;">
            ESTABLECIMIENTO QUE OFRECE ESTE SERVICIO
        </div>

        <div class="usuario-div-oferta-lightbox-fototaller">
            <div class="usuario-div-oferta-lightbox-marco">
                <a href="<?php echo base_url() . 'talleres/' . $oferta->id_establecimiento . '-' . str_replace(" ", "-", convert_accented_characters($oferta->establecimientoNombre)); ?>">
                    <img src="<?php echo base_url().$oferta->logo; ?>" alt="icono oferta" />
                </a>
            </div>
            <div class="usaurio-div-oferta-lightbox-tallerinfo">
                <div class="usaurio-div-oferta-lightbox-taller-nombre">
                    <a href="<?php echo base_url() . 'talleres/' . $oferta->id_establecimiento . '-' . str_replace(" ", "-", convert_accented_characters($oferta->establecimientoNombre)); ?>">
                        <?php echo $oferta->establecimientoNombre; ?>
                    </a>
                </div>

                <div class="usaurio-div-oferta-lightbox-taller-url">
                    <div class=""><?php echo $oferta->establecimientoDescripcion; ?></div>
                    <a href="http://<?php echo $oferta->web; ?>" target="_blank"><?php echo $oferta->web; ?></a>
                </div>

                <div class="usaurio-div-oferta-lightbox-taller-direccion">
                    <?php echo $oferta->direccion; ?>
                </div>

                <div class="usaurio-div-oferta-lightbox-taller-telefono">
                    <strong style="color: black;">Tel: </strong><?php echo $oferta->telefonos; ?>
                </div>

            </div>
            
            <div class="usuario-div-oferta-lightbox-calificacion">
                <?php echo $oferta->num_comentarios; ?> Usuarios han calificado este taller.
            </div>

            <div class="clear"></div>
        </div>

        <div class="usuario-div-oferta-tarjetas">
            <img src="<?php echo base_url(); ?>/resources/images/micuenta/pago-visa.png" alt="visa" />
            <img src="<?php echo base_url(); ?>/resources/images/micuenta/pago-mastercard.png" alt="master card" />
            <img src="<?php echo base_url(); ?>/resources/images/micuenta/pago-americanexp.png" alt="american express" />
        </div>

        <div class="usuario-div-oferta-comprar">
            <input  type="submit" value="PAGAR" title="PAGAR" >
        </div>

    </div>

    <div class="clear"></div>
    </form>
</div>