<tr>
    <td>
        <table width="970" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>&nbsp;</td>
                <td colspan="2" valign="top" class="box_fondo">
                    <table width="930" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td class="box_fondo"></td>
                            <td class="box_borde_sup" ></td>
                            <td class="box_esquina_sup_der" height="14"></td>
                        </tr>
                        <tr>
                            <td width="106" height="22" class="box_fondo box_titulo"><h1>NOTICIAS</h1></td>
                            <td width="796" class="box_fondo_contenido">&nbsp;</td>
                            <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">
                                <table width="901" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="20">&nbsp;</td>
                                        <td  class="tallerenlinea_texto_pregunta" align="left" style="padding-top:10px;"><strong><?php echo $noticia->titulo; ?></strong></td>
                                        <td align="right">
                                            <table width="200">
                                                <tr>
                                                    <td align="right" valign="top"><div class="fb-like" data-send="true" data-layout="box_count" data-width="45" data-show-faces="true"></div></td>
                                                    <td align="right" valign="top"><a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php echo $noticia->titulo; ?> via @laspartes" data-count="vertical" data-lang="es">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script></td>
                                                    
                                                    <td align="right" valign="top"><g:plusone size="tall"></g:plusone></td>
                                                </tr>
                                            </table>

                                        </td>
                                        <td width="60" align="right">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" class="general_texto_secundario" align="left" style="padding-bottom:10px;padding-top:5px;"><h3><strong>Publicada hace</strong> <strong><?php echo relative_time($noticia->fecha); ?></strong></h3></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td width="861" colspan="2" align="left" style="padding-bottom:5px;line-height:1.5;" class="general_borde_inferior"><?php if($noticia->imagen_url!='' && $noticia->imagen_url!=NULL){ ?><img class="floatLeft" src="<?php echo base_url().$noticia->imagen_url; ?>" alt="<?php echo $noticia->titulo; ?>" /><?php } ?><h2 class="general_link"><?php echo $noticia->noticia; ?></h2><br />
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" align="center">
                                            <table width="860" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <?php if(!$this->session->userdata('esta_registrado')){ ?>
                                                        <td width="51"><a href="#registro-me-gusta" title="Registro o Inicio de Sesión" class="general_btn_megusta registro-me-gusta"><span>Me gusta</span></a></td>
                                                        <td width="145" align="left" valign="middle" class="general_link"><h4><a href="#registro-me-gusta" title="Registro o Inicio de Sesión" class="registro-me-gusta">Me gusta esta noticia</a></h4></td>
                                                        <td width="51"><a href="#registro-me-gusta" title="Registro o Inicio de Sesión" class="general_btn_nomegusta registro-me-gusta"><span>No me gusta</span></a></td>
                                                        <td width="160" class="general_link" align="left" valign="middle"><h4><a href="#registro-me-gusta" title="Registro o Inicio de Sesión" class="registro-me-gusta">No me gusta esta noticia</a></h4></td>
                                                        <td width="129" >&nbsp;</td>
                                                        <td width="324" align="right">
                                                            <h4>A <strong><?php echo $noticia->me_gusta; ?></strong> personas les gusta esta noticia</h4>
                                                            <h4>A <strong><?php echo $noticia->no_me_gusta; ?></strong> personas no les gusta esta noticia</h4>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td class="me-gusta-decidir" <?php if($usuario_le_gusta != NULL){ ?>style="display: none"<?php } ?> width="51"><a onclick="me_gusta(<?php echo $noticia->id_noticia; ?>)" class="general_btn_megusta" title="Me gusta"><span>Me gusta</span></a></td>
                                                        <td class="me-gusta-decidir" <?php if($usuario_le_gusta != NULL){ ?>style="display: none"<?php } ?> width="113" align="left" valign="middle" class="general_link"><h4><a onclick="me_gusta(<?php echo $noticia->id_noticia; ?>)">Me gusta esta noticia</a></h4></td>
                                                        <td class="me-gusta-decidir" <?php if($usuario_le_gusta != NULL){ ?>style="display: none"<?php } ?> width="51"><a onclick="no_me_gusta(<?php echo $noticia->id_noticia; ?>)" class="general_btn_nomegusta" title="No me gusta"><span>No me gusta</span></a></td>
                                                        <td class="me-gusta-decidir" <?php if($usuario_le_gusta != NULL){ ?>style="display: none"<?php } ?> width="120" class="general_link" align="left" valign="middle"><h4><a onclick="no_me_gusta(<?php echo $noticia->id_noticia; ?>)">No me gusta esta noticia</a></h4></td>

                                                        <td class="me-gusta-decision" <?php if($usuario_le_gusta==NULL || $usuario_le_gusta==0){ ?>style="display: none"<?php } ?> width="60" align="center" valign="middle"><img src="<?php echo base_url(); ?>resources/images/botones/megusta.gif" width="28" height="28" alt="Me gusta" /></td>
                                                        <td class="me-gusta-decision" <?php if($usuario_le_gusta==NULL || $usuario_le_gusta==0){ ?>style="display: none"<?php } ?> width="200" align="left" valign="middle" class="general_link"><h4>Me gusta esta noticia</h4></td>
                                                        <td class="me-gusta-decision" <?php if($usuario_le_gusta==NULL || $usuario_le_gusta==0){ ?>style="display: none"<?php } ?> width="75" class="general_link" align="left" valign="middle"><h4></h4></td>

                                                        <td class="no-me-gusta-decision" <?php if($usuario_le_gusta==NULL || $usuario_le_gusta==1){ ?>style="display: none"<?php } ?> width="60" align="center" valign="middle"><img src="<?php echo base_url(); ?>resources/images/botones/nomegusta.gif" width="28" height="28" alt="Me gusta" /></td>
                                                        <td class="no-me-gusta-decision" <?php if($usuario_le_gusta==NULL || $usuario_le_gusta==1){ ?>style="display: none"<?php } ?> width="200" align="left" valign="middle" class="general_link"><h4>No me gusta esta noticia</h4></td>
                                                        <td class="no-me-gusta-decision" <?php if($usuario_le_gusta==NULL || $usuario_le_gusta==1){ ?>style="display: none"<?php } ?> width="75" class="general_link" align="left" valign="middle"><h4></h4></td>
                                                        <td width="129" >&nbsp;</td>
                                                        <td width="324" align="right">
                                                            <h4>A <strong id="me-gusta-cantidad"><?php echo $noticia->me_gusta; ?></strong> personas les gusta esta noticia</h4>
                                                            <h4>A <strong id="no-me-gusta-cantidad"><?php echo $noticia->no_me_gusta; ?></strong> personas no les gusta esta noticia</h4>
                                                        </td>
                                                    <?php } ?>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" align="right" class="general_link" style="padding-bottom:10px;"><h4><a id="link-reportar-abuso-<?php $noticia->id_noticia; ?>" class="link-reportar-abuso" href="<?php echo base_url().'usuario/formulario_reportar_abuso_ajax/aprende/noticia/'.$noticia->id_noticia; ?>">Reportar abuso</a></h4></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" align="left" class="general_link" style="padding-left:10px;padding-bottom:10px;"><h4>¿Le gustaría publicar una noticia en nuestra comunidad? <span style="font-size:14px;"><a href="#publicar-noticia" id="publicar-noticia-link">Haga click aquí</a></span></h4></td>
                                        <td>&nbsp;</td>
                                    </tr>
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
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td width="20">&nbsp;</td>
                <td width="554" valign="top" class="box_fondo">
                    <table width="554" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td class="box_fondo"></td>
                            <td class="box_borde_sup" ></td>
                            <td class="box_esquina_sup_der" height="14"></td>
                        </tr>
                        <tr>
                            <td width="134" height="22" class="box_fondo box_titulo"><h1>COMENTARIOS</h1></td>
                            <td width="392" class="box_fondo_contenido">&nbsp;</td>
                            <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">
                                <table width="526" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="6" class="general_separador_transparente"></td>
                                    </tr>
                                     <?php $config = array('id' => 'formulario_agregar_comentario');
                                        echo form_open('aprende/agregar_noticia_comentario', $config); ?>
                                    <input type="hidden" name="id_noticia" value="<?php echo $noticia->id_noticia; ?>" />
                                    <tr id="tr-formulario-agregar-comentario">
                                        <td>&nbsp;</td>
                                        <td colspan="4">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="3%" class="general_formulario_texto">&nbsp;</td>
                                                    <td width="95%" align="left" style="padding:5px;" class="general_formulario_texto"><h3>Escriba su comentario:</h3></td>
                                                    <td width="2%" class="general_formulario_texto">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td class="general_formulario_texto">&nbsp;</td>
                                                    <td class="general_formulario_texto" style="padding-bottom:10px;"><textarea class="general_textarea" name="comentario" id="comentario" rows="8" cols="50"></textarea></td>
                                                    <td class="general_formulario_texto">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="general_link" style="padding-bottom:10px;padding-top:5px;" align="right" >
                                            <?php if($this->session->userdata('esta_registrado')){ ?>
                                                <input type="submit" class="general_boton_secundario" name="btn_comentar2" id="btn_comentar2" value="Comentar" />
                                            <?php } else { ?>
                                                <a id="registro-comentario-id" href="#registro-comentario" title="Registro o Inicio de Sesión"><input type="submit" class="general_boton_secundario" name="btn_comentar2" onclick="agregar_comentario_sin_sesion()" id="btn_comentar2" value="Comentar" /></a>
                                            <?php } ?>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <?php echo form_close(); ?>
                                    <tr>
                                        <td width="15"></td>
                                        <td colspan="4" class="general_separador_transparente_borde_sup2"></td>
                                        <td width="15"></td>
                                    </tr>
                                    <?php if(sizeof($comentarios)!=0){
                                        foreach($comentarios as $comentario){ ?>
                                    <tr id="comentario-<?php echo $comentario->id_noticia_comentario; ?>">
                                        <td width="15">&nbsp;</td>
                                        <td width="85" rowspan="2" align="left" valign="top"><a href="#"><img src="<?php if($comentario->imagen_thumb_url!='' && $comentario->imagen_thumb_url!=NULL){ echo base_url().$comentario->imagen_thumb_url; } else { echo base_url().'resources/images/usuarios/avatar_thumb.gif'; } ?>" width="63" height="70" alt="Foto usuario" /></a></td>
                                        <td colspan="3" class="general_link general_texto_secundario" align="left" ><h3>Comentario de <a href="#"><?php echo $comentario->usuario; ?></a> el <strong><?php echo real_date($comentario->fecha); ?></strong></h3></td>
                                        <td width="15">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="3" style="padding-top:10px;padding-bottom:5px;padding-right:10px;" align="left"><h2><?php echo $comentario->comentario; ?></h2></td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td width="161">&nbsp;</td>
                                        <td colspan="2" align="right" class="general_link" style="padding:5px;"><h4><a id="link-reportar-abuso-<?php $comentario->id_noticia_comentario; ?>" class="link-reportar-abuso" href="<?php echo base_url().'usuario/formulario_reportar_abuso_ajax/aprende/comentario_noticia/'.$comentario->id_noticia_comentario; ?>">Reportar abuso</a></h4></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="4" class="general_separador_transparente_borde_sup"></td>
                                        <td></td>
                                    </tr>
                                    <?php }
                                    } ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="general_link" style="padding-bottom:10px;padding-top:5px;" align="right" >
                                            <a href="#" onclick="$.scrollTo('#tr-formulario-agregar-comentario', 800); return false;"><input type="submit" class="general_boton_secundario" name="btn_comentar2" id="comentar-ir" value="Comentar" /></a>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
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
                <td width="376" valign="top" class="box_fondo">
                    <table width="376" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td class="box_fondo"></td>
                            <td class="box_borde_sup" ></td>
                            <td class="box_esquina_sup_der" height="14"></td>
                        </tr>
                        <tr>
                            <td width="141" height="22" class="box_fondo box_titulo"><h1>MÁS NOTICIAS</h1></td>
                            <td width="207" class="box_fondo_contenido">&nbsp;</td>
                            <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">
                                <table width="346" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="20" class="general_separador_transparente"></td>
                                        <td width="306" class="general_separador_transparente"></td>
                                        <td width="20" class="general_separador_transparente"></td>
                                    </tr>
                                    <?php if(sizeof($noticias)!=0){
                                        foreach($noticias as $otra_noticia){ ?>
                                    <tr>
                                        <td class="general_link " align="left">&nbsp;</td>
                                        <td class="general_link " align="left"><h2><a href="<?php echo base_url(); ?>aprende/noticia/<?php echo $otra_noticia->id_noticia; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($otra_noticia->titulo)); ?>"><?php echo $otra_noticia->titulo; ?></a></h2></td>
                                        <td class="general_link " align="left">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="left" class=" general_texto_secundario">&nbsp;</td>
                                        <td align="right" class=" general_texto_secundario"><h4><strong>Publicada hace <?php echo relative_time($otra_noticia->fecha); ?></strong></h4></td>
                                        <td align="left" class=" general_texto_secundario">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="" align="right">&nbsp;</td>
                                        <td class="" align="right" style="padding-bottom:10px;"><h4><img src="<?php echo base_url(); ?>resources/images/iconos/megusta.gif" width="20" height="20" alt="Me gusta" /> A <strong><?php echo $otra_noticia->me_gusta; ?></strong> personas les gusta</h4></td>
                                        <td class="" align="right">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="general_separador_transparente"></td>
                                        <td class="general_separador_transparente_borde_sup2"></td>
                                        <td ></td>
                                    </tr>
                                    <?php }
                                    } ?>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td height="14" class="box_esquina_inf_izq"></td>
                            <td colspan="2" class="box_borde_inf"></td>
                            <td class="box_esquina_inf_der"></td>
                        </tr>
                    </table>
                    
                    <table width="376" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td class="box_fondo"></td>
                            <td class="box_borde_sup" ></td>
                            <td class="box_esquina_sup_der" height="14"></td>
                        </tr>
                        <tr>
                            <td width="141" height="22" class="box_fondo box_titulo"><h1>RECOMENDACIONES</h1></td>
                            <td width="207" class="box_fondo_contenido">&nbsp;</td>
                            <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">
                                <table width="346" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="20" class="general_separador_transparente"></td>
                                        <td width="306" class="general_separador_transparente">
                                            <div class="fb-recommendations" data-site="www.laspartes.com" data-width="306" data-height="300" data-header="false"></div>
                                        </td>
                                        <td width="20" class="general_separador_transparente"></td>
                                    </tr>
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

