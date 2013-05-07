<tr>
    <td>
        <table width="970" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="20">&nbsp;</td>
                <td width="655" valign="top" class="box_fondo">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td width="106" class="box_fondo"></td>
                            <td width="521" class="box_borde_sup" ></td>
                            <td width="14" height="14" class="box_esquina_sup_der"></td>
                        </tr>
                        <tr>
                            <td height="22" class="box_fondo box_titulo"><h1>PREGUNTA</h1></td>
                            <td class="box_fondo_contenido box_ordenamiento">&nbsp;</td>
                            <td rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">
                                <table width="626" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="6" class="general_separador_transparente" align="right" >
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15">&nbsp;&nbsp;&nbsp;</td>
                                        <td colspan="3" class="general_texto_secundario" align="left"><h3><strong>Publicada el <?php echo real_date($pregunta->fecha); ?></strong></h3></td>
                                        <td width="151" rowspan="2" align="center" valign="middle" class="general_link" style="padding:5px;">
                                            <a href="<?php 
                                                            if(strlen($pregunta->imagen_thumb_url)== 0 && strlen($pregunta->thumb)>0):
                                                                echo base_url().'establecimientos/'.$pregunta->idEstablecimiento.'-'.$pregunta->nombreEstablecimiento;
                                                            else: echo base_url().'usuario';
                                                            endif;?>
                                                                ">
                                                                <img src="<?php if($pregunta->imagen_thumb_url!='' && $pregunta->imagen_thumb_url!=NULL){ echo base_url().$pregunta->imagen_thumb_url; } else if(strlen($pregunta->thumb)>0) {echo base_url().$pregunta->thumb; } else { echo base_url().'resources/images/usuarios/avatar_thumb.gif'; } ?>" width="63" height="70" alt="<?php echo $pregunta->usuario; ?>" /></a>
                                            <br />
                                            <h4><?php echo $pregunta->usuario; ?><br/>
                                                <?php
                                                if(isset($vehiculos_usuario))
                                                {
                                                    foreach($vehiculos_usuario as $vehiculo_usuario)
                                                    {
                                                        echo $vehiculo_usuario->marca.' '.$vehiculo_usuario->linea.'<br/>';
                                                    }
                                                }
                                                    ?>
                                            </h4></td>
                                        <td width="15">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="3" style="padding-bottom:10px; padding-top:10px;" align="left" valign="middle"><h2 class="tallerenlinea_texto_pregunta"><strong><?php echo $pregunta->titulo_pregunta; ?></strong></h2></td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="4" align="left" valign="middle" style="padding-bottom:5px; padding-top:10px;"><?php if(strlen($pregunta->img_url)>0): ?><img src="<?php echo base_url().$pregunta->img_url;?>" alt="imagen pregunta"/><?php endif; ?></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="4" align="left" valign="middle" style="padding-bottom:5px; padding-top:10px;"><h2><strong>Palabras clave: </strong><?php echo $pregunta->palabras_clave; ?></h2></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="4" align="left" valign="middle" style="padding-bottom:5px; padding-top:10px;"><h2><?php echo nl2br($pregunta->cuerpo_pregunta); ?></h2></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr  height="100px">
                                        <td colspan="6" align="right">
                                            <table width="200">
                                                <tr>
                                                    <td align="right" valign="top"><div class="fb-like" data-send="true" data-layout="box_count" data-width="45" data-show-faces="true"></div></td>
                                                    <td align="right" valign="top"><a href="https://twitter.com/share" class="twitter-share-button" data-text="<?php echo $pregunta->titulo_pregunta; ?> via @laspartes" data-count="vertical" data-lang="es">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script></td>
                                                    
                                                    <td align="right" valign="top"><g:plusone size="tall"></g:plusone></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="3" align="left" class="general_link"><h4><a id="link-reportar-abuso-<?php $pregunta->id_pregunta; ?>" class="link-reportar-abuso" href="<?php echo base_url().'usuario/formulario_reportar_abuso_ajax/taller_en_linea/pregunta/'.$pregunta->id_pregunta; ?>">Reportar abuso</a></h4></td>
                                        <td class="general_link" align="right" style="padding-bottom:5px;padding-top:5px;">
                                            <input type="submit" class="general_boton_secundario" name="btn_responder" id="btn_responder" onclick="$.scrollTo('#responder-pregunta', 800); return false;" value="Responder" />
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    
                                    <tr>
                                        <td></td>
                                        <td colspan="4" class="general_separador_transparente_borde_sup2"></td> 
                                        <td></td>
                                    </tr>
                                    <?php if(sizeof($respuestas)!=0){
                                        foreach($respuestas as $respuesta){ ?>
                                    <tr id="respuesta-<?php echo $respuesta->id_respuesta; ?>">
                                        <td>&nbsp;</td>
                                        <td width="85" rowspan="2" align="left" valign="top">
                                            <a href="<?php 
                                                            if(strlen($respuesta->thumb)>0):
                                                                echo base_url().'establecimientos/'.$respuesta->idEstablecimiento.'-'.$respuesta->nombreEstablecimiento;
                                                            else: echo base_url().'usuario';
                                                            endif;?>
                                                                ">
                                                                <img src="<?php if($respuesta->imagen_thumb_url!='' && $respuesta->imagen_thumb_url!=NULL){ echo base_url().$respuesta->imagen_thumb_url; } else if(strlen($respuesta->thumb)>0) {echo base_url().$respuesta->thumb; } else { echo base_url().'resources/images/usuarios/avatar_thumb.gif'; } ?>" width="63" height="70" alt="<?php echo $respuesta->usuario; ?>" /></a>
                                            <div><h4><?php echo $respuesta->usuario;?></h4></div>
                                            
                                        </td>
                                        <td colspan="3" class="general_link general_texto_secundario" align="left" ><h3>Respuesta de <?php echo $respuesta->usuario; ?> el <strong><?php echo real_date($respuesta->fecha); ?></strong></h3></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="3" style="padding-top:10px;padding-bottom:5px;padding-right:10px;" align="left"><h2><?php echo nl2br($respuesta->respuesta); ?></h2></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td colspan="3" align="right" style="padding:10px;"><h4>A <strong id="me-gusta-cantidad-<?php echo $respuesta->id_respuesta; ?>"><?php echo $respuesta->me_gusta; ?></strong> personas les gusta esta respuesta</h4></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td colspan="3" align="center" valign="middle">
                                            <table width="335" border="0" cellspacing="0" cellpadding="0">
                                                <?php if(!$this->session->userdata('esta_registrado')){ ?>
                                                    <tr>
                                                        <td width="51"><a href="#registro-me-gusta" title="Registro o Inicio de Sesión" class="general_btn_megusta registro-me-gusta"><span>Me gusta</span></a></td>
                                                        <td width="113" align="left" valign="middle" class="general_link"><h4><a href="#registro-me-gusta" title="Registro o Inicio de Sesión" class="registro-me-gusta">Me gusta esta respuesta</a></h4></td>
                                                        <td width="51"><a href="#registro-me-gusta" title="Registro o Inicio de Sesión" class="general_btn_nomegusta registro-me-gusta"><span>No me gusta</span></a></td>
                                                        <td width="120" class="general_link" align="left" valign="middle"><h4><a href="#registro-me-gusta" title="Registro o Inicio de Sesión" class="registro-me-gusta">No me gusta esta respuesta</a></h4></td>
                                                    </tr>
                                                <?php } 
                                                    else {
                                                        $le_gusta = NULL;
                                                        foreach($respuestas_me_gustan as $me_gusta){
                                                            if($me_gusta->id_respuesta == $respuesta->id_respuesta)
                                                                    $le_gusta = $me_gusta->me_gusta;
                                                        }
                                                    ?>
                                                    
                                                        <tr id="me-gusta-decidir-<?php echo $respuesta->id_respuesta; ?>" <?php if($le_gusta != NULL){ ?>style="display: none"<?php } ?>>
                                                            <td width="51"><a onclick="me_gusta(<?php echo $respuesta->id_respuesta; ?>)" class="general_btn_megusta" title="Me gusta"><span>Me gusta</span></a></td>
                                                            <td width="113" align="left" valign="middle" class="general_link"><h4><a onclick="me_gusta(<?php echo $respuesta->id_respuesta; ?>)">Me gusta esta respuesta</a></h4></td>
                                                            <td width="51"><a onclick="no_me_gusta(<?php echo $respuesta->id_respuesta; ?>)" class="general_btn_nomegusta" title="No me gusta"><span>No me gusta</span></a></td>
                                                            <td width="120" class="general_link" align="left" valign="middle"><h4><a onclick="no_me_gusta(<?php echo $respuesta->id_respuesta; ?>)">No me gusta esta respuesta</a></h4></td>
                                                        </tr>
                                                        <tr id="me-gusta-decision-<?php echo $respuesta->id_respuesta; ?>" <?php if($le_gusta==0){ ?>style="display: none"<?php } ?>>
                                                            <td width="60" align="center" valign="middle"><img src="<?php echo base_url(); ?>resources/images/botones/megusta.gif" width="28" height="28" alt="Me gusta" /></td>
                                                            <td width="200" align="left" valign="middle" class="general_link"><h4>Me gusta esta respuesta</h4></td>
                                                            <td width="75" class="general_link" align="left" valign="middle"><h4></h4></td>
                                                        </tr>
                                                        <tr id="no-me-gusta-decision-<?php echo $respuesta->id_respuesta; ?>" <?php if($le_gusta==NULL || $le_gusta==1){ ?>style="display: none"<?php } ?>>
                                                            <td width="60" align="center" valign="middle"><img src="<?php echo base_url(); ?>resources/images/botones/nomegusta.gif" width="28" height="28" alt="Me gusta" /></td>
                                                            <td width="200" align="left" valign="middle" class="general_link"><h4>No me gusta esta respuesta</h4></td>
                                                            <td width="75" class="general_link" align="left" valign="middle"><h4></h4></td>
                                                        </tr>
                                                <?php } ?>
                                            </table>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td width="161">&nbsp;</td>
                                        <td colspan="2" align="right" class="general_link" style="padding:5px;"><h4><a id="link-reportar-abuso-<?php $respuesta->id_respuesta; ?>" class="link-reportar-abuso" href="<?php echo base_url().'usuario/formulario_reportar_abuso_ajax/taller_en_linea/respuesta/'.$respuesta->id_respuesta; ?>">Reportar abuso</a></h4></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="4" class="general_separador_transparente_borde_sup"></td>
                                        <td></td>
                                    </tr>
                                    <?php }
                                    } ?>

                                    <?php $config = array('id' => 'formulario_agregar_respuesta');
                                        echo form_open('taller_en_linea/agregar_respuesta', $config); ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="4" id="responder-pregunta">
                                            <input type="hidden" name="id_pregunta" value="<?php echo $pregunta->id_pregunta; ?>" />
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="3%" class="general_formulario_texto">&nbsp;</td>
                                                    <td width="95%" align="left" style="padding:5px;" class="general_formulario_texto"><h3>Escriba su respuesta:</h3></td>
                                                    <td width="2%" class="general_formulario_texto">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td class="general_formulario_texto">&nbsp;</td>
                                                    <td class="general_formulario_texto" style="padding-bottom:10px;">
                                                        <textarea class="general_textarea" name="respuesta" id="respuesta" rows="8" cols="50"></textarea>
                                                    </td>
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
                                                <input type="submit" class="general_boton_secundario" name="btn_responder2" id="btn_responder2" value="Responder" />
                                            <?php } else { ?>
                                                <a id="registro-respuesta-id" href="#registro-respuesta" title="Registro o Inicio de Sesión"><input type="submit" class="general_boton_secundario" name="btn_responder2" id="btn_responder2" onclick="agregar_respuesta_sin_sesion()" value="Responder" /></a>
                                            <?php } ?>
                                        </td>
                                        <td>&nbsp;</td>
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
                <td width="275" valign="top" class="box_fondo">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td width="203" class="box_fondo"></td>
                            <td width="44" class="box_borde_sup" ></td>
                            <td width="14" height="14" class="box_esquina_sup_der"></td>
                        </tr>
                        <tr>
                            <td height="22" class="box_fondo box_titulo"><h1>PREGUNTAS RELACIONADAS</h1></td>
                            <td class="box_fondo_contenido">&nbsp;</td>
                            <td rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido"><table width="246" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="20">&nbsp;</td>
                                        <td width="206">&nbsp;</td>
                                        <td width="20">&nbsp;</td>
                                    </tr>
                                    <?php if(sizeof($preguntas_relacionadas)!=0){
                                        foreach($preguntas_relacionadas as $pregunta_relacionada){ ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td class="general_link" align="left"><h2><a href="<?php echo base_url(); ?>preguntas/<?php echo $pregunta_relacionada->id_pregunta; ?>-<?php echo str_replace(' ', '-', convert_accented_characters($pregunta_relacionada->titulo_pregunta)); ?>"><?php echo $pregunta_relacionada->titulo_pregunta; ?></a></h2></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td class="general_texto_secundario" align="right" style="padding-bottom:10px;padding-top:5px;"><h3><strong>Publicada hace <?php echo relative_time($pregunta_relacionada->fecha); ?></strong></h3></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td class="general_separador_transparente_borde_sup"></td>
                                        <td></td>
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
                </td>
                <td width="20">&nbsp;</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td class="general_separador_transparente"></td>
</tr>    
<?php if(!$this->session->userdata('esta_registrado')){ ?>
<tr style="display: none;">
    <td>
        <div id="registro-respuesta">
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
                                    <?php $config = array('id' => 'formulario_agregar_respuesta_registrarse');
                                    echo form_open('taller_en_linea/agregar_respuesta_registrarse', $config); ?>
                                    <input type="hidden" name="id_pregunta_registrarse" id="id_pregunta_registrarse" value="<?php echo $pregunta->id_pregunta; ?>" />
                                    <input type="hidden" name="respuesta_registrarse" id="respuesta_registrarse" value="" />
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
                                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><h3>Escribe tus nombres:</h3></td>
                                                            <td width="15">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" valign="middle" align="left" class="general_formulario_texto registro_formulario_texto"><input class="general_cuadro_texto registrarse" type="text" name="nombre_registrarse" id="nombre_registrarse" size="38" /></td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left" height="5"></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><h3>Escribe tus apellidos:</h3></td>
                                                            <td width="15">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" valign="middle" align="left" class="general_formulario_texto registro_formulario_texto"><input class="general_cuadro_texto registrarse" type="text" name="apellidos_registrarse" id="apellidos_registrarse" size="38" /></td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left" height="5"></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left"><h3>Escoge la ciudad donde vives:</h3></td>
                                                            <td width="15">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" valign="middle" align="left" class="general_formulario_texto registro_formulario_texto">
																<div class="ui-widget">
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
																</div>
                                                            </td>
                                                            <td>&nbsp;</td>
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
                                                        	<td colspan="2" valign="top" align="left" style="padding-bottom:5px;" class="general_formulario_texto"><h3>
						<input type="checkbox" name="tiene_carro_registrarse" id="tiene_carro_registrarse" checked/>¿Tiene carro?</h3>
						<div id="tiene_carro_form_registro">
							<table width="100%">
								<tr>
									<td>
										<h4>Marca</h4>
									</td>
									<td>
										<div class="ui-widget">
<?php
$option_marcas = array();
$selected = false;
foreach($marcas as $marca){
	if( $marca->marca != 'default'){
		$option_marcas[$marca->marca] = $marca->marca;
		if(!$selected){
			$selected = $marca->marca;
		}
	}
}
echo form_dropdown('marca_registrarse', $option_marcas, $selected);//, 'id="marca_registrarse"');
?>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<h4>L&iacute;nea</h4>
									</td>
									<td>
										<div class="ui-widget">
<?php
echo form_dropdown('linea_registrarse', array(), '');
?>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<h4>Kilometraje</h4>
									</td>
									<td>
										<div class="ui-widget">
<?php
$option_kilometraje = array();
$selected = false;
$option_kilometraje['-1'] = 'No recuerdo';
for($i = 1; $i < 100000; $i += 5000){
	$option_kilometraje[$i-1] = $i.' Km. - '.($i + 4999).' Km.';
	if(!$selected){
		$selected = $i-1;
	}
}
echo form_dropdown('kilometraje_registrarse', $option_kilometraje, $selected);
?>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<h4>Modelo</h4>
									</td>
									<td>
										<input class="general_cuadro_texto" type="text" name="modelo_registrarse" id="modelo_registrarse" size="20" />
									</td>
								</tr>
							</table>
						</div>
					</td>
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
                        <?php $config = array('id' => 'formulario_agregar_respuesta_ingresar');
                        echo form_open('taller_en_linea/agregar_respuesta_ingresar', $config); ?>
                        <input type="hidden" name="id_pregunta_ingresar" id="id_pregunta_ingresar" value="<?php echo $pregunta->id_pregunta; ?>" />
                        <input type="hidden" name="respuesta_ingresar" id="respuesta_ingresar" value="" />
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
                                                <td colspan="2" class="general_link" valign="middle" align="left" style="padding-top:5px;padding-bottom:5px;"><h3><a href="<?php echo base_url(); ?>usuario/formulario_olvido_contrasena">Olvid&eacute; mi contrase&ntilde;a</a></h3></td>
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
                                                <td colspan="2" class="general_link" valign="middle" align="left" style="padding-top:5px;padding-bottom:5px;"><h3><a href="<?php echo base_url(); ?>usuario/formulario_olvido_contrasena">Olvid&eacute; mi contrase&ntilde;a</a></h3></td>
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
