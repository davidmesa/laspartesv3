<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: usuarios :: Lista de Usuarios</title>

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
        <![endif]-->
        <script>
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
                        filter_searchDelay : 100,

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
        <?php include_once './resources/admin/templates/usuario_submenu_include.php'; ?>

        <div id="main_content_wrap" class="container_12">
            <div class="container_12">
                <?php if (isset($confirmacion)) { ?>
                    <div class="notification success canhide">
                        <p><?php echo $confirmacion; ?></p>
                    </div>
                <?php }
                if (isset($error)) {
                    ?>
                    <div class="notification failure canhide">
                        <p><?php echo $error; ?></p>
                    </div>
<?php } ?>

                <h2>Lista de Usuarios</h2>
                <a title="Agregar usuario" href="<?php echo base_url(); ?>admin/usuario/formulario_usuario"><img src="<?php echo base_url(); ?>resources/admin/images/add.png" alt="Agregar una autoparte" /> Agregar un usuario (Administrador o Establecimiento)</a>

                <table width="100%"  id="backend_tabla" class="tablesorter">
                    <thead>
                        <tr class="tablesorter-headerRow">
                            <th data-placeholder="ID">ID</th>
                            <th data-placeholder="Usuario" class="tablesorter-header" width="100">Usuario</th>
                            <th data-placeholder="Tipo" class="tablesorter-header">Tipo</th>
                            <th data-placeholder="Nombres" class="tablesorter-header">Nombres</th>
                            <th data-placeholder="Apellidos" class="tablesorter-header">Apellidos</th>
                            <th data-placeholder="Correo electrónico" class="tablesorter-header">Correo Electrónico</th>
                            <th data-placeholder="Lugar" class="tablesorter-header">Lugar</th>
                            <th data-placeholder=""  class="tablesorter-header filter-false">Estado</th>
                            <th data-placeholder=""  class="tablesorter-header filter-false">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (sizeof($usuarios) != 0) {
                            foreach ($usuarios as $usuario) {
                                ?>
                                <tr>
                                    <td><a href="<?php echo base_url(); ?>admin/usuario/ver_usuario/<?php echo $usuario->id_usuario; ?>"><?php echo $usuario->id_usuario; ?></a></td>
                                    <td><?php echo $usuario->usuario; ?></td>
                                    <td>
                                        <?php
                                        if ($usuario->tipo == 10) {
                                            echo 'Administrador';
                                        } else if ($usuario->tipo == 20) {
                                            echo 'Establecimiento';
                                        } else if ($usuario->tipo == 30) {
                                            echo 'Usuario Normal';
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $usuario->nombres; ?></td>
                                    <td><?php echo $usuario->apellidos; ?></td>
                                    <td><?php echo $usuario->email; ?></td>
                                    <td><?php echo $usuario->lugar; ?></td>
                                    <td><?php if ($usuario->estado == 'Activo') { ?><img src="<?php echo base_url(); ?>resources/admin/images/bullet_green.png" alt="Activo" /><?php } else { ?><img src="<?php echo base_url(); ?>resources/admin/images/bullet_red.png" alt="No Activo" /><?php } ?></td>
                                    <td>
                                        <a title="Ver usuario" href="<?php echo base_url(); ?>admin/usuario/ver_usuario/<?php echo $usuario->id_usuario; ?>"><img src="<?php echo base_url(); ?>resources/admin/images/pencil.png" alt="Ver o Actualizar Usuario" /></a>
                                        <a title="Agregar compra" href="<?php echo base_url(); ?>admin/usuario/recibo/<?php echo $usuario->id_usuario; ?>"><img src="<?php echo base_url(); ?>resources/admin/images/shopping-cart.png" alt="Generar recibo de pago"></a>
                                        <a title="Agregar orden de remisión" href="<?php echo base_url(); ?>admin/usuario/bono/<?php echo $usuario->id_usuario; ?>"><img src="<?php echo base_url(); ?>resources/admin/images/shopping-cart.png" alt="Generar recibo de pago"></a>
                                    </td>
                                </tr>
    <?php }
}
?>
                    </tbody>
                </table>
            </div>

<?php include_once './resources/admin/templates/footer_include.php'; ?>
        </div>
    </body>
</html>