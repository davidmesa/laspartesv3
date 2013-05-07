<?php $sesion = $this->session->userdata('esta_registrado'); ?>
<div id="sesion-div-header"> 


    <div id="sesion-div-header-content"> 
        <div id="sesion-div-header-que-es">
            <a href="<?php echo base_url(); ?>acerca/que_es_laspartes">¿Qué es Laspartes.com?</a>
        </div>
        <div class="sesion-div-titulos-espaciador"></div>
        <div id="sesion-div-header-que-es"> 
            <a href="<?php echo base_url(); ?>aprende">Tips y consejos</a>
        </div>
        <div class="sesion-div-titulos-espaciador" style="margin-right: 0px;"></div>
        <div id="sesion-div-header-contactenos" class="sesion-div-header-contactenos" style="padding-left: 15px; padding-right: 15px;">
            <a href="<?php echo base_url(); ?>ayuda">Cuéntanos lo que necesitas</a>
        </div>
        <div class="sesion-div-titulos-espaciador" style="margin-right: 0px; margin-left: 0px;"></div>  
        <div id="sesion-div-header-telefonos">
            <span>BOG </span><img src="<?php echo base_url(); ?>resources/images/iconos/banderas/co.gif" alt="telefono colombia"/><span> <a href="tel:+5713819790">3819790</a> - <a href="tel:+5713134207281">(313) 420-7281</a></span>
        </div>
        
        <?php if ($sesion): ?>
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
                    <span id="sesion-span-header-dd-vehiculos"><a href="<?php echo base_url();?>usuario#usuario-div-mis-vehiculos">Mis vehículos</a></span><span></span>
                </div>
                <div id="sesion-div-header-dd-opcion">
                    <span id="sesion-span-header-dd-ofertas"><a href="<?php echo base_url();?>usuario#usuario-div-ofertas">Ofertas de mantenimiento</a></span><span></span>
                </div>
                <div id="sesion-div-header-dd-opcion">
                    <span id="sesion-span-header-dd-compras"><a href="<?php echo base_url();?>usuario#usuario-div-compras">Mis compras</a></span><span></span>
                </div>
                <div id="sesion-div-header-dd-opcion">
                    <span id="sesion-span-header-dd-preguntas"><a href="<?php echo base_url();?>usuario#usuario-div-comunidad">Mis preguntas</a></span><span></span>
                </div>
                <div id="sesion-div-header-dd-opcion">
                    <span id="sesion-span-header-dd-respuestas"><a href="<?php echo base_url();?>usuario#usuario-div-comunidad">Mis respuestas</a></span><span></span>
                </div>
            </div>
        <?php else: ?>    
            <div id="sesion-div-header-sin-sesion">No ha iniciado sesión.</div>
        <?php endif; ?>
             <div class="clear"></div>
    </div>  
</div>
<div class="home-div-header">
    <div class="home-div-header-logo">
        <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>resources/template/header/logo-laspartes.png" /></a>
    </div>
    <div class="home-div-header-espacio1"></div>
    <div class="home-div-header-informacion">
        <div class="home-div-header-top">
            <div id="home-div-header-buscar">
                <form id="form_buscar">
                    <div id="home-div-header-buscar-boton">
                        <input name="input-buscar-boton" type="submit"  value=""/>
                    </div>
                    <div id="home-div-header-buscar-input">
                        <input name="input-buscar" id="input-busqueda-palabra" onclick="this.value='';" value="<?php if($busqueda) echo $busqueda; else echo 'BUSCAR'; ?>"/>
                    </div>
                </form>

            </div> 
            <div class="open-sans" id="home-div-header-redes-sociales">
                <span>Síguenos en:</span>
                <div class="iconos"> 
                    <a target="_blank" href="https://plus.google.com/113083431473419170081/posts"><div class="gplus"></div></a>
                    <a target="_blank" href="https://www.facebook.com/laspartes"><div class="fb"></div></a>
                    <a target="_blank" href="http://twitter.com/laspartes"><div class="twitter"></div></a>
                </div>
            </div>
            <div id="home-div-header-sesion-carrito">
            <?php if ($sesion) { ?>
                <?php if($navegacion_view == 'micuenta'):?>
                    <a href="<?php echo base_url() . 'usuario' ?>">
                        <div class="helvetica-regular" id="home-div-header-top-sesion-activo">
                            <span>MI TALLER</span>
                        </div>
                    </a>
                <?php else:?>
                <a href="<?php echo base_url() . 'usuario' ?>">
                    <div class="helvetica-regular" id="home-div-header-top-sesion-no-activo">
                        <span>MI TALLER</span>
                    </div>
                </a>
                <?php endif; ?>
            <?php } else { ?>
                <div class="helvetica-regular" id="home-div-header-top-sesion">
                    <span>INICIAR MI SESION</span>
                </div>
            <?php } ?>
               
           
            <div id="home-div-header-login-box" class="open-sans hide">
                 <div id="home-div-login-box-triangulo"></div>
                <form id="formulario_login">
                    <label id="email">E-mail:</label>
                    <input name="input_login_email" type="text" class="input_login_email" id="email-dado" value="" />
                    <label id="contrasena">Contraseña:</label>
                    <input name="input_login_contrasena" class="input_login_contrasena" id="contrasena-dada"  type="password" value="" />
                    <div id="formulario_login_bottom">
                        <a href="<?php echo base_url();?>usuario/formulario_olvido_contrasena" id="olvide-contraseña"  >Olvidé mi contraseña</a>
                        <input type="submit" class="input_login_submit" id="forma-login" name="forma-login-submit" value="Ingresar" />
                        <div class="clear"></div>
                    </div><br/>
                    <img  id="home-div-facebook-button"  class="home-div-facebook-button" width="100%" src="<?php echo base_url();?>resources/images/login/facebook-conectar-boton.png"/>
                </form>
            </div>
            <?php if ($navegacion_view == 'micarrito'): ?>
            <div class="helvetica-regular" id="home-div-header-top-carrito-activo"  >
                <a href="<?php echo base_url() . 'carrito'; ?>" >
                    <span id="home-span-carrito-titulo">CARRITO</span>
                    <span id="home-span-carrito-numero">(<?php echo $this->cart->total_items(); ?>)</span>
                </a>
<!--                <span>CERRAR SESION</span>-->
            </div>
            <?php else:?>
            <div class="helvetica-regular" id="home-div-header-top-carrito"  >
                <a href="<?php echo base_url() . 'carrito'; ?>" >
                    <span id="home-span-carrito-titulo">CARRITO</span>
                    <span id="home-span-carrito-numero">(<?php echo $this->cart->total_items(); ?>)</span>
                </a>
<!--                <span>CERRAR SESION</span>-->
            </div>
            <?php endif; ?>
            <div class="clear"></div>   
            </div> 
        </div>

        <?php
        if (isset($navegacion_view)) {
            $this->load->view('template/navegacion_view');
        }
        ?>

    </div>       
</div>