<?php if(!$this->session->userdata('esta_registrado')){ ?>
<tr style="display: none;">
    <td>
        <div id="registro-comentario">
            <table width="761" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td colspan="2" valign="top" class="box_fondo" align="center" >
                        <table width="751" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="box_fondo">&nbsp;</td>
                                <td class="box_borde_sup" height="14"></td>
                                <td class="box_esquina_sup_der">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="14" class="box_borde_izq">&nbsp;</td>
                                <td width="713" class="box_fondo_contenido" align="center" style="padding:5px;"><h2>Debes registrarte para poder hacer esto. Si ya lo has hecho, inicia sesión con tus datos de registro.</h2></td>
                                <td width="14" class="box_borde_der">&nbsp;</td>
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
                    <td width="388" valign="top" class="box_fondo">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                                <td width="190" class="box_fondo"></td>
                                <td width="172" class="box_borde_sup" ></td>
                                <td width="13" height="14" class="box_esquina_sup_der"></td>
                            </tr>
                            <tr>
                                <td height="22" class="box_fondo box_titulo"><h1>REGISTRO</h1></td>
                                <td class="box_fondo_contenido box_ordenamiento">&nbsp;</td>
                                <td rowspan="2" class="box_borde_der">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="box_borde_izq">&nbsp;</td>
                                <td colspan="2" class="box_fondo_contenido">
                                    <?php $config = array('id' => 'formulario_agregar_comentario_registrarse');
                                    echo form_open('aprende/agregar_noticia_comentario_registrarse', $config); ?>
                                    <input type="hidden" name="id_noticia_registrarse" id="id_noticia_registrarse" value="<?php echo $noticia->id_noticia; ?>" />
                                    <input type="hidden" name="comentario_registrarse" id="comentario_registrarse" value="" />
                                        <table width="360" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="15" valign="top">&nbsp;</td>
                                                <td width="345"><table width="346" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td colspan="2" height="10"></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left" height="5"></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><h3>Nombre:</h3></td>
                                                            <td width="15">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" valign="middle" align="left" class="general_formulario_texto registro_formulario_texto"><input class="general_cuadro_texto registrarse" type="text" name="nombre_registrarse" id="nombre_registrarse" size="38" /></td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><h3>Apellidos:</h3></td>
                                                            <td width="15">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" valign="middle" align="left" class="general_formulario_texto registro_formulario_texto"><input class="general_cuadro_texto registrarse" type="text" name="apellidos_registrarse" id="apellidos_registrarse" size="38" /></td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><h3>Escoge tu ciudad de residencia:</h3></td>
                                                            <td width="15">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" valign="middle" align="left" class="general_formulario_texto registro_formulario_texto">
<?php
$option_ciudades = array();
$selected = false;
$ciudades = array("Aguachica", "Apartadó", "Arauca", "Arjona", "Armenia", "Barrancabermeja", "Barranquilla", "Bello", "Bogotá", "Bucaramanga", "Buenaventura", "Calarcá", "Caldas", "Cali", "Candelaria", "Carmen de Bolívar", "Cartagena de indias", "Cartago", "Caucasia", "Cereté", "Chía", "Chigorodó", "Chiquinquirá", "Ciénaga", "Copacabana", "Dosquebradas", "Duitama", "Envigado", "Espinal", "Facatativa", "Florencia", "Floridablanca", "Fundación", "Funza", "Fusagasugá", "Garzón", "Girardot", "Guadalajara de Buga", "Ibagué", "Ipiales", "Itagüi", "Jamundí", "La Dorada", "Los Patios", "Madrid", "Magangué", "Maicao", "Malambo", "Manizales", "Medellín", "Montelíbano", "Monteria", "Mosquera", "Neiva", "Ocaña", "Palmira", "Pamplona", "Pasto", "Pereira", "Piedecuesta", "Pitalito", "Planeta Rica", "Popayán", "Quibdó", "Riohacha", "Rionegro", "Sabanalarga", "Sahagun", "San Andrés", "San Andrés de Sotavento", "San Andrés de Tumaco", "San José de Cúcuta", "San Juan de Girón", "Santa Cruz de Lorica", "Santa Marta", "Santa Rosa de Cabal", "Santander de Quilichao", "Sincelejo", "Soacha", "Sogamoso", "Soledad", "Tierralta", "Tuluá", "Tunja", "Turbaco", "Valledupar", "Villa del Rosario", "Villavicencio", "Yopal", "Yumbo", "Zipaquirá");
foreach($ciudades as $ciudad){
	if( $ciudad != 'default'){
		$option_ciudades[$ciudad] = $ciudad;
		if(!$selected){
			$selected = $ciudad;
		}
	}
}
echo form_dropdown('ciudad_registrarse', $option_ciudades, $selected);//, 'id="marca_registrarse"');
?>
                                                            </td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><h3>Escoge tu nombre de usuario: (50 caracteres)</h3></td>
                                                            <td width="15">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" valign="middle" align="left" class="general_formulario_texto registro_formulario_texto"><input class="general_cuadro_texto registrarse" type="text" name="usuario_registrarse" id="usuario_registrarse" size="38" /></td>
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
                                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><input class="general_cuadro_texto registrarse" type="text" name="email_registrarse" id="email_registrarse" size="38" /></td>
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
                                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><input class="general_cuadro_texto registrarse" type="password" name="contrasena_registrarse"  id="contrasena_registrarse" size="38" /></td>
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
                                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><input class="general_cuadro_texto registrarse" type="password" name="contrasena2_registrarse" id="contrasena2_registrarse" size="38" /></td>
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
                                                                    <input type="checkbox" name="terminos_condiciones_registrarse" id="terminos_condiciones_registrarse" class="registrarse" />
                                                                    Acepto los <a href="<?php echo base_url()?>acerca/terminos_condiciones" target="_blank">T&eacute;rminos y Condiciones</a></h3></td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="115">&nbsp;</td>
                                                            <td width="216" align="right" valign="top" style="padding-top:5px;padding-bottom:10px;"><input name="registrarse" id="registrarse" type="submit" class="general_boton_secundario" value="Registrarme" /></td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
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
                    <td width="373" valign="top" class="box_fondo">
                        <?php $config = array('id' => 'formulario_agregar_comentario_ingresar');
                        echo form_open('aprende/agregar_noticia_comentario_ingresar', $config); ?>
                        <input type="hidden" name="id_noticia_ingresar" id="id_noticia_ingresar" value="<?php echo $noticia->id_noticia; ?>" />
                        <input type="hidden" name="comentario_ingresar" id="comentario_ingresar" value="" />
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
                                    <td colspan="2" class="box_fondo_contenido">
                                        <table width="346" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td colspan="5" class="general_separador_transparente"></td>
                                            </tr>
                                            <tr>
                                                <td width="15">&nbsp;</td>
                                                <td width="90" align="right" class="general_formulario_texto " style="padding-bottom:5px;padding-top:10px;"><h3>E-mail:</h3></td>
                                                <td colspan="2" class="general_formulario_texto " align="right" style="padding-bottom:5px;padding-right:10px;padding-top:10px;"><input class="general_cuadro_texto ingresar" type="text" name="email_ingresar" id="email_ingresar" size="25" /></td>
                                                <td width="15">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td class="general_formulario_texto " align="right" style="padding-bottom:10px;"><h3>Contrase&ntilde;a:</h3></td>
                                                <td colspan="2" class="general_formulario_texto " align="right" style="padding-bottom:10px;padding-right:10px;"><input class="general_cuadro_texto ingresar" type="password" name="contrasena_ingresar" id="contrasena_ingresar" size="25" /></td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td colspan="2" valign="middle" align="left" style="padding-top:5px;padding-bottom:5px;"><h3>
                                                        <input class="general_checkbox" type="checkbox" name="chk_recordarme" id="chk_recordarme" />
                                                        No cerrar sesi&oacute;n</h3></td>
                                                <td width="136" rowspan="2" align="right" valign="top" style="padding-top:5px;padding-bottom:5px;"><input type="submit" class="general_boton_secundario" name="ingresar" id="ingresar" value="Iniciar sesión" /></td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td colspan="2" class="general_link" valign="middle" align="left" style="padding-top:5px;padding-bottom:5px;"><h3><a href="#">Olvid&eacute; mi contrase&ntilde;a</a></h3></td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td height="5"></td>
                                                <td></td>
                                                <td width="90"></td>
                                                <td></td>
                                                <td></td>
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
                </tr>
            </table>
        </div>
    </td>
</tr>

<tr style="display: none;">
    <td>
        <div id="registro-me-gusta">
            <table width="761" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td colspan="2" valign="top" class="box_fondo" align="center" >
                        <table width="751" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="box_fondo">&nbsp;</td>
                                <td class="box_borde_sup" height="14"></td>
                                <td class="box_esquina_sup_der">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="14" class="box_borde_izq">&nbsp;</td>
                                <td width="713" class="box_fondo_contenido" align="center" style="padding:5px;"><h2>Debes registrarte para poder hacer esto. Si ya lo has hecho, inicia sesión con tus datos de registro.</h2></td>
                                <td width="14" class="box_borde_der">&nbsp;</td>
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
                    <td width="388" valign="top" class="box_fondo">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                                <td width="190" class="box_fondo"></td>
                                <td width="172" class="box_borde_sup" ></td>
                                <td width="13" height="14" class="box_esquina_sup_der"></td>
                            </tr>
                            <tr>
                                <td height="22" class="box_fondo box_titulo"><h1>REGISTRO</h1></td>
                                <td class="box_fondo_contenido box_ordenamiento">&nbsp;</td>
                                <td rowspan="2" class="box_borde_der">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="box_borde_izq">&nbsp;</td>
                                <td colspan="2" class="box_fondo_contenido">
                                    <?php $config = array('id' => 'formulario_registrarse');
                                    echo form_open('', $config); ?>
                                        <table width="360" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="15" valign="top">&nbsp;</td>
                                                <td width="345">
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
                                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><h3>Escoge tu nombre de usuario: (50 caracteres)</h3></td>
                                                            <td width="15">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" valign="middle" align="left" class="general_formulario_texto registro_formulario_texto"><input class="general_cuadro_texto registrarse" type="text" name="usuario_registrarse_reload" id="usuario_registrarse_reload" size="38" /></td>
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
                                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><input class="general_cuadro_texto registrarse" type="text" name="email_registrarse_reload" id="email_registrarse_reload" size="38" /></td>
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
                                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><input class="general_cuadro_texto registrarse" type="password" name="contrasena_registrarse_reload"  id="contrasena_registrarse_reload" size="38" /></td>
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
                                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><input class="general_cuadro_texto registrarse" type="password" name="contrasena2_registrarse_reload" id="contrasena2_registrarse_reload" size="38" /></td>
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
                                                                    <input type="checkbox" name="terminos_condiciones_registrarse_reload" id="terminos_condiciones_registrarse_reload" class="registrarse" />
                                                                    Acepto los <a href="<?php echo base_url()?>acerca/terminos_condiciones" target="_blank">T&eacute;rminos y Condiciones</a></h3></td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="115">&nbsp;</td>
                                                            <td width="216" align="right" valign="top" style="padding-top:5px;padding-bottom:10px;"><input name="registrarse_reload" id="registrarse_reload" type="submit" class="general_boton_secundario" value="Registrarme" /></td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
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
                    <td width="373" valign="top" class="box_fondo">
                        <?php $config = array('id' => 'formulario_ingresar');
                        echo form_open('', $config); ?>
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
                                    <td colspan="2" class="box_fondo_contenido">
                                        <table width="346" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td colspan="5" class="general_separador_transparente"></td>
                                            </tr>
                                            <tr>
                                                <td width="15">&nbsp;</td>
                                                <td width="90" align="right" class="general_formulario_texto " style="padding-bottom:5px;padding-top:10px;"><h3>E-mail:</h3></td>
                                                <td colspan="2" class="general_formulario_texto " align="right" style="padding-bottom:5px;padding-right:10px;padding-top:10px;"><input class="general_cuadro_texto ingresar" type="text" name="email_ingresar_reload" id="email_ingresar_reload" size="25" /></td>
                                                <td width="15">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td class="general_formulario_texto " align="right" style="padding-bottom:10px;"><h3>Contrase&ntilde;a:</h3></td>
                                                <td colspan="2" class="general_formulario_texto " align="right" style="padding-bottom:10px;padding-right:10px;"><input class="general_cuadro_texto ingresar" type="password" name="contrasena_ingresar_reload" id="contrasena_ingresar_reload" size="25" /></td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td colspan="2" valign="middle" align="left" style="padding-top:5px;padding-bottom:5px;"><h3>
                                                        <input class="general_checkbox" type="checkbox" name="chk_recordarme" id="chk_recordarme" />
                                                        No cerrar sesi&oacute;n</h3></td>
                                                <td width="136" rowspan="2" align="right" valign="top" style="padding-top:5px;padding-bottom:5px;"><input type="submit" class="general_boton_secundario" name="ingresar_reload" id="ingresar_reload" value="Iniciar sesión" /></td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td colspan="2" class="general_link" valign="middle" align="left" style="padding-top:5px;padding-bottom:5px;"><h3><a href="#">Olvid&eacute; mi contrase&ntilde;a</a></h3></td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td height="5"></td>
                                                <td></td>
                                                <td width="90"></td>
                                                <td></td>
                                                <td></td>
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
                </tr>
            </table>
        </div>
    </td>
</tr>
<?php } ?>

