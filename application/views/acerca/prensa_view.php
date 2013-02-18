<div id="home-div-content">
    <div id="novedades-div-banner">
        <div id="tallerlinea-div-banner-comunidad">
            <div id="tallerlinea-div-banner-comunidad-titulo">

                 <h1 style="font-size: 30px;">"Visualizaron una oportunidad de negocio</h1>
                <h1>que no existía en America Latína"</h1>
                <h1 style="float: right; margin-right: 100px;">ELTIEMPO.COM</h1>
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
                    <img  src="<?php echo base_url(); ?>resources/images/novedades/novedad-icon.png" alt="icono novedades" />
                </div>
                <div id="autopart-div-titulo">
                    <h1>
                        <span style="color: #C60200;">PRENSA</span>
                    </h1>
                </div>

                <div class="clear"></div>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>
            <div id="quienes-detalle-div">
                <a target="blank" href="http://www.portafolio.co/negocios/asi-sera-el-salon-del-automovil-bogota">
                    <div id="prensa-detalle-div-marco">
                        <img src="<?php echo base_url();?>resources/images/acerca/portafolio.png" alt="logo de portafolio.co"/>
                    </div>
                </a>
                <div id="prensa-detalle-div-content">

                    <div id="prensa-div-titulo">
                        <a target="blank" href="http://www.portafolio.co/negocios/asi-sera-el-salon-del-automovil-bogota">Laspartes.com en el salón internacional del automóvil</a>
                    </div>
                    
                    <div id="prensa-div-fecha">
                        octubre 29 de 2012
                    </div>
                </div>

                <div class="clear"></div>
                
                
                <div id="prensa-detalle-div-cuerpo">
                    "Por otro lado, laspartes.com presentará una web diseñada para ayudar a los usuarios en el mantenimiento y reparación de vehículos. Es un site que funciona como taller en línea, en donde..."
                </div>
                <div class="autopart-div-autoparte-vermas" style="text-align: right;">
                                
                    <a target="blank" href="http://www.portafolio.co/negocios/asi-sera-el-salon-del-automovil-bogota">Ver más</a>
                    <img src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que" style="right: 0px;"/>
                    <img src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que" style="right: 4px;"/>
                </div>
                <div class="clear"></div>
            </div>

            <div id="quienes-detalle-div">
                <a target="blank" href="http://www.eltiempo.com/archivo/documento/MAM-3512861">
                    <div id="prensa-detalle-div-marco">
                        <img src="<?php echo base_url();?>resources/images/acerca/logo_eltiempo.png" alt="logo de eltiempo.com"/>
                    </div>
                </a>
                <div id="prensa-detalle-div-content">

                    <div id="prensa-div-titulo">
                        <a target="blank" href="http://www.eltiempo.com/archivo/documento/MAM-3512861">Visualizaron una oportunidad de negocio que no existía en América Latína</a>
                    </div>
                    
                    <div id="prensa-div-fecha">
                        agosto 3 de 2012
                    </div>
                </div>

                <div class="clear"></div>
                
                
                <div id="prensa-detalle-div-cuerpo">
                    "Visualizaron una oportunidad de negocio que no existía en América Latína y así, Felipe Pacheco y Camilo Jiménez se decidieron por la creación de su portal laspartes.com, punto de encuentro en línea de compradores y vendedores de partes para carros"
                </div>
                <div class="autopart-div-autoparte-vermas" style="text-align: right;">
                                
                    <a target="blank" href="http://www.eltiempo.com/archivo/documento/MAM-3512861">Ver más</a>
                    <img src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que" style="right: 0px;"/>
                    <img src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que" style="right: 4px;"/>
                </div>
                 <div class="clear"></div>
            </div>

            <div id="prensa-div-redes">
                <div class="fb-like"  data-send="false" data-layout="box_count" data-width="450" data-show-faces="false" data-font="arial"></div>
                <a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php echo $pregunta->titulo_pregunta; ?> via @laspartes" data-count="vertical" data-lang="es">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
                <g:plusone size="tall"></g:plusone>
            </div>

        </div>
        
        <div class="div-content-center-novedades-detalle">
            <div id="autopart-div-autopartes-titulo">
                <div id="autopart-div-titulo">
                    <h1>
                        <span>LINKS RELACIONADOS</span>
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