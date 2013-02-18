<tr>
    <td>
        <table width="930" border="0" cellspacing="0" cellpadding="0" style="margin: 20px;">
            <tr>
                <td valign="top" class="box_fondo">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="15" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td width="130" class="box_fondo"></td>
                            <td width="770" class="box_borde_sup" ></td>
                            <td width="15" height="14" class="box_esquina_sup_der"></td>
                        </tr>
                        <tr>
                            <td class="box_fondo box_titulo" height="22"><h1>MIS VEH&Iacute;CULOS</h1></td>
                            <td class="box_fondo_contenido box_ordenamiento"><a href="<?php echo base_url(); ?>usuario/formulario_modificar_perfil">Editar perfil</a></td>
                            <td class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido limites">
                                <table border="0" cellspacing="0" cellpadding="0" class="info_perfil">
                                    <tr>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td align="left" width="830">
                                            <div id="descripcion">
                                            </div>
                                            <div  class="perfil">
                                                <a href="#" style="float: right;">
                                                    <img src="<?php
if ($usuario->imagen_thumb_url != NULL || $usuario->imagen_thumb_url != '') {
    echo base_url() . $usuario->imagen_thumb_url;
} else {
    echo base_url() . 'resources/images/usuarios/avatar.gif';
}
?>" width="89" height="100" alt="Foto usuario"/>
                                                </a>
                                                <div class="texto">
                                                    <h2><?php echo $usuario->nombres; ?> <?php echo $usuario->apellidos; ?></h2>
                                                    <h3><?php echo $usuario->usuario; ?></h3>
                                                    <h4><?php echo $usuario->email; ?></h4>
                                                    <h4><?php echo $usuario->lugar; ?></h4>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="indice secciones">
                                            <ul class="indice secciones">
                                                <li class="<?php if ($tab == 'vehiculos') { ?>tab-selected<?php } ?>">
                                                    <a href="" id="vehiculos-seleccionar">
                                                        <span id="vehiculos-seleccionar-span" class="tabs-span">Mis Veh&iacute;culos (<?php echo sizeof($vehiculos); ?>)</span>
                                                    </a>
                                                </li>
                                                <li class="<?php if ($tab == 'ofertas') { ?>tab-selected<?php } ?>">
                                                    <a href="" id="ofertas-seleccionar">
                                                        <span id="ofertas-seleccionar-span" class="tabs-span">Ofertas
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="<?php if ($tab == 'preguntas') { ?>tab-selected<?php } ?>">
                                                    <a href="" id="preguntas-seleccionar">
                                                        <span id="preguntas-seleccionar-span" class="tabs-span">Preguntas (<?php echo sizeof($preguntas); ?>)
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="<?php if ($tab == 'respuestas') { ?>tab-selected<?php } ?>">
                                                    <a href="" id="respuestas-seleccionar">
                                                        <span id="respuestas-seleccionar-span" class="tabs-span">Respuestas (<?php echo sizeof($respuestas); ?>)
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="<?php if ($tab == 'comentarios') { ?>tab-selected<?php } ?>">
                                                    <a href="" id="comentarios-seleccionar">
                                                        <span id="comentarios-seleccionar-span" class="tabs-span">Comentarios (<?php echo sizeof($comentarios_noticias) + sizeof($comentarios_tips) + sizeof($comentarios_tutoriales); ?>)
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="ultimo <?php if ($tab == 'carritos-compras') { ?>tab-selected<?php } ?>">
                                                    <a href="" id="carritos-compras-seleccionar">
                                                        <span id="carritos-compras-seleccionar-span" class="tabs-span ">Mis compras (<?php echo sizeof($carritos_compras); ?>)
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                </table>
                                
                                <table id="preguntas" class="tabs" <?php if ($tab != 'preguntas') { ?>style="display: none"<?php } ?> width="830" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="2" style="padding-top:5px;padding-bottom:10px;" align="left">
                                            <!--h2>Estas son las preguntas que has hecho en el taller en l&iacute;nea...</h2-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td width="15">&nbsp;</td>
                                    </tr>
                                    <?php
                                    $numero_pregunta = 0;
                                    if (sizeof($preguntas) != 0) {
                                        foreach ($preguntas as $pregunta) {
                                            ?>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td class="general_link<?php if ($numero_pregunta % 2 == 0) { ?> box_fondo<?php } ?>" align="left" style="padding-left:10px;padding-top:5px;">
                                                    <h3>
                                                        <a href="<?php echo base_url(); ?>taller_en_linea/ver_pregunta/<?php echo $pregunta->id_pregunta; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($pregunta->titulo_pregunta)); ?>"><?php echo $pregunta->titulo_pregunta; ?></a>
                                                    </h3>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td class="general_link<?php if ($numero_pregunta % 2 == 0) { ?> box_fondo<?php } ?>" align="left" style="padding-left:10px;">
                                                    <h4><?php echo character_limiter($pregunta->cuerpo_pregunta, 150); ?> <a href="<?php echo base_url(); ?>taller_en_linea/ver_pregunta/<?php echo $pregunta->id_pregunta; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($pregunta->titulo_pregunta)); ?>">Ver más</a>
                                                    </h4>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td class="general_link<?php if ($numero_pregunta % 2 == 0) { ?> box_fondo<?php } ?>" align="right" style="padding-bottom:5px;padding-top:5px;padding-right:10px;">
                                                    <h4>Categoría: <a href="<?php echo base_url(); ?>taller_en_linea/ver_preguntas/<?php echo str_replace(' ', '-', convert_accented_characters($pregunta->pregunta_categoria)); ?>/recientes/10/0"><?php echo $pregunta->pregunta_categoria; ?></a> | Publicado hace <?php echo relative_time($pregunta->fecha); ?> | Respuestas: <?php echo $pregunta->numero_respuestas; ?></h4>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td class="general_separador_transparente"></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <?php
                                            $numero_pregunta++;
                                        }
                                    }
                                    ?>
                                </table>
                                <table id="respuestas" class="tabs" <?php if ($tab != 'respuestas') { ?>style="display: none"<?php } ?> width="830" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" style="padding-top:5px;padding-bottom:10px;" align="left">
                                            <!--h2>Estas son las preguntas que has respondido en el taller en l&iacute;nea.</h2-->
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="11">&nbsp;</td>
                                        <td width="83">&nbsp;</td>
                                        <td width="465">&nbsp;</td>
                                        <td width="16">&nbsp;</td>
                                    </tr>
                                    <?php
                                    $numero_respuesta = 0;
                                    if (sizeof($respuestas) != 0) {
                                        foreach ($respuestas as $respuesta) {
                                            ?>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td rowspan="3"  align="left" valign="middle" class="general_link<?php if ($numero_respuesta % 2 == 0) { ?> box_fondo<?php } ?>" style="padding:10px;">
                                                    <img src="<?php
                                            if ($respuesta->imagen_thumb_url != NULL || $respuesta->imagen_thumb_url != '') {
                                                echo base_url() . $respuesta->imagen_thumb_url;
                                            } else {
                                                echo base_url() . 'resources/images/usuarios/avatar_thumb.gif';
                                            }
                                            ?>" width="63" height="70" alt="Foto usuario" />
                                                </td>
                                                <td align="left" class="general_link<?php if ($numero_respuesta % 2 == 0) { ?> box_fondo<?php } ?>" style="padding-left:5px;padding-top:10px;padding-right:10px;">
                                                    <h4>
                                                        <a href="<?php echo base_url(); ?>taller_en_linea/ver_pregunta/<?php echo $respuesta->id_pregunta; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($respuesta->titulo_pregunta)); ?>"><?php echo $respuesta->titulo_pregunta; ?></a>
                                                    </h4>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td align="left" class="general_link<?php if ($numero_respuesta % 2 == 0) { ?> box_fondo<?php } ?>" style="padding-left:5px;padding-right:5px;">
                                                    <h4><?php echo character_limiter($respuesta->cuerpo_pregunta, 150); ?> <a href="<?php echo base_url(); ?>taller_en_linea/ver_pregunta/<?php echo $respuesta->id_pregunta; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($respuesta->titulo_pregunta)); ?>">Ver más</a>
                                                    </h4>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td align="right" valign="middle" class="general_link<?php if ($numero_respuesta % 2 == 0) { ?> box_fondo<?php } ?>" style="padding-bottom:5px;padding-top:5px;padding-right:10px;">
                                                    <h4>Categoría: <a href="<?php echo base_url(); ?>taller_en_linea/ver_preguntas/<?php echo str_replace(' ', '-', convert_accented_characters($respuesta->pregunta_categoria)); ?>/recientes/10/0"><?php echo $respuesta->pregunta_categoria; ?></a> | Publicado hace <?php echo relative_time($respuesta->fecha); ?> | Respuestas: <?php echo $respuesta->numero_respuestas; ?></h4>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td class="general_separador_transparente"></td>
                                                <td colspan="2"></td>
                                                <td></td>
                                            </tr>
                                            <?php
                                            $numero_respuesta++;
                                        }
                                    }
                                    ?>
                                </table>

                                <table id="comentarios" class="tabs" <?php if ($tab != 'comentarios') { ?>style="display: none"<?php } ?> width="830" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" style="padding-top:5px;padding-bottom:10px;" align="left">
                                            <!--h2>Estos son las noticias, tips y tutoriales en los que ud ha comentado.</h2></td-->
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="15">&nbsp;</td>
                                        <td width="85">&nbsp;</td>
                                        <td width="835">&nbsp;</td>
                                        <td width="15">&nbsp;</td>
                                    </tr>
                                    <?php
                                    $numero_comentario = 0;
                                    if (sizeof($comentarios_noticias) != 0) {
                                        foreach ($comentarios_noticias as $comentario_noticia) {
                                            ?>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td rowspan="3"  align="left" valign="middle" class="general_link<?php if ($numero_comentario % 2 == 0) { ?> box_fondo<?php } ?>" style="padding:10px;">
                                                    <img src="<?php
                                            if ($comentario_noticia->imagen_thumb_url == "" || $comentario_noticia->imagen_thumb_url == NULL) {
                                                echo base_url() . 'resources/images/establecimientos/tmpl_logo_establecimiento_thumb_nd_2.gif';
                                            } else {
                                                echo base_url() . $comentario_noticia->imagen_thumb_url;
                                            }
                                            ?>" width="99" height="56" alt="<?php echo $comentario_noticia->titulo; ?>" />
                                                </td>
                                                <td align="left" class="general_link <?php if ($numero_comentario % 2 == 0) { ?> box_fondo<?php } ?>" style="padding-left:5px;padding-top:10px;padding-right:10px;">
                                                    <h4>
                                                        <a href="<?php echo base_url(); ?>aprende/noticia/<?php echo $comentario_noticia->id_noticia; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($comentario_noticia->titulo)); ?>"><?php echo $comentario_noticia->titulo; ?></a>
                                                    </h4>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td align="left" class="general_link <?php if ($numero_comentario % 2 == 0) { ?> box_fondo<?php } ?>" style="padding-left:5px;padding-right:5px;">
                                                    <h4><?php echo character_limiter($comentario_noticia->noticia, 150); ?> <a href="<?php echo base_url(); ?>aprende/noticia/<?php echo $comentario_noticia->id_noticia; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($comentario_noticia->titulo)); ?>">Ver más</a>
                                                    </h4>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td align="right" valign="middle" class="general_link <?php if ($numero_comentario % 2 == 0) { ?> box_fondo<?php } ?>" style="padding-bottom:5px;padding-top:5px;padding-right:10px;">
                                                    <h4>Categoría: <a href="<?php echo base_url(); ?>aprende/noticias">Noticias</a> | Publicado <?php echo real_date($comentario_noticia->fecha); ?>
                                                    </h4>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td class="general_separador_transparente"></td>
                                                <td colspan="2"></td>
                                                <td></td>
                                            </tr>
                                            <?php
                                            $numero_comentario++;
                                        }
                                    }
                                    if (sizeof($comentarios_tips) != 0) {
                                        foreach ($comentarios_tips as $comentario_tip) {
                                            ?>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td rowspan="3"  align="left" valign="middle" class="general_link<?php if ($numero_comentario % 2 == 0) { ?> box_fondo<?php } ?>" style="padding:10px;">
                                                    <img src="<?php
                                            if ($comentario_tip->imagen_thumb_url == "" || $comentario_tip->imagen_thumb_url == NULL) {
                                                echo base_url() . 'resources/images/establecimientos/tmpl_logo_establecimiento_thumb_nd_2.gif';
                                            } else {
                                                echo base_url() . $comentario_tip->imagen_thumb_url;
                                            }
                                            ?>" width="99" height="56" alt="<?php echo $comentario_tip->titulo; ?>" />
                                                </td>
                                                <td align="left" class="general_link <?php if ($numero_comentario % 2 == 0) { ?> box_fondo<?php } ?>" style="padding-left:5px;padding-top:10px;padding-right:10px;">
                                                    <h4>
                                                        <a href="<?php echo base_url(); ?>aprende/tip/<?php echo $comentario_tip->id_tip; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($comentario_tip->titulo)); ?>"><?php echo $comentario_tip->titulo; ?></a>
                                                    </h4>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td align="left" class="general_link <?php if ($numero_comentario % 2 == 0) { ?> box_fondo<?php } ?>" style="padding-left:5px;padding-right:5px;">
                                                    <h4><?php echo character_limiter($comentario_tip->tip, 150); ?> <a href="<?php echo base_url(); ?>aprende/tip/<?php echo $comentario_tip->id_tip; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($comentario_tip->titulo)); ?>">Ver más</a></h4>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td align="right" valign="middle" class="general_link <?php if ($numero_comentario % 2 == 0) { ?> box_fondo<?php } ?>" style="padding-bottom:5px;padding-top:5px;padding-right:10px;">
                                                    <h4>Categoría: <a href="<?php echo base_url(); ?>aprende/tips">Tips</a> | Publicado <?php echo real_date($comentario_tip->fecha); ?></h4>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td class="general_separador_transparente"></td>
                                                <td colspan="2"></td>
                                                <td></td>
                                            </tr>
        <?php
        $numero_comentario++;
    }
}

