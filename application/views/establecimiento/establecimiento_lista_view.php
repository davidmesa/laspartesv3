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
                        <input class="vehiculos error" name="ciudad[]" onfocus="if(this.value=='<?php echo $zonaCiudad;?>'){this.value=''};" onblur="if(this.value==''){this.value='<?php echo $zonaCiudad;?>'}"  type="text" value="<?php echo $zonaCiudad;?>">
                        <?php else:?>
                            <input class="vehiculos" name="ciudad[]" onfocus="if(this.value=='TODAS LAS CIUDADES'){this.value=''};" onblur="if(this.value==''){this.value='TODAS LAS CIUDADES'}" type="text" value="TODAS LAS CIUDADES">
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            
            <?php  if(sizeof($zonas)>0 && (sizeof($zonaCiudad)>0 && sizeof($zonaCiudad))):?>
            <div class="autopart-div-espaciador-rallas"></div>

            <div id="autopart-div-titulo">
                <h1><span>ZONAS</span></h1>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>


            <div class="autopart-div-categoria">
                <div class="autopart-div-categoria-bullet comprimido"><img src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que rojo" /></div>
                <div class="autopart-div-categoria-content">
                    <h4 class="autopart-h4-categoria-titulo autopart-div-filtro" id="categoria-filtro-todos-zonas"><span class="categorias-div-filtro-x">Todas las zonas</span>
                        <span class="utopart-h4-span-cantidad"> </span>
                    </h4>
                </div>
                <div class="clear"></div>
            </div>
            <?php foreach ($zonas as $zona): ?>
                <div class="autopart-div-categoria filtro-zona">
                    <div class="autopart-div-categoria-bullet comprimido"><img src="<?php echo base_url(); ?>resources/images/autopartes/mayor-que.png" alt="mayor que rojo" /></div>
                    <div class="autopart-div-categoria-content">
                        <h4 class="autopart-h4-categoria-titulo"><span><?php echo $zona->nombre; ?></span>
                            <span class="utopart-h4-span-cantidad">(<?php echo $zona->cantidad; ?>)</span>
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
            
            <?php endif; ?>
            
            
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
                        <h1><span style="color: #C60200;">TALLERES</span><span> ALIADOS</span></h1>
                </div>

                <div class="autopart-div-pagination" id="autopart-div-pagination">
                    <?php $attributes = array('class' => 'form_paginacion', 'id' => 'form_paginacion');
                        echo form_open('',$attributes); ?>
                        <img class="paginacion-flecha paginacion-atras" id="paginacion-atras" src="<?php echo base_url();?>resources/images/autopartes/menor-que.png" alt="menor que" />
                        <span>Página</span>
                        <input name="pagina-actual" id="input_paginacion_pagina" value="<?php echo $limit;?>" />
                        <span>de</span>
                        <span><?php echo $numero_establecimientos;?></span>
                        <img class="paginacion-flecha paginacion-adelante" id="paginacion-adelante" src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que" />
                    <?php echo form_close(); ?>
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
                 
                
                <div class="talleres-div-ordenar talleres-div-ordenar" id="talleres-div-ordenar-calificacion">
                    <img style="display: none;" src="<?php echo base_url();?>resources/images/autopartes/chulo.png" alt="chulo de calificación" /><span>Ordenar por calificación</span>
                </div>
                <div class="talleres-div-ordenar talleres-div-ordenar" id="talleres-div-ordenar-nombre" style="margin-right: 20px;">
                    <img style="display: none;" src="<?php echo base_url();?>resources/images/autopartes/chulo.png" alt="chulo de calificación" /><span>Ordenar por nombre</span>
                </div>

                <div class="clear"></div>	
            </div>

            <div id="autopart-div-autopartes">
                <?php foreach ($establecimientos as $establecimiento):?>
               <div class="talleres-div-taller">
                   <?php  $urlTaller = base_url().'talleres/'.$establecimiento->id_establecimiento.'-'.str_replace(' ', '-', convert_accented_characters($establecimiento->nombre)); ?>
                        <?php if($encontro){
                            $urlTaller .= '/buscar';
                            if(isset($servicioBusqueda) && sizeof($servicioBusqueda)>0):  
                                $urlTaller .= '/servicio/'.str_replace(' ', '-', convert_accented_characters($servicioBusqueda));?> 
                        <?php endif; if(isset($zonaBusqueda) && sizeof($zonaBusqueda)>0):
                                $urlTaller .= '/zona/'.str_replace(' ', '-', convert_accented_characters($zonaBusqueda));?> 
                        <?php endif;  if(isset($zonaCiudad) && sizeof($zonaCiudad)>0):
                                $urlTaller .= '/ciudad/'.str_replace(' ', '-', convert_accented_characters($zonaCiudad));?> 
                        <?php endif;  ?>
                        <?php 
                    }?>
                    <div class="talleres-div-taller-marco">
                        <a href="<?php echo $urlTaller;?>">
                            <img src="<?php if($establecimiento->logo_thumb_url==''||$establecimiento->logo_thumb_url==NULL){ echo base_url().'resources/images/establecimientos/tmpl_logo_establecimiento_thumb_nd.gif'; } else { echo base_url().$establecimiento->logo_thumb_url; } ?>" alt="<?php echo $establecimiento->nombre; ?>" />
                        </a>
                    </div>

                    <div class="talleres-div-taller-datos">
                            <div class="talleres-div-taller-info">
                            <div class="autopart-div-autoparte-titulo">
                                <a href="<?php echo $urlTaller;?>">
                                    <?php echo $establecimiento->nombre;?>  
                                    <?php // echo $establecimiento->numero_respuestas;?>
                                </a>
                            </div>

