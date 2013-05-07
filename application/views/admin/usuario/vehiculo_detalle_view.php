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
            $(document).ready(function() {
                $("#kilometraje").keydown(function(event) {
                    if ( event.keyCode == 46 || event.keyCode == 8 ){}
                    else {
                        if (event.keyCode < 48 || event.keyCode > 57 )
                            event.preventDefault();
                    }
                });
                $("#modelo").keydown(function(event) {
                    if ( event.keyCode == 46 || event.keyCode == 8 ){}
                    else {
                        if (event.keyCode < 48 || event.keyCode > 57 )
                            event.preventDefault();
                    }
                });

                 $("#marca").change(function (){
                     $("#id_vehiculo").empty();
                     if($("#marca").val()=='Seleccione una marca...')
                        $("#id_vehiculo").append("<option>Seleccione primero una marca...</option>");
                     else{
                        $("#id_vehiculo").append("<option>Cargando líneas...</option>");
                        $.ajax({
                            url: "<?php echo base_url(); ?>usuario/dar_vehiculos_lineas_ajax/",
                            type: "POST",
                            data: {
                                marca: function(){ return $("#marca option:selected").val(); }
                            },
                            onsubmit: false,
                            success: function(data){
                                $("#id_vehiculo").empty();
                                $.each($.parseJSON(data), function(i,item){
                                    $("#id_vehiculo").append("<option value='"+item.id_vehiculo+"'>"+item.linea+"</option>");
                                });
                            }
                        });
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
                <h2>Ver o Actualizar Vehículo de un Usuario</h2>
                <?php echo validation_errors('<div class="notification failure canhide"><p>', '</p></div>'); ?>
                <?php echo form_open('admin/usuario/actualizar_usuario_vehiculo'); ?>
                    <input type="hidden" name="id_usuario_vehiculo" value="<?php echo $vehiculo->id_usuario_vehiculo; ?>" />
                    <input type="hidden" name="id_usuario" value="<?php echo $vehiculo->id_usuario; ?>" />
                    <p>
                      <label>Nombre</label><br />
                      <input name="nombre" type="text" class="text medium" value="<?php echo $vehiculo->nombre; ?>" />
                    </p>
                    <p>
                        <label>Marca</label><br />
                        <select id="marca" name="marca">
                            <option>Seleccione una marca...</option> 
                            <?php if(sizeof($marcas)!=0){
                            foreach($marcas as $marca){ ?>
                            <option value="<?php echo $marca->marca; ?>" <?php if($marca->marca == $vehiculo->marca){ ?>selected<?php } ?>><?php echo $marca->marca; ?></option>
                            <?php }
                            } ?>
                        </select>
                    </p>
                    <p>
                        <label>Línea</label><br />
                        <select id="id_vehiculo" name="id_vehiculo">
                            <?php if(sizeof($lineas)!=0){
                            foreach($lineas as $linea){ ?>
                            <option value="<?php echo $linea->id_vehiculo; ?>" <?php if($linea->id_vehiculo == $vehiculo->id_vehiculo){ ?>selected<?php } ?>><?php echo $linea->linea; ?></option>
                            <?php }
                            } ?>
                        </select>
                    </p>
                    <p>
                      <label>Modelo</label><br />
                      <input name="modelo" type="text" class="text medium" value="<?php echo $vehiculo->modelo; ?>" />
                    </p>
                    <p>
                      <label>Kilometraje</label><br />
                      <input name="kilometraje" type="text" class="text medium" value="<?php echo $vehiculo->kilometraje; ?>" />
                    </p>
                    <p>
                      <label>Placa</label><br />
                      <input name="placa" type="text" class="text medium" value="<?php echo $vehiculo->numero_placa; ?>" />
                    </p>
                    <p>
                      <label>Fecha SOAT (YYYY-MM-DD)</label><br />
                      <input name="soat" type="text" class="text medium" value="<?php echo $soat; ?>" disabled />
                    </p>
                    <p>
                      <label>Fecha Revisi&oacute;n (YYYY-MM-DD)</label><br /> 
                      <input name="revision" type="text" class="text medium" value="<?php echo $tecnomecanica; ?>" disabled />
                    </p>
                    <p>
                      <label>Fecha</label><br />
                      <?php echo $vehiculo->fecha; ?>
                    </p>
                    <p>
                      <label>Imagen</label><br />
                      <?php if($vehiculo->imagen_thumb_url!='' && $vehiculo->imagen_thumb_url!=NULL){ ?><img src="<?php echo $vehiculo->imagen_thumb_url; ?>" alt="Imagen del Vehículo" /><br />
                      <a href="<?php echo base_url(); ?>admin/usuario/eliminar_usuario_vehiculo_imagen/<?php echo $vehiculo->id_usuario_vehiculo; ?>" onclick="return confirm('¿Está seguro de eliminar esta imagen? Recuerde que no se puede deshacer esta decisión.');"><img src="<?php echo base_url(); ?>resources/admin/images/cancel.png" alt="Eliminar la imagen" />Eliminar la imagen del vehículo</a><?php } ?>
                    </p>
                    <p>
          		<input type="submit" class="submit" value="Actualizar Vehículo" />
                    </p>
                <?php echo form_close(); ?>
            </div>

            <?php include_once './resources/admin/templates/footer_include.php'; ?>
        </div>
    </body>
</html>