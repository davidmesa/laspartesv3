<div class="registro-login-div" id="registro-login-div"></div>
<div id="home-div-content">
    <div id="talleres-div-banner">
        <div id="autopart-div-banner-encuentra">
                <div id="autopart-div-banner-encuentra-titulo">
                <h1>TODOS LOS TALLERES Y SERVICIOS EN UN SÓLO LUGAR!</h1>
            </div>   
            <div id="autopart-div-banner-encuentra-pasos">
                <div class="autopart-div-banner-encuentra-paso">
                        <div class="autopart-div-banner-encuentra-paso-imagen">1</div>
                        <h1>ELIGE TU CIUDAD</h1>
                </div>
                <div class="autopart-div-banner-encuentra-paso no-padding">
                        <div class="autopart-div-banner-encuentra-paso-imagen">2</div>
                        <h1>ELIGE EL SERVICIO QUE BUSCAS</h1>
                </div>
                <div class="autopart-div-banner-encuentra-paso">
                        <div class="autopart-div-banner-encuentra-paso-imagen">3</div>
                        <h1 id="autopart-h1-banner-encuentra">CALIFICA Y COMPARTE</h1>
                </div>                                                
            </div>
        </div>
        <div class="clear"></div>


    </div>

    <div id="autopart-div-banner-bottom"></div>

    <div class="div-content">
        <div class="div-breadcrumb open-sans">
            <div style="color:white; background-color:black; font-weight:bold;">>></div>

            <?php echo $breadcrumb; ?>
        </div>
        <div class="clear"></div>
        <div class="div-content-left">
            <div id="autopart-div-titulo">
                <h1><span>CIUDAD</span></h1>
            </div>

            <div id="autopart-div-buscar">
                <form>
                    <div id="autopart-div-buscar-boton">
                        <input name="input-buscar-boton" type="button">
                    </div>
                    <div id="autopart-div-buscar-input" class="ui-widget">
                        <input type="hidden" value="na" name="ciudad" class="hidden_carro_selected">
                        <?php if(sizeof($zonaCiudad)>0 && sizeof($zonaCiudad)>0): ?>
                            <input class="vehiculos" name="ciudad[]" type="text" value="<?php echo $zonaCiudad;?>">
                        <?php else:?>
                            <input class="vehiculos" name="ciudad[]" onclick="this.value='';" type="text" value="TODAS LAS CIUDADES">
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>

            <div id="autopart-div-titulo">
                <h1><span>SERVICIOS</span></h1>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>


            <div class="autopart-div-categoria">
                <div class="autopart-div-categoria-bullet comprimido"><img src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que rojo" /></div>
                <div class="autopart-div-categoria-content">
                    <h4 class="autopart-h4-categoria-titulo autopart-div-filtro" id="categoria-filtro-todos-servicio"><span class="categorias-div-filtro-x">Todos los servicios</span>
                        <span class="utopart-h4-span-cantidad"> </span>
                    </h4>
                </div>
                <div class="clear"></div>
            </div>
            <?php foreach ($servicios as $servicio):?>
            <div class="autopart-div-categoria filtro-servicio">
                <div class="autopart-div-categoria-bullet comprimido"><img src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que rojo" /></div>
                <div class="autopart-div-categoria-content">
                    <h4 class="autopart-h4-categoria-titulo"><span><?php echo $servicio->nombre; ?></span>
                        <span class="utopart-h4-span-cantidad">(<?php echo $servicio->cantidad;?>)</span>
                    </h4>
