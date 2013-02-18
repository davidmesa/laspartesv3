<tr>
	<td class="<?php if(!isset($navegacion_view)){echo "borde_inferior";}?> formulario">
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
		<td class="right">
<?php
	$config = array('id' => 'formulario_registrar_usuario');
	echo form_open('usuario/registrar_usuario', $config);
?>
			<h3 class="titulo">Reg&iacute;strate</h3>
                        <?php 
                            if(isset($referenciado))
                            {
                        ?>
                        <input type="hidden" name="referenciado" value="<?echo $referenciado; ?>"/>
                        <?php
                            }
                        ?>
			<table border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="2" class="general_formulario_texto registro_formulario_texto" align="left" height="5"></td>
					<td></td>
				</tr>
				<tr>
					<td class="general_formulario_texto registro_formulario_texto" align="left">
						<h3>Escribe tu nombre:</h3>
					</td>
					<td valign="middle" align="left" class="general_formulario_texto registro_formulario_texto">
						<input class="general_cuadro_texto" type="text" name="nombre_usuario_registrarse" id="nombre_usuario_registrarse" size="25" />
					</td>
				</tr>
				<tr>
					<td class="general_formulario_texto registro_formulario_texto" align="left">
						<h3>Escribe tus apellidos:</h3>
					</td>
					<td valign="middle" align="left" class="general_formulario_texto registro_formulario_texto">
						<input class="general_cuadro_texto" type="text" name="apellidos_usuario_registrarse" id="apellidos_usuario_registrarse" size="25" />
					</td>
				</tr>
				<tr>
					<td class="general_formulario_texto registro_formulario_texto" align="left">
						<h3>Escoge tu nombre de usuario:</h3>
					</td>
					<td valign="middle" align="left" class="general_formulario_texto registro_formulario_texto">
						<input class="general_cuadro_texto" type="text" name="usuario_registrarse" id="usuario_registrarse" size="25" />
					</td>
				</tr>
				<tr>
					<td class="general_formulario_texto registro_formulario_texto" align="left">
						<h3>Escoge la ciudad en la que vives:</h3>
					</td>
					<td class="general_formulario_texto registro_formulario_texto filtros_categoria" align="left">
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
					<td class="general_formulario_texto registro_formulario_texto" align="left" height="10"></td>
				</tr>
				<tr>
					<td class="general_formulario_texto registro_formulario_texto" align="left">
						<h3>Digita tu correo electr&oacute;nico:</h3>
					</td>
					<td class="general_formulario_texto registro_formulario_texto" align="left">
						<input class="general_cuadro_texto" type="text" name="email_registrarse" id="email_registrarse" size="25" />
					</td>
					<td class="general_formulario_texto registro_formulario_texto" align="left" height="10"></td>
				</tr>
				<tr>
					<td class="general_formulario_texto registro_formulario_texto" align="left">
						<h3>Escoge una contrase&ntilde;a:</h3>
					</td>
					<td class="general_formulario_texto registro_formulario_texto" align="left">
						<input class="general_cuadro_texto" type="password" name="contrasena_registrarse" id="contrasena_registrarse" size="25" />
					</td>
				</tr>
				<tr>
					<td class="general_formulario_texto registro_formulario_texto" align="left">
						<h3>Repite la contrase&ntilde;a:</h3>
					</td>
					<td class="general_formulario_texto registro_formulario_texto" align="left">
						<input class="general_cuadro_texto" type="password" name="contrasena2_registrarse" id="contrasena2_registrarse" size="25" />
					</td>
				</tr>
				<tr>
					<td colspan="2" valign="top" align="left" style="padding-bottom:5px;" class="general_link"><h3>
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
                                                                            <?php 
                                                                                $option_modelo = array();
                                                                                $selected = false;
                                                                                $option_modelo[-1] = 'No recuerdo';
                                                                                $año = intval(mdate('%Y'));
                                                                                for ($i = $año; $i > 1950; $i--) {
                                                                                    $option_modelo[$i] = $i;
                                                                                    if(!$selected){
                                                                                            $selected = $i;
                                                                                    } 
                                                                                }
                                                                                echo form_dropdown('modelo_registrarse', $option_modelo, $selected);
                                                                            ?>
<!--										<input class="general_cuadro_texto" type="text" name="modelo_registrarse" id="modelo_registrarse" size="20" />-->
									</td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
				<tr>
					<td class="general_formulario_texto registro_formulario_texto" align="left">
						<h3>Escribe los 4 d&iacute;gitos de abajo:</h3>
					</td>
					<td class="general_formulario_texto registro_formulario_texto" align="left">
						<input class="general_cuadro_texto" type="text" name="captcha_registrarse" id="captcha_registrarse" size="25" />
					</td>
				</tr>
				<tr>
					<td colspan="3" style="padding-top:10px;" class="general_formulario_texto registro_formulario_texto" align="center"><?php echo $captcha['image']; ?></td>
				</tr>
				<tr>
					<td class="general_formulario_texto registro_formulario_texto" align="left" height="10"></td>
				</tr>
				<tr>
					<td colspan="2" class="general_separador_transparente"></td>
				</tr>
				<tr>
					<td colspan="2" valign="top" align="left" style="padding-bottom:5px;" class="general_link"><h3>
						<label for="terminos_condiciones_registrarse">Acepto los <a href="<?php echo base_url()?>acerca/terminos_condiciones" target="_blank">T&eacute;rminos y Condiciones</a>
						<input type="checkbox" name="terminos_condiciones_registrarse" id="terminos_condiciones_registrarse"/></label></h3>
					</td>
				</tr>
				<tr>
					<td colspan="2" valign="top" align="left" style="padding-bottom:5px;" class="general_link">
						<input name="btn_registro" type="submit" class="general_boton_secundario" id="btn_registro" value="Registrarme" />
					</td>
				</tr>
			</table>
<?php
	echo form_close();
?>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right" valign="top" style="padding-top:5px;padding-bottom:10px;">
			
		</td>
	</tr>
	</table>
	</td>
</tr>