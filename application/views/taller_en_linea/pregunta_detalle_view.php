<div class="registro-login-div" id="registro-login-div"></div>
<div id="home-div-content">
    <div id="tallerlinea-div-banner">
        <div id="tallerlinea-div-banner-comunidad">
            <div id="tallerlinea-div-banner-comunidad-titulo">
                <h1>¡UNA COMUNIDAD DE MÁS DE <?php echo $numero_establecimientos-1; ?> TALLERES ALIADOS</h1>
                <h1 style="font-size: 31px;">DISPUESTOS A RESOLVER TUS DUDAS!</h1>
            </div>   

            <div id="tallerlinea-div-banner-comunidad-preguntanos">
                <h1>PREGÚNTANOS</h1>
            </div>
            <div id="tallerlinea-div-banner-comunidad-comparte">
                <h1><a href="<?php echo base_url();?>preguntas#autopart-div-autopartes-titulo">COMPARTE CON NOSOTROS TU EXPERIENCIA</a></h1>
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

        <div class="div-content-left-tallerlinea">
            <div id="autopart-div-autopartes-titulo">
                <div id="autopart-div-titulo-icono">
                    <img src="<?php echo base_url();?>resources/images/home/preguntas.png" alt="icono preguntas" />
                </div>
                <div id="autopart-div-titulo">
                    <h1>
                        <span style=" margin-left: 5px; color: #C60200;">PREGUNTAS</span>
                        <span> / DETALLE</span>
                    </h1>
                </div>

                <div class="clear"></div>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>

            <div id="tallerlinea-detalle-div-pregunta">
                <div id="tallerlinea-detalle-div-pregunta-marco"> 
                    <?php if(strlen($pregunta->thumb)>0):?>
                        <a href="<?php echo base_url().'talleres/'.$pregunta->idEstablecimiento.'-'.str_replace(' ', '-', convert_accented_characters($pregunta->nombreEstablecimiento)); ?>">
                            <img src="<?php echo base_url().$pregunta->thumb; ?>" alt="<?php echo $pregunta->usuario; ?>"/>
                        </a>
                    <?php elseif($pregunta->imagen_url !='' || $pregunta->imagen_url!=NULL):?> 
                        <img src="<?php if(strpos($pregunta->imagen_url, 'http') !== false) echo $pregunta->imagen_url; else echo base_url().$pregunta->imagen_url; ?>" alt="<?php echo $pregunta->usuario; ?>"/>

                    <?php
                    else:?>
                        <img src="<?php echo base_url().'resources/images/usuarios/avatar_thumb.gif';  ?>" alt="<?php echo $pregunta->usuario; ?>"/>
                    <?php
                    endif; ?>
                    
                </div>

                <div id="tallerlinea-detalle-div-pregunta-content">
                    <div id="tallerlinea-detalle-div-pregunta-titulo">
                        <?php echo $pregunta->titulo_pregunta; ?>
                    </div>
                    <div id="tallerlinea-detalle-div-pregunta-autor">
                        <?php if(strlen($pregunta->thumb)>0):?>
                        <a href="<?php echo base_url().'talleres/'.$pregunta->idEstablecimiento.'-'.str_replace(' ', '-', convert_accented_characters($pregunta->nombreEstablecimiento)); ?>">
                            vehiculos_usuario
                        </a>
                        <?php else:
                                echo $pregunta->usuario;
                        endif; ?>
                       
                    </div>
                    <div id="tallerlinea-detalle-div-pregunta-autor" style="margin-top: 0px;">
                        <?php foreach ($vehiculos_usuario as $index => $vehiculo): 
                            echo  $vehiculo->marca.' '.$vehiculo->linea;
                            if($index+1 < count($vehiculos_usuario))
                                echo ' | ';
                         endforeach; ?>
                       
                    </div>

                    <div id="tallerlinea-detalle-div-pregunta-fecha">
                        <?php echo real_date($pregunta->fecha); ?>
                    </div>

                    <div id="tallerlinea-detalle-div-pregunta-cuerpo">
                        <?php echo nl2br($pregunta->cuerpo_pregunta); ?>
                    </div>

                    <div id="tallerlinea-detalle-div-pregunta-reportar" class="lightbox-reportar">
                        REPORTAR ABUSO
                    </div>

                    <div id="tallerlinea-detalle-div-pregunta-redes">
                        <div class="fb-like"   data-send="false" data-layout="box_count" data-width="450" data-show-faces="false" data-font="arial"></div>
                        <a href="https://twitter.com/share" class="twitter-share-button" data-text="#tallerenlinea <?php echo $pregunta->titulo_pregunta; ?>" data-count="vertical" data-lang="es">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
                        <g:plusone size="tall"></g:plusone>
                    </div>
                </div>

                <div class="clear"></div>
            </div>

                <input type="submit" id="tallerlinea-input-submit-link"  value="RESPONDER" />

            <div class="clear"></div>

            <div id="tallerlinea-detalle-div-respuestas"> 
                <?php if(sizeof($respuestas)> 0):
                                        foreach($respuestas as $respuesta): ?>
                <div class="tallerlinea-detalle-div-respuesta">
                    <input type="hidden" class="tallerlinea-detalle-input-respuesta-id" value="<?php echo $respuesta->id_respuesta; ?>"/>
                    <div id="tallerlinea-detalle-div-pregunta-marco">
                        <?php if(strlen($respuesta->thumb)>0):?>
                            <a href="<?php echo base_url().'talleres/'.$respuesta->idEstablecimiento.'-'.str_replace(' ', '-', convert_accented_characters($respuesta->nombreEstablecimiento)); ?>">
                                <img src="<?php if(strpos($respuesta->thumb, 'http') !== false) echo $respuesta->thumb; else echo base_url().$respuesta->thumb; ?>" alt="<?php echo $respuesta->usuario; ?>"/>
                            </a>
                    <?php elseif($respuesta->imagen_url!='' && $respuesta->imagen_url!=NULL):?>
                        <img src="<?php if(strpos($respuesta->imagen_url, 'http') !== false) echo $respuesta->imagen_url; else echo base_url().$respuesta->imagen_url; ?>" alt="<?php echo $respuesta->usuario; ?>"/>

                    <?php
                    else:?>
                        <img src="<?php echo base_url().'resources/images/usuarios/avatar_thumb.gif';  ?>" alt="<?php echo $pregunta->usuario; ?>"/>
                    <?php
                    endif; ?>
                         
                    </div>

                    <div id="tallerlinea-detalle-div-respuesta-content">
                        <div id="tallerlinea-detalle-div-respuesta-respuesta">
                            Respuesta:
                        </div>

                        <div id="tallerlinea-detalle-div-respuesta-autor">
                            <?php if(strlen($respuesta->thumb)>0):?>
                            <a href="<?php echo base_url().'talleres/'.$respuesta->idEstablecimiento.'-'.str_replace(' ', '-', convert_accented_characters($respuesta->nombreEstablecimiento)); ?>">
                                <?php echo $respuesta->usuario; ?>
                            </a>
                            <?php else:
                                    echo $respuesta->usuario;
                            endif; ?>
                        </div>
                        
                        <div id="tallerlinea-detalle-div-pregunta-fecha">
                            <?php echo real_date($respuesta->fecha); ?>
                        </div>

                        <div id="tallerlinea-detalle-div-respuesta-cuerpo">
                            <?php echo nl2br($respuesta->respuesta); ?>
                        </div>

                        <div id="tallerlinea-detalle-div-respuesta-reportar" class="lightbox-reportar-respuesta">
                            REPORTAR ABUSO
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="clear"></div>
                </div>
                <?php endforeach; endif; ?>
            </div>


            <div id="tallerlinea-detalle-div-responder">
                <div id="autopart-div-titulo">
                    <h1>
                        <span>ESCRIBE</span>
                        <span style="color: #C60200;">TU RESPUESTA</span>
                    </h1>
                </div>
                <form id="forma-responder">
                    <textarea id="tallerlinea-textarea-respuesta" name="respuesta"></textarea>
                    <input type="submit" id="tallerlinea-input-submit" value="RESPONDER" />
                    <div class="clear"></div>
                </form>

            </div>
        </div>
        <div class="div-content-center-tallerlinea">
            <div id="autopart-div-autopartes-titulo">
                <div id="autopart-div-titulo">
                    <h1>
                        <span>PREGUNTAS RELACIONADAS</span>
                    </h1>
                </div>

                <div class="clear"></div>
            </div>
            <div class="autopart-div-espaciador-rallas"></div>

            <?php if(sizeof($preguntas_relacionadas)!=0):
                                        foreach($preguntas_relacionadas as $pregunta_relacionada): ?>
            <div class="tallerlinea-detalle-div-relacionada">
                <div class="tallerlinea-detalle-div-relacionada-titulo">
                    <?php echo character_limiter($pregunta_relacionada->titulo_pregunta, 80); ?>
                </div>

                <div class="tallerlinea-detalle-div-relacionada-cuerpo">
                    <?php echo character_limiter($pregunta_relacionada->cuerpo_pregunta, 80); ?>
                </div>

                <div class="talleres-div-vermas div-ver-mas open-sans">
                    <a href="<?php echo base_url(); ?>preguntas/<?php echo $pregunta_relacionada->id_pregunta; ?>-<?php echo str_replace(' ', '-', convert_accented_characters($pregunta_relacionada->titulo_pregunta)); ?>">
                        <span class="autopart-detalle-span-vermas">LEER MÁS</span>
                        <img style="margin-left:3px;" src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" /><img src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" />
                    </a>
                </div>
            </div>
            <?php endforeach; endif; ?>
            
        </div>


        <div class="clear"></div>
    </div>