<!--                    <ul>
                        <li><h4>cat 1</h4></li>
                        <li><h4>cat 2</h4></li>
                        <li><h4>cat 3</h4></li>
                        <li><h4>cat 4</h4></li>
                    </ul>-->
                </div>
                <div class="clear"></div>
            </div>
            
            <?php endforeach; ?>

            

            <div class="autopart-div-espacio"></div>
        </div>

        <div class="div-content-center">

            <div id="autopart-div-autopartes-titulo">
                <div id="autopart-div-titulo-icono">
                    	<img src="<?php echo base_url();?>resources/images/autopartes/pinones.png" alt="icono autopartes" />
                </div>
                    <div id="autopart-div-titulo">
                    <h1><span style="color: #C60200;">TALLERES ALIADOS</span> / DETALLE</h1>
                </div>

                <div class="clear"></div>
            </div>
            <div class="autopart-div-espaciador-rallas"></div>

            <div class="autopart-div-filtros">
                <?php $encontro= false; if(isset($servicioBusqueda) && sizeof($servicioBusqueda)>0): $encontro = true;?>
                <div class="autopart-div-filtro" id="filtro-servicio">
                    <span><?php echo $servicioBusqueda;?></span>
                    <div class="autopart-div-filtro-x">X</div>
                </div>
                <?php endif; ?>
                
                <?php if(isset($zonaCiudad) && sizeof($zonaCiudad)>0): $encontro = true;?>
                <div class="autopart-div-filtro" id="filtro-ciudad">
                    <span><?php echo $zonaCiudad;?></span>
                    <div class="autopart-div-filtro-x">X</div>
                </div>
                <?php endif; ?>

                <?php if(isset($zonaBusqueda) && sizeof($zonaBusqueda)>0): $encontro = true;?>
                <div class="autopart-div-filtro" id="filtro-zona">
                    <span><?php echo $zonaBusqueda;?></span>
                    <div class="autopart-div-filtro-x">X</div>
                </div>
                <?php endif; ?>

                <div class="clear"></div>	
            </div>

            <div id="talleres-detalle-div-talleres">
                 	
                    <div class="talleres-detalle-div-taller">
                    	
                        
                        <div class="talleres-detalle-div-taller-datos">
                        	<div class="talleres-detalle-div-taller-info">
                                    
                                <div class="talleres-detalle-div-taller-marco">
                                    <img src="<?php if($establecimiento->logo_url!=NULL && $establecimiento->logo_url!=''){ echo base_url().$establecimiento->logo_url; } else { echo base_url().'resources/images/establecimientos/tmpl_logo_establecimiento_nd.gif'; } ?>" alt="<?php echo $establecimiento->nombre; ?>" />
                                </div>
                            	<div class="autopart-div-autoparte-titulo">
                                	<?php echo $establecimiento->nombre;?>
                                </div>
                                <div class="talleres-detalle-div-calificacion-estrellas">
                                        <?php if($establecimiento_calificacion->promedio != ''):?>
                                        <div class="talleres-detalle-div-calificacion-estrellas-imagen estrellas-sin-clasificar-grandes">
                                            <div class="talleres-detalle-div-calificacion-estrellas-imagen-calificada estrellas-clasificadas-grandes"><span><?php echo (round($establecimiento_calificacion->promedio)*20).'%';?></span></div>
                                        </div>
                                        <?php endif; ?>   
                                        <span><?php if($establecimiento_calificacion->promedio != '' && round($establecimiento_calificacion->promedio)== 5 ): echo '<strong>EXCELENTE</strong> - '.$establecimiento_calificacion->count.' opiniones de usuarios';
                                        elseif($establecimiento_calificacion->promedio != '' && round($establecimiento_calificacion->promedio)== 4 ): echo '<strong>MUY BUENO</strong> - '.$establecimiento_calificacion->count.' opiniones de usuarios';
                                        elseif($establecimiento_calificacion->promedio != '' && round($establecimiento_calificacion->promedio)== 3 ): echo '<strong>BUENO</strong> - '.$establecimiento_calificacion->count.' opiniones de usuarios';
                                        elseif($establecimiento_calificacion->promedio != '' && round($establecimiento_calificacion->promedio)== 2 ): echo '<strong>REGULAR</strong> - '.$establecimiento_calificacion->count.' opiniones de usuarios';
                                        elseif($establecimiento_calificacion->promedio != '' && round($establecimiento_calificacion->promedio)== 1 ): echo '<strong>MALO</strong> - '.$establecimiento_calificacion->count.' opiniones de usuarios';
                                        else: echo '<strong>SIN CALIFICACIÓN</strong> - 0 opiniones de usuarios';
                                        endif; ?></span>
                                </div>

                                <div class="talleres-div-taller-direccion"> 
                                	<strong>Zona:</strong> <?php echo $establecimiento->ciudad.', '.$establecimiento->zona;;?>
                                </div><!--
                                
                                <div class="talleres-detalle-div-taller-telefono">
                                	<strong >Telefonos:</strong> <?php // echo $establecimiento->telefonos;?>
                                </div>-->
                                
                                <div class="autopart-div-autoparte-descripcion">
                                    <?php echo $establecimiento->descripcion;?> 
                                </div>
                                
                                <div class="talleres-detalle-div-contactover">
                                    <div class="talleres-detalle-div-contacto lightbox-contacto" id="lightbox-contacto">
                                        <img src="<?php echo base_url();?>resources/images/autopartes/contactar.png" alt="contacto" />
                                        <span>CONTACTAR EN LÍNEA</span>
                                    </div>
                                    <div class="talleres-div-vermas div-ver-mas open-sans">
                                        <?php if($establecimiento->web): ?>
                                        <span class="autopart-detalle-span-vermas"><a target="_blank" href="http://<?php echo $establecimiento->web; ?>">IR AL SITIO</a></span>
                                        <img style="margin-left:3px;" src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" /><img src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" />
                                        <?php endif; ?>
                                    </div>
                                <div class="clear"></div>
                                </div>
                            </div>
                            
                            <div class="talleres-detalle-div-taller-localizacion">
                                <div class="talleres-detalle-div-taller-gmaps" id="googlemap">
                                
                                </div>
                                <?php  $urlTaller = base_url().'talleres/'.$establecimiento->id_establecimiento.'-'.str_replace(' ', '-', convert_accented_characters($establecimiento->nombre)); ?>
                                 
                                <div id="talleres-detalle-div-taller-redes">
