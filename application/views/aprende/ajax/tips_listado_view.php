<?php
if (sizeof($tips) != 0):
    foreach ($tips as $tip):
        ?>
        <div class="novedades-div-tip">
            <div class="novedades-div-tip-titulo">
                <a href="<?php echo base_url(); ?>novedades/tip/<?php echo $tip->id_tip; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($tip->titulo)); ?>"><?php echo character_limiter($tip->titulo, 80); ?></a>
            </div>

            <div class="novedades-div-tip-cuerpo">
                <table>
                    <tr>
                        <td>
                            <?php echo character_limiter($tip->tip, 80); ?>
                        </td>
                    </tr>
                </table>
            </div>

            <img class="novedades-div-tip-separador" src="<?php echo base_url(); ?>resources/images/home/separador-tweet.png" alt="separador tip" />

            <div class="novedades-div-tip-autorfecha">
                <div class="novedades-div-tip-autor">
                    Por: Luis Cabarique
                </div>
                <div class="novedades-div-tip-fecha">
                    <?php echo strftime("%B %d de %Y", strtotime($tip->fecha)); ?>
                </div>	
            </div>
            <img class="novedades-div-tip-icon" src="<?php echo base_url(); ?>resources/images/novedades/bombillo-pequeno-icono.png"  alt="icono bombillo" />
        </div>
        <div class="clear"></div>
    <?php
    endforeach;
endif;
?>