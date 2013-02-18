<div id="home-div-content">
    <div id="novedades-div-banner">
        <div id="tallerlinea-div-banner-comunidad">
            <div id="tallerlinea-div-banner-comunidad-titulo">

                <h1 style="font-size: 30px;">¡CONOCE MÁS SOBRE TU CARRO!</h1>
                <h1>LAS ÚLTIMAS TENDENCIAS Y LOS MEJORES CONSEJOS PARA QUE ESTÉS AL DÍA.</h1>
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
        <div class="div-content-left-novedades-detalle">
            <div id="autopart-div-autopartes-titulo">
                <div id="autopart-div-titulo-icono">
                    <img src="<?php echo base_url(); ?>resources/images/novedades/novedad-icon.png" alt="icono autopartes" />
                </div>
                <div id="autopart-div-titulo">
                    <h1>
                        <span style="color: #C60200;">NOTICIAS</span>
                        <span> / DETALLE</span>
                    </h1>
                </div>


                <div class="clear"></div>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>
            <div id="novedades-detalle-div-noticia-content">
                <div id="novedades-detalle-div-pregunta">
                    <div id="novedades-detalle-div-pregunta-marco">
                        <?php if ($noticia->imagen_url != '' && $noticia->imagen_url != NULL) { ?>
                            <a href="<?php echo base_url(); ?>noticias/<?php echo $noticia->id_noticia; ?>-<?php echo str_replace(' ', '-', convert_accented_characters($noticia->titulo)); ?>"><img src="<?php echo base_url() . $noticia->imagen_url; ?>" alt="<?php echo $noticia->titulo; ?>" /></a>
                        <?php } ?>
                    </div>

                    <div id="novedades-detalle-div-pregunta-content">
                        <div id="novedades-detalle-div-pregunta-titulo">
                            <?php echo $noticia->titulo; ?>
                        </div>

                        <div id="novedades-detalle-div-pregunta-fecha">
                            <?php echo strftime("%B %d de %Y", strtotime($noticia->fecha)); ?>
                        </div>

                        <div id="novedades-detalle-div-pregunta-cuerpo">
                            <table><?php echo $noticia->noticia; ?></table>
                        </div>

                        <div class="clear"></div>

                    </div>

                    <div class="clear"></div>
                </div>
                <div id="tallerlinea-detalle-div-publicar">
                    ¿Te gustaría publicar una noticia en nuestra comunidad? escríbenos a contactenos@laspartes.com.co<br/>
                    <a href="mailto:contactenos@laspartes.com.co?subject=me gustaría publicar una noticia">Haz click aquí</a>
                </div>
                <div id="tallerlinea-detalle-div-pregunta-redes">
                    <div class="fb-like"   data-send="false" data-layout="box_count" data-width="450" data-show-faces="false" data-font="arial"></div>
                    <a href="https://twitter.com/share" class="twitter-share-button" data-text="#tallerenlinea <?php echo $noticia->titulo; ?>" data-count="vertical" data-lang="es">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
                    <g:plusone size="tall"></g:plusone>
                </div>
                <div class="clear"></div>
            </div>
        </div>

        <div class="div-content-center-novedades-detalle">
            <div id="autopart-div-autopartes-titulo">
                <div id="autopart-div-titulo">
                    <h1>
                        <span>OTRAS NOTICIAS</span>
                    </h1>
                </div>

                <div class="clear"></div>
            </div>
            <div class="autopart-div-espaciador-rallas"></div>


            <div id="novedades-detalle-div-noticias-content">
                <?php
                if (sizeof($noticias) != 0):
                    foreach ($noticias as $noti):
                        ?>

                        <div class="novedades-detalle-div-noticia">
                            <div class="novedades-detalle-div-noticias-marco">
                                <?php if ($noti->imagen_thumb_url != '' && $noti->imagen_thumb_url != NULL) { ?>
                                    <a href="<?php echo base_url(); ?>noticias/<?php echo $noti->id_noticia; ?>-<?php echo str_replace(' ', '-', convert_accented_characters($noti->titulo)); ?>"><img src="<?php echo base_url() . $noti->imagen_url; ?>" alt="<?php echo $noti->titulo; ?>" /></a>
                                <?php } ?>
                            </div> 
                            <div class="novedades-detalle-div-noticia-titulo">
                                <a href="<?php echo base_url(); ?>noticias/<?php echo $noti->id_noticia; ?>-<?php echo str_replace(' ', '-', convert_accented_characters($noti->titulo)); ?>"><?php echo character_limiter($noti->titulo, 50); ?></a>
                            </div>

                            <div class="novedades-detalle-div-noticia-cuerpo">
                                <table>
                                    <tr>
                                        <td>
                                            <?php echo character_limiter($noti->noticia, 50); ?>
                                        </td>
                                    </tr>
                                </table>

                            </div>

                            <img class="novedades-detalle-div-noticia-separador" src="<?php echo base_url(); ?>resources/images/tallerenlinea/separador-establecimiento.png" alt="separador tip" />
                        </div>
                        <div class="clear"></div>
                        <?php
                    endforeach;
                endif;
                ?>
                <div class="clear"></div>
            </div>

        </div>

        <div class="clear"></div>
    </div>
</div>