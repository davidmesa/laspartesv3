<?php
$var_impar = false;
$var = 1;
$sizeAllofertas = sizeof($allofertas);
$contador = 0;
foreach ($allofertas as $oferta):
    $contador++;
    ?>
    <div class="usuario-div-oferta <?php
    if (($sizeAllofertas % 2 == 0 && $contador < $sizeAllofertas - 1))
        echo "subsesion";
    else if ($sizeAllofertas % 2 == 1 && $contador != $sizeAllofertas)
        echo "subsesion";
    ?> open-sans <?php
     if ($var_impar) {
         echo 'oferta-derecha';
         $var_impar = false;
     } else {
         $var_impar = true;
     }
     ?>">
        <div class="usuario-div-id_oferta"><?php echo $oferta->id_oferta; ?></div>
        <div class="usuario-div-oferta-left">

            <div class="usuario-div-oferta-marco  lightboxme">
                <img src="<?php echo $oferta->logo; ?>" alt="icono oferta" />
            </div>

            <div class="usuario-div-oferta-precio lightboxme">
                <?php
                if ($oferta->dco_feria != 0):
                    $precio = $oferta->precio;
                    $iva = $oferta->iva;
                    $dco = $oferta->dco_feria;
                    $base = $precio - $iva;
                    $ivaPorce = $iva / $base;
                    $valorDco = $base * ((100 - $dco) / 100);
                    $precionConDco = ($valorDco * (1 + $ivaPorce));
                    ?>
                    <span>$ <?php echo number_format($precionConDco, 0, ",", "."); ?></span>
                    <div class="usuario-div-oferta-precio-sin-descuento">Antes: <strike>$ <?php echo number_format($oferta->precio, 0, ",", "."); ?></strike></div>
                <?php else: ?>
                    <span>$ <?php echo number_format($oferta->precio, 0, ",", "."); ?></span>
    <?php endif; ?>
            </div>

        </div>

        <div class="usuario-div-oferta-right">
            <div class="usuario-div-oferta-titulo lightboxme">
    <?php echo $oferta->titulo; ?>
            </div>

            <div class="usaurio-div-oferta-validez-desde">

            </div>

            <div class="usuario-div-oferta-validez-hasta">
                OFERTA VÁLIDA HASTA EL <?php echo strftime("%d de %B de %Y", strtotime($oferta->vigencia)); ?>
            </div>

            <div style="font-size:12px; color:black;  margin-top: 20px; font-weight: bold;">Incluye:</div>

            <div class="usuario-div-oferta-incluye">
    <?php echo $oferta->incluye; ?>
            </div>

            <div class="usuario-div-oferta-comprar lightboxme">
                <input type="button" value="COMPRAR" />
            </div>
            <div class="clear"></div>
        </div>

        <div class="clear"></div>
    </div>

    <?php
    if ($var % 2 == 0) {
        echo '<div class="clear"></div>';
    }
    $var++;
    ?>
<?php endforeach; ?>




<div class="clear"></div>