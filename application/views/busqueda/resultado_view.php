<div id="home-div-content">
    <div id="novedades-div-banner">
        <div id="tallerlinea-div-banner-comunidad">
            <div id="tallerlinea-div-banner-comunidad-titulo">

                <h1 style="font-size: 30px; padding-top: 20px;">ENCUENTRA EN LASPARTES.COM</h1>
                <h1>LA INFORMACIÓN MÁS COMPLETA PARA TU VEHÍCULO</h1>
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
        <div class="div-content-left-carrito">
            <div id="autopart-div-autopartes-titulo">
                <div id="autopart-div-titulo-icono" style="float: left;">
                    <img style="margin-left: 30px;" src="<?php echo base_url(); ?>resources/images/novedades/novedad-icon.png" alt="icono autopartes" />
                </div>
                <div id="autopart-div-titulo" style="float: left; margin-top: 0px;">
                    <h1>
                        <span style="color: #C60200;">BÚSQUEDA</span>
                    </h1>
                </div>
                
                <div class="autopart-div-pagination" id="autopart-div-pagination">
                    <?php $attributes = array('class' => 'form_paginacion', 'id' => 'form_paginacion');
                        echo form_open('',$attributes); ?>
                        <img class="paginacion-flecha paginacion-atras" id="paginacion-atras" src="<?php echo base_url();?>resources/images/autopartes/menor-que.png" alt="menor que" />
                        <span>Página</span>
                        <input name="pagina-actual" id="input_paginacion_pagina" value="<?php echo $offset;?>" />
                        <span>de</span>
                        <span><?php echo $numero_resultados;?></span>
                        <img class="paginacion-flecha paginacion-adelante" id="paginacion-adelante" src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que" />
                    <?php echo form_close(); ?>
                </div>

                <div class="clear"></div>
            </div>
            

            <div class="autopart-div-espaciador-rallas"></div>

            <div id="terminos-detalle-div" class="busqueda-div-resultados">
                        
                <?php $numero_resultado = 0;
                if(sizeof($resultados)!=0){
                foreach($resultados as $resultado){ ?>
                
                    <h3><a href="<?php echo base_url().$resultado->url; ?>"><?php echo $resultado->titulo; ?></a></h3>
                   
                
                    <h4><?php echo character_limiter($resultado->resumen, 200); ?> <a href="<?php echo base_url().$resultado->url; ?>">Ver más</a></h4>
                    
                    <h4>Encontrado en <strong><?php echo $resultado->seccion; ?></strong></h4>
                   
            <?php $numero_resultado++;
                }
            } else{?>
                    
                    <h2>¡Lo sentimos! No se encontraron resultados para tu busqueda.</h2>
            <?php }?>

            </div>
            
            <div class="autopart-div-pagination" id="autopart-div-pagination">
                <?php $attributes = array('class' => 'form_paginacion', 'id' => 'form_paginacion');
                    echo form_open('',$attributes); ?>
                    <img class="paginacion-flecha paginacion-atras" id="paginacion-atras" src="<?php echo base_url();?>resources/images/autopartes/menor-que.png" alt="menor que" />
                    <span>Página</span>
                    <input name="pagina-actual" id="input_paginacion_pagina" value="<?php echo $offset;?>" />
                    <span>de</span>
                    <span><?php echo $numero_resultados;?></span>
                    <img class="paginacion-flecha paginacion-adelante" id="paginacion-adelante" src="<?php echo base_url();?>resources/images/autopartes/mayor-que.png" alt="mayor que" />
                <?php echo form_close(); ?>
            </div>
            <br/><br/>


        </div>
        
        <div class="div-content-center-novedades">
            <div id="carrito-div-publicidad-titulo" class="font-universe">
                <div>PUBLICIDAD</div>
            </div>
            <div class="carrito-div-publicidad-imagen">
                <img src="<?php echo base_url();?>/resources/images/home/imagen-publicidad.png" alt="imagen publicidad" />
            </div>
        </div>

        <div class="clear"></div>
    </div>
</div>