<tr style="display: none;">
    <td>
        <div id="publicar-noticia" align="center">
            <table width="600" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td valign="top" class="box_fondo" align="center">
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="box_fondo" width="14">&nbsp;</td>
                                <td class="box_borde_sup" height="14" width="572"></td>
                                <td class="box_esquina_sup_der" width="14">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="box_borde_izq">&nbsp;</td>
                                <td class="box_fondo_contenido" align="left" style="padding:10px;"><h2>¿Tiene alguna noticia o historia que quiera contar en nuestra comunidad? Cuéntenos de qué se trata. Su dirección electrónica (e-mail) la necesitamos para darle el reconocimiento respectivo, o para pedirle más información, en el caso de publicar la noticia.</h2></td>
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
                                <td width="160" class="box_fondo"></td>
                                <td width="412" class="box_borde_sup" ></td>
                                <td height="14" class="box_esquina_sup_der" width="14"></td>
                            </tr>
                            <tr>
                                <td height="22" class="box_fondo box_titulo"><h1>PUBLICAR NOTICIA</h1></td>
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
                                        <?php $config = array('id' => 'formulario_publicar_noticia');
                                        echo form_open('aprende/publicar_noticia', $config); ?>
                                        <input type="hidden" name="id_noticia_publicar_noticia" value="<?php echo $noticia->id_noticia; ?>" />
                                        <tr>
                                            <td width="15" class="general_separador_transparente"></td>
                                            <td width="71"></td>
                                            <td width="470"></td>
                                            <td width="15"></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td colspan="2" class="general_formulario_texto" style="padding-left:18px;padding-right:15px;padding-top:10px;"><h2>E-mail:</h2></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td colspan="2" align="left" valign="middle" class="general_formulario_texto" style="padding-bottom:1px;padding-left:15px;padding-right:15px;">
                                                <input class="general_cuadro_texto" type="text" name="email_publicar_noticia" id="email_publicar_noticia" size="67" />
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td colspan="2" class="general_formulario_texto" style="padding-left:15px;padding-top:10px;"><h2>Noticia: </h2></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td colspan="2" class="general_formulario_texto" style="padding-bottom:15px;padding-left:15px;padding-right:15px;">

                                                <textarea class="general_textarea" name="noticia_publicar_noticia" id="noticia_publicar_noticia" rows="8" cols="50"></textarea>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td >&nbsp;</td>
                                            <td colspan="2" align="right" style="padding-bottom:10px;padding-top:10px;"><span class="establecimiento_comentarios_boton_form">
                                                    <input type="submit" class="general_boton_secundario" name="btn_enviar" id="btn_enviar" value="Enviar" />
                                                </span></td>
                                            <td></td>
                                        </tr>
                                        <?php echo form_close(); ?>
                                    </table>
                                </td>
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
        </div>
    </td>
</tr>