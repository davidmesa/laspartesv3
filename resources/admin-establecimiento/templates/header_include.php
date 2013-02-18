<div id="header" class="png_bg">
    <div id="head_wrap" class="container_12">
        <div id="logo" class="grid_4">
            <h1>Las Partes <span>Admin</span></h1>
        </div>

        <div id="controlpanel" class="grid_8">
            <ul>
                <li><p>Bienvenido <strong><?php echo $this->session->userdata('usuario'); ?></strong></p></li>
                <li><a href="<?php echo base_url(); ?>admin-establecimiento/usuario/cerrar_sesion" class="last">Cerrar Sesión</a></li>
            </ul>
        </div>

        <div id="navigation" class=" grid_12">
            <ul>
                <li><a href="<?php echo base_url(); ?>admin-establecimiento/">Inicio</a></li>
                <li><a href="<?php echo base_url(); ?>admin-establecimiento/establecimiento">Mis Establecimientos</a></li>
                <li><a href="<?php echo base_url(); ?>admin-establecimiento/ventas">Mis Ventas</a></li>
                <li><a href="<?php echo base_url(); ?>admin-establecimiento/comentarios">Mis Comentarios</a></li>
            </ul>
        </div>
    </div>
</div>