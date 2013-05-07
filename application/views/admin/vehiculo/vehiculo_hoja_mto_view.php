<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Usuarios :: Ver o Actualizar Vehículo</title>

        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin/css/styles.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin/css/facebox.css" />

        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery1.4.3.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/scripts.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/facebox.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery.flot.pack.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                //Al dar click a agregar tarea, se carga el formulario
                $('.hoja_mto_agregar_tarea').click(function(){
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>admin/vehiculo/dar_nueva_tarea_ajax",
                        async: false,
                        success: function(data){
                            $('#hoja_mto_table').append(data);
                        }
                    });
                }); 
                
                //al dar click al icono de eliminar, se elimina el formulario y el 
                //registro de la db
                $('.hoja_mto_eliminar_tarea').live('click', function(){
                    var padre = $('.hoja_mto_table_tr').has(this);
                    var idTarea = $('.hoja_mto_id_tarea_otros', padre).val();
                   $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>admin/vehiculo/eliminar_tarea_ajax",
                        async: false,
                        data: 'id_tarea= '+idTarea
                    });
                    $(padre).remove();
                });
                
                //al hacer click en actualizar, se envía el registro para ser 
                //actualizado/agregado en la db
                 $('.hoja_mto_actualizar_tarea').live('click', function(){
                    var form = $('#hoja_mto_form');
                    var padre = $('.hoja_mto_table_tr').has(this);
                    var id_servicio = $('.hoja_mto_table_dd', padre);
                    form.append(id_servicio);
                    var periodicidad = $('.hoja_mto_tarea_periodicidad', padre);
                    form.append(periodicidad);
                    var rango = $('.hoja_mto_tarea_rango', padre);
                    form.append(rango);
                    var modelo = $('.hoja_mto_tarea_modelo', padre);
                    form.append(modelo);
                    var id_vehiculo = '<?php echo $id_vehiculo;?>';
                    inputVehiculo = $('<input>').attr('name', 'id_vehiculo').attr('value', id_vehiculo);
                    form.append(inputVehiculo);
                    var otro = $('.hoja_mto_tarea_otros', padre);
                    form.append(otro);
                    var textAreaOtro = $('.hoja_mto_textarea_otros', padre);
                    form.append(textAreaOtro);
                    var fileOtro = $('.hoja_mto_file_otros', padre);
                    form.append(fileOtro);
                    var idTarea = $('.hoja_mto_id_tarea_otros', padre);
                    form.append(idTarea);
                    //TODO
                    //Hacer el form validation
                    form.submit();
                });

                
                //cuando se selecciona la opción de otros, sale un formulario 
                //para llenar los datos de la nueva tarea
                $('.hoja_mto_table_dd').live('change',function(){
                    var padre = $('.hoja_mto_table_tr').has(this);
                    if($(this).val()== 0){
                        $('.hoja_mto_div_tarea_otros', padre).show();
                    }else{
                        $('.hoja_mto_div_tarea_otros', padre).hide();
                    }
                });
            });
            
        </script>
    </head>

    <body>
        <?php include_once './resources/admin/templates/header_include.php'; ?>
        <?php include_once './resources/admin/templates/vehiculo_submenu_include.php'; ?>

        <div id="main_content_wrap" class="container_12">
            <div class="container_12">
                <h2>Ver o Actualizar la hoja de mantenimiento del vehículo <?php echo $vehiculo->marca.' '.$vehiculo->linea; ?></h2>
                <?php echo $mensaje;?>
                <p class="hoja_mto_agregar_tarea">
                    <img src="<?php echo base_url(); ?>resources/admin/images/add.png" alt="Agregar una tarea"> Agregar una tarea
                </p>
                <table id="hoja_mto_table" width="700"> 
                    <tr>
                        <th width="400">Tarea</th>
                        <th width="250">Periodicidad</th>
                        <th width="150">Rango de tolerancia(%)</th>
                        <th width="150">Modelo del vehículo</th> 
                        <th width="50">Acción</th>
                    </tr>
                    
                    <?php echo form_open_multipart('admin/vehiculo/actualizar_tarea_ajax', 'id="hoja_mto_form"'); ?>
                    <?php echo form_close(); ?>
                    <?php $model= 0; foreach ($hojas as $hoja): ?> 
                    
                        <?php if($hoja->modelo != $model): 
                             if($model == 0) $hoja->modelo; 
                             else echo '<tr class="hoja_mto_table_tr" style="background-color: gray;"><td colspan="5"></td></tr>';
                             $model = $hoja->modelo; 
                         endif;?>
                    
                        <tr class="hoja_mto_table_tr">
                            <td>
                                <input type="hidden" value="<?php echo $hoja->id_tarea;?>" name="hoja_mto_id_tarea_otros" class="hoja_mto_id_tarea_otros"/>
                                <?php echo form_dropdown('id_tarea', $tareas, $hoja->id_servicio, 'class="hoja_mto_table_dd"'); ?> 
                                <div class="hoja_mto_div_tarea_otros">
                                    <br/>*Si otro, cuál:
                                    <input class="hoja_mto_tarea_otros" type="text" name="otro" style="width: 267px;"/><br/><br/> 
                                    <label>Descripción de la tarea: </label><br/><textarea rows="8" cols="50" class="hoja_mto_textarea_otros" name="textAreaOtro"></textarea><br/><br/>
                                    <label>Seleccione una imagen de la tarea: </label><input type="file" accept="image/*" name="imagen" id="hoja_mto_file_otros" class="hoja_mto_file_otros" multiple />
                                </div>
                            </td>
                            <td><input name="periodicidad" type="text" class="text medium hoja_mto_tarea_periodicidad" value="<?php echo $hoja->periodicidad; ?>" /></td>
                            <td><input name="rango" type="text" class="text medium hoja_mto_tarea_rango" value="<?php echo $hoja->rango; ?>" /></td>
                            <td><?php
                                $option_modelo = array();
                                $selected = $hoja->modelo;
                                $año = intval(mdate('%Y')) +1;
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
                    <?php endforeach; ?>
                </table>
                <p class="hoja_mto_agregar_tarea">
                    <img src="<?php echo base_url(); ?>resources/admin/images/add.png" alt="Agregar una tarea"> Agregar una tarea
                </p>
            </div>

            <?php include_once './resources/admin/templates/footer_include.php'; ?>
        </div>
    </body>
</html>