<html>
    <head>
        <link href="<?php echo base_url(); ?>resources/css/estilo.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
    <!-- Inicio formulario reporte de abuso -->
    
        <div id="hacer-sugerencia" align="center">
            <?php
                $hidden = array(
                    'seccion' => $seccion,
                    'tipo' => $tipo,
                    'id' => $id
                );

                echo form_open(base_url().'usuario/reportar_abuso', '', $hidden);
            ?>

            <table width="600" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="top" class="box_fondo" align="center" >
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="box_fondo" width="14">&nbsp;</td>
                                <td class="box_borde_sup" height="14" width="572"></td>
                                <td class="box_esquina_sup_der" width="14">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="box_borde_izq">&nbsp;</td>
                                <td class="box_fondo_contenido" align="left" style="padding:10px;"><h2>
                                        Ay&uacute;denos a mantener nuestros comentarios libres de contenido innecesario. Si tiene algo que agregar, utilice el cuadro de texto al final de este formulario. Gracias.
                                    </h2></td>
                                <td class="box_borde_der">&nbsp;</td>
                            </tr>
                            <tr>
                                <td height="14" class="box_esquina_inf_izq"></td>
                                <td class="box_borde_inf"></td>
                                <td class="box_esquina_inf_der"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="box_fondo">
                        <table width="600" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td rowspan="2" class="box_fondo" width="14">&nbsp;</td>
                                <td width="194" class="box_fondo"></td>
                                <td width="378" class="box_borde_sup" ></td>
                                <td height="14" class="box_esquina_sup_der" width="14"></td>
                            </tr>
                            <tr>
                                <td height="22" class="box_fondo box_titulo"><h1>REPORTE ESTE COMENTARIO</h1></td>
                                <td class="box_fondo_contenido box_ordenamiento">&nbsp;</td>
                                <td class="box_borde_der">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="box_borde_izq"></td>
                                <td colspan="2" class="box_fondo_contenido"></td>
                                <td class="box_borde_der"></td>
                            </tr>
                            <tr>
                                <td class="box_borde_izq">&nbsp;</td>
                                <td colspan="2" class="box_fondo_contenido">
                                    <table width="571" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="15" class="general_separador_transparente"></td>
                                            <td width="71"></td>
                                            <td width="470"></td>
                                            <td width="15"></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td class="general_formulario_texto" align="right" valign="middle"><h2>Motivo:</h2></td>
                                            <td class="general_formulario_texto" align="left" style="padding:10px;">
                                                <select name="motivo_reporte" id="motivo_reporte" >
                                                    <option value="Lenguaje ofensivo" selected>Lenguaje ofensivo</option>
                                                    <option value="Me siento vulnerado">Me siento vulnerado</option>
                                                    <option value="Publicidad/spam">Publicidad/spam</option>
                                                    <option value="Plagio">Plagio</option>
                                                    <option value="Otro">Otro</option>
                                                </select>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="15" class="general_separador_transparente"></td>
                                            <td width="71"></td>
                                            <td width="470"></td>
                                            <td width="15"></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                                <td colspan="2" class="general_formulario_texto" style="padding:15px;">

                                                <textarea class="general_textarea" name="comentarios_reporte" id="mensaje_reporte"  rows="8" cols="50"></textarea>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td >&nbsp;</td>
                                            <td colspan="2" align="right" style="padding-bottom:10px;padding-top:10px;"><span class="establecimiento_comentarios_boton_form">
                                                    <input type="submit" class="general_boton_secundario" name="btn_reportar" id="btn_reportar" value="Reportar" />
                                                </span></td>
                                            <td></td>
                                        </tr>
                                    </table></td>
                                <td class="box_borde_der">&nbsp;</td>
                            </tr>
                            <tr>
                                <td height="14" class="box_esquina_inf_izq"></td>
                                <td colspan="2" class="box_borde_inf"></td>
                                <td class="box_esquina_inf_der"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <?php echo form_close(); ?>
        </div>
    
    <!-- Final formulario reporte de abuso -->
    </body>
</html>