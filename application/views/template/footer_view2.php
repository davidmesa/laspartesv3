<?php
    $categoriasAutopartes = $this->autoparte_model->dar_autopartes_categorias();
    $zonasEstablecimientos = $this->establecimiento_model->dar_establecimientos_zonas();
    $serviciosEstablecimientos = $this->establecimiento_model->dar_establecimientos_servicios();
    $categoriasPreguntas = $this->pregunta_model->dar_preguntas_categorias();
?>

<tr>
    <td>
        <table width="970" border="0" cellspacing="0" cellpadding="0" class="footer">
            <tr>
                <td width="150" class="footer_panel_izq" valign="top" align="center">
                    <a href="http://www.laspartes.com"><img src="<?php echo base_url(); ?>resources/images/template/logos/laspartesGrande.png" alt="Logo Laspartes.com" width="110" height="67" /></a>
                    <h4 class="general_link" style="margin-bottom: 5px;margin-top: 10px;"><a href="<?php echo base_url(); ?>usuario/">Mis Veh&iacute;culos</a></h4>
                    <h4 class="general_link" style="margin-bottom: 5px;"><a href="<?php echo base_url(); ?>acerca/terminos_condiciones">Términos y condiciones</a></h4>
                    <h4 class="general_link" style="margin-bottom: 5px;"><a href="<?php echo base_url(); ?>acerca/quienes_somos">¿Quiénes somos?</a></h4>
                    <h4 class="general_link" style="margin-bottom: 5px;"><a href="<?php echo base_url(); ?>acerca/contactenos">Contáctenos</a></h4>
                </td>
                <td width="820" rowspan="7" class="footer_panel_der general_link">
                    <table width="800" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="160" align="left" valign="top">
                                <h2><strong>Autopartes</strong></h2>
                                <h4>
            <?php
                foreach ($categoriasAutopartes as $cat) {
            ?>
                                    <a href="<?php echo base_url(); ?>autopartes/index/<?php echo str_replace(' ', '-', convert_accented_characters($cat->nombre)); ?>/todas-las-marcas/nombre/todas-las-marcas/todas-las-lineas/10/0"><?php echo $cat->nombre; ?></a><br/>
            <?php
                }
            ?>
                                </h4>
                            </td>
                            <td width="160" align="left" valign="top">
                                <h2><strong>Establecimientos</strong></h2>
                                <h4>
            <?php
                foreach ($zonasEstablecimientos as $zonaEst) {
            ?>
                                    <a href="<?php echo base_url(); ?>establecimientos/index/todos-los-servicios/<?php echo convert_accented_characters( $zonaEst->nombre ) ?>/nombre/10/0"><?php echo $zonaEst->nombre ?></a><br/>
            <?php
                }
            ?>
                                </h4>
                            </td>
                            <td width="160" align="left" valign="top">
                                <h2><strong>Servicios</strong></h2>
                                <h4>
            <?php
                foreach ($serviciosEstablecimientos as $servicioEst) {
            ?>
                        <a href="<?php echo base_url(); ?>establecimientos/index/<?php echo convert_accented_characters( $servicioEst->nombre ); ?>/todas-las-zonas/nombre/10/0"><?php echo $servicioEst->nombre ?></a><br/>
            <?php
                }
            ?>
                                </h4>
                            </td>
                            <td width="160" align="left" valign="top">
                                <h2><strong>Taller en l&iacute;nea</strong></h2>

                                <h4>
            <?php
                foreach ($categoriasPreguntas as $catPreg) {
            ?>
                                    <a href="<?php echo base_url(); ?>taller_en_linea/ver_preguntas/<?php echo convert_accented_characters( $catPreg->nombre ); ?>/recientes/10/0"><?php echo $catPreg->nombre; ?></a><br/>
            <?php
                }
            ?>

                                </h4>

                            </td>
                            <td width="160" valign="top">
                                <h2><strong>Aprende</strong></h2>
                                <h4>
                                    <a href="<?php echo base_url(); ?>aprende/tips">Consejos y Tips</a> <br/>
                                    <a href="<?php echo base_url(); ?>aprende/noticias">Noticias</a> <br/>
                                    <a href="<?php echo base_url(); ?>aprende/tutoriales">Hágalo usted mismo</a>
                                </h4>
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
            
        </table>
    </td>
</tr>
<tr>
    <td class="borde_inferior"></td>
</tr>
<tr>
    <td class="footer_copyright">
        <h3>Copyright &copy; 2011 - Laspartes.com<br  />Todos los derechos reservados<br /><br />
            Encu&eacute;ntrenos tambi&eacute;n en:
            <br/><a href="http://www.twitter.com/laspartes" ><img src="http://twitter-badges.s3.amazonaws.com/twitter-a.png" alt="Sigue a Laspartes.com en Twitter"/></a>
        </h3>
    </td>
</tr>