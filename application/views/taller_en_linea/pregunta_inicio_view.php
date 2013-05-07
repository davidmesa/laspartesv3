<div class="registro-login-div" id="registro-login-div"></div>
<div id="home-div-content">
    <div id="tallerlinea-div-banner">
        <div id="tallerlinea-div-banner-comunidad">
            <div id="tallerlinea-div-banner-comunidad-titulo">
                <h1>¡UNA COMUNIDAD DE MÁS DE <?php echo $numero_establecimientos-1; ?> TALLERES ALIADOS</h1>
                <h1 style="font-size: 31px;">DISPUESTOS A RESOLVER TUS DUDAS!</h1>
            </div>   
            
            <div id="tallerlinea-div-banner-comunidad-preguntanos" class="lightbox-pregunta">
                <h1>PREGÚNTANOS</h1>
            </div>
            <div id="tallerlinea-div-banner-comunidad-comparte">
                <h1><a href="#autopart-div-autopartes-titulo">COMPARTE CON NOSOTROS TU EXPERIENCIA</a></h1>
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
        <div class="div-content-left">

            <div id="autopart-div-titulo">
                <h1><span>CATEGORÍAS</span></h1>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>




             <?php foreach ($preguntas_categorias as $categoria):?>
            <div class="autopart-div-categoria filtro-categoria">
                <div class="autopart-div-categoria-bullet comprimido"><img src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que rojo" /></div>
                <div class="autopart-div-categoria-content">
                    <h4 class="autopart-h4-categoria-titulo"><span><?php echo $categoria->nombre; ?></span>
                        <span class="utopart-h4-span-cantidad">(<?php echo $categoria->cantidad;?>)</span>
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
                    <img src="<?php echo base_url();?>resources/images/home/preguntas.png" alt="icono preguntas" />
                </div>
                <div id="autopart-div-titulo">
                    <h1><span style="color: #C60200;">PREGÚNTALE</span>&nbsp;<span  style="color: #404040;"> A LOS TALLERES</span></h1>
                </div>
                
                <div class="autopart-div-pagination" id="autopart-div-pagination">
                    <?php $attributes = array('class' => 'form_paginacion', 'id' => 'form_paginacion');
                        echo form_open('',$attributes); ?>
                        <img class="paginacion-flecha paginacion-atras" id="paginacion-atras" src="<?php echo base_url();?>resources/images/autopartes/menor-que.png" alt="menor que" />
                        <span>Página</span>
                        <input name="pagina-actual" id="input_paginacion_pagina" value="<?php echo $pagina;?>" />
                        <span>de</span>
                        <span><?php echo $numero_preguntas;?></span>
                        <img class="paginacion-flecha paginacion-adelante" id="paginacion-adelante" src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que" />
                    <?php echo form_close(); ?>
                </div>

                <div class="clear"></div>
            </div>
            <div class="autopart-div-espaciador-rallas"></div>

            <div class="autopart-div-filtros">
                <?php $encontro= false; if(isset($categoriaBuscar) && sizeof($categoriaBuscar)>0): $encontro = true;?>
                <div class="autopart-div-filtro" id="filtro-categoria">
                    <span><?php echo $categoriaBuscar;?></span>
                    <div class="autopart-div-filtro-x">X</div>
                </div>
                <?php endif; ?>

                <div class="clear"></div>	
            </div>
            <?php if ($encontro):?>
                <div class="autopart-div-espaciador-rallas"></div>
            <?php endif; ?>
            
            <div id="tallerlinea-div">
                <div id="tallerlinea-div-top">
                    <div id="tallerlinea-div-top-resuelve">
                        ¡RESUELVE AQUÍ TUS DUDAS CON LOS EXPERTOS!
                    </div>

                    <div id="tallerlinea-div-top-preguntar" class="lightbox-pregunta">
                        QUIERO PREGUNTAR!
                    </div>

                    <div class="clear"></div>
                </div>

                <div id="tallerlinea-div-content">
                    <?php foreach ($preguntas as $pregunta): ?> 
                    <?php $urlTaller =  base_url().'preguntas/'.$pregunta->id_pregunta.'-'.preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $pregunta->titulo_pregunta); ?>
                    <div class="tallerlinea-div-pregunta">

                        <div class="tallerlinea-div-pregunta-imagen">  
                            <a href="<?php echo $urlTaller;?>"><img src="<?php if($pregunta->imagen_url!='' || $pregunta->imagen_url!=NULL){ if(strpos($pregunta->imagen_url, 'http') !== false) echo $pregunta->imagen_url; else echo base_url().$pregunta->imagen_url; } else if(strlen($pregunta->thumb)>0) { if(strpos($pregunta->imagen_url, 'http') !== false) echo $pregunta->thumb; else echo base_url().$pregunta->thumb; } else { echo base_url().'resources/images/usuarios/avatar_thumb.gif'; } ?>"  alt="<?php echo $pregunta->usuario; ?>" /></a>
                        </div>

                        <div class="tallerlinea-div-pregunta-content">
                            <div class="tallerlinea-div-pregunta-titulo">
                                <a href="<?php echo $urlTaller;?>"><?php echo $pregunta->titulo_pregunta;?></a>
                            </div>

                            <div class="tallerlinea-div-pregunta-por">
                                <?php echo $pregunta->usuario;?>
                            </div>

                            <div class="tallerlinea-div-pregunta-fecha">
                               Publicado hace: <?php echo relative_time($pregunta->fecha); ?>
                            </div>

                            <div class="tallerlinea-div-pregunta-descripcion">
                                <?php echo character_limiter($pregunta->cuerpo_pregunta, 250);?>
                            </div>
                             <div class="talleres-div-vermas div-ver-mas open-sans">
                                <span class="autopart-detalle-span-vermas">
                                    <a href="<?php echo $urlTaller; ?>">LEER MÁS</a>
                                </span>
                                <img style="margin-left:3px;" src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" /><img src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" />
                            </div>

                            <div class="tallerlinea-div-pregunta-bot">
                                <span><strong>Categoría: </strong></span>
                                <span  class="tallerlinea-span-pregunta-categoria"><?php echo $pregunta->pregunta_categoria; ?></span>
                                <span>&nbsp;&nbsp;|&nbsp;&nbsp;</span>
                                <span><strong>Respuestas: </strong></span>
                                <span class="tallerlinea-span-pregunta-respuestas">
                                    <?php echo $pregunta->numeroRespuestas; ?>
                                </span>

                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    
                    <?php endforeach; ?>
                </div><br/>
                <div class="autopart-div-pagination" id="autopart-div-pagination">
                    <?php $attributes = array('class' => 'form_paginacion', 'id' => 'form_paginacion');
                        echo form_open('',$attributes); ?>
                        <img class="paginacion-flecha paginacion-atras" id="paginacion-atras" src="<?php echo base_url();?>resources/images/autopartes/menor-que.png" alt="menor que" />
                        <span>Página</span>
                        <input name="pagina-actual" id="input_paginacion_pagina" value="<?php echo $pagina;?>" />
                        <span>de</span>
                        <span><?php echo $numero_preguntas;?></span>
                        <img class="paginacion-flecha paginacion-adelante" id="paginacion-adelante" src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que" />
                    <?php echo form_close(); ?>
                </div><br/><br/>
            </div>

        </div>

        <div class="clear"></div>
    </div>
