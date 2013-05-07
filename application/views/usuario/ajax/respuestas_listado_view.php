<?php foreach ($respuestas as $respuesta): ?>
    <div class="usuario-div-comunidad-pregunta">

        <img src="<?php echo base_url(); ?>resources/images/micuenta/mayor-que-rojo.png" alt="mayor que" />

        <div class="usuario-div-comunidad-pregunta-derecha">
            <div class="usuario-div-comunidad-pregunta-titulo">
                <a href="<?php echo base_url() . 'preguntas/' . $pregunta->id_pregunta . '-' . str_replace(" ", "-", convert_accented_characters($pregunta->titulo_pregunta)); ?>"> <?php echo $respuesta->titulo_pregunta; ?></a>
            </div>

            <div style="position: relative;">
                <img id="usuario-div-comunidad-triguangulo" src="<?php echo base_url() ?>resources/images/micuenta/triangulo-caja.png" />
                <div class="usuario-div-comunidad-pregunta-contenido">
                    <?php
                    $text = strip_tags($respuesta->respuesta);
                    $words = explode(" ", $text);
                    $content = "";
                    $i = 0;
                    foreach ($words as $word) {
                        if ($i == 35) {
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
            </div>

            <div class="usuario-div-comunidad-pregunta-respuestas">
                <a href="<?php echo base_url() . 'preguntas/' . $respuesta->id_pregunta . '-' . str_replace(" ", "-", convert_accented_characters($respuesta->titulo_pregunta)); ?>"><?php echo $respuesta->numero_respuestas; ?> respuestas</a>

                <div class="usuario-div-comunidad-pregunta-autor">
                    <div class="usuario-div-comunidad-pregunta-autor-nombre">
                        Por: <?php echo $usuario->nombres . " " . $usuario->apellidos; ?>
                    </div>
                    <div class="usuario-div-comunidad-pregunta-autor-fecha">
                        <?php echo strftime("%d de %B de %Y", strtotime($respuesta->fecha)); ?>
                    </div>
                </div>

                <div class="clear"></div>
            </div>
        </div>

        <div class="clear"></div>

    </div>
<?php endforeach; ?>