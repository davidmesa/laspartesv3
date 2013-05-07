<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Establecimientos :: Agregar o Actualizar Establecimiento-Autopartes</title>

        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin-establecimiento/css/styles.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin-establecimiento/css/facebox.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin-establecimiento/css/jqueryui.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin-establecimiento/css/autocomplete.css" />

        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin-establecimiento/js/jquery1.4.3.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin-establecimiento/js/scripts.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/admin-establecimiento/js/facebox.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin-establecimiento/js/jquery.flot.pack.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin-establecimiento/js/jquery-ui.custom.min.js"></script>
        <script type="text/javascript">
            /*
             * Actualiza las autopartes de un establecimiento usando ajax
             */
            $(document).ready(function() {

                $("input[name^=precio_]").change( function() {

                    var id_autoparte = $(this).attr("name").split("_")[1];
                    // Check if it's checked
                    if($("#checkbox_"+id_autoparte).attr('checked'))
                    {
                        // Show the loading image and call an ajax update
                        $("#div_error_"+id_autoparte).hide();
                        $("#div_success_"+id_autoparte).hide();
                        $("#div_loading_"+id_autoparte).show();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>admin-establecimiento/establecimiento/ajax_actualizar_precio_establecimiento_autoparte",
                            context: this,
                            data: {
                                'id_autoparte': $(this).attr("name").split("_")[1],
                                'id_establecimiento': $("input[name=id_establecimiento]").val(),
                                'precio': $(this).val()
                            },
                            success: function(msg){
                                var id_autoparte = $(this).attr("name").split("_")[1];
                                $("#div_loading_"+id_autoparte).hide();
                                if(msg == "true")
                                {
                                    $("#div_success_"+id_autoparte).show();
                                }
                                else
                                {
                                    alert('No se pudo conectar. Intente nuevamente. Revise el precio.');
                                    $("#div_error_"+id_autoparte).show();
                                }
                            }
                        });
                    }

                });

                $("input[id^=checkbox_]").change( function() {

                    var id_autoparte = $(this).attr("id").split("_")[1];

                    // Show the loading image and call an ajax update
                    $("#div_error_"+id_autoparte).hide();
                    $("#div_success_"+id_autoparte).hide();
                    $("#div_loading_"+id_autoparte).show();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>admin-establecimiento/establecimiento/ajax_actualizar_establecimiento_autoparte",
                        context: this,
                        data: {
                            'id_autoparte': $(this).attr("id").split("_")[1],
                            'id_establecimiento': $("input[name=id_establecimiento]").val(),
                            'precio': $("input[name^=precio_"+$(this).attr("id").split("_")[1]+"]").val(),
                            'agregar': $(this).attr('checked')
                        },
                        success: function(msg){
                            var id_autoparte = $(this).attr("id").split("_")[1];
                            $("#div_loading_"+id_autoparte).hide();
                            if(msg == "true")
                            {
                                if(!$(this).attr('checked'))
                                    $("input[name^=precio_"+$(this).attr("id").split("_")[1]+"]").val("");
                                else if($("input[name^=precio_"+$(this).attr("id").split("_")[1]+"]").val() == "")
                                    $("input[name^=precio_"+$(this).attr("id").split("_")[1]+"]").val("0");
                                $("#div_success_"+id_autoparte).show();
                            }
                            else
                            {
                                alert('No se pudo conectar. Intente nuevamente. Revise el precio.');
                                $("#div_error_"+id_autoparte).show();
                            }
                        }
                    });

                });

            });
        </script>

        <script type="text/javascript">
            $(function(){
                var vehiculos = <?php echo json_encode($vehiculos); ?>;

                $("#vehiculos").autocomplete({
                    source: vehiculos,
                    select: function(e, ui) {
                        var vehiculo_actual = ui.item.value,
                        span = $("<span>").html("<input type='hidden' name='id_vehiculos[]' value='"+ui.item.id_vehiculo+"' />"+vehiculo_actual),
                        a = $("<a>").addClass("remove").attr({
                            href: "javascript:",
                            title: "Remove " + vehiculo_actual
                        }).text("x").appendTo(span);
                        span.insertBefore("#vehiculos");
                    },
                    change: function() {
                        $("#vehiculos").val("").css("top", 2);
                    }
                });

                $("#vehiculos_disponibles").click(function(){
                    $("#vehiculos").focus();
                });

                $(".remove", document.getElementById("vehiculos_disponibles")).live("click", function(){
                    $(this).parent().remove();
                    if($("#vehiculos_disponibles span").length === 0) {
                        $("#vehiculos").css("top", 0);
                    }
                });
            });

            $(function() {
                var autopartes = <?php echo $autopartes_autocomplete; ?>;

                $( "#autopartes" ).autocomplete({
                    minLength: 0,
                    source: autopartes,
                    focus: function( event, ui ) {
                        $( "#autopartes" ).val( ui.item.value );
                        return false;
                    },
                    select: function( event, ui ) {
                        $("#autocomplete").hide();
                        $("#autoparte_detalle").show();
                        
                        $("#autoparte_nombre").val(ui.item.nombre);
                        $("#autoparte_descripcion").val(ui.item.descripcion);
                        $("#autoparte_origen").val(ui.item.origen);
                        $("#autoparte_referencia").val(ui.item.referencia);

                        $("#autoparte_id_autoparte_marca option[value='"+ui.item.id_autoparte_marca+"']").attr('selected', 'selected');
                        $("#autoparte_id_autoparte_categoria option[value='"+ui.item.id_autoparte_categoria+"']").attr('selected', 'selected');
                        $("#autoparte_estado option[value='"+ui.item.estado+"']").attr('selected', 'selected');
                        
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url(); ?>admin-establecimiento/autoparte/ver_autoparte_vehiculos_ajax",
                            context: this,
                            dataType: 'json',
                            data: {
                                'id_autoparte': ui.item.id_autoparte
                            },
                            success: function(data){
                                var vehiculos_seleccionados = data;
                                for (var i = 0; i < vehiculos_seleccionados.length; i++){
                                    var vehiculo_actual = vehiculos_seleccionados[i].value,
                                    span = $("<span>").html("<input type='hidden' name='id_vehiculos[]' value='"+vehiculos_seleccionados[i].id_vehiculo+"' />"+vehiculo_actual),
                                    a = $("<a>").addClass("remove").attr({
                                        href: "javascript:",
                                        title: "Remove " + vehiculo_actual
                                    }).text("x").appendTo(span);
                                    span.insertBefore("#vehiculos");
                                }
                            }
                        });
                        return false;
                    }
                })
                .data( "autocomplete" )._renderItem = function( ul, item ){
                    return $( "<li></li>" )
                    .data( "item.autocomplete", item )
                    .append( "<a><b>" + item.value + "</b>"
                            + "<br>" + item.descripcion + "<br>"
                            + "<i>" + item.marca + "</i> de "
                            + "<i>" + item.origen + "</i><br>"
                            + "Vehículos: " + item.vehiculos + "</a>")
                    .appendTo( ul );
                };

                $("#autopartes").keypress(function(e){
                    if(e.which == 13){
                        $("#autocomplete").hide();
                        $("#autoparte_nombre").val($("#autopartes").val());
                        $("#autoparte_detalle").show();
                    }
                });
            });
        </script>

        

        <!--[if IE]>
            <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>resources/admin-establecimiento/js/excanvas.pack.js"></script>
        <![endif]-->

        <!--[if IE 6]>
            <script src="<?php echo base_url(); ?>resources/admin-establecimiento/js/pngfix.js"></script>
            <script>
                DD_belatedPNG.fix('.png_bg');
            </script>
        <![endif]-->
    </head>

    <body>
        <?php include_once './resources/admin-establecimiento/templates/header_include.php'; ?>
        <?php include_once './resources/admin-establecimiento/templates/establecimiento_submenu_include.php'; ?>

        <div id="main_content_wrap" class="container_12">
            <div class="container_12">
                <h2>Agregar Establecimiento-Autopartes</h2>
                 <p>Escriba una autoparte para asociarla o agregar una nueva autoparte.</p>
                 <p>Recuerde que las autopartes ya asociadas al establecimiento no aparece en el listado. Si desea cambiar el precio de una autoparte asociada, en el listado de abajo puede realizarlo.</p>
                <?php echo validation_errors('<div class="notification failure canhide"><p>', '</p></div>'); ?>
                <?php if(isset ($confirmacion)){ ?>
                <div class="notification success canhide">
                    <p><?php echo $confirmacion; ?></p>
                </div>
                <?php } ?>

               
                
                <div class="grid_8">
                    <div id="autocomplete">
                        <input id="autopartes"  />
                        <input type="hidden" id="id_autoparte" />
                    </div>

                    <div id="autoparte_detalle" style="display: none">
                        <?php echo form_open_multipart('admin-establecimiento/establecimiento/agregar_establecimiento_autoparte'); ?>
                        <input type="hidden" name="id_establecimiento" value="<?php echo $id_establecimiento; ?>" />
                        <p>
                          <label>Nombre</label><br />
                          <input name="nombre" id="autoparte_nombre" type="text" class="text medium" value="" />
                        </p>
                        <p>
                            <label>Marca</label><br />
                            <select name="id_autoparte_marca" id="autoparte_id_autoparte_marca" class="select">
                                <?php if(sizeof($marcas)!=0){
                                    foreach($marcas as $marca){ ?>
                                        <option value="<?php echo $marca->id_autoparte_marca; ?>"><?php echo $marca->nombre; ?></option>
                                <?php }
                                } ?>
                            </select>
                        </p>
                        <p>
                          <label>Categoría</label><br />
                          <select name="id_autoparte_categoria" id="autoparte_id_autoparte_categoria" class="select">
                                <?php if(sizeof($categorias)!=0){
                                    foreach($categorias as $categoria){ ?>
                                        <option value="<?php echo $categoria->id_autoparte_categoria; ?>"><?php echo $categoria->nombre; ?></option>
                                <?php }
                                } ?>
                            </select>
                        </p>
                        <p>
                          <label>Descripción</label><br />
                          <textarea name="descripcion" id="autoparte_descripcion" cols="8" rows="6"></textarea>
                        </p>
                        <p>
                          <label>Imagen</label><br />
                          <input name="imagen" id="autoparte_imagen" type="file" class="text medium" />
                        </p>
                        <p>
                          <label>Origen</label><br />
                          <input name="origen" id="autoparte_origen" type="text" class="text medium" value="" />
                        </p>
                        <p>
                          <label>Referencia</label><br />
                          <input name="referencia" id="autoparte_referencia" type="text" class="text medium" value="" />
                        </p>
                        <p>
                          <label>Estado</label><br />
                          <select name="estado" id="autoparte_estado">
                              <option value="Activo">Activo</option>
                              <option value="No Activo">No Activo</option>
                          </select>
                        </p>

                        <h2>Autoparte en relación con los Vehículos</h2>
                        <p>Seleccione los vehículos compatibles con esta autoparte.</p>
                        <fieldset>
                            <label id="vehiculosLabel">Vehículos: </label>
                            <div id="vehiculos_disponibles" class="ui-helper-clearfix">
                                <input id="vehiculos" name="vehiculos" type="text" />
                            </div>
                        </fieldset>
                        <p>
                          <label>Precio</label><br />
                          <input name="precio" id="autoparte_precio" type="text" class="text medium" value="0" />
                        </p>
                        <p>
                            <input type="submit" class="submit" value="Agregar Autoparte" />
                        </p>
                    <?php echo form_close(); ?>
                    </div>


                    <h2>Agregar o Actualizar Establecimiento-Autopartes</h2>
                    <p>A continuación se muestra las relaciones del establecimiento con las autopartes.</p>
                
                    <?php echo form_open('admin-establecimiento/establecimiento/actualizar_establecimiento_autopartes'); ?>
                        <input type="hidden" name="id_establecimiento" value="<?php echo $id_establecimiento; ?>" />
                        <table width="100%">
                            <tr>
                                <th width="5%" scope="col"><input type="checkbox" name="checkbox" id="checkbox" class="checkall" /><label for="checkbox"></label></th>
                                <th>Autoparte</th>
                                <th>Precio</th>
                            </tr>
                            <?php if(sizeof($autopartes)!=0){
                                foreach($autopartes as $autoparte){ 
                                    foreach($establecimiento_autopartes as $establecimiento_autoparte){
                                        if($establecimiento_autoparte->id_autoparte == $autoparte->id_autoparte){
                                    ?>
                            <tr>
                                <td><input id="checkbox_<?php echo $autoparte->id_autoparte; ?>" type="checkbox" name="id_autopartes[]" value="<?php echo $autoparte->id_autoparte; ?>" checked /></td>
                                <td>
                                    <?php echo $autoparte->nombre; ?><br/>
                                    <?php if($autoparte->referencia != "") echo "Ref:".$autoparte->referencia."<br/>"; ?>
                                    <strong>Marca:</strong> <?php echo $autoparte->marca; ?><br/>
                                    <strong>Vehículos:</strong><br/> <?php
                                        $texto = '';
                                        foreach( $autopartes_vehiculos as $autoparte_vehiculo )
                                        {
                                            if( $autoparte_vehiculo->id_autoparte == $autoparte->id_autoparte )
                                                $texto.= $autoparte_vehiculo->marca.' '.$autoparte_vehiculo->linea.'<br/> ' ;
                                        }
                                        echo substr($texto, 0, strlen($texto)-2);
                                    ?>
                                </td>
                                <td>
                                    <input name="precio_<?php echo $autoparte->id_autoparte; ?>" type="text" class="text small" value="<?php if(sizeof($establecimiento_autopartes)!=0){
                                    foreach($establecimiento_autopartes as $establecimiento_autoparte){
                                        if($establecimiento_autoparte->id_autoparte == $autoparte->id_autoparte)
                                           echo $establecimiento_autoparte->precio;
                                    }
                                } ?>" /><br/>
                                    <div id="div_loading_<?php echo $autoparte->id_autoparte; ?>" style="display: none;" align="center">
                                        <img alt="Loading"  src="<?php echo base_url(); ?>resources/admin/images/loading.gif" width="20" height="20" />
                                    </div>
                                    <div id="div_success_<?php echo $autoparte->id_autoparte; ?>" style="display: none;" align="center">
                                        <img alt="Uploaded"  src="<?php echo base_url(); ?>resources/admin/images/icondock/accept.png" width="20" height="20" />
                                    </div>
                                    <div id="div_error_<?php echo $autoparte->id_autoparte; ?>" style="display: none;" align="center">
                                        <img alt="Error"  src="<?php echo base_url(); ?>resources/admin/images/icondock/cancel.png" width="20" height="20" />
                                    </div>
                                </td>
                            </tr>
                            <?php }
                                    }
                                }
                            } ?>
                        </table>
                        <p>
                            <input type="submit" class="submit" value="Actualizar Asociaciones Establecimiento-Autopartes" />
                        </p>
                    <?php echo form_close(); ?>
                </div>
            </div>

            <?php include_once './resources/admin-establecimiento/templates/footer_include.php'; ?>
        </div>
    </body>
</html>