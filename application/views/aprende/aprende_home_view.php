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
        <div class="div-content-left-novedades">
            <div id="autopart-div-autopartes-titulo">
                <div id="autopart-div-titulo-icono">
                    <img src="<?php echo base_url(); ?>resources/images/novedades/novedad-icon.png" alt="icono autopartes" />
                </div>
                <div id="autopart-div-titulo">
                    <h1>
                        <span style="color: #C60200;">APRENDE</span>
                    </h1>
                </div>


                <div class="clear"></div>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>
            <div id="novedades-div-noticia-content">
                <?php
                if (sizeof($noticias) != 0):
                    foreach ($noticias as $noticia):
                        ?>
                        <div id="novedades-div-pregunta">
                            <div id="novedades-div-pregunta-marco">
                                <?php if ($noticia->imagen_thumb_url != '' && $noticia->imagen_thumb_url != NULL) { ?>
                                    <a href="<?php echo base_url(); ?>noticias/<?php echo $noticia->id_noticia; ?>-<?php echo str_replace(' ', '-', convert_accented_characters($noticia->titulo)); ?>"><img src="<?php echo base_url() . $noticia->imagen_url; ?>" alt="<?php echo $noticia->titulo; ?>" /></a>
                                <?php } ?>
                            </div>

                            <div id="novedades-div-pregunta-content">
                                <div id="novedades-div-pregunta-titulo">
                                    <a href="<?php echo base_url(); ?>noticias/<?php echo $noticia->id_noticia; ?>-<?php echo str_replace(' ', '-', convert_accented_characters($noticia->titulo)); ?>"><?php echo $noticia->titulo; ?></a>
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
                                    <span class="autopart-detalle-span-vermas"><a href="<?php echo base_url(); ?>noticias/<?php echo $noticia->id_noticia; ?>-<?php echo str_replace(' ', '-', convert_accented_characters($noticia->titulo)); ?>">LEER MÁS</a></span>
                                    <img style="margin-left:3px;" src="<?php echo base_url(); ?>resources/images/home/mayor-que-rojo.png" alt="mayor que" /><img src="<?php echo base_url(); ?>resources/images/home/mayor-que-rojo.png" alt="mayor que" />
                                </div>

                                <div class="clear"></div>
                            </div>

                            <div class="clear"></div>
                        </div>
                    <?php
                    endforeach;
                endif;
                ?>
            </div>
            <div class="talleres-div-vermas div-ver-mas open-sans">
                <span class="autopart-detalle-span-vermas noticia-ver-mas">VER MÁS NOTICIAS</span>
                <img style="margin-left:3px;" src="<?php echo base_url(); ?>resources/images/home/mayor-que-rojo.png" alt="mayor que" /><img src="<?php echo base_url(); ?>resources/images/home/mayor-que-rojo.png" alt="mayor que" />
            </div>
        </div>

        <div class="div-content-center-novedades">
            <div id="autopart-div-autopartes-titulo">
                <div id="autopart-div-titulo">
                    <div id="autopart-div-titulo-icono" style="margin-top: 0px;"> 
                        <img src="<?php echo base_url(); ?>resources/images/novedades/bombillo-icono.png" alt="icono tips" />
                    </div>
                    <h1>
                        <span>TIPS Y </span>
                        <span style="color: #C60200;">CONSEJOS</span>
                    </h1>
                </div>

                <div class="clear"></div>
            </div>
            <div class="autopart-div-espaciador-rallas"></div>
            <div id="novedades-div-tips-content">
                <?php
                if (sizeof($tips) != 0):
                    foreach ($tips as $tip):
                        ?>
                        <div class="novedades-div-tip">
                            <div class="novedades-div-tip-titulo">
                                <a href="<?php echo base_url(); ?>tips/<?php echo $tip->id_tip; ?>-<?php echo str_replace(' ', '-', convert_accented_characters($tip->titulo)); ?>"><?php echo character_limiter($tip->titulo, 80); ?></a>
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
        <?php echo strftime("%B %d de %Y",strtotime($tip->fecha)); ?>
                                </div>	
                            </div>
                            <img class="novedades-div-tip-icon" src="<?php echo base_url(); ?>resources/images/novedades/bombillo-pequeno-icono.png"  alt="icono bombillo" />
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                    <?php
                    endforeach;
                endif;
                ?>
            </div>
            <div class="talleres-div-vermas div-ver-mas open-sans">
                <span class="autopart-detalle-span-vermas tips-ver-mas">VER MÁS TIPS</span>
                <img style="margin-left:3px;" src="<?php echo base_url(); ?>resources/images/home/mayor-que-rojo.png" alt="mayor que" /><img src="<?php echo base_url(); ?>resources/images/home/mayor-que-rojo.png" alt="mayor que" />
            </div>
        </div>

        <div class="clear"></div>
    </div>
</div>