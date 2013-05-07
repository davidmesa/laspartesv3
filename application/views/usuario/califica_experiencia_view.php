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

            <?php echo $breadcrumb; ?>
        </div>
        <div class="clear"></div>
        <div id="div-content-quienes somos">
            <div id="autopart-div-autopartes-titulo">
                <div id="autopart-div-titulo-icono">
                    <img style="margin-left: 30px;" src="<?php echo base_url(); ?>resources/images/novedades/novedad-icon.png" alt="icono autopartes" />
                </div>
                <div id="autopart-div-titulo">
                    <h1>
                        <span style="color: #C60200;">CALIFICA</span>
                        <span>TU EXPERIENCIA</span>
                    </h1>
                </div>

                <div class="clear"></div>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>

            <div style="margin-bottom: 36px; margin-top: 25px;">
                <div id="olvide-detalle-div-descripcion" style="width: 617px; margin-left: 0px;">


                    <?php
                    $config = array('id' => 'formulario_califica_experiencia');
                    echo form_open('usuario/calificar_experiencia', $config);
                    ?>
                    <input type="hidden" value="<?php echo $llave ?>" name="llave" />
                    <label>¿Cómo fue la experiencia en el taller?:</label>
                    <textarea rows="10" cols="70" name="mensaje"></textarea>
                    <div class="talleres-detalle-opinar-calificacion-estrellas" style="float: left; margin-top: 5px;">
                        Califica este establecimiento:
                        <div class="multiField" id="calificacion-comentario-div">
                            <input type="hidden" name="calificacion" id="calificacion" value="" />
                            <select>
                                <option value="1">1 (Malo)</option>
                                <option value="2">2 (Regular)</option>
                                <option value="3">3 (Bueno)</option>
                                <option value="4">4 (Muy Bueno)</option>
                                <option value="5">5 (Excelente)</option>
                            </select>
                        </div>
                    </div>
                    <input type="submit" class="general_boton_secundario"  value="Enviar" style="float: right; margin-top: 45px;"/>
                    <?php echo form_close(); ?>
                </div>

                <div id="califica-detalle-div-content" style="width: 300px; margin-left: 30px;">

                    <div class="talleres-detalle-div-taller-marco">
                        <img src="<?php
                    if ($establecimiento->logo_url != NULL && $establecimiento->logo_url != '') {
                        echo base_url() . $establecimiento->logo_url;
                    } else {
                        echo base_url() . 'resources/images/establecimientos/tmpl_logo_establecimiento_nd.gif';
                    }
                    ?>" alt="<?php echo $establecimiento->nombre; ?>" />
                    </div>
                    <div class="autopart-div-autoparte-titulo">
                        <?php echo $establecimiento->nombre; ?>
                    </div>
                    <div class="talleres-detalle-div-calificacion-estrellas">
                        <?php if ($establecimiento_calificacion->promedio != ''): ?>
                            <div class="talleres-detalle-div-calificacion-estrellas-imagen estrellas-sin-clasificar-grandes">
                                <div class="talleres-detalle-div-calificacion-estrellas-imagen-calificada estrellas-clasificadas-grandes"><span><?php echo (round($establecimiento_calificacion->promedio) * 20) . '%'; ?></span></div>
                            </div>
                        <?php endif; ?>   
                        <span><?php
                        if ($establecimiento_calificacion->promedio != '' && round($establecimiento_calificacion->promedio) == 5): echo '<strong>EXCELENTE</strong> - ' . $establecimiento_calificacion->count . ' opiniones de usuarios';
                        elseif ($establecimiento_calificacion->promedio != '' && round($establecimiento_calificacion->promedio) == 4): echo '<strong>MUY BUENO</strong> - ' . $establecimiento_calificacion->count . ' opiniones de usuarios';
                        elseif ($establecimiento_calificacion->promedio != '' && round($establecimiento_calificacion->promedio) == 3): echo '<strong>BUENO</strong> - ' . $establecimiento_calificacion->count . ' opiniones de usuarios';
                        elseif ($establecimiento_calificacion->promedio != '' && round($establecimiento_calificacion->promedio) == 2): echo '<strong>REGULAR</strong> - ' . $establecimiento_calificacion->count . ' opiniones de usuarios';
                        elseif ($establecimiento_calificacion->promedio != '' && round($establecimiento_calificacion->promedio) == 1): echo '<strong>MALO</strong> - ' . $establecimiento_calificacion->count . ' opiniones de usuarios';
                        else: echo '<strong>SIN CALIFICACIÓN</strong> - 0 opiniones de usuarios';
                        endif;
                        ?></span>
                    </div>

                    <div class="talleres-div-taller-direccion"> 
                        <strong>Zona:</strong> <?php echo $establecimiento->ciudad . ', ' . $establecimiento->zona;
                        ; ?>
                    </div>

                    <div class="autopart-div-autoparte-descripcion">
<?php echo $establecimiento->descripcion; ?> 
                    </div>
                </div>

                <div class="clear"></div>
            </div>


        </div>



        <div class="clear"></div>
    </div>
</div>