<!--                                    <div class="fb-like" data-href="<?php echo $urlTaller;?>"  data-send="false" data-layout="box_count" data-width="450" data-show-faces="false" data-font="arial"></div>-->
                                    <div class="fb-like" data-href="<?php echo $urlTaller;?>" data-send="true" data-layout="box_count" data-width="450" data-show-faces="true" data-action="recommend" data-font="arial"></div>
                                    <a href="https://twitter.com/share" class="twitter-share-button" data-text="#tallerenlinea Recomiendo <?php echo $establecimiento->nombre; ?>" data-count="vertical" data-lang="es">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
                                     <g:plusone size="tall"></g:plusone>
                                </div>
<!--                                <div id="talleres-detalle-div-taller-recomendar-fb">
                                     <div class="fb-like" data-send="false" data-width="450" data-show-faces="true" data-action="recommend" data-font="arial"></div>
                                </div>-->
<!--                                <div class="talleres-detalle-div-taller-calificacion-numero">
                                	<div class="talleres-detalle-div-taller-calificacion-numero-gusta">
                                    	A <strong>5</strong> PERSONAS LES GUSTA ESTE TALLER
                                    </div>
                                    <div class="talleres-detalle-div-taller-calificacion-numero-nogusta">
                                    	A <strong>5</strong> PERSONAS NO LES GUSTA ESTE TALLER
                                    </div>
                                    
                                    <div class="clear"></div>
                                </div>-->
                                
<!--                                <div class="talleres-detalle-div-taller-calificacion-thumbs">
                                	<div class="talleres-detalle-div-taller-calificacion-thumbs-gusta">
                                    	<div>ME GUSTA ESTE TALLER</div>
                                        <img src="<?php echo base_url();?>resources/images/autopartes/si-gusta.png" alt="si me gusta" />
                                    </div>
                                    <div class="talleres-detalle-div-taller-calificacion-thumbs-nogusta">
                                    	<div>NO ME GUSTA ESTE TALLER</div>
                                        <img src="<?php echo base_url();?>resources/images/autopartes/no-gusta.png" alt="no me gusta" />
                                    </div>
                                    
                                    <div class="clear"></div>
                                </div>-->
                                
                            </div>
                            
                            <div class="clear"></div>
                            
                            
                        </div>
                        <div class="clear"></div>
                        
                    </div>
                    
<!--                    <div class="autopart-div-espaciador-rallas"></div>-->
                    
