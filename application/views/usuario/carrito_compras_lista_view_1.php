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
                            <td width="122" height="22" class="box_fondo box_titulo"><h1>MIS COMPRAS</h1></td>
                            <td width="780" class="box_fondo_contenido box_ordenamiento">&nbsp;</td>
                            <td width="14" rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td colspan="16" class="general_separador_transparente"></td>
                                    </tr>
                                    <tr>
                                        <td width="9">&nbsp;</td>
                                        <td width="9" class="titulo_fondo_izq">&nbsp;</td>
                                        <td width="80" class="titulo_fondo_centrado" align="center" valign="middle"><h3>Cantidad</h3></td>
                                        <td width="5">&nbsp;</td>
                                        <td width="173" class="titulo_fondo_centrado"><h3>Nombre</h3></td>
                                        <td width="5">&nbsp;</td>
                                        <td width="182" class="titulo_fondo_centrado"><h3>Descripci&oacute;n</h3></td>
                                        <td width="5">&nbsp;</td>
                                        <td width="121" class="titulo_fondo_centrado"><h3>Establecimiento</h3></td>
                                        <td width="5">&nbsp;</td>
                                        <td width="121" class="titulo_fondo_centrado"><h3>Precio unidad</h3></td>
                                        <td width="5">&nbsp;</td>
                                        <td width="101" class="titulo_fondo_centrado"><h3>Total</h3></td>
                                        <td width="5">&nbsp;</td>
                                        <td width="61" class="titulo_fondo_centrado">&nbsp;</td>
                                        <td width="15" class="titulo_fondo_der">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="17" class="general_separador_transparente"></td>
                                    </tr>
                                    <?php $numero_items_carrito = 0;
                                    foreach($this->cart->contents() as $autoparte){ ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="carrito_compras_listado general_link <?php if($numero_items_carrito%2==0){ ?>carrito_compras_listado_selected<?php } ?>"><h4><a href="<?php echo base_url(); ?>usuario/actualizar_carrito_compras/<?php echo $autoparte['rowid']; ?>/<?php echo $autoparte['qty']-1; ?>">-</a> <?php echo $autoparte['qty']; ?> <a href="<?php echo base_url(); ?>usuario/actualizar_carrito_compras/<?php echo $autoparte['rowid']; ?>/<?php echo $autoparte['qty']+1; ?>">+</a></h4></td>
                                        <td>&nbsp;</td>
                                        <td class="carrito_compras_listado general_link <?php if($numero_items_carrito%2==0){ ?>carrito_compras_listado_selected<?php } ?>"><h4><?php echo $autoparte['name']; ?></h4>
                                            <h4><a href="<?php echo base_url(); ?>autopartes/ver_autoparte/<?php echo $autoparte['id']; ?>">Ver autoparte</a></h4></td>
                                        <td>&nbsp;</td>
                                        <td class="carrito_compras_listado general_link <?php if($numero_items_carrito%2==0){ ?>carrito_compras_listado_selected<?php } ?>"><h4><?php echo $autoparte['options']['descripcion_autoparte']; ?></h4></td>
                                        <td>&nbsp;</td>
                                        <td class="general_link carrito_compras_listado <?php if($numero_items_carrito%2==0){ ?>carrito_compras_listado_selected<?php } ?>"><h4><a href="<?php echo base_url(); ?>establecimientos/ver_establecimiento/<?php echo $autoparte['options']['id_establecimiento']; ?>/<?php echo $autoparte['options']['nombre_establecimiento']; ?>"><?php echo $autoparte['options']['nombre_establecimiento']; ?></a></h4></td>
                                        <td>&nbsp;</td>
                                        <td class="carrito_compras_listado <?php if($numero_items_carrito%2==0){ ?>carrito_compras_listado_selected<?php } ?>"><input type="submit" class="listado_autopartes_btn_compra" value="<?php echo number_format($autoparte['price'],0,',','.'); ?>"/></td>
                                        <td >&nbsp;</td>
                                        <td class="carrito_compras_listado <?php if($numero_items_carrito%2==0){ ?>carrito_compras_listado_selected<?php } ?>"><h3>$<?php echo number_format($autoparte['price']*$autoparte['qty'],0,',','.'); ?></h3></td>
                                        <td>&nbsp;</td>
                                        <td class="general_link carrito_compras_listado <?php if($numero_items_carrito%2==0){ ?>carrito_compras_listado_selected<?php } ?>"><h3><a href="<?php echo base_url(); ?>usuario/eliminar_carrito_compras/<?php echo $autoparte['rowid']; ?>">Eliminar</a></h3></td>
                                        <td >&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="17" class="general_separador_transparente"></td>
                                    </tr>
                                    <?php $numero_items_carrito++;
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
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td width="20">&nbsp;</td>
                <td width="340" valign="top" class="box_fondo"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="14" class="box_borde_izq">&nbsp;</td>
                            <td width="311" class="box_fondo_contenido"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="8" colspan="4" class="general_separador_transparente"></td>
                                    </tr>
                                    <tr>
                                        <td width="3%">&nbsp;</td>
                                        <td width="52%" class="carrito_compras_total carrito_compras_listado_selected"><h2>Precio:</h2></td>
                                        <td width="42%" class="carrito_compras_total_numeros carrito_compras_listado_selected"><h2>$<?php echo number_format($this->cart->total() - ($this->cart->total()*0.16),0,',','.'); ?></h2></td>
                                        <td width="3%">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td class="carrito_compras_total"><h2> IVA:</h2></td>
                                        <td  class="carrito_compras_total_numeros"><h2>$<?php echo number_format($this->cart->total()*0.16,0,',','.'); ?></h2></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td class="carrito_compras_total carrito_compras_listado_selected"><h1>TOTAL</h1></td>
                                        <td class="carrito_compras_total_numeros carrito_compras_listado_selected"><h2><strong>$<?php echo number_format($this->cart->total(),0,',','.'); ?></strong></h2></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="general_separador_transparente"></td>
                                    </tr>
                                </table></td>
                            <td width="13" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="14" class="box_esquina_inf_izq"></td>
                            <td class="box_borde_inf"></td>
                            <td class="box_esquina_inf_der"></td>
                        </tr>
                    </table></td>
                <td width="590" valign="middle" class="box_fondo"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="27%" align="right">
                                <?php if($this->cart->total_items()!=0){ ?>
                                    <?php if($this->session->userdata('esta_registrado')){ ?>
                                    <form id="forma_pagosonline" method="post" action="<?php echo $urlPagosOnline?>" target="_self">
                                    <input name="usuarioId" id="usuarioId" type="hidden" value="<?php echo $usuarioId?>">
                                    <input name="descripcion" id="descripcion" type="hidden" value="<?php echo $descripcion ?>" >
                                    <input name="refVenta" id="refVenta" type="hidden" value="<?php echo $refVenta ?>">
                                    <input name="valor" id="valor" type="hidden" value="<?php echo $valor ?>">
                                    <input name="iva" id="iva" type="hidden" value="<?php echo $iva ?>">
                                    <input name="baseDevolucionIva" id="baseDevolucionIva" type="hidden" value="<?php echo $baseDevolucionIva ?>" >
                                    <input name="firma" id="firma" type="hidden" value="<?php echo $firma?>">
                                    <input name="emailComprador" id="emailComprador" type="hidden" value="<?php echo $emailComprador?>">
                                    <input name="prueba" id="prueba" type="hidden" value="<?php echo $prueba?>">
                                    <input name="url_respuesta" id="url_respuesta" type="hidden" value="<?php echo $url_respuesta?>">
                                    <input name="url_confirmacion" id="url_confirmacion" type="hidden" value="<?php echo $url_confirmacion?>">
<!--                                    <input name="Submit" type="submit" class="carrito_compras_btn_comprar" title="Comprar" value="">-->
                                    </form>
                                    <?php } else { ?>
                                        <a id="registro-carrito-compras-id" href="#registro-carrito-compras" title="Registro o Inicio de Sesión" class="carrito_compras_btn_comprar" title="Comprar"><span>Comprar</span></a>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                            <td style="padding:10px;" width="73%" align="left"><h2>Compra las autopartes que necesitas de manera <strong>f&aacute;cil, r&aacute;pida y segura</strong> en Laspartes.com. <br/>
                                    <br/>
                                    <strong>Paso 1.</strong> Escoja las autopartes que requiere. <br/>
                                    <strong>Paso 2.</strong> Haga clic en Comprar. <br/>
                                    <strong>Paso 3.</strong> En breve, nos comunicaremos con usted para verificar la disponibilidad de las autopartes y ultimar detalles de pago, env&iacute;o e instalaci&oacute;n. * <br/>
                                    </h2><br/>
                                <h4>
                                    * El precio de las autopartes no incluye costos de env&iacute;o e instalaci&oacute;n.</h4>
                                <h4>
                                    * Algunos precios no incluyen IVA.</h4>
                                </td>
                        </tr>
                    </table></td>
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
        <div id="registro-carrito-compras">
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
                                    <?php $config = array('id' => 'formulario_checkout_carrito_compras_registrarse');
                                    echo form_open('usuario/checkout_carrito_compras_registrarse', $config); ?>
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
                        <?php $config = array('id' => 'formulario_checkout_carrito_compras_ingresar');
                        echo form_open('usuario/checkout_carrito_compras_ingresar', $config); ?>
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
                                                <td colspan="2" class="general_link" valign="middle" align="left" style="padding-top:5px;padding-bottom:5px;"><h3><a href="<?php echo base_url();?>usuario/formulario_olvido_contrasena">Olvid&eacute; mi contrase&ntilde;a</a></h3></td>
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