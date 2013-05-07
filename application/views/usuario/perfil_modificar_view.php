<tr>
    <td>
        <table width="970" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="20">&nbsp;</td>
                <td width="605" valign="top" class="box_fondo">
                    <?php $config = array('id' => 'formulario_modificar_perfil');
                        echo form_open_multipart('usuario/modificar_perfil', $config); ?>
                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $usuario->id_usuario; ?>" />
                    <table width="605" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="15" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td width="141" class="box_fondo"></td>
                            <td width="435" class="box_borde_sup" ></td>
                            <td width="14" height="14" class="box_esquina_sup_der"></td>
                        </tr>
                        <tr>
                            <td height="22" class="box_fondo box_titulo"><h1>EDITAR PERFIL</h1></td>
                            <td class="box_fondo_contenido box_ordenamiento"><a href="<?php echo base_url(); ?>usuario/mi_cuenta">Volver a mi cuenta</a></td>
                            <td rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">
                                <table width="575" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="20" class="general_separador_transparente"></td>
                                        <td width="110"></td>
                                        <td width="112"></td>
                                        <td width="310"></td>
                                        <td width="23"></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="3">
                                            <table width="532" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="110" rowspan="4" valign="bottom" align="center"><img src="<?php if($usuario->imagen_thumb_url!=NULL || $usuario->imagen_thumb_url!='' ){ echo base_url().$usuario->imagen_thumb_url; } else { echo base_url().'resources/images/micuenta/tmpl_img_micuenta_vehiculo_nd.gif'; } ?>" width="99" height="99" alt="Foto Perfil" /></td>
                                                    <td align="left" width="422" style="padding-left:10px;padding-top:5px;"><h2>&nbsp;</h2></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="padding-left:10px;padding-top:5px;"><h2>&nbsp;</h2></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="padding-left:20px;padding-top:5px;padding-bottom:5px;" class="general_formulario_texto"><h2>Tu imagen:</h2></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="bottom" style="padding-bottom:5px;padding-left:20px;" class="general_formulario_texto">
                                                        <input type="text" id="txt_foto_usuario" class="general_cuadro_texto micuenta_input_textbox" readonly="readonly" size="35" />
                                                        <div class="micuenta_div_input">
                                                            &nbsp;<input type="button" value="Examinar..." class="micuenta_input_button general_boton_secundario" />
                                                            <input type="file" name="imagen" id="imagen" class="micuenta_input_hidden" onchange="document.getElementById('txt_foto_usuario').value = this.value;" />
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="general_separador_transparente"></td>
                                        <td colspan="3"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="general_formulario_texto" style="padding-bottom:5px;" align="right" ><h2>Nombres:</h2></td>
                                        <td class="general_formulario_texto" style="padding-bottom:5px;padding-left:5px;padding-top:10px;" align="left">
                                            <input class="general_cuadro_texto" type="text" name="nombres" id="nombres" size="34" value="<?php echo $usuario->nombres; ?>" />
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="general_formulario_texto" style="padding-bottom:5px;" align="right"><h2>Apelidos:</h2></td>
                                        <td class="general_formulario_texto" style="padding-bottom:5px;padding-left:5px;" align="left">
                                            <input class="general_cuadro_texto" type="text" name="apellidos" id="apellidos" size="34" value="<?php echo $usuario->apellidos; ?>"/>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="general_formulario_texto" style="padding-bottom:10px;" align="right"><h2>Lugar:</h2></td>
                                        <td class="general_formulario_texto" style="padding-bottom:10px;padding-left:5px;" align="left">
                                            <h2>
                                                <input class="general_cuadro_texto" type="text" name="lugar" id="lugar" size="34" value="<?php echo $usuario->lugar; ?>" />
                                            </h2></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="general_formulario_texto" style="padding-bottom:5px;" align="right"><h2>E-mail</h2></td>
                                        <td class="general_formulario_texto" style="padding-bottom:5px;padding-left:5px;" align="left">
                                            <input class="general_cuadro_texto" type="text" name="email" id="email" size="34" value="<?php echo $usuario->email; ?>" />
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="general_formulario_texto" style="padding-bottom:5px;" align="right"><h2>Verifica tu email:</h2></td>
                                        <td class="general_formulario_texto" style="padding-bottom:5px;padding-left:5px;" align="left">
                                            <input class="general_cuadro_texto" type="text" name="email2" id="email2" size="34" value="<?php echo $usuario->email; ?>" />
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="general_formulario_texto" style="padding-bottom:10px;" align="right"><h2>Usuario:</h2></td>
                                        <td class="general_formulario_texto" style="padding-bottom:10px;padding-left:5px;" align="left">
                                            <h2>
                                                <input class="general_cuadro_texto" type="text" name="usuario" id="usuario" size="34" value="<?php echo $usuario->usuario; ?>" />
                                            </h2></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="general_formulario_texto" style="padding-bottom:10px;" align="right"><h2>Contrase&ntilde;a:</h2></td>
                                        <td class="general_formulario_texto" style="padding-bottom:10px;padding-left:5px;" align="left">
                                            <h2>
                                                <input class="general_cuadro_texto" type="password" name="contrasena" id="contrasena" size="34" value="" />
                                            </h2></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="general_formulario_texto" style="padding-bottom:10px;" align="right"><h2>Verifica tu contrase&ntilde;a:</h2></td>
                                        <td class="general_formulario_texto" style="padding-bottom:10px;padding-left:5px;" align="left">
                                            <h2>
                                                <input class="general_cuadro_texto" type="password" name="contrasena2" id="contrasena2" size="34" value="" />
                                            </h2></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td colspan="2" style="padding-bottom:10px;padding-top:5px;" align="right">
                                            <input type="submit" class="general_boton_secundario" name="btn_agregar" id="btn_agregar" value="Modificar" />
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                                <?php echo form_close(); ?>
                            </td>
                        </tr>
                        <tr>
                            <td height="14" class="box_esquina_inf_izq"></td>
                            <td colspan="2" class="box_borde_inf"></td>
                            <td class="box_esquina_inf_der"></td>
                        </tr>
                    </table>
                </td>
                <td width="325" valign="top" class="box_fondo">
                    <table width="324" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td width="136" class="box_fondo"></td>
                            <td width="160" class="box_borde_sup" ></td>
                            <td width="14" height="14" class="box_esquina_sup_der"></td>
                        </tr>
                        <tr>
                            <td height="22" class="box_fondo box_titulo"><h1>PROMOCIONES</h1></td>
                            <td class="box_fondo_contenido">&nbsp;</td>
                            <td rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">&nbsp;</td>
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