</div>
<div class="pregunta-detalle-reportar lightboxme-reportar">
    <form id="form_reportar_pregunta">
        <div class="pregunta-detalle-reportar-escribe">
            <label for="pregunta-comentario">Escribe tu comentario:</label><br/>
            <textarea name="comentarios_reporte" id="textarea_reportar_comentario"  rows="8" cols="50"></textarea>
        </div>
            
        <div class="pregunta-detalle-reporte">
            <div class="pregunta-detalle-reporte-titulo" style="margin-top: 10px;">
                Motivo:
            </div>
                
                
                <div class="multiField" id="calificacion-comentario-div" style="padding-bottom: 10px;">
                    <select name="motivo_reporte" id="motivo_reporte" >
                        <option value="Lenguaje ofensivo" selected>Lenguaje ofensivo</option>
                        <option value="Me siento vulnerado">Me siento vulnerado</option>
                        <option value="Publicidad/spam">Publicidad/spam</option>
                        <option value="Plagio">Plagio</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
            
            <label>Escribe los 4 dígitos de abajo:</label>  
            <input class="general_cuadro_texto" type="text" name="captcha_registrarse" id="captcha_registrarse" size="38" />
            <?php echo $captcha['image']; ?>
            
            
                
            <input type="submit" name="input-reportar-submit" value="Reportar"/>
        </div>
            
        <div class="clear"></div>
    </form>
