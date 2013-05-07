<div id="home-div-content">
    <div id="novedades-div-banner">
        <div id="tallerlinea-div-banner-comunidad">
            <div id="tallerlinea-div-banner-comunidad-titulo">

                <h1 style="font-size: 30px;">ENCUENTRA EN LASPARTES.COM</h1>
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
        <div id="div-content-quienes somos">
            <div id="autopart-div-autopartes-titulo">
                <div id="autopart-div-titulo-icono">
                    <img style="margin-left: 30px;" src="<?php echo base_url(); ?>resources/images/novedades/novedad-icon.png" alt="icono autopartes" />
                </div>
                <div id="autopart-div-titulo">
                    <h1>
                        <span style="color: #C60200;">OLVIDÉ</span>
                        <span>MI CONTRASEÑA</span>
                    </h1>
                </div>

                <div class="clear"></div>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>

            <div id="quienes-detalle-div">
                <div id="olvide-detalle-div-descripcion">
                    <img src="<?php echo base_url(); ?>resources/images/template/iconos/Check.gif" width="60" height="60" alt="Correo ha sido enviado" /><br/>
                    Las <strong>instrucciones</strong> para recuperar tu contrase&ntilde;a han sido enviadas al <strong>correo especificado</strong>. 
                </div>

                <div id="quienes-detalle-div-content">

                    <?php $config = array('id' => 'formulario_olvido_contrasena');
                                echo form_open('usuario/olvido_contrasena', $config); ?>
                    <label>Correo electrónico:</label>
                        <input class="general_cuadro_texto" type="text" name="email_registrarse" id="email_registrarse" size="38" />
                    <label>Escribe los 4 dígitos de abajo:</label>    
                        <input class="general_cuadro_texto" type="text" name="captcha_registrarse" id="captcha_registrarse" size="38" />
                        <?php echo $captcha['image']; ?>
                        <input name="btn_olvido_contrasena" type="submit" class="general_boton_secundario" id="btn_olvido_contrasena" value="Recuperar mi contrase&ntilde;a" />
                   <?php echo form_close(); ?>
                </div>

                <div class="clear"></div>
            </div>


        </div>



        <div class="clear"></div>
    </div>
</div>