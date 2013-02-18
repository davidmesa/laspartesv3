<?php
$temp_impar = false;
$var = 1;
if (sizeof($carritos_compras) != 0) {
    foreach ($carritos_compras as $carrito_compra) {
        if (sizeof($carritos_compras_autopartes) != 0) {

            foreach ($carritos_compras_autopartes as $carrito_compra_autoparte) {
                if ($carrito_compra_autoparte->carrito == $carrito_compra->id_carrito_compra && strlen($carrito_compra_autoparte->nombre) > 0) {
                    ?>

                    <!--                                aqui va la información de carritos de compra de autopartes-->

                    <?php
                    $numero_carrito_compra_autoparte++;
                } else if ($carrito_compra_autoparte->carrito == $carrito_compra->id_carrito_compra && strlen($carrito_compra_autoparte->nombre) == 0) {
                    ?>
                    <div class="usuario-div-compra subsesion open-sans <?php
                    if ($temp_impar) {
                        echo 'compraderecha';
                        $temp_impar = false;
                    } else {
                        $temp_impar = true;
                    }
                    ?>">
                        <div class="usuario-div-compra-left">

                            <div class="usuario-div-compra-marco">
                                <img src="../../../resources/ofertas/oferta1.png" alt="icono oferta" />
                            </div>

                        </div>

                        <div class="usuario-div-compra-right">
                            <div class="usuario-div-compra-titulo">
                                <?php echo $carrito_compra_autoparte->titulo; ?>
                            </div>

                            <div class="usuario-div-compra-precio">
                                $<?php echo number_format($carrito_compra_autoparte->precioOferta, 0, ',', '.'); ?>
                            </div>

                            <div class="usuario-div-compra-fecha">
                                <?php echo strftime("%B %d de %Y", strtotime($carrito_compra->fecha)); ?>
                            </div>

                            <div class="usuario-div-compra-estado">
                                <strong style="color:black;">Estado:</strong> <span><?php echo $carrito_compra->estado; ?></span>
                            </div>

                            <div class="usuario-div-compra-factura">
                                <a href="">FACTURA</a><img style="margin-left:3px;" src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" /><img src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" /> 
                            </div>

                            <div class="clear"></div>
                        </div>

                        <div class="clear"></div>
                    </div>

                    <?php
                    $numero_carrito_compra_autoparte++;
                    if ($var % 2 == 0) {
                        echo '<div class="clear"></div>';
                    }
                    $var++;
                }//end if
            }//end foreach
        }// end if
    }//end foreach
}//end if
?>
<div class="clear"></div>