if (sizeof($comentarios_tutoriales) != 0) {
    foreach ($comentarios_tutoriales as $comentario_tutorial) {
        ?>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td rowspan="3"  align="left" valign="middle" class="general_link<?php if ($numero_comentario % 2 == 0) { ?> box_fondo<?php } ?>" style="padding:10px;">
                                                    <img src="<?php
                                                 if ($comentario_tutorial->imagen_thumb_url == "" || $comentario_tutorial->imagen_thumb_url == NULL) {
                                                     echo base_url() . 'resources/images/establecimientos/tmpl_logo_establecimiento_thumb_nd_2.gif';
                                                 } else {
                                                     echo base_url() . $comentario_tutorial->imagen_thumb_url;
                                                 }
                                                 ?>" width="99" height="56" alt="<?php echo $comentario_tutorial->titulo; ?>" />
                                                </td>
                                                <td align="left" class="general_link <?php if ($numero_comentario % 2 == 0) { ?> box_fondo<?php } ?>" style="padding-left:5px;padding-top:10px;padding-right:10px;">
                                                    <h4>
                                                        <a href="<?php echo base_url(); ?>aprende/tip/<?php echo $comentario_tutorial->id_tutorial; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($comentario_tutorial->titulo)); ?>"><?php echo $comentario_tutorial->titulo; ?></a>
                                                    </h4>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td align="left" class="general_link <?php if ($numero_comentario % 2 == 0) { ?> box_fondo<?php } ?>" style="padding-left:5px;padding-right:5px;">
                                                    <h4><?php echo character_limiter($comentario_tutorial->resumen, 150); ?> <a href="<?php echo base_url(); ?>aprende/tutorial/<?php echo $comentario_tutorial->id_tutorial; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($comentario_tutorial->titulo)); ?>">Ver más</a>
                                                    </h4>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td align="right" valign="middle" class="general_link <?php if ($numero_comentario % 2 == 0) { ?> box_fondo<?php } ?>" style="padding-bottom:5px;padding-top:5px;padding-right:10px;">
                                                    <h4>Categoría: <a href="<?php echo base_url(); ?>aprende/tutoriales">Tutoriales</a> | Publicado <?php echo real_date($comentario_tutorial->fecha); ?></h4>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td class="general_separador_transparente"></td>
                                                <td colspan="2"></td>
                                                <td></td>
                                            </tr>
        <?php
        $numero_comentario++;
    }
}
?>
                                </table>
                                <table id="carritos-compras" class="tabs" <?php if ($tab != 'carritos-compras') { ?>style="display: none"<?php } ?> width="830" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="4" style="padding-top:5px;padding-bottom:10px;" align="left">
                                            <!--h2>Estas son las compras que has hecho.</h2-->
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td width="15">&nbsp;</td>
                                        <td width="">&nbsp;</td>
                                        <td width="200">&nbsp;</td>
                                        <td width="540">&nbsp;</td>
                                        <td width="">&nbsp;</td>
                                        <td width="15">&nbsp;</td>
                                    </tr>
