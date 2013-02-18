<div id="sesion-div-header-cerrar">
    Cerrar sesión
</div>
<div id="sesion-div-header-perfil"> 

    <span id="sesion-span-header-perfil-nombre"><?php echo $this->session->userdata('usuario'); ?></span>
    <img id="sesion-span-header-perfil-flechita" src="<?php echo base_url(); ?>resources/template/header/flechita-usuario.png" alt="" />


</div>
<div class="clear"></div>
<img id="sesion-span-header-perfil-triangulo" class="hidden-header-perfil" src="<?php echo base_url(); ?>resources/template/header/triangulo-header.png" />
<div id="sesion-div-header-dropdown"  class="hidden-header-perfil">

    <div id="sesion-div-header-dd-opcion">
        <span id="sesion-span-header-dd-vehiculos"><a href="<?php echo base_url(); ?>usuario#usuario-div-mis-vehiculos">Mis vehículos</a></span><span></span>
    </div>
    <div id="sesion-div-header-dd-opcion">
        <span id="sesion-span-header-dd-ofertas"><a href="<?php echo base_url(); ?>usuario#usuario-div-ofertas">Ofertas de mantenimiento</a></span><span></span>
    </div>
    <div id="sesion-div-header-dd-opcion">
        <span id="sesion-span-header-dd-compras"><a href="<?php echo base_url(); ?>usuario#usuario-div-compras">Mis compras</a></span><span></span>
    </div>
    <div id="sesion-div-header-dd-opcion">
        <span id="sesion-span-header-dd-preguntas"><a href="<?php echo base_url(); ?>usuario#usuario-div-comunidad">Mis preguntas</a></span><span></span>
    </div>
    <div id="sesion-div-header-dd-opcion">
        <span id="sesion-span-header-dd-respuestas"><a href="<?php echo base_url(); ?>usuario#usuario-div-comunidad">Mis respuestas</a></span><span></span>
    </div>
</div>