<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $titulo; ?></title>
        <link href="<?php echo base_url(); ?>resources/css/estilo.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>resources/css/jquery.fancybox.css" rel="stylesheet" type="text/css"  media="screen" />
        
        <script src="<?php echo base_url(); ?>resources/js/jquery.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/js/jquery.fancybox.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>resources/js/jquery.validate.js" type="text/javascript"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $("#link-sugerencia").fancybox({
                    'transitionIn': 'none',
                    'transitionOut': 'none'
                });

                $("#formulario-hacer-sugerencia").validate({
                    rules: {
                        email_sugerencia: {
                            required: true,
                            email: true
                        },
                        asunto_sugerencia: {
                            required: true
                        },
                        mensaje_sugerencia: {
                            required: true
                        }
                    },
                    messages: {
                        email_sugerencia: {
                            required: "Escriba su correo electrónico",
                            email: "Escriba un correo electrónico válido"
                        },
                        asunto_sugerencia: {
                            required: "Escriba un asunto"
                        },
                        mensaje_sugerencia: {
                            required: "Escriba su sugerencia en el campo de texto"
                        }
                    },
                    invalidHandler: function(form, validator){
                        var errors = validator.numberOfInvalids();
                        if (errors) {
                            var message = errors == 1
                              ? 'Se encontró el siguiente error:\n'
                              : 'Se encontraron los siguientes ' + errors + ' errores:\n';
                            var errors = "";
                            if (validator.errorList.length > 0) {
                                for (x=0;x<validator.errorList.length;x++) {
                                    errors += "\n\u25CF " + validator.errorList[x].message;
                                }
                            }
                            alert(message + errors);
                        }
                        validator.focusInvalid();
                    },
                    submitHandler: function(form){
                        $.ajax({
                            url: "<?php echo base_url(); ?>usuario/hacer_sugerencia/",
                            type: "POST",
                            data: {
                                email: function(){ return $("#email_sugerencia").val(); },
                                asunto: function(){ return $("#asunto_sugerencia").val(); },
                                mensaje: function(){ return $("#mensaje_sugerencia").val(); }
                            },
                            onsubmit: false,
                            success: function(data){
                                $.fancybox.close();
                                alert('Muchas gracias por su opinión.');
                            }
                        });
                    }
                });

                $.validator.setDefaults({
                    errorPlacement: function(error, element){
                    }
                });
            });
        </script>
        
        

        <?php $this->load->view($header_view); ?>
        
        <?php if(validation_errors() != false || isset($error) || isset($confirmacion)){
            $excepcion = '';
            if(validation_errors() != false)
                $excepcion .= validation_errors().'<br>';
            if(isset($error))
                $excepcion .= $error.'<br>';
            if(isset($confirmacion))
                $excepcion .= $confirmacion;
            ?>
            <script type="text/javascript">
                var mensaje = "<?php echo preg_replace('/(\n)+/m', '\n', strip_tags($excepcion)); ?>";
                alert(mensaje);
            </script>
        <?php } ?>

        <script type="text/javascript">

          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-23173661-1']);
          _gaq.push(['_trackPageview']);

          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();

        </script>
    </head>

    <body>
        <!-- Inicio buzón de sugerencias -->
        <a href="#hacer-sugerencia" id="link-sugerencia"></a>
        <div style="display:none">
            <div id="hacer-sugerencia" align="center">
                <?php $config = array('id' => 'formulario-hacer-sugerencia');
                    echo form_open('', $config); ?>

                <table width="600" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td valign="top" class="box_fondo" align="center" >
                            <table border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td class="box_fondo" width="14">&nbsp;</td>
                                    <td class="box_borde_sup" height="14" width="572"></td>
                                    <td class="box_esquina_sup_der" width="14">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="box_borde_izq">&nbsp;</td>
                                    <td class="box_fondo_contenido" align="left" style="padding:10px;"><h2>Nuestro principal objetivo es brindarle el mejor servicio. Por esta razón, su opinión es muy importante. Le agredecemos llenar los siguientes campos. </h2></td>
                                    <td class="box_borde_der">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td height="14" class="box_esquina_inf_izq"></td>
                                    <td class="box_borde_inf"></td>
                                    <td class="box_esquina_inf_der"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="box_fondo">
                            <table width="600" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td rowspan="2" class="box_fondo" width="14">&nbsp;</td>
                                    <td width="194" class="box_fondo"></td>
                                    <td width="378" class="box_borde_sup" ></td>
                                    <td height="14" class="box_esquina_sup_der" width="14"></td>
                                </tr>
                                <tr>
                                    <td height="22" class="box_fondo box_titulo"><h1>BUZÓN DE SUGERENCIAS</h1></td>
                                    <td class="box_fondo_contenido box_ordenamiento">&nbsp;</td>
                                    <td class="box_borde_der">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td class="box_borde_izq"></td>
                                    <td colspan="2" class="box_fondo_contenido"></td>
                                    <td class="box_borde_der"></td>
                                </tr>
                                <tr>
                                    <td class="box_borde_izq">&nbsp;</td>
                                    <td colspan="2" class="box_fondo_contenido">
                                        <table width="571" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="15" class="general_separador_transparente"></td>
                                                <td width="71"></td>
                                                <td width="470"></td>
                                                <td width="15"></td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td class="general_formulario_texto" align="right" valign="middle"><h2>E-mail:</h2></td>
                                                <td class="general_formulario_texto" align="left" style="padding:10px;">
                                                    <input class="general_cuadro_texto" type="text" name="email_sugerencia" id="email_sugerencia" size="58" />
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td width="15" class="general_separador_transparente"></td>
                                                <td width="71"></td>
                                                <td width="470"></td>
                                                <td width="15"></td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td class="general_formulario_texto" align="right" valign="middle"><h2>Asunto:</h2></td>
                                                <td class="general_formulario_texto" align="left" style="padding:10px;">
                                                    <input class="general_cuadro_texto" type="text" name="asunto_sugerencia" id="asunto_sugerencia" size="58" />
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td width="15" class="general_separador_transparente"></td>
                                                <td width="71"></td>
                                                <td width="470"></td>
                                                <td width="15"></td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                    <td colspan="2" class="general_formulario_texto" style="padding:15px;">

                                                    <textarea class="general_textarea" name="mensaje_sugerencia" id="mensaje_sugerencia"  rows="8" cols="50"></textarea>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td >&nbsp;</td>
                                                <td colspan="2" align="right" style="padding-bottom:10px;padding-top:10px;"><span class="establecimiento_comentarios_boton_form">
                                                        <input type="submit" class="general_boton_secundario" name="btn_enviar" id="btn_enviar" value="Enviar" />
                                                    </span></td>
                                                <td></td>
                                            </tr>
                                        </table></td>
                                    <td class="box_borde_der">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td height="14" class="box_esquina_inf_izq"></td>
                                    <td colspan="2" class="box_borde_inf"></td>
                                    <td class="box_esquina_inf_der"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <?php echo form_close(); ?>
            </div>
        </div>
        <!-- Final buzón de sugerencias -->

        <!-- Inicio template -->
        <div align="center">
            <table width="990" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="10" height="10" class="esquina_sup_izq"></td>
                    <td width="970" class="borde_superior"></td>
                    <td width="10" class="esquina_sup_der"></td>
                </tr>
                <tr>
                    <td class="borde_izquierdo">&nbsp;</td>
                    <td>
                        <table width="970" border="0" cellspacing="0" cellpadding="0">
                            <?php 
                            	$header_viewdata = array();
                            	if(isset($show_login)){
                            		$data['show_login'] = true;
                            	}
                                    
                                  
                            	$this->load->view('template/header_view', $data);
                            ?>
                            <?php if(isset($navegacion_view)){$this->load->view('template/navegacion_view');} ?>
                            <?php if(!isset($hide_search)){$this->load->view('template/busqueda_view');} ?>
                            <?php if(isset($breadcrumb)){$this->load->view('template/breadcrumbs_view');} ?>
                            <?php $this->load->view($contenido_view); ?>
                            <?php $this->load->view('template/footer_view'); ?>
                        </table>
                    </td>
                    <td class="borde_derecho">&nbsp;</td>
                </tr>
                <tr>
                    <td height="10" class="esquina_inf_izq"></td>
                    <td class="borde_inferior"></td>
                    <td class="esquina_inf_der"></td>
                </tr>
            </table>
        </div>
        <!-- Final template -->
    </body>
</html>