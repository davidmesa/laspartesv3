<tr>
    <td>
        <table width="970" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="20">&nbsp;</td>
                <td width="555" valign="top" class="box_fondo">
                    <?php $config = array('id' => 'formulario_agregar_pregunta');
                    echo form_open_multipart('taller_en_linea/agregar_pregunta', $config); ?>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td width="114" class="box_fondo"></td>
                            <td width="413" class="box_borde_sup" ></td>
                            <td width="14" height="14" class="box_esquina_sup_der"></td>
                        </tr>
                        <tr>
                            <td height="22" class="box_fondo box_titulo"><h1>PREGUNTAR</h1></td>
                            <td class="box_fondo_contenido box_ordenamiento">&nbsp;</td>
                            <td rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">

                                <table width="526" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="4" align="center" style="padding:10px;"><h2>Tu pregunta ser&aacute; respondida por nuestra comunidad de expertos en veh&iacute;culos...</h2></td>
                                    </tr>
                                    <tr>
                                        <td width="21">&nbsp;</td>
                                        <td colspan="2" align="left" class="general_formulario_texto" style="padding-bottom:2px;padding-left:15px;padding-top:10px;"><h3>Pregunta:</h3></td>
                                        <td width="20">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" align="left" class="general_formulario_texto" style="padding-left:15px;padding-right:10px;">
                                            <textarea class="general_textarea" name="titulo_pregunta" id="titulo_pregunta" onfocus="if(this.value=='Escribe aqu&iacute; tu pregunta...'){this.value=''};" onblur="if(this.value==''){this.value='Escribe aqu&iacute; tu pregunta...'}" rows="3" cols="40">Escribe aqu&iacute; tu pregunta...</textarea>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" align="left" class="general_formulario_texto" style="padding-left:15px;"><h3>Detalles:</h3></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" align="left" class="general_formulario_texto" style="padding-left:15px;padding-right:10px;">
                                            <textarea class="general_textarea" name="cuerpo_pregunta" id="cuerpo_pregunta" onfocus="if(this.value=='Escribe aqu&iacute; los detalles de tu pregunta...'){this.value=''};" onblur="if(this.value==''){this.value='Escribe aqu&iacute; los detalles de tu pregunta...'}" rows="8" cols="40">Escribe aqu&iacute; los detalles de tu pregunta...</textarea>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" align="right" class="general_formulario_texto" style="padding-right:15px;padding-bottom:5px;"><h4>Escribe los detalles necesarios para aclarar tu pregunta</h4></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td align="right" class="general_formulario_texto" style="padding-right:15px;padding-bottom:5px;"><h4>Agrega una imagen:</h4></td>
                                        <td class="general_formulario_texto" style="padding-right:15px;padding-bottom:5px;"><input type="file" name="imagen_pregunta" id="imagen_pregunta"/></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td width="122" align="right" class="general_formulario_texto" style="padding-bottom:2px;padding-left:15px;"><h3>Categor&iacute;a:</h3></td>
                                        <td width="363" class="general_formulario_texto registro_formulario_texto" style="padding-right:15px;padding-left:7px;" align="left">
                                            <select class="general_lista" name="id_pregunta_categoria" id="id_pregunta_categoria" style="width:300px;" >
                                                <?php if(sizeof($preguntas_categorias)){
                                                foreach($preguntas_categorias as $pregunta_categoria){ ?>
                                                <option value="<?php echo $pregunta_categoria->id_pregunta_categoria; ?>"><?php echo $pregunta_categoria->nombre; ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" align="right" class="general_formulario_texto" style="padding-right:15px;"><h4>Ay&uacute;danos a clasificar tu pregunta</h4></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td align="right" class="general_formulario_texto" style="padding-bottom:2px;"><h3>Palabras clave:</h3></td>
                                        <td class="general_formulario_texto registro_formulario_texto" style="padding-right:15px;padding-left:5px;" align="left">
                                            <input class="general_cuadro_texto" type="text" name="palabras_clave" id="palabras_clave" size="45" onfocus="if(this.value=='Por ejemplo: Llantas, Renault, Twingo'){this.value=''};" onblur="if(this.value==''){this.value='Por ejemplo: Llantas, Renault, Twingo'}" value="Por ejemplo: Llantas, Renault, Twingo"/>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td colspan="2" align="right" class="general_formulario_texto" style="padding-right:15px;"><h4>Separar palabras por una coma (,)</h4></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="general_link" style="padding-bottom:10px;padding-top:5px;" align="right">
                                            <?php if($this->session->userdata('esta_registrado')){ ?>
                                                <input type="submit" class="general_boton_secundario" name="btn_preguntar" id="btn_preguntar" value="Preguntar" />
                                            <?php } else { ?>
                                                <a id="registro-pregunta-id" href="#registro-pregunta" title="Registro o Inicio de Sesión"><input type="submit" class="general_boton_secundario" name="btn_preguntar" id="btn_preguntar" onclick="agregar_pregunta_sin_sesion()" value="Preguntar" /></a>
                                            <?php } ?>
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
                    <?php echo form_close(); ?>
                </td>
                <td width="375" valign="top" class="box_fondo">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="14" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td width="203" class="box_fondo"></td>
                            <td width="144" class="box_borde_sup" ></td>
                            <td width="14" height="14" class="box_esquina_sup_der"></td>
                        </tr>
                        <tr>
                            <td height="22" class="box_fondo box_titulo"><h1>PREGUNTAS RECIENTES</h1></td>
                            <td class="box_fondo_contenido">&nbsp;</td>
                            <td rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido"><table width="346" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="20">&nbsp;</td>
                                        <td width="306">&nbsp;</td>
                                        <td width="20">&nbsp;</td>
                                    </tr>
                                    <?php if(sizeof($preguntas_recientes)!=0){
                                        foreach($preguntas_recientes as $pregunta_reciente){ ?>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td class="general_link" align="left"><h2><a href="<?php echo base_url();?>taller_en_linea/ver_pregunta/<?php echo $pregunta_reciente->id_pregunta; ?>/<?php echo str_replace(' ', '-', convert_accented_characters($pregunta_reciente->titulo_pregunta)); ?>"><?php echo $pregunta_reciente->titulo_pregunta; ?></a></h2></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td class="general_texto_secundario" align="right" style="padding-bottom:10px;padding-top:5px;"><h3><strong>Publicada hace <?php echo relative_time($pregunta_reciente->fecha); ?></strong></h3></td>
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
                    </table></td>
                <td width="20">&nbsp;</td>
            </tr>
        </table>
    </td>
</tr>
<?php if(!$this->session->userdata('esta_registrado')){ ?>
<tr style="display: none;">
    <td>
        <div id="registro-pregunta">
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
                                    <?php $config = array('id' => 'formulario_agregar_pregunta_registrarse');
                                    echo form_open('taller_en_linea/agregar_pregunta_registrarse', $config); ?>
                                    <input type="hidden" name="titulo_pregunta_registrarse" id="titulo_pregunta_registrarse" value="" />
                                    <input type="hidden" name="cuerpo_pregunta_registrarse" id="cuerpo_pregunta_registrarse" value="" />
                                    <input type="hidden" name="id_pregunta_categoria_registrarse" id="id_pregunta_categoria_registrarse" value="" />
                                    <input type="hidden" name="palabras_clave_registrarse" id="palabras_clave_registrarse" value="" />
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
                        <?php $config = array('id' => 'formulario_agregar_pregunta_ingresar');
                        echo form_open('taller_en_linea/agregar_pregunta_ingresar', $config); ?>
                        <input type="hidden" name="titulo_pregunta_ingresar" id="titulo_pregunta_ingresar" value="" />
                        <input type="hidden" name="cuerpo_pregunta_ingresar" id="cuerpo_pregunta_ingresar" value="" />
                        <input type="hidden" name="id_pregunta_categoria_ingresar" id="id_pregunta_categoria_ingresar" value="" />
                        <input type="hidden" name="palabras_clave_ingresar" id="palabras_clave_ingresar" value="" />
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
<?php } ?>