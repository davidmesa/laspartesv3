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
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script> 
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery.datePicker.js"></script>

        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery-ui.custom.min.js"></script>


        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/scripts.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/facebox.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery.flot.pack.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.validate.js"></script>
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
                //                $('#agregar_oferta').submit(function(){
                //                    for(id in ids){
                //                         var input = $("<input>").attr("type", "hidden").attr('value',ids[id]).attr('name','vehiculo_id[]').attr("class", "ids");
                //                         $(this).append(input);
                //                    }
                //                });
            });
            
            $(function(){
                var vehiculos = <?php echo json_encode($vehiculos); ?>;

                $("#vehiculos").autocomplete({
                    source: vehiculos,
                    select: function(e, ui) {
                        var vehiculo_actual = ui.item.value,
                        input = $("<input>").attr("type", "hidden").attr('value',ui.item.id_vehiculo).attr('name','vehiculo_id[]').attr("class", "ids");
                        span = $("<span>").html(vehiculo_actual);
                        a = $("<a>").addClass("remove").attr({
                            href: "javascript:",
                            title: "Remove " + vehiculo_actual
                        }).text("x").appendTo(span);
                        ids[ui.item.id_vehiculo] = ui.item.id_vehiculo;
                        var vehiculos = $('span').has("#vehiculos");
                        input.insertBefore(vehiculos);
                        span.insertAfter(input);
                    },
                    change: function() {
                        $("#vehiculos").val("").css("top", 2); 
                    }
                });

                $("#vehiculos_disponibles").click(function(){
                    $("#vehiculos").focus();
                });

                $("#vehiculos_disponibles .remove").live("click", function(){
                    var span = $("span").has(this);
                    $(span).prev('input').remove();
                    $(span).remove();
                });
                
                $("#agregar_oferta").validate({
                    rules: {
                        titulo: {
                            required: true
                        },precio: {
                            required: true,
                            number: true
                        },iva: {
                            required: true,
                            number: true
                        },margen: {
                            required: true,
                            number: true
                        },descuento: {
                            required: true,
                            number: true
                        },plazo: {
                            required: true,
                            number: true
                        }
                    },
                    messages: {
                        titulo: "*Debes escribir el título de la oferta",
                        precio: {
                            required: "*Debes escribir el precio de la promoción",
                            number: "*El campo precio debe ser un número"
                        },
                        iva: {
                            required: "*Debes escribir el precio de la promoción",
                            number: "*El campo precio debe ser un número"
                        },
                        margen: {
                            required: "*Debes escribir el precio de la promoción",
                            number: "*El campo precio debe ser un número"
                        },
                        descuento: {
                            required: "*Debes escribir el precio de la promoción",
                            number: "*El campo precio debe ser un número"
                        },
                        plazo: {
                            required: "*Debes escribir el precio de la promoción",
                            number: "*El campo precio debe ser un número"
                        }
                    }, 
                    errorClass: "form-invalid",
                    validClass: "form-valid",
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass(errorClass);
                        var divValid =  $(element.form).find("div[for=" + element.id + "]");
                        divValid.addClass(errorClass);
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass(errorClass).removeClass(validClass);
                        var divValid =  $(element.form).find("div[for=" + element.id + "]");
                        divValid.addClass(validClass).removeClass(errorClass);
                    },
                    invalidHandler: function (form, validator) {
                        var errors = validator.numberOfInvalids();
                        if (errors) {
                            var message = errors == 1 ? 'Se encontró el siguiente error:\n' : 'Se encontraron los siguientes ' + errors + ' errores:\n';
                            var errors = "";
                            if (validator.errorList.length > 0) {
                                for (x = 0; x < validator.errorList.length; x++) {
                                    errors += "\n\u25CF " + validator.errorList[x].message
                                }
                            }
                            alert(message + errors)
                        }
                        validator.focusInvalid()
                    },
                    submitHandler: function (form) {
                        form.submit();
                        return false;
                    }
                });
            });
        </script>
    </head>

    <body>
        <?php include_once './resources/admin/templates/header_include.php'; ?>
        <?php include_once './resources/admin/templates/establecimiento_submenu_include.php'; ?>

        <div id="main_content_wrap" class="container_12">
            <div id="oferta-img-no-display">
                <img src="<?php echo base_url(); ?>resources/admin/images/oferta.jpg" />
            </div>
            <div class="container_12">
                <h2>Ver o Actualizar Oferta</h2>
                <h3>Url: <a href="<?php echo base_url().'promociones/'.$oferta->id_oferta.'-'.preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $oferta->titulo);?>"><?php echo base_url().'promociones/'.$oferta->id_oferta.'-'.preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $oferta->titulo);?></a></h3>
                <?php echo validation_errors('<div class="notification failure canhide"><p>', '</p></div>'); ?>
                <?php if (isset($confirmacion)) { ?>
                    <div class="notification success canhide">
                        <p><?php echo $confirmacion; ?></p>
                    </div>
                <?php } ?>

                <?php
                $attributes = array('class' => 'agregar_oferta', 'id' => 'agregar_oferta');
                echo form_open_multipart(base_url() . 'admin/establecimiento/actualizar_establecimiento_oferta/' . $id_establecimiento, $attributes);
                ?>

                <?php
                $config_mini = array();

                $config_mini['toolbar'] = array(
                    array('Source', '-', 'Bold', 'Italic', 'Underline', '-', 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', '-', 'NumberedList', 'BulletedList',
                        'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv',
                        '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Styles', 'Format', 'Font', 'FontSize', 'TextColor', 'BGColor'
                        , 'SelectAll', '-', 'SpellChecker', 'Scayt')
                );

                /* Y la configuración del kcfinder, la debemos poner así si estamos trabajando en local */
                $config_mini['filebrowserBrowseUrl'] = base_url() . "ckeditor/kcfinder/browse.php";
                $config_mini['filebrowserImageBrowseUrl'] = base_url() . "ckeditor/kcfinder/browse.php?type=images";
                $config_mini['filebrowserUploadUrl'] = base_url() . "ckeditor/kcfinder/upload.php?type=files";
                $config_mini['filebrowserImageUploadUrl'] = base_url() . "ckeditor/kcfinder/upload.php?type=images";
                ?>
                <input type="hidden" name="id_oferta" value="<?php echo $oferta->id_oferta; ?>" />
                <div class="form_login_div_campo">
                    <label>Titulo</label>
                    <input title="Titulo de la oferta" name="titulo" id="titulo" type="text" class="text medium" value="<?php echo $oferta->titulo; ?>" />
                    <div for="titulo"></div>
                </div>
                <div class="form_login_div_campo small"> 
                    <label>Precio (Valor del item para el usuario, sin comas ni puntos)</label>
                    $<input title="Precio de la oferta" name="precio" id="precio" type="text" class="text small" value="<?php echo $oferta->precio; ?>" />
                    <div for="precio"></div>
                </div>
                <div class="form_login_div_campo small">
                    <label>IVA (valor del iva para el usuario, sin comas ni puntos)</label>
                    $<input title="IVA de la oferta" name="iva" type="text" id="iva" class="text small" value="<?php echo $oferta->iva; ?>"/>
                    <div for="iva"></div>
                </div>
                <div class="form_login_div_campo small">
                    <label>Margen de Laspartes (Valor del margen que gana laspartes, sin comas ni puntos)</label>
                    $<input title="Margen de la oferta" name="margen" type="text" id="margen" class="text small" value="<?php echo $oferta->margenLP; ?>"/>
                    <div for="margen"></div>
                </div>
                <div class="form_login_div_campo small">
                    <label>Descuento de promoción (Porcentaje de descuento sobre el valor total)</label>
                    <input title="Descuento de la oferta" name="descuento" type="text" id="descuento" class="text small" value="<?php echo $oferta->dco_feria; ?>"/>%
                    <div for="descuento"></div>
                </div>
                <div class="form_login_div_campo small">
                    <label>Plazo de uso (Número de días para que el usuario haga efectiva la compra)</label>
                    <input title="Plazo de uso de la oferta" name="plazo" type="text" id="plazo" class="text small" value="<?php echo $oferta->plazo_uso; ?>"/>Días
                    <div for="plazo"></div>
                </div>
                <div class="form_login_div_campo small">
                    <label>Imagen de la oferta: (Imagenes con extención JPG, PNG y GIF)</label>
                    <?php if(!empty($oferta->foto)):?><img src="<?php echo base_url().$oferta->foto; ?>" alt="imagen de la oferta" style="max-width: 400px;"/><br/><?php endif; ?>
                    <input name="imagen" type="file" id="imagen" class="small" />
                    <div for="plazo"></div>
                </div>

                <p>
                    <label>Condiciones</label>
                    <?php echo $this->ckeditor->editor("condiciones", $oferta->condiciones, $config_mini); ?>
                </p>

                <p>
                    <label>Incluye</label>
                    <?php echo $this->ckeditor->editor("incluye", $oferta->incluye, $config_mini); ?>
                </p>

                <div class="form_login_div_campo">
                    <label>Fecha de vigencia</label><br />
                    <input title="Fecha de vigencia de la oferta" name="vigencia" id="Range" class="text small" type="textbox" value="<?php echo $oferta->vigencia; ?>"/>
                    <div for="Range"></div>
                    <div id="fromCalendar"></div>
                </div>   
                <h2>Categoría de la oferta</h2>
                <p>Seleccione los las categorías compatibles con esta oferta</p>
                <div class="oferta-tabla-categoria">
                    <table width="340">
                        <tr>
                            <th width="5%" scope="col"></th>
                            <th>Servicio</th>
                        </tr>
                        <?php foreach ($categorias as $categoria): list($id, $nombre, $checked) = split('-', $categoria) ?>
                            <tr>
                                <td>
                                    <input name="categoria[]" type="checkbox" <?php echo $checked; ?> class="checkbox" value="<?php echo $id; ?>" />
                                </td>
                                <td>
                                    <?php echo $nombre ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <div class="form_login_div_campo">
                        <span>Otra, cuál?: </span>
                        <input type="text" name="categoria_otra" id="categoria_otra" class="text medium"></input>
                        <div for="categoria_otra"></div>
                    </div>

                    <div id="oferta-img-no-display2">
                        <img src="<?php echo base_url(); ?>resources/admin/images/categoria.jpg"  style="margin-right: 120px;"/>
                    </div>
                </div>

                <p>
                    <p>
                        <h2>Oferta en relación con los Vehículos</h2>
                        <p>Seleccione los vehículos compatibles con esta oferta.</p>

                        <fieldset>
                            <label id="vehiculosLabel">Vehículos: </label><br/>
                            <div id="vehiculos_disponibles" class="ui-helper-clearfix">

                                <?php foreach ($autos as $auto): ?>
                                    <input class="ids" type="hidden" value="<?php echo $auto->id_vehiculo; ?>" name="vehiculo_id[]" />
                                    <span><?php echo $auto->marca . ' ' . $auto->linea; ?><a class="remove" href="javascript:" title=" <?php echo $auto->marca . ' ' . $auto->linea; ?>">x</a></span>
                                <?php endforeach; ?>
                                <span><input id="vehiculos" name="id_vehiculo" type="text" /></span>
                            </div>
                        </fieldset>
                    </p>

                    <p>
                        <input type="submit" class="submit" value="Actualizar Oferta" />
                    </p>
                    <?php echo form_close(); ?>
            </div>

            <?php include_once './resources/admin/templates/footer_include.php'; ?>
        </div>
    </body>
</html>