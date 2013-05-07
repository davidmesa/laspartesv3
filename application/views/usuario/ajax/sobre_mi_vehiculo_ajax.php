<div id="usuario-div-smv-content-header">
    <img src="<?php echo base_url(); ?>/resources/images/micuenta/mayor-que-rojo.png" alt="mayor que" />
    <div id="usuario-div-smv-content-carro" class="font-universe"><?php echo $vehiculos[0]->marca . " " . $vehiculos[0]->linea; ?></div>
    <div id="usuario-div-smv-content-te-contamos" class="open-sans">
        <div id="usuario-div-smv-content-te-contamos-txt1">TE CONTAMOS LO QUE DEBES HACER Y LO QUE HAS HECHO CON TU VEHÍCULO!</div>
        <div id="usuario-div-smv-content-te-contamos-txt2">Te recordamos qué cosas has hecho para tú vehículo, cuáles debes cumplir de manera urgente y cuáles están pendientes por hacer; además, tendrás un historial de las preguntas, respuesta y talleres sobre los que has hablado!!
        </div>
    </div> 

    <div class="usuario-div-smv-cronograma">Ver lo que tengo que hacer el durante el año</div>
    <div class="clear"></div>
    <div>
        <div class="usuario-div-smv-soat">Cotizar SOAT para mi vehículo</div>
        <div class="usuario-div-smv-soat-telefono">
            <div>Teléfono:</div>
            <input class="usuario-input-smv-telefono" type="text" /><input class="usuario-input-smv-soat" type="submit" value="Enviar"/>
            <div class="usuario-div-smv-soat-agentes">En breve uno de nuestros agentes se comunicará contigo.</div>
        </div>
        <div class="clear"></div> 
    </div>
    <div class="clear"></div>   
</div>

