<?php
if (sizeof($noticias) != 0):
    foreach ($noticias as $noticia):
        ?>
        <div id="novedades-div-pregunta">
            <div id="novedades-div-pregunta-marco">
                <?php if ($noticia->imagen_thumb_url != '' && $noticia->imagen_thumb_url != NULL) { ?>
                    <a href="<?php echo base_url(); ?>aprende/noticia/<?php echo $noticia->id_noticia; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($noticia->titulo)); ?>"><img src="<?php echo base_url() . $noticia->imagen_url; ?>" alt="<?php echo $noticia->titulo; ?>" /></a>
                <?php } ?>
            </div>

            <div id="novedades-div-pregunta-content">
                <div id="novedades-div-pregunta-titulo">
                    <a href="<?php echo base_url(); ?>aprende/noticia/<?php echo $noticia->id_noticia; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($noticia->titulo)); ?>"><?php echo $noticia->titulo; ?></a>
                </div>

                <div id="novedades-div-pregunta-cuerpo">
                    <table>
                        <tr>
                            <td>
                                <?php echo character_limiter($noticia->noticia, 450); ?>
                            </td>
                        </tr>
                    </table>

                </div>

                <div class="clear"></div>
                <div class="talleres-div-vermas open-sans">
                    <span class="autopart-detalle-span-vermas"><a href="<?php echo base_url(); ?>aprende/noticia/<?php echo $noticia->id_noticia; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($noticia->titulo)); ?>">LEER MÁS</a></span>
                    <img style="margin-left:3px;" src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" /><img src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" />
                </div>

                <div class="clear"></div>
            </div>

            <div class="clear"></div>
        </div>
        <?php
    endforeach;
endif;
?>