<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Las Partes Admin :: Taller en Línea :: Ver o Actualizar Pregunta</title>

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
    </head>

    <body>
        <?php include_once './resources/admin/templates/header_include.php'; ?>
        <?php include_once './resources/admin/templates/taller_en_linea_submenu_include.php'; ?>

        <div id="main_content_wrap" class="container_12">
            <div class="container_12">
                <h2>Ver o Actualizar Pregunta</h2>
                <?php echo validation_errors('<div class="notification failure canhide"><p>', '</p></div>'); ?>
                <?php if(isset ($confirmacion)){ ?>
                <div class="notification success canhide">
                    <p><?php echo $confirmacion; ?></p>
                </div>
                <?php } ?>

                <?php echo form_open('admin/taller_en_linea/actualizar_pregunta'); ?>
                    <input type="hidden" name="id_pregunta" value="<?php echo $pregunta->id_pregunta; ?>" />
                    <p>
                      <label>Título</label><br />
                      <textarea cols="10" rows="10" name="titulo_pregunta"><?php echo $pregunta->titulo_pregunta; ?></textarea>
                    </p>
                    <p>
                      <label>Detalles</label><br />
                      <textarea cols="10" rows="10" name="cuerpo_pregunta"><?php echo $pregunta->cuerpo_pregunta; ?></textarea>
                    </p>
                    <p>
                        <label>Categoría</label><br />
                        <select name="id_pregunta_categoria" class="select">
                            <?php if(sizeof($preguntas_categorias)!=0){
                                foreach($preguntas_categorias as $pregunta_categoria){ ?>
                            <option value="<?php echo $pregunta_categoria->id_pregunta_categoria; ?>" <?php if($pregunta_categoria->id_pregunta_categoria==$pregunta->id_pregunta_categoria){ ?>selected<?php } ?>><?php echo $pregunta_categoria->nombre; ?></option>
                            <?php }
                            } ?>
                        </select>
                    </p>
                    <p>
                      <label>Palabras Clave</label><br />
                      <input name="palabras_clave" type="text" class="text medium" value="<?php echo $pregunta->palabras_clave; ?>" />
                    </p>
                    <p>
                        <label>Estado</label><br />
                        <select name="estado" class="select">
                            <option value="Activo" <?php if($pregunta->estado=='Activo'){ ?>selected<?php } ?>>Activo</option>
                            <option value="No Activo" <?php if($pregunta->estado=='No Activo'){ ?>selected<?php } ?>>No Activo</option>
                        </select>
                    </p>
                    <p>
          		<input type="submit" class="submit" value="Actualizar Pregunta" />
                    </p>
                <?php echo form_close(); ?>

                <h2>Respuestas</h2>
                <div>
                    <?php if(sizeof($respuestas)!=0){
                        foreach($respuestas as $respuesta){ ?>
                        <?php echo form_open('admin/taller_en_linea/actualizar_respuesta'); ?>
                            <input type="hidden" name="id_respuesta" value="<?php echo $respuesta->id_respuesta; ?>" />
                            <input type="hidden" name="id_pregunta" value="<?php echo $pregunta->id_pregunta; ?>" />

                            <p><b>Usuario: </b><?php echo $respuesta->usuario; ?></p>
                            <p><b>Fecha: </b><?php echo $respuesta->fecha; ?></p>
                            <p>
                              <label>Respuesta</label><br />
                              <textarea cols="10" rows="10" name="respuesta"><?php echo $respuesta->respuesta; ?></textarea>
                            </p>
                            <p>
                                <input type="submit" class="submit" value="Actualizar Respuesta" />
                            </p>
                            <p>
                                <a href="<?php echo base_url(); ?>admin/taller_en_linea/eliminar_respuesta/<?php echo $pregunta->id_pregunta; ?>/<?php echo $respuesta->id_respuesta; ?>" onclick="return confirm('¿Está seguro de eliminar esta respuesta?');"><input type="button" class="submit" value="Eliminar Respuesta" /></a>
                            </p>
                            <hr />
                        <?php echo form_close(); ?>
                    <?php }
                    } ?>
                </div>
            </div>

            <?php include_once './resources/admin/templates/footer_include.php'; ?>
        </div>
    </body>
</html>