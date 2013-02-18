
<div id="home-div-header-bottom">
    <div class="font-universe" id="home-div-header-menu">
        <?php if ($navegacion_view == 'inicio') { ?>
            <a href="<?php echo base_url(); ?>">
                <div id="home-div-header-menu-home" class="barra_selected">
                    <img src="<?php echo base_url(); ?>resources/template/header/header-menu-home.png" alt="casita-menu" />
                </div>
            </a>
        <?php } else { ?> 
            <a href="<?php echo base_url(); ?>"> 
                <div id="home-div-header-menu-home">
                    <img src="<?php echo base_url(); ?>resources/template/header/header-menu-home.png" alt="casita-menu" />
                </div>
            </a>
        <?php } ?>
        
        <div class="home-div-header-menu-espacio"></div>

        <?php if ($navegacion_view == 'establecimientos') { ?>
            <div class="home-div-header-menu-titulos barra_selected"><a href="<?php echo base_url(); ?>talleres" >TALLERES</a></div>
        <?php } else { ?>
            <div class="home-div-header-menu-titulos"><a href="<?php echo base_url(); ?>talleres" >TALLERES</a></div>
        <?php } ?>
            
        <div class="home-div-header-menu-espacio"></div>

        <?php if ($navegacion_view == 'autopartes') { ?>
            <div class="home-div-header-menu-titulos barra_selected"><a href="<?php echo base_url(); ?>autopartes" >AUTOPARTES</a></div>
        <?php } else { ?>
            <div class="home-div-header-menu-titulos"><a href="<?php echo base_url(); ?>autopartes" >AUTOPARTES</a></div>
        <?php } ?>

        <div class="home-div-header-menu-espacio"></div>

        <?php if ($navegacion_view == 'tallerenlinea') { ?>
            <div class="home-div-header-menu-titulos barra_selected"><a href="<?php echo base_url(); ?>preguntas" >PREGUNTAS</a></div>
        <?php } else { ?>
            <div class="home-div-header-menu-titulos"><a href="<?php echo base_url(); ?>preguntas" >PREGUNTAS</a></div>
        <?php } ?>

        <div class="home-div-header-menu-espacio"></div>

        <?php if ($navegacion_view == 'promociones') { ?>
            <div class="home-div-header-menu-titulos barra_selected"><a href="<?php echo base_url(); ?>promociones" >PROMOCIONES</a></div>
            <img id="home-img-header-triangulo" src="<?php echo base_url(); ?>resources/template/header/triangulo-novedades.png"/>
        <?php } else { ?>
            <div class="home-div-header-menu-titulos"  id="barra_novedades"><a href="<?php echo base_url(); ?>promociones" >PROMOCIONES</a></div>
            <img style="display: none;" id="home-img-header-triangulo" src="<?php echo base_url(); ?>resources/template/header/triangulo-novedades.png"/>
        <?php } ?>
            <?php if ($this->session->userdata('esta_registrado')): ?>
                <div class="home-div-header-menu-titulos2" style="margin-right: 35px;"><a href="<?php echo base_url(); ?>usuario" >MI TALLER EN LÍNEA</a></div>
            <?php else: ?>
                 <div class="home-div-header-menu-titulos2"><a href="<?php echo base_url(); ?>registro" >REGISTRAR MI VEHÍCULO</a></div>
            <?php endif; ?>
    </div>

</div> 