<?php
if (sizeof($carritos_compras) != 0) {
    foreach ($carritos_compras as $carrito_compra) {
        ?>
                                            <tr>
                                                <td class="titulo_fondo_izq">&nbsp;</td>
                                                <td colspan="4"  align="right" valign="middle" class="general_link titulo_fondo" >
                                                    <h3>Compra # <strong><?php echo $carrito_compra->id_carrito_compra; ?></strong></h3>
                                                </td>
                                                <td class="titulo_fondo_der">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td colspan="4"  align="left" valign="middle" class="general_link" style="padding-left:5px;padding-top:5px;">
                                                    <h3>
                                                        <span class="general_texto_secundario">
                                                            <strong>Estado: </strong>
                                                        </span><?php echo $carrito_compra->estado; ?>
                                                    </h3>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td colspan="4"  align="left" valign="middle" class="general_link" style="padding-left:5px;">
                                                    <h3>
                                                        <span class="general_texto_secundario">
                                                            <strong>Fecha:</strong>
                                                        </span> <?php echo strftime("%B %d de %Y", strtotime($carrito_compra->fecha)); ?>
                                                    </h3>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td colspan="4"  align="left" valign="middle" class="general_link" style="padding-left:5px;padding-bottom:5px;">
                                                    <h3><span class="general_texto_secundario"><strong>Total:</strong></span> $<?php echo number_format($carrito_compra->total, 0, ',', '.'); ?></h3>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>

        <?php
        $numero_carrito_compra_autoparte = 1;
        $show_banner = true;
        if (sizeof($carritos_compras_autopartes) != 0) {
            foreach ($carritos_compras_autopartes as $carrito_compra_autoparte) {
                if ($carrito_compra_autoparte->carrito == $carrito_compra->id_carrito_compra && strlen($carrito_compra_autoparte->nombre) > 0) {

                    if ($show_banner): $show_banner = false;
                        ?>

                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td  align="center" valign="middle" class="general_link box_fondo" style="padding:5px;">
                                                                    <h4>
                                                                        <strong>Cantidad</strong>
                                                                    </h4>
                                                                </td>
                                                                <td  align="center" valign="middle" class="general_link box_fondo" >
                                                                    <h4>
                                                                        <strong>Autoparte</strong>
                                                                    </h4>
                                                                </td>
                                                                <td align="center" valign="middle" class="general_link box_fondo" >
                                                                    <h4>
                                                                        <strong>Establecimiento</strong>
                                                                    </h4>
                                                                </td>
                                                                <td style="padding-right:10px;" align="right" valign="middle" class="general_link box_fondo" >
                                                                    <h4>
                                                                        <strong>Precio</strong>
                                                                    </h4>
                                                                </td>
                                                                <td>&nbsp;</td>
                                                            </tr>

                    <?php endif; ?>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td  align="center" valign="middle" class="general_link <?php if ($numero_carrito_compra_autoparte % 2 == 0) { ?>box_fondo<?php } ?>" >
                                                                <h4><?php echo $carrito_compra_autoparte->cantidad; ?></h4>
                                                            </td>
                                                            <td align="center" valign="middle" class="general_link <?php if ($numero_carrito_compra_autoparte % 2 == 0) { ?>box_fondo<?php } ?>" style="padding:5px;">
                                                                <h4><?php echo $carrito_compra_autoparte->nombre; ?></h4>
                                                            </td>
                                                            <td align="center" valign="middle" class="general_link <?php if ($numero_carrito_compra_autoparte % 2 == 0) { ?>box_fondo<?php } ?>" >
                                                                <h4>
                                                                    <a href="<?php echo base_url(); ?>establecimientos/ver_establecimiento/<?php echo $carrito_compra_autoparte->id_establecimiento; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($carrito_compra_autoparte->establecimiento)); ?>"><?php echo $carrito_compra_autoparte->establecimiento; ?></a>
                                                                </h4>
                                                            </td>
                                                            <td align="right" valign="middle" class="general_link <?php if ($numero_carrito_compra_autoparte % 2 == 0) { ?>box_fondo<?php } ?>" style="padding-right:10px;">
                                                                <h4>$<?php echo ($carrito_compra_autoparte->total * $carrito_compra_autoparte->cantidad); ?></h4>
                                                            </td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <?php
                                                        $numero_carrito_compra_autoparte++;
                                                    }else if($carrito_compra_autoparte->carrito == $carrito_compra->id_carrito_compra && strlen($carrito_compra_autoparte->nombre) == 0){
                                                        ?>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td  align="center" valign="middle" class="general_link box_fondo" style="padding:5px;">
                                                                    <h4>
                                                                        <strong>Cantidad</strong>
                                                                    </h4>
                                                                </td>
                                                                <td  align="center" valign="middle" class="general_link box_fondo" >
                                                                    <h4>
                                                                        <strong>Oferta</strong>
                                                                    </h4>
                                                                </td>
                                                                <td align="center" valign="middle" class="general_link box_fondo" >
                                                                    <h4>
                                                                        <strong>Establecimiento</strong>
                                                                    </h4>
                                                                </td>
                                                                <td style="padding-right:10px;" align="right" valign="middle" class="general_link box_fondo" >
                                                                    <h4>
                                                                        <strong>Precio</strong>
                                                                    </h4>
                                                                </td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                            
                                                            <tr>
                                                            <td>&nbsp;</td>
                                                            <td  align="center" valign="middle" class="general_link <?php if ($numero_carrito_compra_autoparte % 2 == 0) { ?>box_fondo<?php } ?>" >
                                                                <h4>1</h4>
                                                            </td>
                                                            <td align="left" valign="middle" class="general_link <?php if ($numero_carrito_compra_autoparte % 2 == 0) { ?>box_fondo<?php } ?>" style="padding:5px; padding-left: 20px; text-align: justify;">
                                                                <h4><?php echo $carrito_compra_autoparte->titulo; ?></h4>
                                                            </td>
                                                            <td align="center" valign="middle" class="general_link <?php if ($numero_carrito_compra_autoparte % 2 == 0) { ?>box_fondo<?php } ?>" >
                                                                <h4>
                                                                    <a href="<?php echo base_url(); ?>establecimientos/ver_establecimiento/<?php echo $carrito_compra_autoparte->IDestablecimientoOferta; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($carrito_compra_autoparte->establecimiento2)); ?>"><?php echo $carrito_compra_autoparte->establecimiento2; ?></a>
                                                                </h4>
                                                            </td>
                                                            <td align="right" valign="middle" class="general_link <?php if ($numero_carrito_compra_autoparte % 2 == 0) { ?>box_fondo<?php } ?>" style="padding-right:10px;">
                                                                <h4>$<?php echo number_format($carrito_compra_autoparte->precioOferta, 0, ',', '.'); ?></h4>
                                                            </td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        
                                                        <?php $numero_carrito_compra_autoparte++;
                                                    }
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td class="general_separador_transparente"></td>
                                                <td colspan="4"></td>
                                                <td></td>
                                            </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                </table>
                                <table id="vehiculos" class="tabs" <?php if ($tab != 'vehiculos') { ?>style="display: none"<?php } ?> border="0" width="830" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td>
                                            <ul class="indice vehiculos">
                                                <?php
                                                $i = 0;
                                                foreach ($vehiculos as $vehiculo):
                                                    ?>
                                                    <li>
                                                        <a id="vehiculo_<?php echo $i; ?>" href="javascript:actualizarTimeline(<?php echo $i; ?>, <?php echo $vehiculo->id_usuario_vehiculo; ?>)">
                                                            <h4>Veh&iacute;culo <?php echo $i + 1; ?></h4>
                                                        </a>
                                                    </li>
    <?php
    $i++;
endforeach;
?>
                                                <li class="ultimo">
                                                    <h4>
                                                        <a href="<?php echo base_url(); ?>usuario/formulario_agregar_vehiculo">+</a>
                                                    </h4>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
<?php
$var = 0;
$numero_vehiculos = 0;
if (sizeof($vehiculos) != 0) {
    foreach ($vehiculos as $vehiculo) {
        ?>
                                                    <table id="info-vehiculo-<?php echo $numero_vehiculos; ?>" class="info-vehiculo-general">
                                                        <tr>
                                                            <td>
                                                                <div id="info-vehiculo">
                                                                    <div class="imagen">
                                                                        <img src="<?php
                                                                     if ($vehiculo->imagen_thumb_url != NULL || $vehiculo->imagen_thumb_url != '') {
                                                                         echo base_url() . $vehiculo->imagen_thumb_url;
                                                                     } else {
                                                                         echo base_url() . 'resources/images/micuenta/tmpl_img_micuenta_vehiculo_nd.gif';
                                                                     }
                                                                     ?>" width="150" height="150" alt="Foto veh&iacute;culo" valign="top" />
                                                                        <h4 class="general_link">
                                                                            <a href="<?php echo base_url(); ?>usuario/formulario_modificar_vehiculo/<?php echo $vehiculo->id_usuario_vehiculo; ?>">Editar</a> - <a href="<?php echo base_url(); ?>usuario/eliminar_vehiculo/<?php echo $vehiculo->id_usuario_vehiculo; ?>" onclick="return confirm('¿Está seguro de eliminar este vehículo? Recuerde que esta acción no se puede deshacer.');">Eliminar</a>
                                                                        </h4>
                                                                    </div>
                                                                    <input type="hidden" id="id_vehiculo_<?php echo $numero_vehiculos; ?>" value="<?php echo $vehiculo->id_usuario_vehiculo; ?>" />

                                                                    <table>
                                                                        <tr>
                                                                            <td align="left" class="general_link" width="110">
                                                                                <h4>
                                                                                    <span class="general_texto_secundario">
                                                                                        <strong>Marca:</strong>
                                                                                    </span>
                                                                                </h4>
                                                                            </td>
                                                                            <td width="150">
                                                                                <h4><?php echo $vehiculo->marca; ?></h4>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="left" class="general_link">
                                                                                <h4>
                                                                                    <span class="general_texto_secundario">
                                                                                        <strong>L&iacute;nea:</strong>
                                                                                    </span>
                                                                                </h4>
                                                                            </td>
                                                                            <td>
                                                                                <h4><?php echo $vehiculo->linea; ?></h4>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="left" class="general_link">
                                                                                <h4>
                                                                                    <span class="general_texto_secundario">
                                                                                        <strong>Modelo: </strong>
                                                                                    </span>
                                                                                </h4>
                                                                            </td>
                                                                            <td>
                                                                                <h4><?php echo $vehiculo->modelo; ?></h4>
                                                                            </td>
                                                                            <td>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="left" class="general_link">
                                                                                <h4>
                                                                                    <span class="general_texto_secundario">
                                                                                        <strong>Kilometraje: </strong>
                                                                                    </span>
                                                                                </h4>
                                                                            </td>
                                                                            <td>
                                                                                <h4>
                                                                                    <input type="text" id="kilometraje_vehiculo_<?php echo $numero_vehiculos; ?>" name="kilometraje_vehiculo_<?php echo $vehiculo->id_usuario_vehiculo; ?>" value="<?php echo $vehiculo->kilometraje; ?>" size="7" class="texto_kilometraje general_cuadro_texto"/>  Kms.
                                                                                </h4>
                                                                            </td>
                                                                            <td>
                                                                                <div id="tooltip_kilometraje_<?php echo $numero_vehiculos; ?>" class="tooltip-kilometraje">
                                                                                    <p style="margin: 0;">&Eacute;sta informaci&oacute;n es aproximada, si desea poner los datos ex&aacute;ctos haga sobre el recuadro y escriba el Kilometraje exacto.</p>
                                                                                    <p style="margin: 0; display: none;">El kilometraje se ha modificado…</p>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td align="left" class="general_link">
                                                                                <h4>
                                                                                    <span class="general_texto_secundario">
                                                                                        <strong>Placa: </strong>
                                                                                    </span>
                                                                                </h4>
                                                                            </td>
                                                                            <td>
                                                                                <h4>
                                                                                    <input type="text" id="placa_vehiculo_<?php echo $numero_vehiculos; ?>" name="placa_vehiculo_<?php echo $vehiculo->id_usuario_vehiculo; ?>" value="<?php echo $vehiculo->numero_placa; ?>" size="7" class="texto_placa general_cuadro_texto"/>
                                                                                </h4>
                                                                            </td>
                                                                            <td valign="bottom">
                                                                                <div id="tooltip_placa_<?php echo $numero_vehiculos; ?>" class="tooltip-placa">
                                                                                    
                                                                                    <p style="margin: 0; display: none;">La placa se ha modificado…</p>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </td>

                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="ultimo-actualizacion">
                                                                    &Uacute;ltima Actualizaci&oacute;n: <?php echo real_date($vehiculo->fecha); ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" align="left" valign="middle" class="general_link">



                                                                <div id="loading-vehiculo_<?php echo $numero_vehiculos; ?>">
                                                                    <img src="../../../resources/images/iconos/loading_icon_1.gif" alt="cargando" width="" height="" />
                                                                </div>
                                                                <div id="timeline_<?php echo $numero_vehiculos; ?>" class="timeline">

                                                                    <div class="texto_general " id="timeline_content">
        <?php if ($this->session->userdata('esta_registrado')) { ?>
                                                                                            <?php } else { ?>
                                                                                <a id="registro-carrito-compras-id" href="#registro-carrito-compras" title="Registro o Inicio de Sesión" class="carrito_compras_btn_comprar" title="Comprar"><span>Comprar</span></a>
                                                                                                <?php } ?>
                                                                            <div class="boton_tareas_realizar"></div>
                                                                            <div id="no_made_task ">
                                                                                <div class="titulo_categoria">Cosas que debes hacer</div>
                                                                                <div class="categoria_tarea_realizar">
                                                                                    <div class ="wrapper_tarea_realizar hide_wrapper_tarea">
        <?php
        $tareas_vehiculo = $tareas[$vehiculo->id_vehiculo];
        foreach ($tareas_vehiculo as $tarea): if ($tarea->prioridad == 1 && $tarea->realizado == false):
                ?>

                                                                                                <div class="tarea_realizar">
                                                                                                    <?php if ($tarea->id_servicio != 10 && $tarea->id_servicio != 9): ?> 
                                                                                                    <div class="imagen_tarea"><img width="60px" src="<?php echo base_url().$tarea->imagen_thumb_url; ?>" /> </div>
                                                                                                        <div class="checkbox_tarea_realizar"><?php $checkbox = array("name" => 'checkbox[]', "value" => $vehiculo->id_usuario_vehiculo . "-" . $tarea->id_servicio);
                                                                                    echo form_checkbox($checkbox);
                                                                                    ?><br/>Ya lo hice</div> 
                <?php endif; ?>
                                                                                                    <div class="progress-bar"><span class ="porcentaje_progreso"><?php echo $tarea->barra_progreso; ?></span>
                                                                                                        <div class ="fecha_porcentaje_progreso"><span class ="mensaje"><?php echo $tarea->mensaje_dias_restantes; ?></span><span class ="numero"><?php echo $tarea->dias_restantes; ?></span><span> <?php echo $tarea->mensaje_dias_restantes2; ?></span></div>
                                                                                                    </div>
                                                                                                    <div class="nommbre_tarea_realizar"><?php echo $tarea->nombre; ?></div>
                                                                                                    <div class="url_tarea_realizar"><a TARGET="_blank" href="<?php echo base_url() . 'establecimientos'; ?>">Ver sitios donde se presta este servicio</a></div>
                                                                                                    <div class="nombre_tarea_realizar"><?php echo $tarea->descripcion; ?></div>
                                                                                                </div> 
                                                                                        <?php $key = $vehiculo->id_vehiculo . "_" . $tarea->id_servicio; if( sizeof($ofertas[$key]) >= 1){ ?><div class="titulo_promo_categoria">* Para hacer este mantenimiento, te pueden interesar las siguientes ofertas</div><?php }?>

                                                                                                <div class="oferta_tarea">
                <?php   foreach ($ofertas[$key] as $oferta): ?>
                                                                                                        <form class="forma_pagosonline" id="forma_pagosonline" method="post" action="<?php echo $urlPagosOnline ?>" target="_self">
                                                                                                            <input name="id_oferta" class="id_oferta" type="hidden" value="<?php echo $oferta->id_oferta ?>" >
                                                                                                            <input name="emailComprador" class="emailComprador" id="emailComprador" type="hidden" value="<?php echo $emailComprador ?>">
                                                                                                            <input name="prueba" class="prueba" id="prueba" type="hidden" value="<?php echo $prueba ?>">
                                                                                                            <input name="url_respuesta" class="url_respuesta" id="url_respuesta" type="hidden" value="<?php echo $url_respuesta ?>">
                                                                                                            <input name="url_confirmacion" class="url_confirmacion" id="url_confirmacion" type="hidden" value="<?php echo $url_confirmacion ?>">
                                                                                                            <input name="extra1" class="extra1" id="extra1" type="hidden" value="<?php echo $extra1; ?>">

                                                                                                            <div class="contenido_oferta">
                                                                                                                <div class="titulo ">
                                                                                                                    <div style="float: left; width: 80%;" ><strong><?php echo $oferta->titulo; ?></strong></div>
                                                                                                                    <div style="color: white; margin-top: 15px; padding-top: 5px; padding-left: 25px; float: right; height: 33px; width: 110px; background-image: url('../resources/images/autopartes/etiqueta_precio.png'); background-repeat: no-repeat; " >
                                                                                                                        $<?php echo number_format($oferta->precio, 0, ',', '.'); ?>
                                                                                                                    </div>
                                                                                                                    <div class="clear"></div>
                                                                                                                </div>

                                                                                                                <div class="oferta">
                                                                                                                    <div class="descripcion">
                                                                                                                        <div><strong>Precio:</strong> $<?php echo number_format($oferta->precio, 0, ',', '.'); ?></div>
                                                                                                                        <div><strong>Fecha de Vigencia:</strong> <?php echo strftime("%B %d de %Y", strtotime($oferta->vigencia)); ?></div>
                                                                                                                        <div><strong>Descripcion:</strong> <br/><?php echo $oferta->descripcion; ?></div>
                                                                                                                        <div><strong>Condiciones:</strong> <br/><?php echo $oferta->condiciones; ?></div>
                                                                                                                        <div><strong>Incluye:</strong> <br/><?php echo $oferta->incluye; ?></div>
                                                                                                                        <div><strong>Taller:</strong> <br/><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                    echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"><?php echo $oferta->establecimientoNombre; ?></a> - <?php echo $oferta->direccion; ?></div>
                                                                                                                        <div style="padding-left: 10px;"><?php echo $oferta->establecimientoDescripcion; ?></div>
                                                                                                                        <div class="calificacion_taller" style="padding-top: 10px;">Calificación del taller: <span><?php echo round($oferta->calificacion); ?></span></div>
                                                                                                                        <div class="progress_bar">
                                                                                                                            <div class="progress_level"></div>
                                                                                                                        </div>
                                                                                                                        <div><?php echo $oferta->num_comentarios; ?> Usuarios han calificado este taller.</div>
                                                                                                                        <div><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                                                                echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"> Ver comentarios...</a></div>
                                                                                                                    </div>

                                                                                                                    <div class="logo_establecimiento"><img src="<?php echo base_url() . $oferta->logo; ?>"/></div>
                                                                                                                    <div class ="boton_pago_servicios">
                                                                                                                        <input name="oferta_<?php echo $oferta->id_oferta; ?>" type="button" class="carrito_compras_btn_comprar" title="Comprar" >
                                                                                                                        <img width="200px" src="<?php echo base_url().'resources/images/iconos/pol.png'; ?>" alt="respaldo-pagos-online"/>
                                                                                                                    </div>

                                                                                                                    <div class="clear"></div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </form>

                                                                                            <?php endforeach; ?>
                                                                                                </div>
                                                                                        <?php endif;
                                                                                    endforeach;
                                                                                    ?>
                                                                                    </div>

                                                                                </div>
                                                                            </div>

                                                                            <div id="no_made_task_option">
                                                                                <div class="titulo_categoria ">Cosas de deberías hacer</div>
                                                                                <div class="categoria_tarea_realizar">



                                                                                            <?php
                                                                                            $temp_aceite = true;
                                                                                            $temp_embellecimiento = true;
                                                                                            $temp_frenos = true;
                                                                                            $temp_legales = true;
                                                                                            $temp_kit_carretera = true;
                                                                                            $temp_llantas = true;
                                                                                            $temp_niveles = true;
                                                                                            $temp_sincronizacion = true;
                                                                                            $temp_suspension = true;
                                                                                            $temp_otros = true;
                                                                                            $tareas_vehiculo = $tareas[$vehiculo->id_vehiculo];
                                                                                            foreach ($tareas_vehiculo as $tarea):

                                                                                                if ($tarea->prioridad == 2 && $tarea->realizado == false && $tarea->categoria == 'Cambio de aceite'):
                                                                                                    ?>
                <?php if ($temp_aceite): $temp_aceite = false; ?> <div class="titulo_categoria">Cambio de aceite</div><?php endif; ?>

                                                                                            <div class="tarea_realizar hide_wrapper_tarea">
                                                                                                <div class="imagen_tarea"><img width="60px" src="<?php echo base_url().$tarea->imagen_thumb_url; ?>" /> </div>
                                                                                                <div class="checkbox_tarea_realizar"><?php $checkbox = array("name" => 'checkbox[]', "value" => $vehiculo->id_usuario_vehiculo . "-" . $tarea->id_servicio);
                echo form_checkbox($checkbox);
                ?><br/>Ya lo hice</div>
                                                                                                <div class="progress-bar"><span class ="porcentaje_progreso"><?php echo $tarea->barra_progreso; ?></span>
                                                                                                    <div class ="fecha_porcentaje_progreso"><span class ="mensaje"><?php echo $tarea->mensaje_dias_restantes; ?></span><span class ="numero"><?php echo $tarea->dias_restantes; ?></span><span> <?php $tarea->mensaje_dias_restantes2; ?></span></div>
                                                                                                </div>
                                                                                                <div class="nommbre_tarea_realizar"><?php echo $tarea->nombre; ?></div>
                                                                                                <div class="url_tarea_realizar"><a TARGET="_blank" href="<?php echo base_url() . 'establecimientos'; ?>">Ver sitios donde se presta este servicio</a></div>
                                                                                                <div class="nombre_tarea_realizar"><?php echo $tarea->descripcion; ?></div>
                                                                                            </div>
                                                                                            <?php $key = $vehiculo->id_vehiculo . "_" . $tarea->id_servicio; if( sizeof($ofertas[$key]) >= 1){ ?><div class="titulo_promo_categoria">* Para hacer este mantenimiento, te pueden interesar las siguientes ofertas</div><?php }?>
                                                                                            <div class="oferta_tarea">
                <?php foreach ($ofertas[$key] as $oferta): ?>
                                                                                                    <form class="forma_pagosonline" id="forma_pagosonline" method="post" action="<?php echo $urlPagosOnline ?>" target="_self">
                                                                                                        <input name="id_oferta" class="id_oferta" type="hidden" value="<?php echo $oferta->id_oferta ?>" >
                                                                                                        <input name="emailComprador" class="emailComprador" id="emailComprador" type="hidden" value="<?php echo $emailComprador ?>">
                                                                                                        <input name="prueba" class="prueba" id="prueba" type="hidden" value="<?php echo $prueba ?>">
                                                                                                        <input name="url_respuesta" class="url_respuesta" id="url_respuesta" type="hidden" value="<?php echo $url_respuesta ?>">
                                                                                                        <input name="url_confirmacion" class="url_confirmacion" id="url_confirmacion" type="hidden" value="<?php echo $url_confirmacion ?>">
                                                                                                        <input name="extra1" class="extra1" id="extra1" type="hidden" value="<?php echo $extra1; ?>">

                                                                                                        <div class="contenido_oferta">
                                                                                                            <div class="titulo ">
                                                                                                                    <div style="float: left; width: 80%;" ><strong><?php echo $oferta->titulo; ?></strong></div>
                                                                                                                    <div style="color: white; margin-top: 15px; padding-top: 5px; padding-left: 25px; float: right; height: 33px; width: 110px; background-image: url('../resources/images/autopartes/etiqueta_precio.png'); background-repeat: no-repeat; " >
                                                                                                                        $<?php echo number_format($oferta->precio, 0, ',', '.'); ?>
                                                                                                                    </div>
                                                                                                                    <div class="clear"></div>
                                                                                                                </div>

                                                                                                            <div class="oferta">
                                                                                                                <div class="descripcion">
                                                                                                                    <div><strong>Precio:</strong> $<?php echo number_format($oferta->precio, 0, ',', '.'); ?></div>
                                                                                                                    <div><strong>Fecha de Vigencia:</strong> <?php echo strftime("%B %d de %Y", strtotime($oferta->vigencia)); ?></div>
                                                                                                                    <div><strong>Descripcion:</strong> <br/><?php echo $oferta->descripcion; ?></div>
                                                                                                                    <div><strong>Condiciones:</strong> <br/><?php echo $oferta->condiciones; ?></div>
                                                                                                                    <div><strong>Incluye:</strong> <br/><?php echo $oferta->incluye; ?></div>
                                                                                                                    <div><strong>Taller:</strong> <br/><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                                                                echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"><?php echo $oferta->establecimientoNombre; ?></a> - <?php echo $oferta->direccion; ?></div>
                                                                                                                    <div style="padding-left: 10px;"><?php echo $oferta->establecimientoDescripcion; ?></div>
                                                                                                                    <div class="calificacion_taller" style="padding-top: 10px;">Calificación del taller: <span><?php echo round($oferta->calificacion); ?></span></div>
                                                                                                                    <div class="progress_bar">
                                                                                                                        <div class="progress_level"></div>
                                                                                                                    </div>
                                                                                                                    <div><?php echo $oferta->num_comentarios; ?> Usuarios han calificado este taller.</div>
                                                                                                                    <div><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                                                            echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"> Ver comentarios...</a></div>
                                                                                                                </div>

                                                                                                                <div class="logo_establecimiento"><img src="<?php echo base_url() . $oferta->logo; ?>"/></div>
                                                                                                                <div class ="boton_pago_servicios">
                                                                                                                    <input name="oferta_<?php echo $oferta->id_oferta; ?>" type="button" class="carrito_compras_btn_comprar" title="Comprar" >
                                                                                                                    <img width="200px" src="<?php echo base_url().'resources/images/iconos/pol.png'; ?>" alt="respaldo-pagos-online"/>
                                                                                                                </div>

                                                                                                                <div class="clear"></div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </form>

                <?php endforeach; ?>
                                                                                            </div>



                <?php elseif ($tarea->prioridad == 2 && $tarea->realizado == false && $tarea->categoria == 'Embellecimiento'):
                ?>
                <?php if ($temp_embellecimiento): $temp_embellecimiento = false; ?>  <div class="titulo_categoria">Embellecimiento</div><?php endif; ?>
                                                                                            <div class="tarea_realizar hide_wrapper_tarea">
                                                                                                <div class="imagen_tarea"><img width="60px" src="<?php echo base_url().$tarea->imagen_thumb_url; ?>" /> </div>
                                                                                                <div class="checkbox_tarea_realizar"><?php $checkbox = array("name" => 'checkbox[]', "value" => $vehiculo->id_usuario_vehiculo . "-" . $tarea->id_servicio);
                echo form_checkbox($checkbox);
                ?><br/>Ya lo hice</div>
                                                                                                <div class="progress-bar"><span class ="porcentaje_progreso"><?php echo $tarea->barra_progreso; ?></span>
                                                                                                    <div class ="fecha_porcentaje_progreso"><span class ="mensaje"><?php echo $tarea->mensaje_dias_restantes; ?></span><span class ="numero"><?php echo $tarea->dias_restantes; ?></span><span> <?php echo $tarea->mensaje_dias_restantes2; ?></span></div>
                                                                                                </div>
                                                                                                <div class="nommbre_tarea_realizar"><?php echo $tarea->nombre; ?></div>
                                                                                                <div class="url_tarea_realizar"><a TARGET="_blank" href="<?php echo base_url() . 'establecimientos'; ?>">Ver sitios donde se presta este servicio</a></div>
                                                                                                <div class="nombre_tarea_realizar"><?php echo $tarea->descripcion; ?></div>

                                                                                            </div>
                                                                                            <?php $key = $vehiculo->id_vehiculo . "_" . $tarea->id_servicio; if( sizeof($ofertas[$key]) >= 1){ ?><div class="titulo_promo_categoria">* Para hacer este mantenimiento, te pueden interesar las siguientes ofertas</div><?php }?>
                                                                                            <div class="oferta_tarea">
                <?php   foreach ($ofertas[$key] as $oferta): ?>
                                                                                                    <form class="forma_pagosonline" id="forma_pagosonline" method="post" action="<?php echo $urlPagosOnline ?>" target="_self">
                                                                                                        <input name="id_oferta" class="id_oferta" type="hidden" value="<?php echo $oferta->id_oferta ?>" >
                                                                                                        <input name="emailComprador" class="emailComprador" id="emailComprador" type="hidden" value="<?php echo $emailComprador ?>">
                                                                                                        <input name="prueba" class="prueba" id="prueba" type="hidden" value="<?php echo $prueba ?>">
                                                                                                        <input name="url_respuesta" class="url_respuesta" id="url_respuesta" type="hidden" value="<?php echo $url_respuesta ?>">
                                                                                                        <input name="url_confirmacion" class="url_confirmacion" id="url_confirmacion" type="hidden" value="<?php echo $url_confirmacion ?>">
                                                                                                        <input name="extra1" class="extra1" id="extra1" type="hidden" value="<?php echo $extra1; ?>">

                                                                                                        <div class="contenido_oferta">
                                                                                                            <div class="titulo ">
                                                                                                                    <div style="float: left; width: 80%;" ><strong><?php echo $oferta->titulo; ?></strong></div>
                                                                                                                    <div style="color: white; margin-top: 15px; padding-top: 5px; padding-left: 25px; float: right; height: 33px; width: 110px; background-image: url('../resources/images/autopartes/etiqueta_precio.png'); background-repeat: no-repeat; " >
                                                                                                                        $<?php echo number_format($oferta->precio, 0, ',', '.'); ?>
                                                                                                                    </div>
                                                                                                                    <div class="clear"></div>
                                                                                                                </div>

                                                                                                            <div class="oferta">
                                                                                                                <div class="descripcion">
                                                                                                                    <div><strong>Precio:</strong> $<?php echo number_format($oferta->precio, 0, ',', '.'); ?></div>
                                                                                                                    <div><strong>Fecha de Vigencia:</strong> <?php echo strftime("%B %d de %Y", strtotime($oferta->vigencia)); ?></div>
                                                                                                                    <div><strong>Descripcion:</strong> <br/><?php echo $oferta->descripcion; ?></div>
                                                                                                                    <div><strong>Condiciones:</strong> <br/><?php echo $oferta->condiciones; ?></div>
                                                                                                                    <div><strong>Incluye:</strong> <br/><?php echo $oferta->incluye; ?></div>
                                                                                                                    <div><strong>Taller:</strong> <br/><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                    echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"><?php echo $oferta->establecimientoNombre; ?></a> - <?php echo $oferta->direccion; ?></div>
                                                                                                                    <div style="padding-left: 10px;"><?php echo $oferta->establecimientoDescripcion; ?></div>
                                                                                                                    <div class="calificacion_taller" style="padding-top: 10px;">Calificación del taller: <span><?php echo round($oferta->calificacion); ?></span></div>
                                                                                                                    <div class="progress_bar">
                                                                                                                        <div class="progress_level"></div>
                                                                                                                    </div>
                                                                                                                    <div><?php echo $oferta->num_comentarios; ?> Usuarios han calificado este taller.</div>
                                                                                                                    <div><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                                                            echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"> Ver comentarios...</a></div>
                                                                                                                </div>

                                                                                                                <div class="logo_establecimiento"><img src="<?php echo base_url() . $oferta->logo; ?>"/></div>
                                                                                                                <div class ="boton_pago_servicios">
                                                                                                                    <input name="oferta_<?php echo $oferta->id_oferta; ?>" type="button" class="carrito_compras_btn_comprar" title="Comprar" >
                                                                                                                    <img width="200px" src="<?php echo base_url().'resources/images/iconos/pol.png'; ?>" alt="respaldo-pagos-online"/>
                                                                                                                </div>

                                                                                                                <div class="clear"></div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </form>

                <?php endforeach; ?>
                                                                                            </div>




            <?php elseif ($tarea->prioridad == 2 && $tarea->realizado == false && $tarea->categoria == 'Frenos'): ?>
                <?php if ($temp_frenos): $temp_frenos = false; ?> <div class="titulo_categoria">Frenos</div><?php endif; ?>
                                                                                            <div class="tarea_realizar hide_wrapper_tarea">
                                                                                                <div class="imagen_tarea"><img width="60px" src="<?php echo base_url().$tarea->imagen_thumb_url; ?>" /> </div>
                                                                                                <div class="checkbox_tarea_realizar"><?php $checkbox = array("name" => 'checkbox[]', "value" => $vehiculo->id_usuario_vehiculo . "-" . $tarea->id_servicio);
                echo form_checkbox($checkbox);
                ?><br/>Ya lo hice</div>
                                                                                                <div class="progress-bar"><span class ="porcentaje_progreso"><?php echo $tarea->barra_progreso; ?></span>
                                                                                                    <div class ="fecha_porcentaje_progreso"><span class ="mensaje"><?php echo $tarea->mensaje_dias_restantes; ?></span><span class ="numero"><?php echo $tarea->dias_restantes; ?></span><span> <?php echo $tarea->mensaje_dias_restantes2; ?></span></div>
                                                                                                </div>
                                                                                                <div class="nommbre_tarea_realizar"><?php echo $tarea->nombre; ?></div>
                                                                                                <div class="url_tarea_realizar"><a TARGET="_blank" href="<?php echo base_url() . 'establecimientos'; ?>">Ver sitios donde se presta este servicio</a></div>
                                                                                                <div class="nombre_tarea_realizar"><?php echo $tarea->descripcion; ?></div>
                                                                                            </div>
                                                                                            <?php $key = $vehiculo->id_vehiculo . "_" . $tarea->id_servicio; if( sizeof($ofertas[$key]) >= 1){ ?><div class="titulo_promo_categoria">* Para hacer este mantenimiento, te pueden interesar las siguientes ofertas</div><?php }?>
                                                                                            <div class="oferta_tarea">
                <?php foreach ($ofertas[$key] as $oferta): ?>
                                                                                                    <form class="forma_pagosonline" id="forma_pagosonline" method="post" action="<?php echo $urlPagosOnline ?>" target="_self">
                                                                                                        <input name="id_oferta" class="id_oferta" type="hidden" value="<?php echo $oferta->id_oferta ?>" >
                                                                                                        <input name="emailComprador" class="emailComprador" id="emailComprador" type="hidden" value="<?php echo $emailComprador ?>">
                                                                                                        <input name="prueba" class="prueba" id="prueba" type="hidden" value="<?php echo $prueba ?>">
                                                                                                        <input name="url_respuesta" class="url_respuesta" id="url_respuesta" type="hidden" value="<?php echo $url_respuesta ?>">
                                                                                                        <input name="url_confirmacion" class="url_confirmacion" id="url_confirmacion" type="hidden" value="<?php echo $url_confirmacion ?>">
                                                                                                        <input name="extra1" class="extra1" id="extra1" type="hidden" value="<?php echo $extra1; ?>">

                                                                                                        <div class="contenido_oferta">
                                                                                                           <div class="titulo ">
                                                                                                                    <div style="float: left; width: 80%;" ><strong><?php echo $oferta->titulo; ?></strong></div>
                                                                                                                    <div style="color: white; margin-top: 15px; padding-top: 5px; padding-left: 25px; float: right; height: 33px; width: 110px; background-image: url('../resources/images/autopartes/etiqueta_precio.png'); background-repeat: no-repeat; " >
                                                                                                                        $<?php echo number_format($oferta->precio, 0, ',', '.'); ?>
                                                                                                                    </div>
                                                                                                                    <div class="clear"></div>
                                                                                                                </div>

                                                                                                            <div class="oferta">
                                                                                                                <div class="descripcion">
                                                                                                                    <div><strong>Precio:</strong> $<?php echo number_format($oferta->precio, 0, ',', '.'); ?></div>
                                                                                                                    <div><strong>Fecha de Vigencia:</strong> <?php echo strftime("%B %d de %Y", strtotime($oferta->vigencia)); ?></div>
                                                                                                                    <div><strong>Descripcion:</strong> <br/><?php echo $oferta->descripcion; ?></div>
                                                                                                                    <div><strong>Condiciones:</strong> <br/><?php echo $oferta->condiciones; ?></div>
                                                                                                                    <div><strong>Incluye:</strong> <br/><?php echo $oferta->incluye; ?></div>
                                                                                                                    <div><strong>Taller:</strong> <br/><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                                                                    echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"><?php echo $oferta->establecimientoNombre; ?></a> - <?php echo $oferta->direccion; ?></div>
                                                                                                                    <div style="padding-left: 10px;"><?php echo $oferta->establecimientoDescripcion; ?></div>
                                                                                                                    <div class="calificacion_taller" style="padding-top: 10px;">Calificación del taller: <span><?php echo round($oferta->calificacion); ?></span></div>
                                                                                                                    <div class="progress_bar">
                                                                                                                        <div class="progress_level"></div>
                                                                                                                    </div>
                                                                                                                    <div><?php echo $oferta->num_comentarios; ?> Usuarios han calificado este taller.</div>
                                                                                                                    <div><a v href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                                                                    echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"> Ver comentarios...</a></div>
                                                                                                                </div>

                                                                                                                <div class="logo_establecimiento"><img src="<?php echo base_url() . $oferta->logo; ?>"/></div>
                                                                                                                <div class ="boton_pago_servicios">
                                                                                                                    <input name="oferta_<?php echo $oferta->id_oferta; ?>" type="button" class="carrito_compras_btn_comprar" title="Comprar" >
                                                                                                                    <img width="200px" src="<?php echo base_url().'resources/images/iconos/pol.png'; ?>" alt="respaldo-pagos-online"/>
                                                                                                                </div>

                                                                                                                <div class="clear"></div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </form>

                <?php endforeach; ?>
                                                                                            </div>

                <?php elseif ($tarea->prioridad == 2 && $tarea->realizado == false && $tarea->categoria == 'Legales'):
                ?>
                <?php if ($temp_legales): $temp_legales = false; ?>   <div class="titulo_categoria">Legales</div> <?php endif; ?>
                                                                                            <div class="tarea_realizar hide_wrapper_tarea">
                                                                                                <div class="imagen_tarea"><img width="60px" src="<?php echo base_url().$tarea->imagen_thumb_url; ?>" /> </div>
                                                                                                <div class="checkbox_tarea_realizar"><?php $checkbox = array("name" => 'checkbox[]', "value" => $vehiculo->id_usuario_vehiculo . "-" . $tarea->id_servicio);
                echo form_checkbox($checkbox);
                ?><br/>Ya lo hice</div>
                                                                                                <div class="progress-bar"><span class ="porcentaje_progreso"><?php echo $tarea->barra_progreso; ?></span>
                                                                                                    <div class ="fecha_porcentaje_progreso"><span class ="mensaje"><?php echo $tarea->mensaje_dias_restantes; ?></span><span class ="numero"><?php echo $tarea->dias_restantes; ?></span><span> <?php echo $tarea->mensaje_dias_restantes2; ?></span></div>
                                                                                                </div>
                                                                                                <div class="nommbre_tarea_realizar"><?php echo $tarea->nombre; ?></div>
                                                                                                <div class="url_tarea_realizar"><a TARGET="_blank" href="<?php echo base_url() . 'establecimientos'; ?>">Ver sitios donde se presta este servicio</a></div>
                                                                                                <div class="nombre_tarea_realizar"><?php echo $tarea->descripcion; ?></div>

                                                                                            </div>
                                                                                            <?php $key = $vehiculo->id_vehiculo . "_" . $tarea->id_servicio; if( sizeof($ofertas[$key]) >= 1){ ?><div class="titulo_promo_categoria">* Para hacer este mantenimiento, te pueden interesar las siguientes ofertas</div><?php }?>
                                                                                            <div class="oferta_tarea">
                <?php  foreach ($ofertas[$key] as $oferta):  ?>
                                                                                                    <form class="forma_pagosonline" id="forma_pagosonline" method="post" action="<?php echo $urlPagosOnline ?>" target="_self">
                                                                                                        <input name="id_oferta" class="id_oferta" type="hidden" value="<?php echo $oferta->id_oferta ?>" >
                                                                                                        <input name="emailComprador" class="emailComprador" id="emailComprador" type="hidden" value="<?php echo $emailComprador ?>">
                                                                                                        <input name="prueba" class="prueba" id="prueba" type="hidden" value="<?php echo $prueba ?>">
                                                                                                        <input name="url_respuesta" class="url_respuesta" id="url_respuesta" type="hidden" value="<?php echo $url_respuesta ?>">
                                                                                                        <input name="url_confirmacion" class="url_confirmacion" id="url_confirmacion" type="hidden" value="<?php echo $url_confirmacion ?>">
                                                                                                        <input name="extra1" class="extra1" id="extra1" type="hidden" value="<?php echo $extra1; ?>">

                                                                                                        <div class="contenido_oferta">
                                                                                                            <div class="titulo ">
                                                                                                                    <div style="float: left; width: 80%;" ><strong><?php echo $oferta->titulo; ?></strong></div>
                                                                                                                    <div style="color: white; margin-top: 15px; padding-top: 5px; padding-left: 25px; float: right; height: 33px; width: 110px; background-image: url('../resources/images/autopartes/etiqueta_precio.png'); background-repeat: no-repeat; " >
                                                                                                                        $<?php echo number_format($oferta->precio, 0, ',', '.'); ?>
                                                                                                                    </div>
                                                                                                                    <div class="clear"></div>
                                                                                                                </div>

                                                                                                            <div class="oferta">
                                                                                                                <div class="descripcion">
                                                                                                                    <div><strong>Precio:</strong> $<?php echo number_format($oferta->precio, 0, ',', '.'); ?></div>
                                                                                                                    <div><strong>Fecha de Vigencia:</strong> <?php echo strftime("%B %d de %Y", strtotime($oferta->vigencia)); ?></div>
                                                                                                                    <div><strong>Descripcion:</strong> <br/><?php echo $oferta->descripcion; ?></div>
                                                                                                                    <div><strong>Condiciones:</strong> <br/><?php echo $oferta->condiciones; ?></div>
                                                                                                                    <div><strong>Incluye:</strong> <br/><?php echo $oferta->incluye; ?></div>
                                                                                                                    <div><strong>Taller:</strong> <br/><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                                                            echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"><?php echo $oferta->establecimientoNombre; ?></a> - <?php echo $oferta->direccion; ?></div>
                                                                                                                    <div style="padding-left: 10px;"><?php echo $oferta->establecimientoDescripcion; ?></div>
                                                                                                                    <div class="calificacion_taller" style="padding-top: 10px;">Calificación del taller: <span><?php echo round($oferta->calificacion); ?></span></div>
                                                                                                                    <div class="progress_bar">
                                                                                                                        <div class="progress_level"></div>
                                                                                                                    </div>
                                                                                                                    <div><?php echo $oferta->num_comentarios; ?> Usuarios han calificado este taller.</div>
                                                                                                                    <div><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                                                            echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"> Ver comentarios...</a></div>
                                                                                                                </div>

                                                                                                                <div class="logo_establecimiento"><img src="<?php echo base_url() . $oferta->logo; ?>"/></div>
                                                                                                                <div class ="boton_pago_servicios">
                                                                                                                    <input name="oferta_<?php echo $oferta->id_oferta; ?>" type="button" class="carrito_compras_btn_comprar" title="Comprar" >
                                                                                                                    <img width="200px" src="<?php echo base_url().'resources/images/iconos/pol.png'; ?>" alt="respaldo-pagos-online"/>
                                                                                                                </div>

                                                                                                                <div class="clear"></div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </form>

                <?php endforeach; ?>
                                                                                            </div>


            <?php elseif ($tarea->prioridad == 2 && $tarea->realizado == false && $tarea->categoria == 'Kit de carretera'): ?>
                <?php if ($temp_kit_carretera): $temp_kit_carretera = false; ?> <div class="titulo_categoria">Kit de carretera</div><?php endif; ?>
                                                                                            <div class="tarea_realizar hide_wrapper_tarea">
                                                                                                <div class="imagen_tarea"><img width="60px" src="<?php echo base_url().$tarea->imagen_thumb_url; ?>" /> </div>
                                                                                                <div class="checkbox_tarea_realizar"><?php $checkbox = array("name" => 'checkbox[]', "value" => $vehiculo->id_usuario_vehiculo . "-" . $tarea->id_servicio);
                echo form_checkbox($checkbox);
                ?><br/>Ya lo hice</div>
                                                                                                <div class="progress-bar"><span class ="porcentaje_progreso"><?php echo $tarea->barra_progreso; ?></span>
                                                                                                    <div class ="fecha_porcentaje_progreso"><span class ="mensaje"><?php echo $tarea->mensaje_dias_restantes; ?></span><span class ="numero"><?php echo $tarea->dias_restantes; ?></span><span> <?php echo $tarea->mensaje_dias_restantes2; ?></span></div>
                                                                                                </div>
                                                                                                <div class="nommbre_tarea_realizar"><?php echo $tarea->nombre; ?></div>
                                                                                                <div class="url_tarea_realizar"><a TARGET="_blank" href="<?php echo base_url() . 'establecimientos'; ?>">Ver sitios donde se presta este servicio</a></div>
                                                                                                <div class="nombre_tarea_realizar"><?php echo $tarea->descripcion; ?></div>

                                                                                            </div>
                                                                                            <?php $key = $vehiculo->id_vehiculo . "_" . $tarea->id_servicio; if( sizeof($ofertas[$key]) >= 1){ ?><div class="titulo_promo_categoria">* Para hacer este mantenimiento, te pueden interesar las siguientes ofertas</div><?php }?>
                                                                                            <div class="oferta_tarea">
                <?php foreach ($ofertas[$key] as $oferta): ?>
                                                                                                    <form class="forma_pagosonline" id="forma_pagosonline" method="post" action="<?php echo $urlPagosOnline ?>" target="_self">
                                                                                                        <input name="id_oferta" class="id_oferta" type="hidden" value="<?php echo $oferta->id_oferta ?>" >
                                                                                                        <input name="emailComprador" class="emailComprador" id="emailComprador" type="hidden" value="<?php echo $emailComprador ?>">
                                                                                                        <input name="prueba" class="prueba" id="prueba" type="hidden" value="<?php echo $prueba ?>">
                                                                                                        <input name="url_respuesta" class="url_respuesta" id="url_respuesta" type="hidden" value="<?php echo $url_respuesta ?>">
                                                                                                        <input name="url_confirmacion" class="url_confirmacion" id="url_confirmacion" type="hidden" value="<?php echo $url_confirmacion ?>">
                                                                                                        <input name="extra1" class="extra1" id="extra1" type="hidden" value="<?php echo $extra1; ?>">

                                                                                                        <div class="contenido_oferta">
                                                                                                            <div class="titulo ">
                                                                                                                    <div style="float: left; width: 80%;" ><strong><?php echo $oferta->titulo; ?></strong></div>
                                                                                                                    <div style="color: white; margin-top: 15px; padding-top: 5px; padding-left: 25px; float: right; height: 33px; width: 110px; background-image: url('../resources/images/autopartes/etiqueta_precio.png'); background-repeat: no-repeat; " >
                                                                                                                        $<?php echo number_format($oferta->precio, 0, ',', '.'); ?>
                                                                                                                    </div>
                                                                                                                    <div class="clear"></div>
                                                                                                                </div>

                                                                                                            <div class="oferta">
                                                                                                                <div class="descripcion">
                                                                                                                    <div><strong>Precio:</strong> $<?php echo number_format($oferta->precio, 0, ',', '.'); ?></div>
                                                                                                                    <div><strong>Fecha de Vigencia:</strong> <?php echo strftime("%B %d de %Y", strtotime($oferta->vigencia)); ?></div>
                                                                                                                    <div><strong>Descripcion:</strong> <br/><?php echo $oferta->descripcion; ?></div>
                                                                                                                    <div><strong>Condiciones:</strong> <br/><?php echo $oferta->condiciones; ?></div>
                                                                                                                    <div><strong>Incluye:</strong> <br/><?php echo $oferta->incluye; ?></div>
                                                                                                                    <div><strong>Taller:</strong> <br/><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                                                                    echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"><?php echo $oferta->establecimientoNombre; ?></a> - <?php echo $oferta->direccion; ?></div>
                                                                                                                    <div style="padding-left: 10px;"><?php echo $oferta->establecimientoDescripcion; ?></div>
                                                                                                                    <div class="calificacion_taller" style="padding-top: 10px;">Calificación del taller: <span><?php echo round($oferta->calificacion); ?></span></div>
                                                                                                                    <div class="progress_bar">
                                                                                                                        <div class="progress_level"></div>
                                                                                                                    </div>
                                                                                                                    <div><?php echo $oferta->num_comentarios; ?> Usuarios han calificado este taller.</div>
                                                                                                                    <div><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                                                                echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"> Ver comentarios...</a></div>
                                                                                                                </div>

                                                                                                                <div class="logo_establecimiento"><img src="<?php echo base_url() . $oferta->logo; ?>"/></div>
                                                                                                                <div class ="boton_pago_servicios">
                                                                                                                    <input name="oferta_<?php echo $oferta->id_oferta; ?>" type="button" class="carrito_compras_btn_comprar" title="Comprar" >
                                                                                                                    <img width="200px" src="<?php echo base_url().'resources/images/iconos/pol.png'; ?>" alt="respaldo-pagos-online"/>
                                                                                                                </div>

                                                                                                                <div class="clear"></div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </form>

                <?php endforeach; ?>
                                                                                            </div>



            <?php elseif ($tarea->prioridad == 2 && $tarea->realizado == false && $tarea->categoria == 'Llantas'): ?>
                <?php if ($temp_llantas): $temp_llantas = false; ?> <div class="titulo_categoria">Llantas</div> <?php endif; ?>
                                                                                            <div class="tarea_realizar hide_wrapper_tarea">
                                                                                                <div class="imagen_tarea"><img width="60px" src="<?php echo base_url().$tarea->imagen_thumb_url; ?>" /> </div>
                                                                                                <div class="checkbox_tarea_realizar"><?php $checkbox = array("name" => 'checkbox[]', "value" => $vehiculo->id_usuario_vehiculo . "-" . $tarea->id_servicio);
                echo form_checkbox($checkbox);
                ?><br/>Ya lo hice</div>
                                                                                                <div class="progress-bar"><span class ="porcentaje_progreso"><?php echo $tarea->barra_progreso; ?></span>
                                                                                                    <div class ="fecha_porcentaje_progreso"><span class ="mensaje"><?php echo $tarea->mensaje_dias_restantes; ?></span><span class ="numero"><?php echo $tarea->dias_restantes; ?></span><span> <?php echo $tarea->mensaje_dias_restantes2; ?></span></div>
                                                                                                </div>
                                                                                                <div class="nommbre_tarea_realizar"><?php echo $tarea->nombre; ?></div>
                                                                                                <div class="url_tarea_realizar"><a TARGET="_blank" href="<?php echo base_url() . 'establecimientos'; ?>">Ver sitios donde se presta este servicio</a></div>
                                                                                                <div class="nombre_tarea_realizar"><?php echo $tarea->descripcion; ?></div>
                                                                                            </div>
                                                                                            <?php $key = $vehiculo->id_vehiculo . "_" . $tarea->id_servicio; if( sizeof($ofertas[$key]) >= 1){ ?><div class="titulo_promo_categoria">* Para hacer este mantenimiento, te pueden interesar las siguientes ofertas</div><?php }?>
                                                                                            <div class="oferta_tarea">
                <?php  foreach ($ofertas[$key] as $oferta): ?>
                                                                                                    <form class="forma_pagosonline" id="forma_pagosonline" method="post" action="<?php echo $urlPagosOnline ?>" target="_self">
                                                                                                        <input name="id_oferta" class="id_oferta" type="hidden" value="<?php echo $oferta->id_oferta ?>" >
                                                                                                        <input name="emailComprador" class="emailComprador" id="emailComprador" type="hidden" value="<?php echo $emailComprador ?>">
                                                                                                        <input name="prueba" class="prueba" id="prueba" type="hidden" value="<?php echo $prueba ?>">
                                                                                                        <input name="url_respuesta" class="url_respuesta" id="url_respuesta" type="hidden" value="<?php echo $url_respuesta ?>">
                                                                                                        <input name="url_confirmacion" class="url_confirmacion" id="url_confirmacion" type="hidden" value="<?php echo $url_confirmacion ?>">
                                                                                                        <input name="extra1" class="extra1" id="extra1" type="hidden" value="<?php echo $extra1; ?>">

                                                                                                        <div class="contenido_oferta">
                                                                                                            <div class="titulo ">
                                                                                                                    <div style="float: left; width: 80%;" ><strong><?php echo $oferta->titulo; ?></strong></div>
                                                                                                                    <div style="color: white; margin-top: 15px; padding-top: 5px; padding-left: 25px; float: right; height: 33px; width: 110px; background-image: url('../resources/images/autopartes/etiqueta_precio.png'); background-repeat: no-repeat; " >
                                                                                                                        $<?php echo number_format($oferta->precio, 0, ',', '.'); ?>
                                                                                                                    </div>
                                                                                                                    <div class="clear"></div>
                                                                                                                </div>

                                                                                                            <div class="oferta">
                                                                                                                <div class="descripcion">
                                                                                                                    <div><strong>Precio:</strong> $<?php echo number_format($oferta->precio, 0, ',', '.'); ?></div>
                                                                                                                    <div><strong>Fecha de Vigencia:</strong> <?php echo strftime("%B %d de %Y", strtotime($oferta->vigencia)); ?></div>
                                                                                                                    <div><strong>Descripcion:</strong> <br/><?php echo $oferta->descripcion; ?></div>
                                                                                                                    <div><strong>Condiciones:</strong> <br/><?php echo $oferta->condiciones; ?></div>
                                                                                                                    <div><strong>Incluye:</strong> <br/><?php echo $oferta->incluye; ?></div>
                                                                                                                    <div><strong>Taller:</strong> <br/><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                                                                echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"><?php echo $oferta->establecimientoNombre; ?></a> - <?php echo $oferta->direccion; ?></div>
                                                                                                                    <div style="padding-left: 10px;"><?php echo $oferta->establecimientoDescripcion; ?></div>
                                                                                                                    <div class="calificacion_taller" style="padding-top: 10px;">Calificación del taller: <span><?php echo round($oferta->calificacion); ?></span></div>
                                                                                                                    <div class="progress_bar">
                                                                                                                        <div class="progress_level"></div>
                                                                                                                    </div>
                                                                                                                    <div><?php echo $oferta->num_comentarios; ?> Usuarios han calificado este taller.</div>
                                                                                                                    <div><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                                                                echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"> Ver comentarios...</a></div>
                                                                                                                </div>

                                                                                                                <div class="logo_establecimiento"><img src="<?php echo base_url() . $oferta->logo; ?>"/></div>
                                                                                                                <div class ="boton_pago_servicios">
                                                                                                                    <input name="oferta_<?php echo $oferta->id_oferta; ?>" type="button" class="carrito_compras_btn_comprar" title="Comprar" >
                                                                                                                    <img width="200px" src="<?php echo base_url().'resources/images/iconos/pol.png'; ?>" alt="respaldo-pagos-online"/>
                                                                                                                </div>

                                                                                                                <div class="clear"></div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </form>

                <?php endforeach; ?>
                                                                                            </div>





            <?php elseif ($tarea->prioridad == 2 && $tarea->realizado == false && $tarea->categoria == 'Niveles'): ?>
                <?php if ($temp_niveles): $temp_niveles = false; ?><div class="titulo_categoria">Niveles</div> <?php endif; ?>
                                                                                            <div class="tarea_realizar hide_wrapper_tarea">
                                                                                                <div class="imagen_tarea"><img width="60px" src="<?php echo base_url().$tarea->imagen_thumb_url; ?>" /> </div>
                                                                                                <div class="checkbox_tarea_realizar"><?php $checkbox = array("name" => 'checkbox[]', "value" => $vehiculo->id_usuario_vehiculo . "-" . $tarea->id_servicio);
                echo form_checkbox($checkbox);
                ?><br/>Ya lo hice</div>
                                                                                                <div class="progress-bar"><span class ="porcentaje_progreso"><?php echo $tarea->barra_progreso; ?></span>
                                                                                                    <div class ="fecha_porcentaje_progreso"><span class ="mensaje"><?php echo $tarea->mensaje_dias_restantes; ?></span><span class ="numero"><?php echo $tarea->dias_restantes; ?></span><span> <?php echo $tarea->mensaje_dias_restantes2; ?></span></div>
                                                                                                </div>
                                                                                                <div class="nommbre_tarea_realizar"><?php echo $tarea->nombre; ?></div>
                                                                                                <div class="url_tarea_realizar"><a TARGET="_blank" href="<?php echo base_url() . 'establecimientos'; ?>">Ver sitios donde se presta este servicio</a></div>
                                                                                                <div class="nombre_tarea_realizar"><?php echo $tarea->descripcion; ?></div>
                                                                                            </div>
                                                                                            <?php $key = $vehiculo->id_vehiculo . "_" . $tarea->id_servicio; if( sizeof($ofertas[$key]) >= 1){ ?><div class="titulo_promo_categoria">* Para hacer este mantenimiento, te pueden interesar las siguientes ofertas</div><?php }?>
                                                                                            <div class="oferta_tarea">
                                                                                            <?php 
                                                                                            foreach ($ofertas[$key] as $oferta):
                                                                                                ?>
                                                                                                    <form class="forma_pagosonline" id="forma_pagosonline" method="post" action="<?php echo $urlPagosOnline ?>" target="_self">
                                                                                                        <input name="id_oferta" class="id_oferta" type="hidden" value="<?php echo $oferta->id_oferta ?>" >
                                                                                                        <input name="emailComprador" class="emailComprador" id="emailComprador" type="hidden" value="<?php echo $emailComprador ?>">
                                                                                                        <input name="prueba" class="prueba" id="prueba" type="hidden" value="<?php echo $prueba ?>">
                                                                                                        <input name="url_respuesta" class="url_respuesta" id="url_respuesta" type="hidden" value="<?php echo $url_respuesta ?>">
                                                                                                        <input name="url_confirmacion" class="url_confirmacion" id="url_confirmacion" type="hidden" value="<?php echo $url_confirmacion ?>">
                                                                                                        <input name="extra1" class="extra1" id="extra1" type="hidden" value="<?php echo $extra1; ?>">

                                                                                                        <div class="contenido_oferta">
                                                                                                            <div class="titulo ">
                                                                                                                    <div style="float: left; width: 80%;" ><strong><?php echo $oferta->titulo; ?></strong></div>
                                                                                                                    <div style="color: white; margin-top: 15px; padding-top: 5px; padding-left: 25px; float: right; height: 33px; width: 110px; background-image: url('../resources/images/autopartes/etiqueta_precio.png'); background-repeat: no-repeat; " >
                                                                                                                        $<?php echo number_format($oferta->precio, 0, ',', '.'); ?>
                                                                                                                    </div>
                                                                                                                    <div class="clear"></div>
                                                                                                                </div>

                                                                                                            <div class="oferta">
                                                                                                                <div class="descripcion">
                                                                                                                    <div><strong>Precio:</strong> $<?php echo number_format($oferta->precio, 0, ',', '.'); ?></div>
                                                                                                                    <div><strong>Fecha de Vigencia:</strong> <?php echo strftime("%B %d de %Y", strtotime($oferta->vigencia)); ?></div>
                                                                                                                    <div><strong>Descripcion:</strong> <br/><?php echo $oferta->descripcion; ?></div>
                                                                                                                    <div><strong>Condiciones:</strong> <br/><?php echo $oferta->condiciones; ?></div>
                                                                                                                    <div><strong>Incluye:</strong> <br/><?php echo $oferta->incluye; ?></div>
                                                                                                                    <div><strong>Taller:</strong> <br/><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                                                                echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"><?php echo $oferta->establecimientoNombre; ?></a> - <?php echo $oferta->direccion; ?></div>
                                                                                                                    <div style="padding-left: 10px;"><?php echo $oferta->establecimientoDescripcion; ?></div>
                                                                                                                    <div class="calificacion_taller" style="padding-top: 10px;">Calificación del taller: <span><?php echo round($oferta->calificacion); ?></span></div>
                                                                                                                    <div class="progress_bar">
                                                                                                                        <div class="progress_level"></div>
                                                                                                                    </div>
                                                                                                                    <div><?php echo $oferta->num_comentarios; ?> Usuarios han calificado este taller.</div>
                                                                                                                    <div><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                                                                echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"> Ver comentarios...</a></div>
                                                                                                                </div>

                                                                                                                <div class="logo_establecimiento"><img src="<?php echo base_url() . $oferta->logo; ?>"/></div>
                                                                                                                <div class ="boton_pago_servicios">
                                                                                                                    <input name="oferta_<?php echo $oferta->id_oferta; ?>" type="button" class="carrito_compras_btn_comprar" title="Comprar" >
                                                                                                                    <img width="200px" src="<?php echo base_url().'resources/images/iconos/pol.png'; ?>" alt="respaldo-pagos-online"/>
                                                                                                                </div>

                                                                                                                <div class="clear"></div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </form>

                <?php endforeach; ?>
                                                                                            </div>


            <?php elseif ($tarea->prioridad == 2 && $tarea->realizado == false && $tarea->categoria == 'Sincronización'): ?>
                <?php if ($temp_sincronizacion): $temp_sincronizacion = false; ?><div class="titulo_categoria">Sincronización</div> <?php endif; ?>
                                                                                            <div class="tarea_realizar hide_wrapper_tarea">
                                                                                                <div class="imagen_tarea"><img width="60px" src="<?php echo base_url().$tarea->imagen_thumb_url; ?>" /> </div>
                                                                                                <div class="checkbox_tarea_realizar"><?php $checkbox = array("name" => 'checkbox[]', "value" => $vehiculo->id_usuario_vehiculo . "-" . $tarea->id_servicio);
                echo form_checkbox($checkbox);
                ?><br/>Ya lo hice</div>
                                                                                                <div class="progress-bar"><span class ="porcentaje_progreso"><?php echo $tarea->barra_progreso; ?></span>
                                                                                                    <div class ="fecha_porcentaje_progreso"><span class ="mensaje"><?php echo $tarea->mensaje_dias_restantes; ?></span><span class ="numero"><?php echo $tarea->dias_restantes; ?></span><span> <?php echo $tarea->mensaje_dias_restantes2; ?></span></div>
                                                                                                </div>
                                                                                                <div class="nommbre_tarea_realizar"><?php echo $tarea->nombre; ?></div>
                                                                                                <div class="url_tarea_realizar"><a TARGET="_blank" href="<?php echo base_url() . 'establecimientos'; ?>">Ver sitios donde se presta este servicio</a></div>
                                                                                                <div class="nombre_tarea_realizar"><?php echo $tarea->descripcion; ?></div>
                                                                                            </div>
                                                                                            <div class="titulo_promo_categoria">* Para hacer este mantenimiento, te pueden interesar las siguientes ofertas</div>
                                                                                            <div class="oferta_tarea">
                <?php $key = $vehiculo->id_vehiculo . "_" . $tarea->id_servicio;
                foreach ($ofertas[$key] as $oferta):
                    ?>
                                                                                                    <form class="forma_pagosonline" id="forma_pagosonline" method="post" action="<?php echo $urlPagosOnline ?>" target="_self">
                                                                                                        <input name="id_oferta" class="id_oferta" type="hidden" value="<?php echo $oferta->id_oferta ?>" >
                                                                                                        <input name="emailComprador" class="emailComprador" id="emailComprador" type="hidden" value="<?php echo $emailComprador ?>">
                                                                                                        <input name="prueba" class="prueba" id="prueba" type="hidden" value="<?php echo $prueba ?>">
                                                                                                        <input name="url_respuesta" class="url_respuesta" id="url_respuesta" type="hidden" value="<?php echo $url_respuesta ?>">
                                                                                                        <input name="url_confirmacion" class="url_confirmacion" id="url_confirmacion" type="hidden" value="<?php echo $url_confirmacion ?>">
                                                                                                        <input name="extra1" class="extra1" id="extra1" type="hidden" value="<?php echo $extra1; ?>">

                                                                                                        <div class="contenido_oferta">
                                                                                                            <div class="titulo ">
                                                                                                                    <div style="float: left; width: 80%;" ><strong><?php echo $oferta->titulo; ?></strong></div>
                                                                                                                    <div style="color: white; margin-top: 15px; padding-top: 5px; padding-left: 25px; float: right; height: 33px; width: 110px; background-image: url('../resources/images/autopartes/etiqueta_precio.png'); background-repeat: no-repeat; " >
                                                                                                                        $<?php echo number_format($oferta->precio, 0, ',', '.'); ?>
                                                                                                                    </div>
                                                                                                                    <div class="clear"></div>
                                                                                                                </div>

                                                                                                            <div class="oferta">
                                                                                                                <div class="descripcion">
                                                                                                                    <div><strong>Precio:</strong> $<?php echo number_format($oferta->precio, 0, ',', '.'); ?></div>
                                                                                                                    <div><strong>Fecha de Vigencia:</strong> <?php echo strftime("%B %d de %Y", strtotime($oferta->vigencia)); ?></div>
                                                                                                                    <div><strong>Descripcion:</strong> <br/><?php echo $oferta->descripcion; ?></div>
                                                                                                                    <div><strong>Condiciones:</strong> <br/><?php echo $oferta->condiciones; ?></div>
                                                                                                                    <div><strong>Incluye:</strong> <br/><?php echo $oferta->incluye; ?></div>
                                                                                                                    <div><strong>Taller:</strong> <br/><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                                                                echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"><?php echo $oferta->establecimientoNombre; ?></a> - <?php echo $oferta->direccion; ?></div>
                                                                                                                    <div style="padding-left: 10px;"><?php echo $oferta->establecimientoDescripcion; ?></div>
                                                                                                                    <div class="calificacion_taller" style="padding-top: 10px;">Calificación del taller: <span><?php echo round($oferta->calificacion); ?></span></div>
                                                                                                                    <div class="progress_bar">
                                                                                                                        <div class="progress_level"></div>
                                                                                                                    </div>
                                                                                                                    <div><?php echo $oferta->num_comentarios; ?> Usuarios han calificado este taller.</div>
                                                                                                                    <div><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                                                                echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"> Ver comentarios...</a></div>
                                                                                                                </div>

                                                                                                                <div class="logo_establecimiento"><img src="<?php echo base_url() . $oferta->logo; ?>"/></div>
                                                                                                                <div class ="boton_pago_servicios">
                                                                                                                    <input name="oferta_<?php echo $oferta->id_oferta; ?>" type="button" class="carrito_compras_btn_comprar" title="Comprar" >
                                                                                                                    <img width="200px" src="<?php echo base_url().'resources/images/iconos/pol.png'; ?>" alt="respaldo-pagos-online"/>
                                                                                                                </div>

                                                                                                                <div class="clear"></div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </form>

                <?php endforeach; ?>
                                                                                            </div>
                                                                                            <?php elseif ($tarea->prioridad == 2 && $tarea->realizado == false && $tarea->categoria == 'Suspensión'): ?>
                                                                                                <?php if ($temp_suspension): $temp_suspension = false; ?><div class="titulo_categoria">Suspensión</div><?php endif; ?>
                                                                                            <div class="tarea_realizar hide_wrapper_tarea">
                                                                                                <div class="imagen_tarea"><img width="60px" src="<?php echo base_url().$tarea->imagen_thumb_url; ?>" /> </div>
                                                                                                <div class="checkbox_tarea_realizar"><?php $checkbox = array("name" => 'checkbox[]', "value" => $vehiculo->id_usuario_vehiculo . "-" . $tarea->id_servicio);
                                                                                echo form_checkbox($checkbox);
                                                                                                ?><br/>Ya lo hice</div>
                                                                                                <div class="progress-bar"><span class ="porcentaje_progreso"><?php echo $tarea->barra_progreso; ?></span>
                                                                                                    <div class ="fecha_porcentaje_progreso"><span class ="mensaje"><?php echo $tarea->mensaje_dias_restantes; ?></span><span class ="numero"><?php echo $tarea->dias_restantes; ?></span><span> <?php echo $tarea->mensaje_dias_restantes2; ?></span></div>
                                                                                                </div>
                                                                                                <div class="nommbre_tarea_realizar"><?php echo $tarea->nombre; ?></div>
                                                                                                <div class="url_tarea_realizar"><a TARGET="_blank" href="<?php echo base_url() . 'establecimientos'; ?>">Ver sitios donde se presta este servicio</a></div>
                                                                                                <div class="nombre_tarea_realizar"><?php echo $tarea->descripcion; ?></div>
                                                                                            </div>
                                                                                            <div class="titulo_promo_categoria">* Para hacer este mantenimiento, te pueden interesar las siguientes ofertas</div>
                                                                                            <div class="oferta_tarea">
                                                                                                <?php $key = $vehiculo->id_vehiculo . "_" . $tarea->id_servicio;
                                                                                                foreach ($ofertas[$key] as $oferta):
                                                                                                    ?>
                                                                                                    <form class="forma_pagosonline" id="forma_pagosonline" method="post" action="<?php echo $urlPagosOnline ?>" target="_self">
                                                                                                        <input name="id_oferta" class="id_oferta" type="hidden" value="<?php echo $oferta->id_oferta ?>" >
                                                                                                        <input name="emailComprador" class="emailComprador" id="emailComprador" type="hidden" value="<?php echo $emailComprador ?>">
                                                                                                        <input name="prueba" class="prueba" id="prueba" type="hidden" value="<?php echo $prueba ?>">
                                                                                                        <input name="url_respuesta" class="url_respuesta" id="url_respuesta" type="hidden" value="<?php echo $url_respuesta ?>">
                                                                                                        <input name="url_confirmacion" class="url_confirmacion" id="url_confirmacion" type="hidden" value="<?php echo $url_confirmacion ?>">
                                                                                                        <input name="extra1" class="extra1" id="extra1" type="hidden" value="<?php echo $extra1; ?>">

                                                                                                        <div class="contenido_oferta">
                                                                                                            <div class="titulo ">
                                                                                                                    <div style="float: left; width: 80%;" ><strong><?php echo $oferta->titulo; ?></strong></div>
                                                                                                                    <div style="color: white; margin-top: 15px; padding-top: 5px; padding-left: 25px; float: right; height: 33px; width: 110px; background-image: url('../resources/images/autopartes/etiqueta_precio.png'); background-repeat: no-repeat; " >
                                                                                                                        $<?php echo number_format($oferta->precio, 0, ',', '.'); ?>
                                                                                                                    </div>
                                                                                                                    <div class="clear"></div>
                                                                                                                </div>

                                                                                                            <div class="oferta">
                                                                                                                <div class="descripcion">
                                                                                                                    <div><strong>Precio:</strong> $<?php echo number_format($oferta->precio, 0, ',', '.'); ?></div>
                                                                                                                    <div><strong>Fecha de Vigencia:</strong> <?php echo strftime("%B %d de %Y", strtotime($oferta->vigencia)); ?></div>
                                                                                                                    <div><strong>Descripcion:</strong> <br/><?php echo $oferta->descripcion; ?></div>
                                                                                                                    <div><strong>Condiciones:</strong> <br/><?php echo $oferta->condiciones; ?></div>
                                                                                                                    <div><strong>Incluye:</strong> <br/><?php echo $oferta->incluye; ?></div>
                                                                                                                    <div><strong>Taller:</strong> <br/><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                                                                echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"><?php echo $oferta->establecimientoNombre; ?></a> - <?php echo $oferta->direccion; ?></div>
                                                                                                                    <div style="padding-left: 10px;"><?php echo $oferta->establecimientoDescripcion; ?></div>
                                                                                                                    <div class="calificacion_taller" style="padding-top: 10px;">Calificación del taller: <span><?php echo round($oferta->calificacion); ?></span></div>
                                                                                                                    <div class="progress_bar">
                                                                                                                        <div class="progress_level"></div>
                                                                                                                    </div>
                                                                                                                    <div><?php echo $oferta->num_comentarios; ?> Usuarios han calificado este taller.</div>
                                                                                                                    <div><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                                                                echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"> Ver comentarios...</a></div>
                                                                                                                </div>

                                                                                                                <div class="logo_establecimiento"><img src="<?php echo base_url() . $oferta->logo; ?>"/></div>
                                                                                                                <div class ="boton_pago_servicios">
                                                                                                                    <input name="oferta_<?php echo $oferta->id_oferta; ?>" type="button" class="carrito_compras_btn_comprar" title="Comprar" >
                                                                                                                    <img width="200px" src="<?php echo base_url().'resources/images/iconos/pol.png'; ?>" alt="respaldo-pagos-online"/>
                                                                                                                </div>

                                                                                                                <div class="clear"></div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </form>

                                                                                            <?php endforeach; ?>
                                                                                            </div>
                                                                                        <?php elseif ($tarea->prioridad == 2 && $tarea->realizado == false && $tarea->categoria == 'Otros'): ?>
                <?php if ($temp_otros): $temp_otros = false; ?><div class="titulo_categoria">Otros</div><?php endif; ?>
                                                                                            <div class="tarea_realizar hide_wrapper_tarea">
                                                                                                <div class="imagen_tarea"><img width="60px" src="<?php echo base_url().$tarea->imagen_thumb_url; ?>" /> </div>
                                                                                                <div class="checkbox_tarea_realizar"><?php $checkbox = array("name" => 'checkbox[]', "value" => $vehiculo->id_usuario_vehiculo . "-" . $tarea->id_servicio);
                echo form_checkbox($checkbox);
                ?><br/>Ya lo hice</div>
                                                                                                <div class="progress-bar"><span class ="porcentaje_progreso"><?php echo $tarea->barra_progreso; ?></span>
                                                                                                    <div class ="fecha_porcentaje_progreso"><span class ="mensaje"><?php echo $tarea->mensaje_dias_restantes; ?></span><span class ="numero"><?php echo $tarea->dias_restantes; ?></span><span> <?php echo $tarea->mensaje_dias_restantes2; ?></span></div>
                                                                                                </div>
                                                                                                <div class="nommbre_tarea_realizar"><?php echo $tarea->nombre; ?></div>
                                                                                                <div class="url_tarea_realizar"><a TARGET="_blank" href="<?php echo base_url() . 'establecimientos'; ?>">Ver sitios donde se presta este servicio</a></div>
                                                                                                <div class="nombre_tarea_realizar"><?php echo $tarea->descripcion; ?></div>
                                                                                            </div>
                                                                                                            <div class="titulo_promo_categoria">* Para hacer este mantenimiento, te pueden interesar las siguientes ofertas</div>
                                                                                            <div class="oferta_tarea">
                                                                                                <?php $key = $vehiculo->id_vehiculo . "_" . $tarea->id_servicio;
                                                                                                foreach ($ofertas[$key] as $oferta):
                                                                                                    ?>
                                                                                                    <form class="forma_pagosonline" id="forma_pagosonline" method="post" action="<?php echo $urlPagosOnline ?>" target="_self">
                                                                                                        <input name="id_oferta" class="id_oferta" type="hidden" value="<?php echo $oferta->id_oferta ?>" >
                                                                                                        <input name="emailComprador" class="emailComprador" id="emailComprador" type="hidden" value="<?php echo $emailComprador ?>">
                                                                                                        <input name="prueba" class="prueba" id="prueba" type="hidden" value="<?php echo $prueba ?>">
                                                                                                        <input name="url_respuesta" class="url_respuesta" id="url_respuesta" type="hidden" value="<?php echo $url_respuesta ?>">
                                                                                                        <input name="url_confirmacion" class="url_confirmacion" id="url_confirmacion" type="hidden" value="<?php echo $url_confirmacion ?>">
                                                                                                        <input name="extra1" class="extra1" id="extra1" type="hidden" value="<?php echo $extra1; ?>">

                                                                                                        <div class="contenido_oferta">
                                                                                                            <div class="titulo ">
                                                                                                                    <div style="float: left; width: 80%;" ><strong><?php echo $oferta->titulo; ?></strong></div>
                                                                                                                    <div style="color: white; margin-top: 15px; padding-top: 5px; padding-left: 25px; float: right; height: 33px; width: 110px; background-image: url('../resources/images/autopartes/etiqueta_precio.png'); background-repeat: no-repeat; " >
                                                                                                                        $<?php echo number_format($oferta->precio, 0, ',', '.'); ?>
                                                                                                                    </div>
                                                                                                                    <div class="clear"></div>
                                                                                                                </div>

                                                                                                            <div class="oferta">
                                                                                                                <div class="descripcion">
                                                                                                                    <div><strong>Precio:</strong> $<?php echo number_format($oferta->precio, 0, ',', '.'); ?></div>
                                                                                                                    <div><strong>Fecha de Vigencia:</strong> <?php echo strftime("%B %d de %Y", strtotime($oferta->vigencia)); ?></div>
                                                                                                                    <div><strong>Descripcion:</strong> <br/><?php echo $oferta->descripcion; ?></div>
                                                                                                                    <div><strong>Condiciones:</strong> <br/><?php echo $oferta->condiciones; ?></div>
                                                                                                                    <div><strong>Incluye:</strong> <br/><?php echo $oferta->incluye; ?></div>
                                                                                                                    <div><strong>Taller:</strong> <br/><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                            echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"><?php echo $oferta->establecimientoNombre; ?></a> - <?php echo $oferta->direccion; ?></div>
                                                                                                                    <div style="padding-left: 10px;"><?php echo $oferta->establecimientoDescripcion; ?></div>
                                                                                                                    <div class="calificacion_taller" style="padding-top: 10px;">Calificación del taller: <span><?php echo round($oferta->calificacion); ?></span></div>
                                                                                                                    <div class="progress_bar">
                                                                                                                        <div class="progress_level"></div>
                                                                                                                    </div>
                                                                                                                    <div><?php echo $oferta->num_comentarios; ?> Usuarios han calificado este taller.</div>
                                                                                                                    <div><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                            echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"> Ver comentarios...</a></div>
                                                                                                                </div>

                                                                                                                <div class="logo_establecimiento"><img src="<?php echo base_url() . $oferta->logo; ?>"/></div>
                                                                                                                <div class ="boton_pago_servicios">
                                                                                                                    <input name="oferta_<?php echo $oferta->id_oferta; ?>" type="button" class="carrito_compras_btn_comprar" title="Comprar" >
                                                                                                                    <img width="200px" src="<?php echo base_url().'resources/images/iconos/pol.png'; ?>" alt="respaldo-pagos-online"/>
                                                                                                                </div>

                                                                                                                <div class="clear"></div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </form>

                <?php endforeach; ?>
                                                                                            </div>
                <?php
            endif;
        endforeach;
        ?>
                                                                                </div>
                                                                            </div>
                                                                            <div id="made_task">
                                                                                <div class="titulo_categoria">Cosas que ya hiciste</div>
                                                                                <div class="categoria_tarea_realizar">
                                                                                    <div class ="wrapper_tarea_realizar hide_wrapper_tarea">
        <?php $tareas_vehiculo = $tareas[$vehiculo->id_vehiculo];
        foreach ($tareas_vehiculo as $tarea): if ($tarea->realizado == true): 
                ?>                                                                              
                                                                                                <div class="tarea_realizar">
                                                                                                    <div class="imagen_tarea"><img width="60px" src="<?php echo base_url().$tarea->imagen_thumb_url; ?>" /> </div>
                                                                                                    <div style="float: left;">
                                                                                                        <div class="nommbre_tarea_realizar"><?php echo $tarea->nombre; ?>   </div> 
                                                                                                        <?php if(($tarea->id_servicio == 10 || $tarea->id_servicio == 9) && $tarea->due != '0000-00-00'): ?> <div>Fecha de vencimiento: <?php echo $tarea->due;?></div>
                                                                                                        <?php elseif(($tarea->id_servicio != 10 && $tarea->id_servicio != 9) && $tarea->due != '0000-00-00'): ?> <div>Fecha de realización: <?php echo $tarea->due;?></div> <?php endif; ?>
                                                                                                        <div class="url_tarea_realizar"><a TARGET="_blank" href="<?php echo base_url() . 'establecimientos'; ?>">Ver sitios donde se presta este servicio</a></div>
                                                                                                        
                                                                                                    </div>
                                                                                                    <div class="clear"></div>
                                                                                                    <div class="nombre_tarea_realizar"><?php echo $tarea->descripcion; ?></div>
                                                                                                </div>
                                                                                            
            <?php endif;                                                                       
        endforeach;
        ?>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <div class="boton_tareas_realizar"></div>
                                                                        

                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
        <?php
        $numero_vehiculos++;
    }
}
?>
                                        </td>
                                    </tr>
                                </table>
                                <table id="ofertas" class="tabs" <?php if ($tab != 'ofertas') { ?>style="display: none"<?php } ?> width="830" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="2" style="padding-top:5px;padding-bottom:10px;" align="left">
                                            <!--h2>Estas son las preguntas que has hecho en el taller en l&iacute;nea...</h2-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td width="15">&nbsp;</td>
                                    </tr>
                                    <tr><td class="general_link">
    <div class ="wrapper_tarea_realizar">
                                                                                                <div class="all_oferta_tarea">
                <?php 
                foreach ($allofertas as $oferta):
                    ?>
                                                                                                        <form class="forma_pagosonline" id="forma_pagosonline" method="post" action="<?php echo $urlPagosOnline ?>" target="_self">
                                                                                                            <input name="id_oferta" class="id_oferta" type="hidden" value="<?php echo $oferta->id_oferta ?>" >
                                                                                                            <input name="emailComprador" class="emailComprador" id="emailComprador" type="hidden" value="<?php echo $emailComprador ?>">
                                                                                                            <input name="prueba" class="prueba" id="prueba" type="hidden" value="<?php echo $prueba ?>">
                                                                                                            <input name="url_respuesta" class="url_respuesta" id="url_respuesta" type="hidden" value="<?php echo $url_respuesta ?>">
                                                                                                            <input name="url_confirmacion" class="url_confirmacion" id="url_confirmacion" type="hidden" value="<?php echo $url_confirmacion ?>">
                                                                                                            <input name="extra1" class="extra1" id="extra1" type="hidden" value="<?php echo $extra1; ?>">

                                                                                                            <div class="all_contenido_oferta">
                                                                                                                <div class="titulo ">
                                                                                                                    <div style="float: left; width: 80%;" ><strong><?php echo $oferta->titulo; ?></strong></div>
                                                                                                                    <div style="color: white; margin-top: 15px; padding-top: 5px; padding-left: 25px; float: right; height: 33px; width: 110px; background-image: url('../resources/images/autopartes/etiqueta_precio.png'); background-repeat: no-repeat; " >
                                                                                                                        $<?php echo number_format($oferta->precio, 0, ',', '.'); ?>
                                                                                                                    </div>
                                                                                                                    <div class="clear"></div>
                                                                                                                </div>

                                                                                                                <div class="all_oferta">
                                                                                                                    <div class="descripcion">
                                                                                                                        <div><strong>Precio:</strong> $<?php echo number_format($oferta->precio, 0, ',', '.'); ?></div>
                                                                                                                        <div><strong>Fecha de Vigencia:</strong> <?php echo strftime("%B %d de %Y", strtotime($oferta->vigencia)); ?></div>
                                                                                                                        <div><strong>Descripcion:</strong> <br/><?php echo $oferta->descripcion; ?></div>
                                                                                                                        <div><strong>Condiciones:</strong> <br/><?php echo $oferta->condiciones; ?></div>
                                                                                                                        <div><strong>Incluye:</strong> <br/><?php echo $oferta->incluye; ?></div>
                                                                                                                        <div><strong>Taller:</strong> <br/><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                    echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"><?php echo $oferta->establecimientoNombre; ?></a> - <?php echo $oferta->direccion; ?></div>
                                                                                                                        <div style="padding-left: 10px;"><?php echo $oferta->establecimientoDescripcion; ?></div>
                                                                                                                        <div class="calificacion_taller" style="padding-top: 10px;">Calificación del taller: <span><?php echo round($oferta->avg); ?></span></div>
                                                                                                                        <div class="progress_bar">
                                                                                                                            <div class="progress_level"></div>
                                                                                                                        </div>
                                                                                                                        <div><?php echo $oferta->count; ?> Usuarios han calificado este taller.</div>
                                                                                                                        <div><a TARGET="_blank" href="<?php $url_nombre_taller = str_replace(" ", "-", $oferta->establecimientoNombre);
                                                                                echo base_url() . 'establecimientos/' . $oferta->id_establecimiento . '-' . $url_nombre_taller; ?>"> Ver comentarios...</a></div>
                                                                                                                    </div>

                                                                                                                    <div class="logo_establecimiento"><img src="<?php echo base_url() . $oferta->logo; ?>"/></div>
                                                                                                                    <div class ="boton_pago_servicios">
                                                                                                                        <input name="oferta_<?php echo $oferta->id_oferta; ?>" type="button" class="carrito_compras_btn_comprar" title="Comprar" >
                                                                                                                        <img width="200px" src="<?php echo base_url().'resources/images/iconos/pol.png'; ?>" alt="respaldo-pagos-online"/>
                                                                                                                    </div>

                                                                                                                    <div class="clear"></div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </form>

                                                                                            <?php endforeach; ?>
                                                                                                </div>

                                                                                </div>
                                </td></tr>
                                </table>
                            </td>
                            <td class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="15" class="box_esquina_inf_izq"></td>
                            <td colspan="2" class="box_borde_inf"></td>
                            <td height="15" class="box_esquina_inf_der"></td>
                        </tr>
                        <tr>
                            <td colspan="5" class="general_separador_transparente"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>