<div id="usuario-div-smv-content-sub">
    <div id="usuario-div-smv-lightbox-realizar"></div>
    <div id="usuario-div-smv-debo-hacer">
        <div class="usuario-div-smv-subtitulo">DEBO HACER</div>
        <div id="usuario-div-smv-db-content" class="open-sans smv_div_tareas"  style="padding-bottom: 50px;">
            <div id="usuario-div-smv-db-content-t1">PRIORIDAD ALTA</div>
            <div id="usuario-div-smv-db-content-t2">PARA HACER LO MÁS PRONTO!</div>


            <div class="div-separador-titulo"></div>

            <?php
            $indexDebo = 0;
            foreach ($tareas as $tarea): if ($tarea->realizado == false &&
                        ( ($tarea->mensaje_dias_restantes == "TE QUEDAN: " && $tarea->dias_restantes <= 15) ||
                        ($tarea->mensaje_dias_restantes == "DEBES HACERLO") )):
                    $indexDebo++;
                    ?>
                    <div class="usuario-div-smv-tarea smv_tarea_realizar <?php if ($indexDebo > 2) echo 'tarea_hidden'; ?>">

                        <div class="usuario-div-smv-tarea-izq">
                            <div class="usuario-div-smv-tarea-foto"><img src="<?php echo base_url() . $tarea->imagen_thumb_url; ?>" alt="tarea" /></div>
                            <div class="usuario-div-smv-tarea-chkbox">
                                <?php if ($tarea->id_servicio != 9 && $tarea->id_servicio != 10): ?>
                                    <input class="usuario-input-smv-tarea-chkbox" name ="" type="checkbox" value="<?php echo $tarea->id_servicio; ?>" /> YA LO HICE!
                                <?php else: ?>
                                    <input  disabled="disabled" class="usuario-input-smv-tarea-chkbox" name ="" type="checkbox" value="<?php echo $tarea->id_servicio; ?>" /> YA LO HICE!
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="usuario-div-smv-tarea-der">
                            <div class="usuario-div-tarea-nombre"><span><?php echo $tarea->nombre; ?></span></div>
                            <div class="usuario-div-tarea-progreso"><span style="background-color: #c60200;"><?php echo $tarea->mensaje_dias_restantes . $tarea->dias_restantes . $tarea->mensaje_dias_restantes2; ?></span></div>
                            <div class="usuario-div-tarea-descripcion">
                                <?php
                                $text = strip_tags($tarea->descripcion);
                                $words = explode(" ", $text);
                                $content = "";
                                $i = 0;
                                foreach ($words as $word) {
                                    if ($i == 30) {
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
                            <div id="usuario-div-smv-db-content-t3" class="usuario-div-smv-db-content-t3">¿QUÉ PASA SI NO LO HAGO?</div>
                        </div>

                        <div class="clear"></div>
                    </div>
                    <?php
                endif;
            endforeach;
            ?>
        </div>
    </div>


    <div id="usuario-div-smv-pendiente">
        <div class="usuario-div-smv-subtitulo">TENGO PENDIENTE</div>
        <div id="usuario-div-smv-tp-content" class="open-sans smv_div_tareas" style="padding-bottom: 50px;">
            <div id="usuario-div-smv-tp-content-t">ESTAS COSAS, DEBES TENERLAS EN CUENTA PRÓXIMAMENTE...</div>

            <div class="div-separador-titulo"></div>

            <?php
            $indexPendiente = 0;
            foreach ($tareas as $tarea): if ($tarea->realizado == false &&
                        ($tarea->mensaje_dias_restantes == "TE QUEDAN: " && $tarea->dias_restantes > 15)):
                    $indexPendiente++;
                    ?>
                    <div class="usuario-div-tp-tarea smv_tarea_realizar <?php if ($indexPendiente > 2) echo 'tarea_hidden'; ?>"> 

                        <div class="usuario-div-tp-tarea-izq">
                            <div class="usuario-div-tp-tarea-foto"><img src="<?php echo base_url() . $tarea->imagen_thumb_url; ?>" alt="tarea" /></div>
                            <div class="usuario-div-smv-tarea-chkbox">
                                <?php if ($tarea->id_servicio != 9 && $tarea->id_servicio != 10): ?>
                                    <input  class="usuario-input-smv-tarea-chkbox" name ="" type="checkbox" value="<?php echo $tarea->id_servicio; ?>" /> YA LO HICE!
                                <?php else: ?>
                                    <input  disabled="disabled" class="usuario-input-smv-tarea-chkbox" name ="" type="checkbox" value="<?php echo $tarea->id_servicio; ?>" /> YA LO HICE!
                                <?php endif; ?>
                            </div> 
                        </div>

                        <div class="usuario-div-tp-tarea-der">
                            <div class="usuario-div-tarea-nombre"><span><?php echo $tarea->nombre; ?></span></div>
                            <div class="usuario-div-tarea-progreso"><span style="background-color: #ef6b00;"><?php echo $tarea->mensaje_dias_restantes . $tarea->dias_restantes . $tarea->mensaje_dias_restantes2; ?></span></div>
                            <div class="usuario-div-tarea-descripcion">
                                <?php
                                $text = strip_tags($tarea->descripcion);
                                $words = explode(" ", $text);
                                $content = "";
                                $i = 0;
                                foreach ($words as $word) {
                                    if ($i == 30) {
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
                            <div id="usuario-div-smv-db-content-t3" class="usuario-div-smv-db-content-t3">¿QUÉ PASA SI NO LO HAGO?</div>
                        </div>

                        <div class="clear"></div>

                    </div>
                    <?php
                endif;
            endforeach;
            ?>
        </div>
    </div>


    <div id="usuario-div-smv-hecho">
        <div class="usuario-div-smv-subtitulo">ESTÁ HECHO</div>

        <div id="usuario-div-smv-hecho-content" class="open-sans">
            <div id="usuario-div-smv-hecho-content-t">TAREAS QUE YA CUMPLISTE!</div>

            <div class="div-separador-titulo"></div>

            <div class="usuario-div-smv-hecho-tareas open-sans smv_div_tareas">
                <ul>
                    <?php
                    $indexT = 0;
                    foreach ($tareas as $tarea): if ($tarea->realizado == true):
                            $indexT++;
                            ?>
                            <li class="usario-li-tarea-realizada <?php if ($indexT > 8) echo 'tarea_hidden'; ?>">
                                <span class="usuario-div-smv-hecho-tareas-id-tarea"><?php echo $tarea->id_tarea_realizada; ?></span>
                                <?php echo $tarea->nombre; ?> ........ 
                                <span>
                                    <?php
                                    if ($tarea->due != '0000-00-00'): echo $tarea->due;
                                    endif;
                                    ?> |
                                </span>
                                <?php if ($tarea->id_servicio != 9 && $tarea->id_servicio != 10): ?>     
                                    <span class="usuario-span-tareas-deshacer">Deshacer</span><?php if (!empty($tarea->adjunto)) { ?><span class="usuario-span-tareas-adjunto"> | <a target="_blank" href="<?php echo $tarea->adjunto; ?>">Adjunto</a></span><?php } ?> 
                                <?php endif; ?>
                            </li>
                            <?php
                        endif;
                    endforeach;
                    foreach ($items_compras as $i => $carrito_compra):
                        ?>
                        <li class="usario-li-tarea-realizada <?php if ($indexT + $i > 7) echo 'tarea_hidden'; ?>">
                            <span class="usuario-div-smv-hecho-tareas-id-tarea"><?php echo $tarea->id_tarea_realizada; ?></span>
                            <?php echo character_limiter($carrito_compra->titulo, 73, ''); ?> ........ 
                            <span>
                                <?php
                                if ($carrito_compra->fecha != '0000-00-00'): echo strftime("%B %d de %Y", strtotime($carrito_compra->fecha));
                                endif;
                                ?><span class="usuario-span-tareas-adjunto"> | <a target="_blank" href="<?php echo base_url() . 'usuario/recibo/' . $carrito_compra->refVenta; ?>">Adjunto</a></span>
                            </span>
                        </li>
                        <?php
                    endforeach;
                    ?>
                </ul>
            </div>
        </div> 
    </div>

    <div class="clear"></div>
    <div class="usuario-div-smv-vermas rojo smv_realizada_vermas <?php if ($indexDebo <= 2 && $indexT + $i < 8 && $indexPendiente <= 2) echo 'tarea_realizada_hidden' ?>">Ver más</div>    
</div>