<!--                    <div class="talleres-detalle-div-calificacion">
                    	<div class="talleres-detalle-div-calificacion-titulo">
                        	<div id="autopart-div-titulo-icono">
                                <img src="<?php echo base_url();?>resources/images/autopartes/calificacion.png" alt="estrella calificaciones" />
                            </div>
                             <div id="autopart-div-titulo">
                                <h1>
                                    <span>CALIFICACIÓN</span>
                                    <span style="color: #C60200;">USUARIOS</span>
                                    <img style="right: -6px;" src="<?php // echo base_url(); ?>/resources/images/home/mayor-que.png" alt="mayor que" />
                                    <img src="<?php // echo base_url(); ?>/resources/images/home/mayor-que.png" alt="mayor que" />
                                </h1>
                            </div>
                        </div>
                        
                        <div class="talleres-detalle-div-calificacion-estrellas">
                                <?php // if($establecimiento_calificacion->promedio != ''):?>
                        	<div class="talleres-detalle-div-calificacion-estrellas-imagen estrellas-sin-clasificar-grandes">
                                    <div class="talleres-detalle-div-calificacion-estrellas-imagen-calificada estrellas-clasificadas-grandes"><span><?php // echo (round($establecimiento_calificacion->promedio)*20).'%';?></span></div>
                                </div>
                                <?php // endif; ?>   
                            
                            <span><?php // if($establecimiento_calificacion->promedio != ''): echo (round($establecimiento_calificacion->promedio)*20).'%'; else: echo 'Sin calificación'; endif; ?></span>
                        </div>
                        
                        <div class="clear"></div>
                    </div>-->
                    
                    <div style="margin-top:0px;" class="autopart-div-espaciador-rallas"></div>
                    
                    <div class="talleres-detalle-div-galeria">
                    	<div class="talleres-detalle-div-galeria-titulo">
                        	<div id="autopart-div-titulo-icono">
                                <img src="<?php echo base_url();?>resources/images/autopartes/galeria.png" alt="galeria" />
                            </div>
                             <div id="autopart-div-titulo">
                                <h1>
                                    <span>GALERÍA</span>
                                </h1>
                            </div>
                        </div>
                        
                         <div class="clear"></div>
                        
                        <div class="talleres-detalle-div-galeria-fotos">
                            <?php foreach ($establecimiento_imagenes as $establecimiento_imagen): ?>
                            <div class="talleres-detalle-div-galeria-foto">
                            	<a href="<?php echo base_url().$establecimiento_imagen->imagen_url; ?>" rel="galeria-imagenes"><img src="<?php echo base_url().$establecimiento_imagen->imagen_thumb_url; ?>" alt="Imagen del Establecimiento" /></a>
                            </div>
                            <?php endforeach; ?>
                            
                            <div class="clear"></div>
                        </div>
                        
                        <div class="autopart-div-espaciador-rallas"></div>
                        
                        <div class="talleres-detalle-div-servicios">
                            <div class="talleres-detalle-div-servicios-titulo">
                                <div id="autopart-div-titulo-icono">
                                    <img src="<?php echo base_url();?>resources/images/autopartes/servicios.png" alt="galeria" />
                                </div>
                                 <div id="autopart-div-titulo">
                                    <h1>
                                        <span>SERVICIOS</span>
                                    </h1>
                                </div>
                           </div>
                        
                         	<div class="clear"></div>
                         
                            <div class="talleres-detalle-div-servicios-lista">
                            <table CELLSPACING=1>
                                
                                <?php $size = sizeof($establecimiento_servicios); 
                                    $tamanoCol = $size/3;
                                ?>
                            <td valign="top" >
                                <ul>
                                    <?php foreach ($establecimiento_servicios as $index=>$servicio): if($index < $tamanoCol || $size == 1):?>
                                    <li><?php echo $servicio->nombre; ?></li>
                                    <?php endif; endforeach; ?>
                                </ul>
                            </td>
                            
                            <td valign="top">
                                <ul>
                                    <?php foreach ($establecimiento_servicios as $index=>$servicio): if($index >= $tamanoCol && $index < ($tamanoCol*2)):?>
                                    <li><?php echo $servicio->nombre; ?></li>
                                    <?php endif; endforeach; ?>
                                </ul>
                            </td>
                            
                            <td valign="top">
                                <ul>
                                    <?php foreach ($establecimiento_servicios as $index=>$servicio): if($index >= ($tamanoCol*2) && $size >3):?>
                                    <li><?php echo $servicio->nombre; ?></li>
                                    <?php endif; endforeach; ?>
                                </ul>
                            </td>
                            
                            </table>
                            
                        </div>
                         
                       </div>
                       
                       <div class="autopart-div-espaciador-rallas"></div>
                       
                       <div class="talleres-detalle-div-opiniones">
                       
                       		<div class="talleres-detalle-div-opiniones-header">
                                <div class="talleres-detalle-div-opiniones-titulo">
                                    <div id="autopart-div-titulo-icono">
                                        <?php echo sizeof($establecimiento_comentarios); ?>
                                    </div>
                                     <div id="autopart-div-titulo">
                                        <h1>
                                            <span>OPINIONES</span>
                                        </h1>
                                    </div>
                               </div>
                               
                                    <div class="talleres-detalle-div-opiniones-aportar lightbox-opinar" id="lightbox-opinar">
                                    <span>APÓRTANOS TU OPINIÓN</span>
                                    <img  src="<?php echo base_url();?>resources/images/autopartes/mayor-que-blanco.png" alt="mayor que" />
                                        <img style="right: 4px;" src="<?php echo base_url();?>resources/images/autopartes/mayor-que-blanco.png" alt="mayor que" />
                               </div>
                               <div class="clear"></div>
                           
                           </div>
                           <div id="talleres-detalle-div-opiniones">
                            <?php foreach($establecimiento_comentarios as $establecimiento_comentario): ?>
                            <div class="talleres-detalle-div-opinion">
                                    <div class="talleres-detalle-div-opinion-left">
                                                <div class="talleres-detalle-div-opinion-comentario"><?php echo $establecimiento_comentario->comentario; ?></div>
                                        <div class="talleres-detalle-div-opinion-por">
                                            Por: <?php echo $establecimiento_comentario->usuario; ?>
                                        </div>
                                        <div class="talleres-detalle-div-opinion-fecha">
                                            Publicado hace <strong><?php echo relative_time($establecimiento_comentario->fecha); ?></strong>
                                        </div>
                                    </div>

                                    <div class="talleres-detalle-div-opinion-right">

                                        <div class="talleres-detalle-div-opinion-calificacion">
                                            <?php if(round($establecimiento_comentario->calificacion) == 5 ): echo '<strong>EXCELENTE</strong>';
                                        elseif(round($establecimiento_comentario->calificacion) ==  4 ): echo '<strong>MUY BUENO</strong>';
                                        elseif(round($establecimiento_comentario->calificacion) ==   3 ): echo '<strong>BUENO</strong>';
                                        elseif(round($establecimiento_comentario->calificacion) ==   2 ): echo '<strong>REGULAR</strong>';
                                        elseif(round($establecimiento_comentario->calificacion) ==  1 ): echo '<strong>MALO</strong>';
                                        endif;?>
                                        </div>

                                        <?php if($establecimiento_comentario->calificacion != ''):?>
                                        <div class="talleres-detalle-div-opinion-calificacion-porcentaje estrellas-sin-clasificar-grandes">
                                            <div class="talleres-detalle-div-opinion-calificacion-calificado estrellas-clasificadas-grandes"><span><?php echo (round($establecimiento_comentario->calificacion)*20).'%';?></span></div>
                                        </div>
                                        <?php endif; ?>   

                                        <div class="talleres-detalle-div-opinion-expandir">
                                            <span>EXPANDIR</span>
                                            <img src="<?php echo base_url();?>resources/images/autopartes/expandir.png" alt="expandir" />
                                        </div>
                                    </div>

                                    <div class="clear"></div>

                                    <div class="talleres-detalle-div-opinion-separador"></div>
                            </div>
                            <?php endforeach; ?>
                           </div>
                       </div>
                       
                       <div class="talleres-detalle-contactar lightboxme-contacto">
                     
                       	<div class="talleres-detalle-contactar-titulo">
                        	CONTACTO EN LÍNEA
                        </div>	
                        
                        <form id="form_contacto_linea">
                            <div class="talleres-detalle-contactar-nombres">
                                    <label for="contacto-asunto">Asunto:</label><br/>
                                    <input type="text" name="asunto_contactar" id="contacto-div-contacto-asunto"/>
                            </div>

                            <div class="clear"></div>

                            <div class="talleres-detalle-contactar-mensaje">
                                    <label for="contacto-mensaje">Mensaje:</label><br/>
                                    <textarea name="mensaje_contactar" id="contacto-div-contacto-mensaje"></textarea>
                            </div>
                            <input type="submit" value="Enviar" name="input_contacto_submit"/>
                        </form>
                       </div>
                       
                       <div class="talleres-detalle-opinar lightboxme-opinar" id="lightboxme-opinar">
                           <form id="form_calificar_taller">
                            <div class="talleres-detalle-opinar-escribe">
                                <label for="opinar-comentario">Escribe tu comentario:</label><br/>
                                <textarea name="comentario" id="textarea_opinar_comentario" onfocus="if(this.value=='Cuéntanos tu experiencia con el establecimiento...'){this.value=''};" onblur="if(this.value==''){this.value='Cuéntanos tu experiencia con el establecimiento...'}" rows="8" cols="50">Cuéntanos tu experiencia con el establecimiento...</textarea>
                            </div>
                            
                            <div class="talleres-detalle-opinar-calificacion">
                                <div class="talleres-detalle-opinar-calificacion-titulo">
                                Califica este establecimiento:
                                </div>
                                
                                <div class="talleres-detalle-opinar-calificacion-estrellas">
                                    
                                    <div class="multiField" id="calificacion-comentario-div">
                                        <input type="hidden" name="calificacion" id="calificacion" value="" />
                                        <select>
                                            <option value="1">1 (Malo)</option>
                                            <option value="2">2 (Regular)</option>
                                            <option value="3">3 (Bueno)</option>
                                            <option value="4">4 (Muy Bueno)</option>
                                            <option value="5">5 (Excelente)</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <input type="submit" name="input-contacto-submit" value="AGREGAR MI OPINION"/>
                            </div>
                            
                            <div class="clear"></div>
                           </form>
                       </div>
                        
                    </div>
                    
                 </div>

        </div>

        <div class="clear"></div>
    </div>
</div>