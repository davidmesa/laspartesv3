<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Establecimientos :: Ver o Actualizar Oferta</title>


        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin/css/styles.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin/css/facebox.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin/css/autocomplete.css" />        

<!--        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery1.4.3.js"></script>-->
         <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
         <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery.datePicker.js"></script>

        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery-ui.custom.min.js"></script>


        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/scripts.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/facebox.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery.flot.pack.js"></script>
        <!--[if IE]>
            <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/excanvas.pack.js"></script>
        <![endif]-->

        <!--[if IE 6]>
            <script src="<?php echo base_url(); ?>resources/admin/js/pngfix.js"></script>
            <script>
                DD_belatedPNG.fix('.png_bg');
            </script>
        <![endif]-->
        <script type="text/javascript">
            
            var ids = new Array();
           $(document).ready(function() {
                $('#agregar_oferta').submit(function(){
                    for(id in ids){
                         var input = $("<input>").attr("type", "hidden").attr('value',ids[id]).attr('name','vehiculo_id[]').attr("class", "ids");
                         $(this).append(input);
                    }
                });
            });
            
            $(function(){
                var vehiculos = <?php echo json_encode($vehiculos); ?>;

                $("#vehiculos").autocomplete({
                    source: vehiculos,
                    select: function(e, ui) {
                        var vehiculo_actual = ui.item.value,
                        input = $("<input>").attr("type", "hidden").attr('value',ui.item.id_vehiculo).attr('name','vehiculo_id').attr("class", "ids");
                        span = $("<span>").html(vehiculo_actual);
                        a = $("<a>").addClass("remove").attr({
                            href: "javascript:",
                            title: "Remove " + vehiculo_actual
                        }).text("x").appendTo(span);
                        ids[ui.item.id_vehiculo] = ui.item.id_vehiculo;
                        input.insertBefore("#vehiculos");span.insertAfter(input);
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

        </script>
    </head>

    <body>
        <?php include_once './resources/admin-establecimiento/templates/header_include.php'; ?>
        <?php include_once './resources/admin-establecimiento/templates/establecimiento_submenu_include.php'; ?>

        <div id="main_content_wrap" class="container_12">
            <div class="container_12">
                <h2>Ver o Actualizar Oferta</h2>
                <?php echo validation_errors('<div class="notification failure canhide"><p>', '</p></div>'); ?>
                <?php if(isset ($confirmacion)){ ?>
                <div class="notification success canhide">
                    <p><?php echo $confirmacion; ?></p> 
                </div>
                <?php } ?>

                <?php $attributes = array('class' => 'agregar_oferta', 'id' => 'agregar_oferta');
                echo form_open(base_url().'admin-establecimiento/establecimiento/actualizar_establecimiento_oferta/'.$id_establecimiento, $attributes); ?>
                
                <?php 
                    $config_mini = array();   

                    $config_mini['toolbar'] = array(
                            array( 'Source', '-', 'Bold', 'Italic', 'Underline', '-','Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','NumberedList','BulletedList',
                                'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
                                '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl','Styles','Format','Font','FontSize','TextColor','BGColor'
                                ,'SelectAll','-','SpellChecker', 'Scayt')
                    );

                    /* Y la configuración del kcfinder, la debemos poner así si estamos trabajando en local */
                    $config_mini['filebrowserBrowseUrl'] = base_url()."ckeditor/kcfinder/browse.php";
                    $config_mini['filebrowserImageBrowseUrl'] = base_url()."ckeditor/kcfinder/browse.php?type=images";
                    $config_mini['filebrowserUploadUrl'] = base_url()."ckeditor/kcfinder/upload.php?type=files";
                    $config_mini['filebrowserImageUploadUrl'] = base_url()."ckeditor/kcfinder/upload.php?type=images";

                ?>
                    <input type="hidden" name="id_oferta" value="<?php echo $oferta->id_oferta; ?>" />
                    <p>
                      <label>Titulo</label><br />
                      <input name="titulo" type="text" class="text medium" value="<?php echo $oferta->titulo; ?>" />
                    </p>
                    <p>
                      <label>Precio</label><br />
                      <input name="precio" type="text" class="text medium" value="<?php echo $oferta->precio; ?>" />
                    </p>
                    <p>
                      <label>IVA</label><br />
                      <input name="iva" type="text" class="text medium" value="<?php echo $oferta->iva; ?>"/>
                    </p><br/>
                    <p>
                      <label>Descripcion</label>
                       <?php  echo $this->ckeditor->editor("descripcion", $oferta->descripcion, $config_mini);?>
                    </p><br/>
                    
                     <p>
                      <label>Condiciones</label>
                      <?php echo $this->ckeditor->editor("condiciones", $oferta->condiciones, $config_mini);?>
                    </p><br/>
                    
                    <p>
                      <label>Incluye</label>
                      <?php echo $this->ckeditor->editor("incluye", $oferta->incluye, $config_mini);?>
                    </p><br/>
                    
                    <div>
                        <label>Fecha de vigencia</label><br />
                        <input name="vigencia" id="Range" type="textbox" value="<?php echo $oferta->vigencia; ?>"/>
                        <div id="fromCalendar"></div>
                    </div>   
                    
                    <?php foreach ($categorias as $categoria): list($id, $nombre, $checked) = split('-', $categoria) ?>
                        <p>
                            <input name="categoria[]" type="checkbox" <?php echo $checked;?> class="checkbox" value="<?php echo $id; ?>" /><label style="padding-left: 5px;"><?php echo $nombre ?></label>
                        </p>
                    <?php endforeach; ?>
                    
                    
                    
                    <p>
                <p>
                <h2>Oferta en relación con los Vehículos</h2>
                    <p>Seleccione los vehículos compatibles con esta oferta.</p>

                        <fieldset>
                            <label id="vehiculosLabel">Vehículos: </label><br/>
                            <div id="vehiculos_disponibles" class="ui-helper-clearfix">
                                <?php foreach ($autos as $auto):?>
                                <input class="ids" type="hidden" value=" <?php echo $auto->id_vehiculo; ?>" name="vehiculo_id" />
                                <span>
                                <?php echo $auto->marca.' '.$auto->linea; ?>
                                <a class="remove" href="javascript:" title=" <?php echo $auto->marca.' '.$auto->linea; ?>">x</a>
                                </span>
                                     <?php endforeach; ?>
                                
                                <span><input id="vehiculos" name="id_vehiculos[]" type="text" /></span>
                            </div>
                        </fieldset>
                </p>
                    
                    <p>
          		<input type="submit" class="submit" value="Actualizar Oferta" />
                    </p>
                <?php echo form_close(); ?>
            </div>

                        <?php include_once './resources/admin-establecimiento/templates/footer_include.php'; ?>
        </div>
    </body>
</html>