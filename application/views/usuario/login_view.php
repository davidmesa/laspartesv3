<tr>
    <td>
        <table width="970" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="20">&nbsp;</td>
                <td width="555" valign="top" class="box_fondo">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td width="183" class="box_fondo"></td>
                            <td width="344" class="box_borde_sup" ></td>
                            <td width="14" height="14" class="box_esquina_sup_der"></td>
                        </tr>
                        <tr>
                            <td height="22" class="box_fondo box_titulo"><h1>REGISTRO</h1></td>
                            <td class="box_fondo_contenido box_ordenamiento">&nbsp;</td>
                            <td rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">
                                <?php $config = array('id' => 'formulario_registrar_usuario');
                                echo form_open(base_url().'usuario/registrar_usuario', $config); ?>
                                <table width="526" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="180" valign="top"><table width="180" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td valign="middle" align="center" style="padding-top:15px;padding-bottom:5px;"><img src="<?php echo base_url(); ?>resources/images/template/iconos/Comentario.gif" width="60" height="60" alt="Pregunta en el taller en línea" /></td>
                                                </tr>
                                                <tr>
                                                    <td width="180" valign="middle" align="center" style="padding-bottom:5px;padding-left:10px;padding-right:10px;"><h3>Preg&uacute;ntale a nuestra comunidad de expertos y resuelve cualquier duda sobre tu veh&iacute;culo</h3></td>
                                                </tr>
                                                <tr>
                                                    <td valign="middle" align="center" style="padding-top:10px;"><img src="<?php echo base_url(); ?>resources/images/template/iconos/Herramientas.gif" width="60" height="60" alt="Establecimientos" /></td>
                                                </tr>
                                                <tr>
                                                    <td valign="middle" align="center" style="padding-bottom:5px;padding-left:10px;padding-right:10px;"><h3>Cuéntanos tu experiencia con los establecimientos de venta de autopartes del pa&iacute;s</h3></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td width="346">
                                            <table width="346" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td colspan="2" height="10"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left" height="5"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><h3>Escoge tu nombre de usuario: (<strong id="usuario_registrarse_caracteres">50</strong> caracteres)</h3></td>
                                                    <td width="15">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" valign="middle" align="left" class="general_formulario_texto registro_formulario_texto"><input class="general_cuadro_texto" type="text" name="usuario_registrarse" id="usuario_registrarse" size="38" /></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left" height="10"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><h3>Digita tu correo electr&oacute;nico:</h3></td>
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
                                                    <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><h3>Escoge una contrase&ntilde;a:</h3></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><input class="general_cuadro_texto" type="password" name="contrasena_registrarse" id="contrasena_registrarse" size="38" /></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left" height="10"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><h3>Repite la contrase&ntilde;a:</h3></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><input class="general_cuadro_texto" type="password" name="contrasena2_registrarse" id="contrasena2_registrarse" size="38" /></td>
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
                                                    <td colspan="2" style="padding-top:10px;" class="general_formulario_texto registro_formulario_texto" align="center"><?php echo $captcha['image']; ?></td>
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
                                                    <td colspan="2" valign="top" align="left" style="padding-bottom:5px;" class="general_link"><h3>
                                                            <input type="checkbox" name="terminos_condiciones_registrarse" id="terminos_condiciones_registrarse" />
                                                            Acepto los <a href="<?php echo base_url()?>acerca/terminos_condiciones" target="_blank">T&eacute;rminos y Condiciones</a></h3></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td width="115">&nbsp;</td>
                                                    <td width="216" align="right" valign="top" style="padding-top:5px;padding-bottom:10px;"><input name="btn_registro" type="submit" class="general_boton_secundario" id="btn_registro" value="Registrarme" /></td>
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
                <td width="375" valign="top" class="box_fondo">
                    <?php echo form_open('usuario/validar_usuario'); ?>
                    <table width="374" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td width="136" class="box_fondo"></td>
                            <td width="210" class="box_borde_sup" ></td>
                            <td width="14" height="14" class="box_esquina_sup_der"></td>
                        </tr>
                        <tr>
                            <td height="22" class="box_fondo box_titulo"><h1>INICIAR SESI&Oacute;N</h1></td>
                            <td class="box_fondo_contenido">&nbsp;</td>
                            <td rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido"><table width="346" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="5" class="general_separador_transparente"></td>
                                    </tr>
                                    <tr>
                                        <td width="15">&nbsp;</td>
                                        <td width="90" align="right" class="general_formulario_texto " style="padding-bottom:5px;padding-top:10px;"><h3>E-mail:</h3></td>
                                        <td colspan="2" class="general_formulario_texto " align="right" style="padding-bottom:5px;padding-right:10px;padding-top:10px;"><input class="general_cuadro_texto" type="text" name="email" id="txt_email" size="25" /></td>
                                        <td width="15">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td class="general_formulario_texto " align="right" style="padding-bottom:10px;"><h3>Contrase&ntilde;a:</h3></td>
                                        <td colspan="2" class="general_formulario_texto " align="right" style="padding-bottom:10px;padding-right:10px;"><input class="general_cuadro_texto" type="password" name="contrasena" id="txt_password" size="25" /></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" valign="middle" align="left" style="padding-top:5px;padding-bottom:5px;">
                                        <td width="136" rowspan="2" align="right" valign="top" style="padding-top:5px;padding-bottom:5px;"><input name="btn_iniciar_sesion" type="submit" class="general_boton_secundario" id="btn_login" value="Iniciar sesi&oacute;n" /></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" class="general_link" valign="middle" align="left" style="padding-top:5px;padding-bottom:5px;"><h3><a href="<?php echo base_url().'usuario/formulario_olvido_contrasena'; ?>">Olvid&eacute; mi contrase&ntilde;a</a></h3></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="5"></td>
                                        <td></td>
                                        <td width="90"></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <?php echo form_close(); ?>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td height="14" class="box_esquina_inf_izq"></td>
                            <td colspan="2" class="box_borde_inf"></td>
                            <td class="box_esquina_inf_der"></td>
                        </tr>
                    </table>
                </td>
                <td width="20">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="5" class="general_separador_transparente"></td>
            </tr>
        </table>
    </td>
</tr>