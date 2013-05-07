<div class="talleres-detalle-div-opinion">
    <div class="talleres-detalle-div-opinion-left">
        <div class="talleres-detalle-div-opinion-comentario"><?php echo $comentario; ?></div>
        <div class="talleres-detalle-div-opinion-por">
            Por: <?php echo $usuario; ?>
        </div>
        <div class="talleres-detalle-div-opinion-fecha">
            Publicado hace <strong>1 minuto</strong>
        </div>
    </div>

    <div class="talleres-detalle-div-opinion-right">

        <div class="talleres-detalle-div-opinion-calificacion">
            <?php if ($calificacion != ''): echo (round($calificacion) * 20) . '%';
            else: echo 'Sin calificación';
            endif; ?>
        </div>

<?php if ($calificacion != ''): ?>
            <div class="talleres-detalle-div-opinion-calificacion-porcentaje estrellas-sin-clasificar-grandes">
                <div class="talleres-detalle-div-opinion-calificacion-calificado estrellas-clasificadas-grandes"><span><?php echo (round($calificacion) * 20) . '%'; ?></span></div>
            </div>
<?php endif; ?>   
        <?php if( strlen($comentario)> 154): ?>
        <div class="talleres-detalle-div-opinion-expandir">
            EXPANDIR 
            <img src="<?php echo base_url(); ?>resources/images/autopartes/expandir.png" alt="expandir" />
        </div>
        <?php endif; ?>
    </div>

    <div class="clear"></div>

    <div class="talleres-detalle-div-opinion-separador"></div>
</div>