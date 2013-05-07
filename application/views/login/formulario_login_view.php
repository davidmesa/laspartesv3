<tr>
    <td class="<?php if (!isset($navegacion_view)) {
    echo "borde_inferior";
} ?> formulario">
        <table>
            <tr>
                <td class="left">
                    <img src="<?php echo base_url(); ?>resources/images/micuenta/mecanico.gif" alt="Registro" style="float: left; padding-left: 20px;" />
                    <h3>
                        <span align="left" style="float: left;padding-left: 15px;">
                            NO TE PREOCUPES POR
                        </span>
                        <span class="grande" style="float: left;padding-left: 15px;">
                            EL MANTENIMIENTO
                        </span>
                        <span align="right" style="float: left;padding-left: 170px;">
                            DE TU CARRO
                        </span>
                    </h3>
                    <br/>
                    <p>
                        Crea un perfil para tu carro y nosotros te avisamos qu&eacute; debes tener en cuenta, cu&aacute;ndo tienes que hacerlo, y qui&eacute;nes pueden hacerte el adecuado mantenimiento.
                    </p>
                </td>
                <td class="right" valign="top">
                    <table><tr><th>Registrate con nostros</th></tr></table>
                    <table  border="0" cellspacing="0" cellpadding="0">
                        
                        <tr >


                            <td >
                                
                                <?php
                                if (!$this->session->userdata('esta_registrado')) {
                                    $show_login = true;
                                }
                                if (isset($show_login) && $show_login != false):
                                    $config = array('id' => 'formulario_ingresar_usuario');
                                    echo form_open(base_url() . 'usuario/validar_usuario', $config);
                                    ?>
                                    <div style="position: relative;">
                                        <table  border="0" cellspacing="0" cellpadding="0">
                                            <tbody>
                                                <tr>
                                                    <td width="90" align="right" style="padding-bottom:5px;padding-top:10px;">
                                                        <h3>E-mail:</h3>
                                                    </td>
                                                    <td align="right" style="padding-bottom:5px;padding-right:10px;padding-top:10px;">
                                                        <input class="general_cuadro_texto" type="text" name="email" id="txt_email" size="25">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="right" style="padding-bottom:10px;">
                                                        <h3>Contraseña:</h3>
                                                    </td>
                                                    <td align="right" style="padding-bottom:10px;padding-right:10px;"><input class="general_cuadro_texto" type="password" name="contrasena" id="txt_password" size="25"></td>
                                                </tr>
                                                <tr>
                                                    <td valign="middle" align="left" style="padding-top:5px;padding-bottom:5px;"></td>
                                                    <td rowspan="2" align="right" valign="top" style="padding-top:5px;padding-bottom:5px;padding-right:10px;">
                                                        <input name="btn_iniciar_sesion" type="submit" class="general_boton_secundario" id="btn_login" value="Iniciar sesión"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="general_link" valign="middle" align="left" style="padding-top:5px;padding-bottom:5px;">
                                                        <h3>
                                                            <a href="<?php echo base_url() . 'usuario/formulario_olvido_contrasena'; ?>">Olvidé mi contraseña</a>
                                                        </h3>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php
                                    echo form_close();
                                endif;
                                ?>
                            </td>
                        </tr>

                    </table>

                </td>
            </tr>
        </table>
    </td>
</tr>