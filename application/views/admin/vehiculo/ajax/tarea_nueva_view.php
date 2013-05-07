<tr class="hoja_mto_table_tr">
    <td>
        <input type="hidden" value="0" name="hoja_mto_id_tarea_otros" class="hoja_mto_id_tarea_otros"/>
        <?php echo form_dropdown('id_tarea', $tareas, '1', 'class="hoja_mto_table_dd"'); ?> 
        <div class="hoja_mto_div_tarea_otros">
            <br/>*Si otro, cuál:
            <input class="hoja_mto_tarea_otros" type="text" name="otro" style="width: 267px;"/><br/><br/> 
            <label>Descripción de la tarea: </label><br/><textarea rows="8" cols="50" class="hoja_mto_textarea_otros" name="textAreaOtro"></textarea><br/><br/>
            <label>Seleccione una imagen de la tarea: </label><input type="file" accept="image/*" name="imagen" id="hoja_mto_file_otros" class="hoja_mto_file_otros" multiple />
        </div>
    </td>
    <td><input name="periodicidad" type="text" class="text medium hoja_mto_tarea_periodicidad" /></td>
    <td><input name="rango" type="text" class="text medium hoja_mto_tarea_rango" /></td>
    <td><?php $this->load->helper('date'); 
        $option_modelo = array();
        $selected = '2010';
        $año = intval(mdate('%Y')) + 1;
        for ($i = $año; $i > 1950; $i--) {
            $option_modelo[$i] = $i;
        }
        echo form_dropdown('modelo', $option_modelo, $selected, 'class="text medium hoja_mto_tarea_modelo", id="modelo"');
        ?>
    <td>
        <img class="hoja_mto_actualizar_tarea" src="<?php echo base_url(); ?>resources/admin/images/update.png"/>
        <img class="hoja_mto_eliminar_tarea" src="<?php echo base_url(); ?>resources/admin/images/x-red.gif"/>   
    </td>
</tr>