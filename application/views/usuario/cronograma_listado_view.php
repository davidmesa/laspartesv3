<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>resources/css/fonts.css" type="text/css" charset="utf-8" />
        <title><?php echo $titulo; ?></title>
        <style>
            #usuario-div-lightbox-cronograma{
                background-color: white;
                padding: 30px 50px;
                font-family: 'open_sansregular';
                width: 700px;
            }

            #usuario-div-lightbox-cronograma-header{
                color: #c60200;
                font-size: 25px;
                margin-bottom: 15px;
            }

            .usuario-div-lightbox-cronograma-titulo{
                font-weight: bold;
                font-size: 14px;
            }

            .usuario-div-lightbox-cronograma-fecha{
                padding-left: 30px;
                font-size: 12px;
            }
            .usuario-div-lightbox-cronograma-content{
                float: left;
                width: 500px;
            }
            .usuario-div-lightbox-cronograma-marco{
                float: left;
                max-width: 120px;
                padding: 2px;
                border: 1px solid #ccc;
                margin-right: 20px;
            }
            
            .usuario-div-lightbox-cronograma-marco img{
                max-width: 120px;
            }
        </style>



    </head>
    <body>
        <div id="usuario-div-lightbox-cronograma">
            <div id="usuario-div-lightbox-cronograma-header">Cronograma de mantenimiento de mi vehículo</div>
            <?php foreach ($tareas_cronograma as $tarea_cronograma): ?>
            <div style="margin-bottom: 20px;">
                <div class="usuario-div-lightbox-cronograma-marco">
                <img src="<?php echo base_url().$tarea_cronograma->img;?>" alt="<?php echo $tarea_cronograma->titulo;?>"/>
            </div>
            <div class="usuario-div-lightbox-cronograma-content">
                <div class="usuario-div-lightbox-cronograma-titulo"><?php echo $tarea_cronograma->titulo; ?></div>
                <div class="usuario-div-lightbox-cronograma-fecha"><?php echo $tarea_cronograma->fecha; ?></div>
            </div>
            <div style="clear: both;"></div>    
            </div>
            <?php endforeach; ?>
        </div>
    </body>
</html>