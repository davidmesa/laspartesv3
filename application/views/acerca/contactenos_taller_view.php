<div id="home-div-content">
    <div id="novedades-div-banner">
        <div id="tallerlinea-div-banner-comunidad">
            <div id="tallerlinea-div-banner-comunidad-titulo">

                <h1 style="font-size: 30px; padding-top: 15px;">PARA NOSOTROS ES UN PLACER ATENDERTE</h1>
                <h1>Cuéntanos cómo podemos ayudarte</h1> 
            </div>  
        </div>
        <div class="clear"></div>
    </div>

    <div id="autopart-div-banner-bottom"></div>

    <div class="div-content">
        <div class="div-breadcrumb open-sans">
            <div style="color:white; background-color:black; font-weight:bold;">>></div>

            <?php echo $breadcrumb;?>
        </div>
        <div class="clear"></div>
        <div id="div-content-quienes somos">
            <div id="autopart-div-autopartes-titulo">
                <div id="autopart-div-titulo-icono">
                    <img style="margin-left: 30px;" src="<?php echo base_url(); ?>resources/images/novedades/novedad-icon.png" alt="icono autopartes" />
                </div>
                <div id="autopart-div-titulo">
                    <h1>
                        <span style="color: #C60200;">CONTACTENOS</span>
                    </h1>
                </div>

                <div class="clear"></div>
            </div>

            <div class="autopart-div-espaciador-rallas"></div>

            <div id="quienes-detalle-div">
                <div id="contactenos-detalle-div">
                    <?php $config = array('id' => 'formulario_contactenos');
                                echo form_open('acerca/contacto', $config); ?>
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="386"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td colspan="2" height="10"></td>
                                            <td width="5%"></td>
                                          </tr>
                                          <tr>
                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left" height="5"></td>
                                            <td></td>
                                          </tr>
                                          <tr>
                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><h3>Escribe tu nombre: </h3></td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><input class="general_cuadro_texto" type="text" name="nombre_contactenos" id="nombre_contactenos" size="38" /></td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><h3>Escribe tu correo electrónico:</h3></td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><input class="general_cuadro_texto" type="text" name="email_contactenos" id="email_contactenos" size="38" /></td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><h3>Escribe la razón para contactarnos:</h3></td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><select name="razon_contactenos" id="razon_contactenos">
                                              <option value="Registro" selected="selected">Soy un taller y quiero registrar mis productos</option>
                                              <option value="Sugerencia">Soy un taller y quiero hacer una sugerencia</option>
                                              <option value="Pauta">Soy un taller y me gustaría pautar con ustedes</option>
                                              <option value="Servicios">Soy un taller y me gustaría contar con un servicio específico</option>
                                              <option value="Error">Algo no funciona</option>
                                              <option value="Otra">Otros</option>
                                            </select></td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><h3>Escribe tu comentario:</h3></td>
                                            <td>&nbsp;</td>
                                          </tr>
                                          <tr>
                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><textarea class="general_textarea" name="comentarios_contactenos" id="comentarios_contactenos" rows="3" cols="20"></textarea></td>
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
                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><input class="general_cuadro_texto" type="text" name="captcha_contactenos" id="captcha_contactenos" size="38" /></td>
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
                                            <td colspan="3" class="general_separador_transparente"></td>
                                          </tr>
                                          <tr>
                                            <td width="10%">&nbsp;</td>
                                            <td width="85%" align="right" valign="top" style="padding-top:5px;padding-bottom:10px;"><input name="btn_contactar" type="submit" class="general_boton_secundario" id="btn_contactar" value="Enviar" /></td>
                                            <td>&nbsp;</td>
                                          </tr>
                                        </table></td>
                                    </tr>
                                </table>
                                <?php echo form_close(); ?>
                </div>

                <div id="quienes-detalle-div-content">

                    <div id="contacto-detalle-div-foto">
                        <img  src="<?php echo base_url();?>resources/images/acerca/contacto.png" alt="">
                        
                    </div>


                </div>

                <div class="clear"></div>
            </div>


        </div>



        <div class="clear"></div>
    </div>
</div>