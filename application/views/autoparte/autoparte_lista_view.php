<div id="home-div-content">
    <div id="autopart-div-banner">
        <div id="autopart-div-banner-encuentra">
            <div id="autopart-div-banner-encuentra-titulo">
                <h1>ENCUENTRA LAS AUTOPARTES QUE NECESITAS DE FORMA FÁCIL!</h1>
            </div>   
            <div id="autopart-div-banner-encuentra-pasos">
                <div class="autopart-div-banner-encuentra-paso">
                    <div class="autopart-div-banner-encuentra-paso-imagen">1</div>
                    <h1>ELIGE TU VEHICULO</h1>
                </div>
                <div class="autopart-div-banner-encuentra-paso no-padding">
                    <div class="autopart-div-banner-encuentra-paso-imagen">2</div>
                    <h1>FILTRA TU BÚSQUEDA</h1>
                </div>
                <div class="autopart-div-banner-encuentra-paso no-padding"> 
                    <div class="autopart-div-banner-encuentra-paso-imagen">3</div>
                    <h1 id="autopart-h1-banner-encuentra">ENCUENTRA TODO LO QUE NECESITAS</h1>
                </div>                                                
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
                <h1><span>MARCA</span>&nbsp;<span style="color: #C60200;">VEHÍCULO</span></h1>
            </div>

            <div id="autopart-div-buscar">
                <form>
                    <div id="autopart-div-buscar-boton">
                        <input name="input-buscar-boton" type="button">
                    </div>
                    <div id="autopart-div-buscar-input" class="ui-widget">
                        <input type="hidden" value="na" name="vehiculo_id" class="hidden_carro_selected">
                        <?php if(sizeof($vehiculoMarcaBusqueda)>0 && sizeof($vehiculoLineaBusqueda)>0): ?>
                            <input class="vehiculos" name="id_vehiculos[]" type="text" value="<?php echo $vehiculoMarcaBusqueda.' '.$vehiculoLineaBusqueda;?>">
                        <?php else:?>
                            <input class="vehiculos" name="id_vehiculos[]" onclick="this.value='';" type="text" value="ESCRIBE AQUÍ LA MARCA">
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>

            <div id="autopart-div-titulo">
                <h1><span>CATEGORIAS</span></h1>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>


            <div class="autopart-div-categoria">
                <div class="autopart-div-categoria-bullet comprimido"><img src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que rojo" /></div>
                <div class="autopart-div-categoria-content">
                    <h4 class="autopart-h4-categoria-titulo autopart-div-filtro" id="categoria-filtro-todos-categorias"><span class="categorias-div-filtro-x">Todas las categorias</span>
                        <span class="utopart-h4-span-cantidad"> </span>
                    </h4>
                </div>
                <div class="clear"></div>
            </div>
            <?php foreach ($categorias as $categoria):?>
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

            <div class="autopart-div-espaciador-rallas"></div>

            <div id="autopart-div-titulo">
                <h1><span>MARCAS</span>&nbsp;<span style="color: #C60200;">AUTOPARTES</span></h1>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>

            <div class="autopart-div-categoria">
                <div class="autopart-div-categoria-bullet comprimido"><img src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que rojo" /></div>
                <div class="autopart-div-categoria-content">
                    <h4 class="autopart-h4-categoria-titulo autopart-div-filtro" id="categoria-filtro-todos-marcas"><span class="categorias-div-filtro-x">Todas las marcas</span>
                        <span class="utopart-h4-span-cantidad"> </span>
                    </h4>
                </div>
                <div class="clear"></div>
            </div>
            <?php foreach ($marcas as $marca):?>
            <div class="autopart-div-categoria filtro-marca">
                <div class="autopart-div-categoria-bullet comprimido"><img src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que rojo" /></div>
                <div class="autopart-div-categoria-content">
                    <h4 class="autopart-h4-categoria-titulo"><span><?php echo $marca->nombre;?></span>
                        <span class="utopart-h4-span-cantidad">(<?php echo $marca->cantidad;?>)</span>
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
                    <img src="<?php echo base_url();?>resources/images/autopartes/icono-titulo.png" alt="icono autopartes" />
                </div>
                <div id="autopart-div-titulo">
                    <h1><span style="color: #C60200;">AUTOPARTES</span></h1>
                </div>

                <div class="autopart-div-pagination" id="autopart-div-pagination">
                    <?php $attributes = array('class' => 'form_paginacion', 'id' => 'form_paginacion');
                        echo form_open('',$attributes); ?>
                        <img class="paginacion-flecha paginacion-atras" id="paginacion-atras" src="<?php echo base_url();?>resources/images/autopartes/menor-que.png" alt="menor que" />
                        <span>Página</span>
                        <input name="pagina-actual" id="input_paginacion_pagina" value="<?php echo $limit;?>" />
                        <span>de</span>
                        <span><?php echo $cantidadAutopart;?></span>
                        <img class="paginacion-flecha paginacion-adelante" id="paginacion-adelante" src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que" />
                    <?php echo form_close(); ?>
                </div>

                <div class="clear"></div>
            </div>
            <div class="autopart-div-espaciador-rallas"></div>

            <div class="autopart-div-filtros">
                <?php $encontro= false; if(isset($vehiculoMarcaBusqueda) && sizeof($vehiculoMarcaBusqueda)>0): $encontro = true;?>
                <div class="autopart-div-filtro" id="filtro-vehiculo">
                    <span><?php echo $vehiculoMarcaBusqueda.' '.$vehiculoLineaBusqueda;?></span>
                    <div class="autopart-div-filtro-x">X</div>
                </div>
                <?php endif; ?>

                <?php if(isset($categoriaBusqueda) && sizeof($categoriaBusqueda)>0): $encontro = true;?>
                <div class="autopart-div-filtro" id="filtro-categoria">
                    <span><?php echo $categoriaBusqueda;?></span>
                    <div class="autopart-div-filtro-x">X</div>
                </div>
                <?php endif; ?>
                
                <?php if(isset($marcaBusqueda) && sizeof($marcaBusqueda)>0): $encontro = true;?>
                <div class="autopart-div-filtro" id="filtro-marca">
                    <span><?php echo $marcaBusqueda; ?></span>
                    <div class="autopart-div-filtro-x">X</div>
                </div>
                <?php endif; ?>

                <div class="clear"></div>	
            </div>

            <div id="autopart-div-autopartes">
                
                <?php foreach ($autopartes as $autoparte):?>
                <div class="autopart-div-autoparte">
                    <?php  $urlAutoparte = base_url().'autopartes/'.$autoparte->id_autoparte.'-'.preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $autoparte->nombre); ?>
                        <?php if($encontro){
                            $urlAutoparte .= '/buscar';
                            if(isset($categoriaBusqueda) && sizeof($categoriaBusqueda)>0): 
                                $urlAutoparte .= '/categoria/'.str_replace(' ', '-', convert_accented_characters($categoriaBusqueda));?> 
                        <?php endif; if(isset($marcaBusqueda) && sizeof($marcaBusqueda)>0):
                                $urlAutoparte .= '/marca/'.str_replace(' ', '-', convert_accented_characters($marcaBusqueda));?> 
                        <?php endif; if(isset($vehiculoMarcaBusqueda) && sizeof($vehiculoMarcaBusqueda)>0):
                                $urlAutoparte .= '/vehiculo/'.str_replace(' ', '-', convert_accented_characters($vehiculoMarcaBusqueda)).'-'.str_replace(' ', '-', convert_accented_characters($vehiculoLineaBusqueda)); ?>
                        <?php 
                            endif;
                        }?>
                    <div class="autopart-div-autoparte-marco">
                        <?php if(!($autoparte->imagen_url== '' ||$autoparte->imagen_url==NULL)):?>
                            <a href="<?php echo $urlAutoparte;?>"><img src="<?php echo base_url().$autoparte->imagen_url; ?>" alt="imagen autoparte" /></a>
                        <?php  else:?>
                            <a href="<?php echo $urlAutoparte;?>"><img style="opacity: 0.4;" src="<?php echo base_url().'resources/images/micuenta/tmpl_img_micuenta_vehiculo_nd1.png'; ?>" alt="imagen autoparte" /></a>
                        <?php endif; ?>
                        
                    </div>

                    <div class="autopart-div-autoparte-datos">
                        <div class="autopart-div-autoparte-info">
                            <div class="autopart-div-autoparte-titulo">
                                <a href="<?php echo $urlAutoparte;?>"><?php echo $autoparte->nombre. ' MARCA '.  $autoparte->marca.' PARA CARROS '. $autoparte->vehiculo_marca;?></a>
                            </div>

                            <div class="autopart-div-autoparte-descripcion">
                                <?php echo character_limiter($autoparte->descripcion, 300); ?>
                            </div>
                        </div>

                        <div class="autopart-div-autoparte-infoprecio">
                            <span>Desde</span>
                            <div class="autopart-div-autoparte-precio">
                                $ <?php echo number_format($autoparte->precio, 0, '.', ','); ?>
                            </div>
                            <div class="autopart-div-autoparte-vendedores">
                                (<?php echo $autoparte->numEstablecimientos?> vendedores)
                            </div>
                            <div class="autopart-div-autoparte-vermas">
                                
                                <a href="<?php echo $urlAutoparte;?>">Ver más</a>
                                <img src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que" style="right: 0px;"/>
                                <img src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que" style="right: 4px;"/>
                            </div>
                        </div>

                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
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
                    <span><?php echo $cantidadAutopart;?></span>
                    <img class="paginacion-flecha paginacion-adelante" id="paginacion-adelante" src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que" />
                <?php echo form_close(); ?>
            </div><br/><br/>

        </div>

        <div class="clear"></div>
        <div id="escoger-carro-lightbox" class="ui-widget">
                <img src="http://www.laspartes.com/resources/images/login/mayor-que.png" alt="flechas de registro"><h1>ESCOGE TU VEHÍCULO</h1>
                <p>
                    <label>Marca de tu carro: ej. Renault</label><br/>
                    <input id="marca-vehiculo" class="marca-vehiculo" type="text"/>
                </p>
                <p>
                    <label>Linea de tu carro: ej. Logan</label><br/>
                    <input id="linea-vehiculo" class="linea-vehiculo" type="text"/>
                </p> 
                <input type="submit" id="escoger-carro-lightbox-submit" value="Envíar"/><input id="escoger-carro-lightbox-cancelar" type="submit" value="Cancelar"/>
        </div> 
    </div>
</div>