</div>

<div id="pregunta-div-form" > 
    <form id="form-preguntar" action="<?php echo base_url(); ?>taller_en_linea/agregar_pregunta" enctype="multipart/form-data" method="POST">
    	<div id="pregunta-div-form-titulo">ENVÍA TU PREGUNTA</div>
        <label id="pregunta-label-pregunta">Escribe aquí tu pregunta:</label>
        <input type="text" name="titulo_pregunta" id="pregunta-input" onfocus="if(this.value=='Escribe aquí tu pregunta...'){this.value=''};" onblur="if(this.value==''){this.value='Escribe aquí tu pregunta...'}" value="Escribe aquí tu pregunta..."/>
        <label>Escribe aquí tu descripción:</label>
        <textarea name="cuerpo_pregunta" id="pregunta-textarea-descripcion" onfocus="if(this.value=='Escribe aquí los detalles de tu pregunta...'){this.value=''};" onblur="if(this.value==''){this.value='Escribe aquí los detalles de tu pregunta...'}" rows="8" cols="40">Escribe aquí los detalles de tu pregunta...</textarea>
        <div id="pregunta-div-imagen">
        	<label>Agrega una imagen que complemente tu pregunta: (Opcional)</label>
            <div id="pregunta-inputdiv-imagen">
            	<input type="file" name="pregunta_input_imagen" id="pregunta-input-imagen" />
            </div>
        </div>
        
        <div id="pregunta-div-clasifica">
        	<label>Categoría:</label>
            <div id="pregunta-inputdiv-clasifica">
                <select class="general_lista" name="id_pregunta_categoria" id="id_pregunta_categoria"  >
                    <?php if(sizeof($preguntas_categorias)){
                    foreach($preguntas_categorias as $pregunta_categoria){ ?>
                    <option value="<?php echo $pregunta_categoria->id_pregunta_categoria; ?>"><?php echo $pregunta_categoria->nombre; ?></option>
                    <?php }
                    } ?>
                </select>
            </div>
        </div>
        
        <div id="pregunta-div-claves">
        	<label id="pregunta-label-claves">Agregar palabras clave:</label>  
        	<input type="text" name="palabras_clave" id="pregunta-input-claves" onfocus="if(this.value=='Por ejemplo: Llantas, Renault, Twingo'){this.value=''};" onblur="if(this.value==''){this.value='Por ejemplo: Llantas, Renault, Twingo'}" value="Por ejemplo: Llantas, Renault, Twingo"/>
        </div>
        
        <input type="submit" id="pregunta-input-submit" value="PREGUNTAR" onclick="publicar_actividad_fb(); alert('Estamos revisando tu pregunta y será publicada en breve...');"/>
        <div class="clear"></div>
    </form>
</div>