
<?php foreach ($establecimientos as $establecimiento): ?>
    <div class="usuario-div-comunidad-talleres-fototaller">
        <div class="usuario-div-comunidad-talleres-marco">
            <a href="<?php echo base_url() . 'establecimientos/' . $establecimiento->id_establecimiento . '-' . str_replace(" ", "-", convert_accented_characters($establecimiento->nombre)); ?>"><img src="<?php echo base_url() . $establecimiento->logo_thumb_url; ?>" alt="icono establecimiento" /></a>
        </div>
        <div class="usaurio-div-comunidad-talleres-tallerinfo">
            <div class="usaurio-div-comunidad-talleres-taller-nombre"><a href="<?php echo base_url() . 'establecimientos/' . $establecimiento->id_establecimiento . '-' . str_replace(" ", "-", convert_accented_characters($establecimiento->nombre)); ?>"><?php echo $establecimiento->nombre; ?></a></div>

            <div class="usaurio-div-comunidad-talleres-taller-url">
                <div class="">
                    <?php
                    $text = strip_tags($establecimiento->descripcion);
                    $words = explode(" ", $text);
                    $content = "";
                    $i = 0;
                    foreach ($words as $word) {
                        if ($i == 6) {
                            break;
                        }
                        if ($i) {
                            $content .= " ";
                        }
                        $content .= $word;
                        $i++;
                    }
                    echo $content . "…";
                    ?>
                </div>
                <a href="http://<?php echo $establecimiento->web; ?>" target="_blank"><?php echo $establecimiento->web; ?></a>
            </div>

            <div class="usaurio-div-comunidad-talleres-taller-direccion">
                <?php echo $establecimiento->direccion; ?>
            </div>

            <div class="usaurio-div-comunidad-talleres-taller-telefono">
                <strong style="color:black;">Tel: </strong><?php echo $establecimiento->telefonos; ?>
            </div>

        </div>
        <div class="clear"></div>

        <div style="position: relative; ">
            <img id="usuario-div-comunidad-triguangulo" src="<?php echo base_url(); ?>resources/images/micuenta/triangulo-caja.png" />
            <div class="usuario-div-comunidad-talleres-comentario open-sans">
                <div class="usuario-div-comunidad-talleres-comentario-imagen">
                    <img src="<?php
            if ($usuario->imagen_url != NULL || $usuario->imagen_url != '') {
                echo base_url() . $usuario->imagen_url;
            } else {
                echo base_url() . 'resources/images/usuarios/avatar.gif';
            }
                ?>" alt="foto usuario" />
                </div>


                <div class="usuario-div-comunidad-talleres-comentario-nombrefecha">
                    <div class="usuario-div-comunidad-talleres-comentario-nombre">
                        <?php echo $usuario->nombres; ?>
                    </div>


                    <div class="usuario-div-comunidad-talleres-comentario-fecha">
                        <?php echo strftime("%d de %B de %Y", strtotime($establecimiento->fecha)); ?>
                    </div>
                </div>

                <div class="usuario-div-comunidad-talleres-comentario-comentariocalificacion">
                    <div class="usuario-div-comunidad-talleres-comentario-comentario">
                        <?php
                        $text = strip_tags($establecimiento->comentario);
                        $words = explode(" ", $text);
                        $content = "";
                        $i = 0;
                        foreach ($words as $word) {
                            if ($i == 4) {
                                break;
                            }
                            if ($i) {
                                $content .= " ";
                            }
                            $content .= $word;
                            $i++;
                        }
                        echo $content . "…";
                        ?>

                    </div>

                    <div class="usuario-div-comunidad-talleres-comentario-calificacion estrellas-sin-clasificar">
                        <div class="usuario-div-comunidad-talleres-comentario-calificacion-activa estrellas-clasificadas"><span><?php echo round($establecimiento->calificacion) * 20; ?>%</span></div>
                    </div>
                </div>

                <div class="clear"></div>
            </div>	
        </div>
    </div>
<?php endforeach; ?>