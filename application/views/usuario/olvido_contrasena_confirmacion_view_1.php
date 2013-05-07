<tr>
    <td>
        <table width="970" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="20">&nbsp;</td>
                <td width="555" valign="top" class="box_fondo">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td width="318" class="box_fondo"></td>
                            <td width="209" class="box_borde_sup" ></td>
                            <td width="14" height="14" class="box_esquina_sup_der"></td>
                        </tr>
                        <tr>
                            <td height="22" class="box_fondo box_titulo"><h1>OLVID&Eacute; MI CONTRASE&Ntilde;A</h1></td>
                            <td class="box_fondo_contenido box_ordenamiento">&nbsp;</td>
                            <td rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">
                                <?php $config = array('id' => 'formulario_olvido_contrasena');
                                echo form_open('usuario/olvido_contrasena', $config); ?>
                                <table width="526" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="180" valign="top"><table width="180" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                  <td valign="middle" align="center" style="padding-top:15px;padding-bottom:5px;"><img src="<?php echo base_url(); ?>resources/images/template/iconos/Check.gif" width="60" height="60" alt="Correo ha sido enviado" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="180" align="center" valign="middle" style="padding-bottom:10px;padding-left:5px;padding-right:5px;padding-top:15px;"><h3>Las <strong>instrucciones</strong> para recuperar su contrase&ntilde;a han sido enviadas al <strong>correo especificado</strong>. </h3></td>
                                                </tr>
                                                <tr>
                                                    <td valign="middle" align="center" style="padding-top:10px;">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td valign="middle" align="center" style="padding-bottom:5px;padding-left:10px;padding-right:10px;"><h3>&nbsp;</h3></td>
                                                </tr>
                                            </table>
                                      </td>
                                        <td width="346">
                                            <table width="346" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td colspan="2" height="10"></td>
                                                    <td width="15"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left" height="5"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><h3>Correo electr&oacute;nico:</h3></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><input class="general_cuadro_texto" type="text" name="email_registrarse" id="email_registrarse" size="38" /></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left" height="10"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><h3>Escribe los 4 dígitos de abajo:</h3></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><input class="general_cuadro_texto" type="text" name="captcha_registrarse" id="captcha_registrarse" size="38" /></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left" height="10"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="center"><?php echo $captcha['image']; ?></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left" height="10"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="general_separador_transparente"></td>
                                                </tr>
                                                <tr>
                                                    <td width="115">&nbsp;</td>
                                                    <td width="216" align="right" valign="top" style="padding-top:5px;padding-bottom:10px;"><input name="btn_olvido_contrasena" type="submit" class="general_boton_secundario" id="btn_olvido_contrasena" value="Recuperar mi contrase&ntilde;a" /></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table></td>
                        </tr>
                        <tr>
                            <td height="14" class="box_esquina_inf_izq"></td>
                            <td colspan="2" class="box_borde_inf"></td>
                            <td class="box_esquina_inf_der"></td>
                        </tr>
                    </table>
                    <?php echo form_close(); ?>
                </td>
                <td width="375" valign="top" class="box_fondo">&nbsp;</td>
                <td width="20">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5" class="general_separador_transparente"></td>
            </tr>
        </table></td>
</tr>

<tr style="display: none;">
    <td>&nbsp;</td>
</tr>