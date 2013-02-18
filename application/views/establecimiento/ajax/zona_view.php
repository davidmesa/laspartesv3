<div class="autopart-div-espaciador-rallas"></div>

<div id="autopart-div-titulo">
    <h1><span>ZONAS</span></h1>
</div>

<div class="autopart-div-espaciador-rallas"></div>



<?php foreach ($zonas as $zona): ?>
    <div class="autopart-div-categoria filtro-servicio">
        <div class="autopart-div-categoria-bullet comprimido"><img src="<?php echo base_url(); ?>resources/images/autopartes/mayor-que.png" alt="mayor que rojo" /></div>
        <div class="autopart-div-categoria-content">
            <h4 class="autopart-h4-categoria-titulo"><span><?php echo $servicio->nombre; ?></span>
                <span class="utopart-h4-span-cantidad">(<?php echo $servicio->cantidad; ?>)</span>
            </h4>
            <!--                    <ul>
                                    <li><h4>cat 1</h4></li>
                                    <li><h4>cat 2</h4></li>
                                    <li><h4>cat 3</h4></li>
                                    <li><h4>cat 4</h4></li>
                                </ul>-->
        </div>
        <div class="clear"></div>
    </div>

<?php endforeach; ?>



<div class="autopart-div-espacio"></div>