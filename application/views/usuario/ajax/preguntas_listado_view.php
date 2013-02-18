<?php foreach ($preguntas as $pregunta): ?>

    <div class="usuario-div-comunidad-pregunta">

        <img src="<?php echo base_url(); ?>resources/images/micuenta/mayor-que-rojo.png" alt="mayor que" />

        <div class="usuario-div-comunidad-pregunta-derecha">
            <div class="usuario-div-comunidad-pregunta-titulo">
                <a href="<?php echo base_url() . 'preguntas/' . $pregunta->id_pregunta . '-' . str_replace(" ", "-", convert_accented_characters($pregunta->titulo_pregunta)); ?>"><?php echo $pregunta->titulo_pregunta; ?></a>
            </div>

            <div class="usuario-div-comunidad-pregunta-contenido">
                <?php
                $text = strip_tags($pregunta->cuerpo_pregunta);
                $words = explode(" ", $text);
                $content = "";
                $i = 0;
                foreach ($words as $word) {
                    if ($i == 25) {
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

            <div class="usuario-div-comunidad-pregunta-respuestas">
                <a href="<?php echo base_url() . 'preguntas/' . $pregunta->id_pregunta . '-' . str_replace(" ", "-", convert_accented_characters($pregunta->titulo_pregunta)); ?>"><?php echo $pregunta->numero_respuestas; ?> respuestas</a>
            </div>
        </div>

        <div class="clear"></div>

    </div>

<?php endforeach; ?>