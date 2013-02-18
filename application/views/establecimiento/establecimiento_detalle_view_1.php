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
                      <td height="22" class="box_fondo box_titulo"><h1>FICHA ESTABLECIMIENTO</h1></td>
                      <td class="box_fondo_contenido box_ordenamiento">&nbsp;</td>
                      <td rowspan="2" class="box_borde_der">&nbsp;</td>
                      </tr>
                    <tr>
                      <td class="box_borde_izq">&nbsp;</td>
                      <td colspan="2" class="box_fondo_contenido"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td colspan="8" class="general_separador_transparente"></td>
                          </tr>
                        <tr>
                          <td width="2%">&nbsp;</td>
                          <td width="2%" class="titulo_fondo_izq">&nbsp;</td>
                          <td colspan="4" class="titulo_fondo"><h2><?php echo $establecimiento->nombre; ?></h2></td>
                          <td width="2%" class="titulo_fondo_der">&nbsp;</td>
                          <td width="2%">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="8" class="general_separador_transparente"></td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="67%" align="center">
                                  <img src="<?php if($establecimiento->logo_url!=NULL && $establecimiento->logo_url!=''){ echo base_url().$establecimiento->logo_url; } else { echo base_url().'resources/images/establecimientos/tmpl_logo_establecimiento_nd.gif'; } ?>" alt="<?php echo $establecimiento->nombre; ?>" />
                              </td>
                              <td width="33%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="38%"><img src="<?php echo base_url(); ?>resources/images/iconos/contacto_est.png" width="65" height="66" alt="Contactar establecimiento" /></td>
                              <td width="62%" align="center" valign="middle" class="general_link">
                                  <h4><a id="contactar-establecimiento-id" href="#contactar-establecimiento" title="Contactar al establecimiento">Contactar al establecimiento</a></h4>
                              </td>
                            </tr>
                            <tr>
                              <td><img src="<?php echo base_url(); ?>resources/images/iconos/calificar_est.png" width="65" height="66" alt="Calificar establecimiento" /></td>
                              <td class="general_link" align="center" valign="middle"><h4><a href="#" onclick="$.scrollTo('#comentario-calificacion', 800); return false;">Calificar establecimiento</a></h4></td>
                            </tr>
                          </table></td>
                            </tr>
                          </table></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="8" class="general_separador_transparente"></td>
                          </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td width="28%" class="box_fondo establecimiento_texto_ficha"><h4 ><strong>Descripción:</strong></h4></td>
                          <td width="1%">&nbsp;</td>
                          <td colspan="2" class="box_fondo establecimiento_texto_ficha"><h4><?php echo $establecimiento->descripcion; ?></h4></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td class="establecimiento_texto_ficha"><h4><strong>Dirección:</strong></h4></td>
                          <td>&nbsp;</td>
                          <td colspan="2" class="establecimiento_texto_ficha"><h4><?php echo $establecimiento->direccion; ?></h4></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td  class="box_fondo establecimiento_texto_ficha"><h4><strong>Teléfonos / Fax:</strong></h4></td>
                          <td>&nbsp;</td>
                          <td class="box_fondo establecimiento_texto_ficha" colspan="2" ><h4><?php echo $establecimiento->telefonos; ?> / <?php echo $establecimiento->faxes; ?></h4></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td class="establecimiento_texto_ficha"><h4><strong>Horario:</strong></h4></td>
                          <td>&nbsp;</td>
                          <td colspan="2" class="establecimiento_texto_ficha"><h4><?php echo $establecimiento->horario; ?></h4></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td class="box_fondo establecimiento_texto_ficha"><h4><strong>Sitio web:</strong></h4></td>
                          <td>&nbsp;</td>
                          <td colspan="2" class="box_fondo establecimiento_texto_ficha general_link"><h4><a target="_blank" href="http://<?php echo $establecimiento->web; ?>"><?php echo $establecimiento->web; ?></a></h4></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td class="establecimiento_texto_ficha"><h4 ><strong>Servicios:</strong></h4></td>
                          <td>&nbsp;</td>
                          <td  class="establecimiento_texto_ficha" colspan="2"> <h4>
                                <?php if(sizeof($establecimiento_servicios)!=0){
                                    foreach($establecimiento_servicios as $servicio){
                                        echo $servicio->nombre.' &nbsp; ';
                                    }
                                } ?>

                              </h4></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td class="box_fondo establecimiento_texto_ficha"><h4><strong>Calificación usuarios:</strong></h4></td>
                          <td>&nbsp;</td>
                          <td colspan="2" class="box_fondo establecimiento_texto_ficha"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="28%"><h4>
                                    <?php if($establecimiento_calificacion->promedio==''){ ?>
                                        Sin calificación
                                    <?php } else {
                                        $promedio_explicacion = '';
                                        $promedio = round($establecimiento_calificacion->promedio);
                                        if($promedio==1)
                                            $promedio_explicacion = '1 (Malo)';
                                        else if($promedio==2)
                                            $promedio_explicacion = '2 (Regular)';
                                        else if($promedio==3)
                                            $promedio_explicacion = '3 (Bueno)';
                                        else if($promedio==4)
                                            $promedio_explicacion = '4 (Muy Bueno)';
                                        else if($promedio==5)
                                            $promedio_explicacion = '5 (Excelente)';
                                        ?>
                                        <?php echo $promedio_explicacion; ?>
                                    <?php } ?>

                                  </h4></td>
                              <td width="72%" class="establecimiento_comentarios_califica_form">
                                  <?php if($establecimiento_calificacion->promedio!=''){
                                    for($i=0; $i<$promedio; $i++){ ?>
                                        <img src="<?php echo base_url(); ?>resources/images/iconos/estrella_act.png" alt="Estrella" width="25" height="25" />&nbsp;
                                <?php }
                                } ?>
                              </td>
                              </tr>
                            </table></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                        </tr>
                          </table></td>
                      </tr>
                    <tr>
                      <td height="14" class="box_esquina_inf_izq"></td>
                      <td colspan="2" class="box_borde_inf"></td>
                      <td class="box_esquina_inf_der"></td>
                      </tr>
                    </table>
                </td>
                <td width="375" valign="top" class="box_fondo">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td width="96" class="box_fondo"></td>
                            <td width="251" class="box_borde_sup" ></td>
                            <td width="14" height="14" class="box_esquina_sup_der"></td>
                        </tr>
                        <tr>
                            <td height="22" class="box_fondo box_titulo"><h1>UBICACI&Oacute;N</h1></td>
                            <td class="box_fondo_contenido">&nbsp;</td>
                            <td rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="3" class="general_separador_transparente"></td>
                                    </tr>
                                    <tr>
                                        <td width="3%" height="200">&nbsp;</td>
                                        <td width="94%">
                                            <div id="googlemap" style="width: 325px; height: 400px;">
                                                
                                            </div>
                                        <td width="3%">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="general_separador_transparente"></td>
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
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td width="95" class="box_fondo"></td>
                            <td width="252" class="box_borde_sup" ></td>
                            <td width="14" height="14" class="box_esquina_sup_der"></td>
                        </tr>
                        <tr>
                            <td height="22" class="box_fondo box_titulo"><h1>IMÁGENES</h1></td>
                            <td class="box_fondo_contenido">&nbsp;</td>
                            <td rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="7" class="general_separador_transparente"></td>
                                    </tr>
                                    <tr>
                                        <?php if(sizeof($establecimiento_imagenes)!=0){
                                            foreach($establecimiento_imagenes as $establecimiento_imagen){ ?>
                                            <td width="3%" height="99">&nbsp;</td>
                                            <td width="29%"><a href="<?php echo base_url().$establecimiento_imagen->imagen_url; ?>" rel="galeria-imagenes"><img src="<?php echo base_url().$establecimiento_imagen->imagen_thumb_url; ?>" alt="Imagen del Establecimiento" /></a></td>
                                        <?php }
                                        } ?>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="general_separador_transparente"></td>
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
<tr>
    <td>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="comentario-calificacion">
            <tr>
                <td width="2%">&nbsp;</td>
                <td width="30%" valign="top">&nbsp;</td>
                <td width="2%">&nbsp;</td>
                <td width="64%" valign="top">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td width="127" class="box_fondo"></td>
                            <td width="466" class="box_borde_sup" ></td>
                            <td width="14" height="14" class="box_esquina_sup_der"></td>
                        </tr>
                        <tr>
                            <td height="22" class="box_fondo box_titulo"><h1>COMENTARIOS</h1></td>
                            <td class="box_fondo_contenido">&nbsp;</td>
                            <td rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="3" class="general_separador_transparente"></td>
                                    </tr>
                                    <?php $config = array('id' => 'formulario_agregar_establecimiento_comentario');
                                    echo form_open('establecimientos/agregar_establecimiento_comentario', $config); ?>
                                    <input type="hidden" name="id_establecimiento" value="<?php echo $establecimiento->id_establecimiento; ?>" />
                                    <tr>
                                        <td width="3%">&nbsp;</td>
                                        <td width="94%">
                                            <table class="establecimiento_comentarios" width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="2%">&nbsp;</td>
                                                    <td colspan="3" class="establecimiento_comentarios_texto_form"><h4>Comentario:</h4></td>
                                                    <td width="2%">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td colspan="3"><textarea class="general_textarea" name="comentario" id="comentario" onfocus="if(this.value=='Cuéntenos su experiencia con el establecimiento...'){this.value=''};" onblur="if(this.value==''){this.value='Cuéntenos su experiencia con el establecimiento...'}" rows="8" cols="50">Cuéntenos su experiencia con el establecimiento...</textarea>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td width="14%" class="establecimiento_comentarios_texto_form"><h4>Calificaci&oacute;n: </h4></td>
                                                    <td width="86%" class="establecimiento_comentarios_califica_form">
                                                        <div class="multiField" id="calificacion-comentario-div">
                                                            <input type="hidden" name="calificacion" id="calificacion" value="" />
                                                            <select>
                                                                <option value="1">1 (Malo)</option>
                                                                <option value="2">2 (Regular)</option>
                                                                <option value="3">3 (Bueno)</option>
                                                                <option value="4">4 (Muy Bueno)</option>
                                                                <option value="5">5 (Excelente)</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td width="3%">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td class="establecimiento_comentarios_boton_form">
                                            <?php if($this->session->userdata('esta_registrado')){ ?>
                                                <input type="submit" class="general_boton_secundario" name="btn_comentar" id="btn_comentar" value="Comentar" />
                                            <?php } else { ?>
                                                <a id="registro-comentario-id" href="#registro-comentario" title="Registro o Inicio de Sesión"><input type="button" class="general_boton_secundario" name="btn_comentar" id="btn_comentar" onclick="agregar_establecimiento_comentario_sin_sesion()" value="Comentar" /></a>
                                            <?php } ?>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <?php echo form_close(); ?>
                                    
                                    <!-- inicio comentario 1 -->
                                    <?php if(sizeof($establecimiento_comentarios)!=0){
                                        foreach($establecimiento_comentarios as $establecimiento_comentario){ ?>
                                    <tr>
                                        <td ></td>
                                        <td class="general_separador_transparente_borde_sup"></td>
                                        <td ></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="comentario-<?php echo $establecimiento_comentario->id_establecimiento_comentario; ?>">
                                                <tr>
                                                    <td width="18%" rowspan="3"><img src="<?php if($establecimiento_comentario->imagen_thumb_url!='' && $establecimiento_comentario->imagen_thumb_url!=NULL){ echo base_url().$establecimiento_comentario->imagen_thumb_url; } else { echo base_url().'resources/images/usuarios/avatar.gif'; } ?>" alt="<?php echo $establecimiento_comentario->usuario; ?>" height="90" width="90" /><br /><?php echo $establecimiento_comentario->usuario; ?></td>
                                                    <td width="49%" class="establecimiento_comentarios_texto"><h4>Calificación: <strong><?php echo $establecimiento_comentario->calificacion; ?></strong></h4></td>
                                                    <td width="33%" class="establecimiento_comentarios_fecha"><h4>Publicado hace <strong><?php echo relative_time($establecimiento_comentario->fecha); ?></strong></h4></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="establecimiento_comentarios_texto"><h3><?php echo $establecimiento_comentario->comentario; ?></h3></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="general_link" align="right"><h4><a id="link-reportar-abuso-<?php $establecimiento_comentario->id_establecimiento_comentario; ?>" class="link-reportar-abuso" href="<?php echo base_url().'usuario/formulario_reportar_abuso_ajax/establecimientos/comentario/'.$establecimiento_comentario->id_establecimiento_comentario; ?>">Reportar abuso</a></h4></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>

                                        <td colspan="3" class="general_separador_transparente"></td>

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
                    </table></td>
                <td width="2%">&nbsp;</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td class="general_separador_transparente">
        
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
                                    <?php $config = array('id' => 'formulario_agregar_establecimiento_comentario_registrarse');
                                    echo form_open('establecimientos/agregar_establecimiento_comentario_registrarse', $config); ?>
                                    <input type="hidden" name="id_establecimiento_registrarse" id="id_establecimiento_registrarse" value="<?php echo $establecimiento->id_establecimiento; ?>" />
                                    <input type="hidden" name="comentario_registrarse" id="comentario_registrarse" value="" />
                                    <input type="hidden" name="calificacion_registrarse" id="calificacion_registrarse" value="" />
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
                        <?php $config = array('id' => 'formulario_agregar_establecimiento_comentario_ingresar');
                        echo form_open('establecimientos/agregar_establecimiento_comentario_ingresar', $config); ?>
                        <input type="hidden" name="id_establecimiento_ingresar" id="id_establecimiento_ingresar" value="<?php echo $establecimiento->id_establecimiento; ?>" />
                        <input type="hidden" name="comentario_ingresar" id="comentario_ingresar" value="" />
                        <input type="hidden" name="calificacion_ingresar" id="calificacion_ingresar" value="" />
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
<?php } ?>

<tr style="display: none">
    <td>
        <div id="contactar-establecimiento" align="center">
            <?php $config = array('id' => 'formulario_contactar_establecimiento');
                echo form_open('establecimientos/contactar_establecimiento', $config); ?>

            <input type="hidden" name="id_establecimiento_contactar" id="id_establecimiento_contactar" value="<?php echo $establecimiento->id_establecimiento; ?>" />
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
                                <td class="box_fondo_contenido" align="left" style="padding:10px;"><h2>Déjanos tu inquietud y te responderemos en la mayor brevedad posible al e-mail que especifiques. Para cotizaciones, describe los productos y/o servicios que deseas cotizar en el mensaje, Gracias.</h2></td>
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
                                <td width="164" class="box_fondo"></td>
                                <td width="408" class="box_borde_sup" ></td>
                                <td height="14" class="box_esquina_sup_der" width="14"></td>
                            </tr>
                            <tr>
                                <td height="22" class="box_fondo box_titulo"><h1>CONTACTO DIRECTO</h1></td>
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
                                            <td class="general_formulario_texto" align="right" valign="middle"><h2>E-mail:</h2></td>
                                            <td class="general_formulario_texto" align="left" style="padding:10px;">
                                                <input class="general_cuadro_texto" type="text" name="email_contactar" id="email_contactar" size="58" />
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
                                            <td class="general_formulario_texto" align="right" valign="middle"><h2>Asunto:</h2></td>
                                            <td class="general_formulario_texto" align="left" style="padding:10px;">
                                                <input class="general_cuadro_texto" type="text" name="asunto_contactar" id="asunto_contactar" size="58" />
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

                                                <textarea class="general_textarea" name="mensaje_contactar" id="mensaje_contactar"  rows="8" cols="50"></textarea>
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
    </td>
</tr>