<!--                            <div class="talleres-div-taller-direccion">
                                    <strong>Direccion:</strong> <?php // echo $establecimiento->direccion;?>
                            </div>-->

                            <div class="autopart-div-autoparte-descripcion">
                                <?php echo character_limiter($establecimiento->descripcion, 500);?>
                            </div>
                            <div class="talleres-div-vermas div-ver-mas open-sans">
                                <span class="autopart-detalle-span-vermas">
                                    <a href="<?php echo $urlTaller; ?>">LEER MÁS</a>
                                </span>
                                <img style="margin-left:3px;" src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" /><img src="<?php echo base_url(); ?>/resources/images/home/mayor-que-rojo.png" alt="mayor que" />
                            </div>
                        </div>

                        <div class="clear"></div>


                    </div>
                   <div class="clear"></div>
                    <div class="talleres-div-taller-calificaciones">
                        <div class="talleres-div-taller-calificacion">
                            <span class="talleres-span-taller-calificaUsuario">CALIFICACIÓN USUARIOS</span>
                            <img src="<?php echo base_url();?>resources/images/home/mayor-que.png" alt="mayor que" />
                            <img  style="right: 4px; "src="<?php echo base_url();?>resources/images/home/mayor-que.png" alt="mayor que" />
<!--                            <span class="talleres-span-taller-calificaNumero"><?php // $calificacion = round($establecimiento->avg)*100/5; if($calificacion > 0)echo $calificacion.'%'; else echo 'Sin calificar'?></span>-->
                            <?php if($establecimiento->avg != ''):?>
                            <div class="talleres-detalle-div-opinion-calificacion-porcentaje estrellas-sin-clasificar-grandes" style="float: right; margin-left: 20px; margin-top: 0px;">
                                <div class="talleres-detalle-div-opinion-calificacion-calificado estrellas-clasificadas-grandes"><span><?php echo (round($establecimiento->avg)*20).'%';?></span></div>
                            </div>
                            <?php else: echo '<span class="talleres-span-taller-calificaNumero">Sin calificar</span>'; endif; ?> 
                        </div>

                        <div class="clear"></div>
                    </div>
                </div>
                <?php endforeach; ?>
                </div>
            
            <div class="autopart-div-pagination" id="autopart-div-pagination">
                <?php $attributes = array('class' => 'form_paginacion', 'id' => 'form_paginacion');
                    echo form_open('',$attributes); ?>
                    <img class="paginacion-flecha paginacion-atras" id="paginacion-atras" src="<?php echo base_url();?>resources/images/autopartes/menor-que.png" alt="menor que" />
                    <span>Página</span>
                    <input name="pagina-actual" id="input_paginacion_pagina" value="<?php echo $limit;?>" />
                    <span>de</span>
                    <span><?php echo $numero_establecimientos;?></span>
                    <img class="paginacion-flecha paginacion-adelante" id="paginacion-adelante" src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que" />
                <?php echo form_close(); ?>
            </div> <br/><br/>

        </div>

        <div class="clear"></div>
    </div>
</div>