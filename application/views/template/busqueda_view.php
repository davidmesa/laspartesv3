<tr>
    <td>
        <table width="970" height="63" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="220" height="63">&nbsp;</td>
                <?php
                    $funcion = 'buscar/general';
                    $seccion = $this->uri->segment(1, '');
                    if($seccion=='autopartes' || $seccion=='establecimientos' || $seccion=='taller_en_linea' || $seccion=='aprende')
                        $funcion = 'buscar/'.$seccion;
                    echo form_open($funcion);
                ?>
                    <td width="436" class="busqueda"><input name="busqueda" type="text" class="busqueda_cuadro_texto" id="busqueda" value="<?php if($busqueda){ echo $busqueda;}?>"/></td>
                    <td width="80" class="busqueda"><input name="btn_busqueda_gral" type="submit" class="busqueda_boton" id="btn_busqueda_gral" value="Buscar" /></td>
                <?php echo form_close(); ?>
                <td width="14" class="busqueda">&nbsp;</td>
                <td width="220" class="home_carrito general_link" align="right" valign="middle" style="padding-right:10px;" >
                    <h4>
                        <a href="<?php echo base_url().'usuario/ver_carrito_compras' ?>">Mis compras (<?php echo $this->cart->total_items(); ?>)</a>
                    </h4>
                </td>
            </tr>
        </table>
    </td>
</tr>