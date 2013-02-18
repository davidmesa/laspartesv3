<tr>
    <td>
        <table width="970" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="20">&nbsp;</td>
                <td width="605" valign="top" class="box_fondo">
                    <table width="605" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="15" rowspan="2" class="box_fondo">&nbsp;</td>
                            <td width="165" class="box_fondo"></td>
                            <td width="411" class="box_borde_sup" ></td>
                            <td width="14" height="14" class="box_esquina_sup_der"></td>
                        </tr>
                        <tr>
                            <td height="22" class="box_fondo box_titulo"><h1>AGREGAR VEH&Iacute;CULO</h1></td>
                            <td class="box_fondo_contenido box_ordenamiento"><a href="<?php echo base_url(); ?>usuario">Volver a mi cuenta</a></td>
                            <td rowspan="2" class="box_borde_der">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="box_borde_izq">&nbsp;</td>
                            <td colspan="2" class="box_fondo_contenido">
                                <?php $config = array('id' => 'formulario_agregar_vehiculo');
                                    echo form_open_multipart('usuario/agregar_vehiculo', $config); ?>
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
                                                    <td width="110" rowspan="4" valign="bottom" align="center"><img src="<?php echo base_url(); ?>resources/images/micuenta/tmpl_img_micuenta_vehiculo_nd.gif" width="99" height="99" alt="Foto vehiculo" /></td>
                                                    <td align="left" width="422" style="padding-left:10px;padding-top:5px;"><h2>&nbsp;</h2></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="padding-left:10px;padding-top:5px;"><h2>&nbsp;</h2></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="padding-left:20px;padding-top:5px;padding-bottom:5px;" class="general_formulario_texto"><h2>Foto de tu veh&iacute;culo:</h2></td>
                                                </tr>
                                                <tr>
                                                    <td align="left" valign="bottom" style="padding-bottom:5px;padding-left:20px;" class="general_formulario_texto">
                                                        <input type="text" id="txt_foto_vehiculo" class="general_cuadro_texto micuenta_input_textbox" readonly="readonly" size="35" />
                                                        <div class="micuenta_div_input">
                                                            &nbsp;<input type="button" value="Examinar..." class="micuenta_input_button general_boton_secundario" />
                                                            <input type="file" name="imagen" id="imagen" class="micuenta_input_hidden" onchange="javascript: document.getElementById('txt_foto_vehiculo').value = this.value" />
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
                                        <td class="general_formulario_texto" style="padding-bottom:5px;" align="right"><h2>Marca: *</h2></td>
                                        <td class="general_formulario_texto" style="padding-bottom:5px;padding-left:5px;" align="left">
                                            <select id="marca" name="marca">
                                                <option value="0">Seleccione una marca...</option>
                                                <?php if(sizeof($marcas)!=0){
                                                foreach($marcas as $marca){ ?>
                                                    <option value="<?php echo $marca->marca; ?>"><?php echo $marca->marca; ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="general_formulario_texto" style="padding-bottom:5px;" align="right"><h2>L&iacute;nea: *</h2></td>
                                        <td class="general_formulario_texto" style="padding-bottom:5px;padding-left:5px;" align="left">
                                            <select id="id_vehiculo" name="id_vehiculo">
                                                <option>Seleccione primero una marca...</option>
                                            </select>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="general_formulario_texto" style="padding-bottom:5px;" align="right"><h2>Modelo: *</h2></td>
                                        <td class="general_formulario_texto" style="padding-bottom:5px;padding-left:5px;" align="left">
                                            <input class="general_cuadro_texto" type="text" name="modelo" id="modelo" size="34" />
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                                                        <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="general_formulario_texto" style="padding-bottom:10px;" align="right"><h2>Kilometraje (kms):</h2></td>
                                        <td class="general_formulario_texto" style="padding-bottom:10px;padding-left:5px;" align="left">
                                            <h2>
                                                <?php
$option_kilometraje = array();
$selected = false;
$option_kilometraje['-1'] = 'No reconozco';
for($i = 1; $i < 100000; $i += 5000){
	$option_kilometraje[$i-1] = $i.' Km. - '.($i + 4999).' Km.';
	if(!$selected){
		$selected = $i;
	}
}
echo form_dropdown('kilometraje', $option_kilometraje, $selected);
?></h2></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="general_formulario_texto" style="padding-bottom:5px;" align="right"><h2>Placa:</h2></td>
                                        <td class="general_formulario_texto" style="padding-bottom:5px;padding-left:5px;" align="left">
                                            <input class="general_cuadro_texto" type="text" name="placa" id="placa" size="34" value=""/>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td colspan="2" class="general_formulario_texto" style="padding-bottom:10px;padding-right: 10px;" align="right"><h4>* Campos obligatorios</h4></td>

                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td colspan="2" style="padding-bottom:10px;padding-top:5px;" align="right">
                                            <input type="submit" class="general_boton_secundario" name="btn_agregar" id="btn_agregar" value="Agregar" />
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