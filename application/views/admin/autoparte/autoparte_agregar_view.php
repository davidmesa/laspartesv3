<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Autopartes :: Agregar Autoparte</title>

        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin/css/styles.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin/css/facebox.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/admin/css/blueTablesorter.css" /> 

        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery1.4.3.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/scripts.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/facebox.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery.flot.pack.js"></script>
        <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery-ui.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/scripts.js"></script>

        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery.tablesorte.js"></script> 
        <script type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/jquery.tablesorter.widgets.js"></script> 
        <!--[if IE]>
            <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>resources/admin/js/excanvas.pack.js"></script>
        <![endif]-->

        <!--[if IE 6]>
            <script src="<?php echo base_url(); ?>resources/admin/js/pngfix.js"></script>
            <script>
                DD_belatedPNG.fix('.png_bg');
            </script>
        <![endif]--><script>
            $(function(){
                
                $("table").tablesorter({
                    theme: 'blue',

                    // hidden filter input/selects will resize the columns, so try to minimize the change
                    widthFixed : true,

                    // initialize zebra striping and filter widgets
                    widgets: ["zebra", "filter"],

                    // headers: { 5: { sorter: false, filter: false } },

                    widgetOptions : {

                        // If there are child rows in the table (rows with class name from "cssChildRow" option)
                        // and this option is true and a match is found anywhere in the child row, then it will make that row
                        // visible; default is false
                        filter_childRows : false,

                        // if true, a filter will be added to the top of each table column;
                        // disabled by using -> headers: { 1: { filter: false } } OR add class="filter-false"
                        // if you set this to false, make sure you perform a search using the second method below
                        filter_columnFilters : true,

                        // css class applied to the table row containing the filters & the inputs within that row
                        filter_cssFilter : 'tablesorter-filter',

                        // add custom filter functions using this option
                        // see the filter widget custom demo for more specifics on how to use this option
                        filter_functions : null,

                        // if true, filters are collapsed initially, but can be revealed by hovering over the grey bar immediately
                        // below the header row. Additionally, tabbing through the document will open the filter row when an input gets focus
                        filter_hideFilters : false,

                        // Set this option to false to make the searches case sensitive
                        filter_ignoreCase : true,

                        // jQuery selector string of an element used to reset the filters
                        filter_reset : 'button.reset',

                        // Delay in milliseconds before the filter widget starts searching; This option prevents searching for
                        // every character while typing and should make searching large tables faster.
                        filter_searchDelay : 300,

                        // Set this option to true to use the filter to find text from the start of the column
                        // So typing in "a" will find "albert" but not "frank", both have a's; default is false
                        filter_startsWith : false,

                        // Filter using parsed content for ALL columns
                        // be careful on using this on date columns as the date is parsed and stored as time in seconds
                        filter_useParsedData : false

                    }

                }); 
            });
        </script>
    </head>

    <body>
        <?php include_once './resources/admin/templates/header_include.php'; ?>
        <?php include_once './resources/admin/templates/autoparte_submenu_include.php'; ?>

        <div id="main_content_wrap" class="container_12">
            <div class="container_12">
                <h2>Agregar Autoparte</h2>
                <?php echo validation_errors('<div class="notification failure canhide"><p>', '</p></div>'); ?>
                <?php echo form_open_multipart('admin/autoparte/agregar_autoparte'); ?><?php
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
                    <p>
                      <label>Nombre</label><br />
                      <input name="nombre" type="text" class="text medium" value="<?php echo set_value('nombre'); ?>" />
                    </p>
                    <p>
                        <label>Marca</label><br />
                        <select name="id_autoparte_marca" class="select">
                            <?php if(sizeof($marcas)!=0){
                                foreach($marcas as $marca){ ?>
                                    <option value="<?php echo $marca->id_autoparte_marca; ?>"><?php echo $marca->nombre; ?></option>
                            <?php }
                            } ?>
                        </select>
                    </p>
                    <p>
                      <label>Categoría</label><br />
                      <select name="id_autoparte_categoria" class="select">
                            <?php if(sizeof($categorias)!=0){
                                foreach($categorias as $categoria){ ?>
                                    <option value="<?php echo $categoria->id_autoparte_categoria; ?>"><?php echo $categoria->nombre; ?></option>
                            <?php }
                            } ?>
                        </select>
                    </p>
                    <p>
                      <label>Descripción</label><br />
                      <?php echo $this->ckeditor->editor("descripcion", set_value('descripcion'), $config_mini); ?>
                    </p>
                    <p>
                      <label>Imagen</label><br />
                      <input name="imagen" type="file" class="text medium" />
                    </p>
                    <p>
                      <label>Origen</label><br />
                      <input name="origen" type="text" class="text medium" value="<?php echo set_value('origen'); ?>" />
                    </p>
                    <p>
                      <label>Referencia</label><br />
                      <input name="referencia" type="text" class="text medium" value="Todas Las Referencias" />
                    </p>
                    <p>
                      <label>Estado</label><br />
                      <select name="estado">
                          <option value="Activo">Activo</option>
                          <option value="No Activo">No Activo</option>
                      </select>
                    </p>

                    <h2>Autoparte en relación con los Vehículos</h2>
                    <p>Seleccione los vehículos compatibles con esta autoparte.</p>
                    <table width="100%">
                        <thead>
                        <tr>
                            <th width="5%" scope="col"><input type="checkbox" name="checkbox" id="checkbox" class="checkall" /><label for="checkbox"></label></th>
                            <th>Marca</th>
                            <th>Línea</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(sizeof($vehiculos)!=0){
                            foreach($vehiculos as $vehiculo){ ?>
                        <tr>
                            <td><input type="checkbox" name="id_vehiculos[]" value="<?php echo $vehiculo->id_vehiculo; ?>" /></td>
                            <td><?php echo $vehiculo->marca; ?></td>
                            <td><?php echo $vehiculo->linea; ?></td>
                        </tr>
                        <?php }
                        } ?>
                        </tbody>
                    </table>
                    <p>
                        <input type="submit" class="submit" value="Agregar Autoparte" />
                    </p>
                <?php echo form_close(); ?>
            </div>

            <?php include_once './resources/admin/templates/footer_include.php'; ?>
        </div>
    </body>
</html>