</div>

<div class="pregunta-detalle-reportar lightboxme-reportar-respuesta">
    <form id="form_reportar_respuesta">
        <input type="hidden" id="id_respuesta-resportar" name="id_respuesta_resportar" value="na"/>
        <div class="pregunta-detalle-reportar-escribe">
            <label for="pregunta-comentario">Escribe tu comentario:</label><br/>
            <textarea name="comentarios_reporte" id="textarea_reportar_comentario"  rows="8" cols="50"></textarea>
        </div>
            
        <div class="pregunta-detalle-reporte">
            <div class="pregunta-detalle-reporte-titulo" style="margin-top: 10px;">
                Motivo:
            </div>
                
                
                <div class="multiField" id="calificacion-comentario-div">
                    <select name="motivo_reporte" id="motivo_reporte" >
                        <option value="Lenguaje ofensivo" selected>Lenguaje ofensivo</option>
                        <option value="Me siento vulnerado">Me siento vulnerado</option>
                        <option value="Publicidad/spam">Publicidad/spam</option>
                        <option value="Plagio">Plagio</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
            
            <label>Escribe los 4 dígitos de abajo:</label>  
            <input class="general_cuadro_texto" type="text" name="captcha_registrarse" id="captcha_registrarse" size="38" />
            <?php echo $captcha['image']; ?>
                
            <input type="submit" name="input-reportar-submit" value="Reportar"/>
        </div>
            
        <div class="clear"></div>
    </form>
</div>

