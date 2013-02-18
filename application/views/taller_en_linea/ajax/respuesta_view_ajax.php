<div class="tallerlinea-detalle-div-respuesta">
    <div id="tallerlinea-detalle-div-pregunta-marco">
        <img src="<?php if ($respuesta->imagen_url != '' && $respuesta->imagen_url != NULL) {
    echo base_url() . $respuesta->imagen_url;
} else if (strlen($respuesta->thumb) > 0) {
    echo base_url() . $respuesta->thumb;
} else {
    echo base_url() . 'resources/images/usuarios/avatar_thumb.gif';
} ?>"  alt="<?php echo $respuesta->usuario; ?>" /></a>
    </div>

    <div id="tallerlinea-detalle-div-respuesta-content">
        <div id="tallerlinea-detalle-div-respuesta-respuesta">
            Respuesta:
        </div>

        <div id="tallerlinea-detalle-div-respuesta-autor">
<?php echo $respuesta->usuario; ?>
        </div>
        
        <div id="tallerlinea-detalle-div-pregunta-fecha">
            <?php echo real_date($respuesta->fecha); ?>
        </div>

        <div id="tallerlinea-detalle-div-respuesta-cuerpo">
<?php echo nl2br($respuesta->respuesta); ?>
        </div>

        <div id="tallerlinea-detalle-div-respuesta-reportar">
            REPORTAR ABUSO
        </div>
        <div class="clear"></div>
    </div>

    <div class="clear"></div>
</div>