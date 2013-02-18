<div id="home-div-content">
    <div id="novedades-div-banner">
        <div id="tallerlinea-div-banner-comunidad">
            <div id="tallerlinea-div-banner-comunidad-titulo">

                <h1 style="font-size: 30px; padding-top: 15px;">ENCUENTRA EN LASPARTES.COM</h1>
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
                        <span style="color: #C60200;">CAMBIAR </span>
                        <span>MI CONTRASEÑA</span>
                    </h1>
                </div>

                <div class="clear"></div>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>

            <div id="quienes-detalle-div">
                <?php echo $confirmacion;?>
                <div id="olvide-detalle-div-descripcion">
                    Escribe tu nueva contraseña para ingresar a nuestra comunidad
                </div>

                <div id="quienes-detalle-div-content">

                    <?php 
                        $hidden = array('id_usuario' => $id_usuario, 'codigo' => $codigo);
                        $config = array('id' => 'formulario_cambio_contrasena');
                        echo form_open('usuario/cambio_contrasena', $config, $hidden);
                    ?>
                    <label>Escoge una nueva contraseña:</label>
                        <input class="general_cuadro_texto" type="password" name="contrasena_registrarse" id="contrasena_registrarse" size="38" />
                    <label>Confirma tu contraseña:</label>    
                        <input class="general_cuadro_texto" type="password" name="contrasena2_registrarse" id="contrasena2_registrarse" size="38" />
                        <input name="btn_olvido_contrasena" type="submit" class="general_boton_secundario" id="btn_olvido_contrasena" value="Cambiar mi contrase&ntilde;a" />
                   <?php echo form_close(); ?>
                </div>

                <div class="clear"></div>
            </div>


        </div>



        <div class="clear"></div>
    </div>
</div>